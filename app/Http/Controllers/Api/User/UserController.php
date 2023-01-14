<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UpdateProfileRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository= $userRepository;
    }

    public function profile(Request $request)
    {
        return $this->userRepository->getProfile($request);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        return $this->userRepository->updateProfile($request);
    }
}
