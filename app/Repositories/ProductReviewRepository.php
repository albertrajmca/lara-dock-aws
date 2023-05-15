<?php

namespace App\Repositories;

use App\Exceptions\ModelNotCreatedException;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductReviewRepository
{
    /**
     * Store the product review
     *
     * @param Request $data
     * @return void
     */
    public function store(Request $data): void
    {
        $review = new Review();
        $review->user_id = $data->user()->id;
        $review->product_id = $data->id;
        $review->title = $data->title;
        $review->rating = $data->rating;
        $review->comment = $data->comment;
        $review->save();
        if (!$review) {
            throw new ModelNotCreatedException("Review model not created");
        }
    }

}