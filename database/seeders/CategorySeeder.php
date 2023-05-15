<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Apparels', 'Footwear', 'Sunglasses', 'Watches', 'Mobiles', 'Laptops'];
        foreach($categories as $category) {
                Category::updateOrCreate(
                    ['name' => $category],
                    ['name' => $category]
                );
        }
    }
}
