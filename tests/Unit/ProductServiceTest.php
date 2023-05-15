<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Services\ProductServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;
    /**
     * Mock product service.
     *
     * @return void
     */
    public function test_mock_product_service_list_method()
    {
        $testData = [
            [
                "id" => 3,
                "name" => "autem",
                "description" => "Dicta necessitatibus consectetur eos.",
                "units" => 195,
                "price" => 681,
                "image" => "https://picsum.photos/640/480?random=28928",
                "category" => [
                    "id" => 3,
                    "name" => "Sunglasses",
                ],
                "avg_rating" => "3.0",
            ],
            [
                "id" => 7,
                "name" => "non",
                "description" => "Voluptatem rerum deleniti atque voluptatem et.",
                "units" => 193,
                "price" => 1250,
                "image" => "https://picsum.photos/640/480?random=75212",
                "category" => [
                    "id" => 2,
                    "name" => "Footwear",
                ],
                "avg_rating" => "4.0",
            ],
        ];
        $this->mock(ProductServiceInterface::class, function (MockInterface $mock) use ($testData) {
            $mock
                ->shouldReceive('listAllProducts')
                ->once()
                ->andReturn($testData);
        });
        $this->getJson(route('products.list'));
    }

    /**
     * Mock product service.
     *
     * @return void
     */
    public function test_mock_product_service_show_method()
    {
        $testData =
            [
            "id" => 2,
            "name" => "odio",
            "description" => "Rerum ipsa sit non tenetur recusandae.",
            "units" => 193,
            "price" => 827,
            "image" => "https://picsum.photos/640/480?random=63720",
            "avg_rating" => "5.0",
            "reviews" => [
                [
                    "id" => 5,
                    "comment" => "Dolorum accusantium dolorum iste voluptatum itaque.",
                    "rating" => 5,
                    "title" => "dolor",
                    "user" => [
                        "id" => 2,
                        "name" => "Jermey Schneider",
                    ],
                ],
                [
                    "id" => 48,
                    "comment" => "Optio ad pariatur amet consequatur qui impedit.",
                    "rating" => 5,
                    "title" => "quia",
                    "user" => [
                        "id" => 7,
                        "name" => "Miss Lera Hodkiewicz DDS",
                    ],
                ],
            ],
        ];
        Product::factory()->count(10)->create();
        $this->mock(ProductServiceInterface::class, function (MockInterface $mock) use ($testData) {
            $mock
                ->shouldReceive('showProduct')
                ->once()
                ->andReturn($testData);
        });
        $this->getJson(route('products.show', Product::pluck('id')->random()));
    }

}
