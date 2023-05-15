<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class CategoryService implements CategoryServiceInterface
{
    /**
     * Constructor
     *
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(public CategoryRepository $categoryRepository)
    {}

    /**
     * Get All categories
     *
     * @return Collection
     */
    public function listAllCategories(): Collection
    {
        return $this->categoryRepository->getAllCategories();
    }
}