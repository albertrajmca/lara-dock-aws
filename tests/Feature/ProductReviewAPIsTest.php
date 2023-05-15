<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Faker\Factory as Faker;

class ProductReviewAPIsTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;
    /**
     * Product review api without auth token test
     *
     */
    public function test_product_review_api_without_auth_token()
    {
        Product::factory()->count(10)->create();
        $response = $this->postJson(route('products.review', Product::pluck('id')->random()), [], []);
        $response->assertStatus(401);
    }

    /**
     * Product review api with proper input data
     *
     */
    public function test_product_review_api_valid_data()
    {
        User::factory()->count(4)->create();
        $randomUser = User::first();

        Product::factory()->count(10)->create();
        $randomProductId = Product::pluck('id')->random();

        $response = $this->actingAs($randomUser)
            ->postJson(route('products.review', $randomProductId),
                [
                    'title' => 'test title',
                    'rating' => 3,
                    'comment' => 'test comment',
                ]);
        $response->assertStatus(201);
        $response->assertJsonStructure(['msg']);
        $msg = $response->json('msg');
        $this->assertIsString($msg);

        // DB assertion
        $this->assertDatabaseHas('reviews', ['title' => 'test title', 'rating' => 3, 'comment' => 'test comment']);
        $this->assertDatabaseMissing('reviews', ['title' => 'not existing title']);
    }

    /**
     * @dataProvider review_data_that_should_fail
     */
    public function test_product_review_data_should_fail(array $requestData): void
    {
        User::factory()->count(3)->create();
        $randomUser = User::first();

        Product::factory()->count(3)->create();
        $randomProductId = Product::pluck('id')->random();

        $response = $this->actingAs($randomUser)
            ->postJson(route('products.review', $randomProductId),
                $requestData);
        $response->assertStatus(422);
    }

    /**
     * product review data test cases 
     *
     * @return array
     */
    public function review_data_that_should_fail(): array
    {
        $title = 'Nice Product';
        $rating = 5;
        $comment = 'Its a great product, we can purchase.';
        $faker = Faker::create();

        $sentence = $faker->sentence(20); // generates a sentence with 20 words
        while (strlen($sentence) <= 50) {
            $sentence = $faker->sentence(30); // generates a sentence with 30 words
        }
        
        return [
            'no_input_data' => [
                []
            ],
            'missing_title' => [
                [
                    'rating' => $rating,
                    'comment' => $comment,
                ],
            ],
            'missing_rating' => [
                [
                    'title' => $title,
                    'comment' => $comment,
                ],
            ],
            'missing_comment' => [
                [
                    'title' => $title,
                    'rating' => $rating,
                ],
            ],
            'number_data_in_title' => [
                [
                    'title' => 45,
                    'rating' => $rating,
                    'comment' => $comment
                ],
            ],
            'string_data_in_rating' => [
                [
                    'title' => $title,
                    'rating' => 'aa',
                    'comment' => $comment
                ],
            ],
            'out_of_range_data_in_rating' => [
                [
                    'title' => $title,
                    'rating' => 8,
                    'comment' => $comment
                ],
            ],
            'min_range_test_in_title' => [
                [
                    'title' => 'a',
                    'rating' => $rating,
                    'comment' => $comment
                ],
            ],
            'max_range_test_in_title' => [
                [
                    'title' => $sentence,
                    'rating' => $rating,
                    'comment' => $comment
                ],
            ],
        ];
    }

}
