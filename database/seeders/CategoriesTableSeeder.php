<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\User;

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
                'type' => 'Car',
                'description' => 'Car Description'
            ],
            [
                'type' => 'Car Hydrogène',
                'description' => 'HYDROGÈNE Description'
            ],
            [
                'type' => 'Jeep',
                'description' => 'Jeep Description'
            ],
            [
                'type' => 'Bike',
                'description' => 'Bike Description'
            ],
            [
                'type' => 'Truck',
                'description' => 'Truck Description'
            ],
            [
                'type' => 'Bus',
                'description' => 'Bus Description'
            ],
            [
                'type' => 'Auto',
                'description' => 'Auto Description'
            ],
        ];

        foreach ($categories as $category) {
            Category::create(array_merge($category, ['created_by' => $user->id]));
        }
    }
}
