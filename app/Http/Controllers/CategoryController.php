<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Services\CategoryServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{

    /**
     * Constructor
     *
     * @param CategoryServiceInterface $categoryService
     */
    public function __construct(public CategoryServiceInterface $categoryService)
    {}

    /**
     * Method used to get all categories.
     *
     * @return AnonymousResourceCollection
     */
    public function __invoke(): AnonymousResourceCollection
    {
        $categories = $this->categoryService->listAllCategories();
        return CategoryResource::collection($categories);
    }
}
