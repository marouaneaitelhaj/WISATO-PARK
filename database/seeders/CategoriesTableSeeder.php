<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\User;

use function PHPSTORM_META\type;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();

        $categories = [
            [
                'type' => 'Electric Car',
                'description' => 'Car'
            ],
            [
                'type' => 'Electric Bike',
                'description' => 'Bike'
            ],
            [
                'type' => 'Electric Bus',
                'description' => 'Bus'
            ],
            [
                'type' => 'Electric Truck',
                'description' => 'Truck'
            ],
            [
                'type' => 'Gasoline Car',
                'description' => 'Car'
            ],
            [
                'type' => 'Gasoline Bike',
                'description' => 'Bike'
            ],
            [
                'type' => 'Gasoline Bus',
                'description' => 'Bus'
            ],
            [
                'type' => 'Gasoline Truck',
                'description' => 'Truck'
            ],

        ];

        foreach ($categories as $category) {
            Category::create(array_merge($category, ['created_by' => 1]));
        }
    }
}
