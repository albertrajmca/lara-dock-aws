<?php

namespace App\Services;

use App\Exceptions\ModelNotCreatedException;
use App\Repositories\ProductReviewRepository;
use Exception;
use Illuminate\Http\Request;

class ProductReviewService implements ProductReviewServiceInterface
{
    /**
     * Constructor
     *
     * @param ProductReviewRepository $reviewRepository
     */
    public function __construct(public ProductReviewRepository $reviewRepository)
    {}

    /**
     * Product review store
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request): void
    {
        try {
            $this->reviewRepository->store($request);
        } catch (Exception | ModelNotCreatedException $e) {
            throw new ModelNotCreatedException($e->getMessage());
        }
    }
}
