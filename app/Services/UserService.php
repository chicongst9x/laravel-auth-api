<?php namespace App\Services;

use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailRegistration;

class UserService{

    protected $userRepository;

    public function __construct()
    {
        $this->userRepository = app(UserRepository::class);
    }

    public function register($params)
    {
        $params['password'] = bcrypt($params['password']);
        return $this->userRepository->create($params);
    }

    public function sendEmailCompletedRegistration($email, $token)
    {
        Mail::to($email)->send(new SendMailRegistration($token));
    }

    public function updateUserRegisterDone($user)
    {
        $params = [
            'email_verified_at' => Carbon::now()->timestamp
        ];

        return $this->userRepository->update($params, $user->id);
    }
}
