<?php

namespace App\Repositories;

use App\Exceptions\ModelNotCreatedException;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    /**
     * Find user based on email
     *
     * @param string $email
     * @return User
     */
    public function findUser(string $email): User
    {
        // throw new ModelNotFoundException("User model not found");

        $user = User::where('email', $email)->first();
        if(!$user) {
            throw new ModelNotFoundException("User model not found");
        }
        return $user;
    }

    /**
     * Store user data
     *
     * @param Request $request
     * @return User
     */
    public function store(Request $request): User
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        if (!$user) {
            throw new ModelNotCreatedException("User model not created");
        }
        return $user;
    }
}