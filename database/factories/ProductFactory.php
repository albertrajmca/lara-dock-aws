<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'units' => $this->faker->numberBetween(1,200),
            'price' => $this->faker->numberBetween(100, 2000),
            'image' => $this->faker->imageUrl,
            'category_id' => Category::pluck('id')->random(),
        ];
    }
}
