<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $ratings = [1, 2, 3, 4, 5];
        $key = array_rand($ratings);
        return [
            'user_id' => User::pluck('id')->random(),
            'product_id' => Product::pluck('id')->random(),
            'title' => $this->faker->word,
            'rating' => $ratings[$key],
            'comment' => $this->faker->sentence,
        ];
    }
}
