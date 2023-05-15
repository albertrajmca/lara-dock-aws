<?php

namespace App\Providers;

use App\Services\CategoryService;
use App\Services\CategoryServiceInterface;
use App\Services\ProductReviewService;
use App\Services\ProductReviewServiceInterface;
use App\Services\ProductService;
use App\Services\ProductServiceInterface;
use App\Services\UserService;
use App\Services\UserServiceInterface;
use Illuminate\Support\ServiceProvider;

class ServiceRegistryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(ProductReviewServiceInterface::class, ProductReviewService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
