<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductAPIsTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * Test the product list api structure.
     */
    public function test_products_list_api()
    {
        Product::factory()->count(6)->create();

        // 50 records were added while build the app
        $this->assertDatabaseCount('products', 56);

        $response = $this->getJson(route('products.list'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    "id",
                    "name",
                    "description",
                    "units",
                    "price",
                    "image",
                    "avg_rating",
                    "category" => [
                        "id",
                        "name",
                    ],
                ],
            ],
        ]);

        $data = $response->json('data');
        foreach ($data as $product) {
            $this->assertIsInt($product['id']);
            $this->assertIsString($product['name']);
            $this->assertIsString($product['description']);
            $this->assertIsInt($product['units']);
            $this->assertIsInt($product['price']);
            $this->assertIsString($product['image']);
            $this->assertIsString($product['avg_rating']);
            $this->assertIsInt($product['category']['id']);
            $this->assertIsString($product['category']['name']);
        }

    }

    /**
     * Product show api test
     *
     */
    public function test_products_show_api()
    {
        Product::factory()->count(10)->create();
        $this->assertDatabaseCount('products', 60);

        $response = $this->getJson(route('products.show', Product::pluck('id')->random()));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                "id",
                "name",
                "description",
                "units",
                "price",
                "image",
                "avg_rating",
                "reviews" => [
                    "*" => [
                        "id",
                        "comment",
                        "rating",
                        "title",
                        "user" => [
                            "id",
                            "name",
                        ],
                    ],
                ],
            ],
        ]);

        $data = $response->json('data');
        $this->assertIsInt($data['id']);
        $this->assertIsString($data['name']);
        $this->assertIsString($data['description']);
        $this->assertIsInt($data['units']);
        $this->assertIsInt($data['price']);
        $this->assertIsString($data['image']);
        $this->assertIsString($data['avg_rating']);

        foreach ($data['reviews'] as $review) {
            $this->assertIsInt($review['id']);
            $this->assertIsString($review['comment']);
            $this->assertIsInt($review['rating']);
            $this->assertIsString($review['title']);
            $this->assertIsInt($review['user']['id']);
            $this->assertIsString($review['user']['name']);
        }

    }






}
