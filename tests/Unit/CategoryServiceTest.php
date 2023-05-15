<?php

namespace Tests\Unit;

use App\Services\CategoryServiceInterface;
use Mockery\MockInterface;
use Tests\TestCase;

class CategoryServiceTest extends TestCase
{
    /**
     * Mock category service.
     *
     * @return void
     */
    public function test_mock_category_servie()
    {
        $sampleData = [    
                        ['id' => 1,'name' => 'Apparels'],
                        ['id' => 2,'name' => 'Laptops'],
                    ];
         $this->mock(CategoryServiceInterface::class, function(MockInterface $mock) use($sampleData){
            $mock
            ->shouldReceive('listAllCategories')
            ->once()
            ->andReturn($sampleData);
        });
       $this->getJson(route('categories.list'));
    }
}
