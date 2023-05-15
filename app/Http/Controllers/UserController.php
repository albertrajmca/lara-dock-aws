<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use App\Services\UserServiceInterface;

class UserController extends Controller
{
    /**
     *
     * @param UserServiceInterface $userService
     */
    public function __construct(public UserServiceInterface $userService)
    {}

    /**
     * Method used to sign up a user
     *
     * @param SignupRequest $request
     * @return array
     */
    public function store(SignupRequest $request): array
    {
        return $this->userService->store($request);
    }
}
