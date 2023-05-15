<?php

namespace App\Services;

use Illuminate\Http\Request;

interface UserServiceInterface
{
    public function store(Request $request);
    public function generateToken(string $email, string $password);
}
