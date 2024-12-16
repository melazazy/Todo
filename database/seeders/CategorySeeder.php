<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{ 
    public function run()
    {
        $categories = [
            'Work',
            'Personal',
            'Urgent',
            'Shopping',
            'Health',
            'Fitness',
            'Education',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
