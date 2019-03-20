<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use JWTAuth;
use Auth;
use App\Entities\User;
use Illuminate\Http\Response;
use App\Http\Requests\Api\RegisterRequest;
use App\Services\UserService;

class AuthController extends ApiController
{
    /** @var  $userService  UserService*/
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
                return $this->error(__('auth.attempt.email_or_password_wrong'), Response::HTTP_FORBIDDEN);
            }
            $user = Auth::user();
            if (!$this->isActive($user)) {
                JWTAuth::setToken($token)->invalidate();
                return $this->error(__('auth.attempt.account_block'), Response::HTTP_FORBIDDEN);
            }

        } catch (\Exception $e) {
            return $this->error(__('auth.attempt.could_not_create_token'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->success('message', [
            'user'  => $user,
            'token' => $token
        ]);
    }
    public function isActive($user)
    {
        if( User::STATUS_ACTIVE != $user->status || $user->email_verified_at === null ) {
            return false;
        }
        return true;
    }
    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->userService->register($request->all());
            $token = JWTAuth::fromUser($user);
            $this->userService->sendMailVerification($user->email, $token);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->success(__('auth.attempt.verify_mail_to_continue'), null);
    }

    public function verifyRegisteredMail()
    {
        try {
            if($user = JWTAuth::parseToken()->toUser()) {
                if ($this->userService->updateUserRegisterDone($user)) {
                    JWTAuth::invalidate();
                    return $this->success('', $user);
                }
                return $this->error(false, Response::HTTP_FORBIDDEN);
            }
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->success('auth.attempt.verify_mail_ok', null);
    }

    public function logout()
    {
        JWTAuth::invalidate();
        return $this->success(true, null);
    }

}

