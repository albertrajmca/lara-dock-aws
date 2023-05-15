<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ProductService implements ProductServiceInterface
{
    /**
     * Constructor
     *
     * @param ProductRepository $productRepository
     */
    public function __construct(public ProductRepository $productRepository)
    {}

    /**
     * Get all products
     *
     * @param Request $request
     * @return Collection
     */
    public function listAllProducts(Request $request): Collection
    {
        return $this->productRepository->getAllProducts($request);
    }

    /**
     * Get a single product
     *
     * @param integer $id
     * @return Product
     */
    public function showProduct(int $id): Product
    {
        return $this->productRepository->findById($id);
    }

}