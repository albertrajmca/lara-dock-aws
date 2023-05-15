<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryAPIsTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * category list api test
     *
     */
    public function test_category_list_api()
    {
        $response = $this->getJson(route('categories.list'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' =>  [
                '*' => [
                        'id',
                        'name'   
                    ],
            ],
        ]);
        $data = $response->json('data');
        foreach ($data as $category) {
            $this->assertIsInt($category['id']);
            $this->assertIsString($category['name']);
        }
    }
}

