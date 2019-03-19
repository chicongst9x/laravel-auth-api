<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use JWTAuth;
use Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Entities\User;
use Illuminate\Http\Response;
use App\Http\Requests\Api\RegisterRequest;
use App\Services\UserService;

class AuthController extends ApiController
{
    protected $userService;

    public function __construct()
    {
        $this->userService = app(UserService::class);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        try {
            $params = $request->only('email', 'password');

            if (! $token = JWTAuth::attempt($params)) {
                return $this->error(trans('auth.attempt.email_or_password_wrong'), Response::HTTP_FORBIDDEN);
            }

            /*
			 * check account is block
			 */
            $user = Auth::user();
            if($user->status != User::STATUS_ACTIVE || $user->email_verified_at === null ) {
                JWTAuth::setToken($token)->invalidate();
                return $this->error(trans('auth.attempt.account_block'), Response::HTTP_FORBIDDEN);
            }

        } catch (JWTException $e) {
            return $this->error(trans('auth.attempt.could_not_create_token'), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->success([
            'user'  => $user,
            'token' => $token
        ]);
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->userService->register($request->all());
            $token = JWTAuth::fromUser($user);
            $this->userService->sendEmailCompletedRegistration($user->email, $token);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->success(__('auth.attempt.verify_email_to_continue'));
    }

    public function verifyEmailRegister()
    {
        try {
            if($user = JWTAuth::parseToken()->toUser()) {
                $this->success($this->userService->updateUserRegisterDone($user));
                JWTAuth::invalidate();
            }
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->success(true);
    }

    public function logout()
    {
        JWTAuth::invalidate();
        return $this->success(true);
    }

}

