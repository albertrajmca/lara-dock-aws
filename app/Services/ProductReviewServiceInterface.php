<?php

namespace App\Services;

use Illuminate\Http\Request;

interface ProductReviewServiceInterface
{
    public function store(Request $request);
}