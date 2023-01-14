<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\ForgotPasswordRequest;
use App\Http\Requests\Api\User\LoginRequest;
use App\Http\Requests\Api\User\RegisterRequest;
use App\Http\Requests\Api\User\ResetPasswordRequest;
use App\Mail\RegisterEmailMail;
use App\Repositories\UserRepository;

class AuthController extends Controller
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository= $userRepository;
    }

    public function register(RegisterRequest $request)
    {
        return $this->userRepository->registerUser($request);
    }

    public function login(LoginRequest $request)
    {
        return $this->userRepository->loginUser($request);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        return $this->userRepository->forgotPassword($request);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        return $this->userRepository->resetPassword($request);
    }


}
