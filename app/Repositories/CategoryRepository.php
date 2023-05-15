<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    /**
     * Get all categories
     *
     * @return Collection
     */
    public function getAllCategories(): Collection
    {
        return Category::all();
    }

}