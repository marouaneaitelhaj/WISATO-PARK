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
                'description' => 'Electric Car Description'
            ],
            [
                'type' => 'Electric Bike',
                'description' => 'Electric Bike Description'
            ],
            [
                'type' => 'Electric Bus',
                'description' => 'Electric Bus Description'
            ],
            [
                'type' => 'Electric Truck',
                'description' => 'Electric Truck Description'
            ],
            [
                'type' => 'Gasoline Car',
                'description' => 'Gasoline Car Description'
            ],
            [
                'type' => 'Gasoline Bike',
                'description' => 'Gasoline Bike Description'
            ],
            [
                'type' => 'Gasoline Bus',
                'description' => 'Gasoline Bus Description'
            ],
            [
                'type' => 'Gasoline Truck',
                'description' => 'Gasoline Truck Description'
            ],
            // [
            //     'type' => 'Auto',
            //     'description' => 'Auto Description'
            // ],
        ];

        foreach ($categories as $category) {
            Category::create(array_merge($category, ['created_by' => $user->id]));
        }
    }
}
