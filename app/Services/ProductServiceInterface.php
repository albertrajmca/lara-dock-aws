<?php

namespace App\Services;

use Illuminate\Http\Request;

interface ProductServiceInterface
{
    public function listAllProducts(Request $request);
    public function showProduct(int $id);
}
