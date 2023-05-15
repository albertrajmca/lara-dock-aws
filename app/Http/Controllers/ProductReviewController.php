<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingStoreRequest;
use App\Services\ProductReviewServiceInterface;
use Illuminate\Http\Response;

class ProductReviewController extends Controller
{

    /**
     * Constructor
     *
     * @param ProductReviewServiceInterface $reviewService
     */
    public function __construct(public ProductReviewServiceInterface $reviewService)
    {}

     /**
      * Store the Review
      *
      * @param RatingStoreRequest $request
      * @return Response
      */
    public function store(RatingStoreRequest $request): Response
    {
        $this->reviewService->store($request);
        return response(['msg' => 'Review is submitted successfully'], 201);
    }
}
