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
        Category::create([
            'type' => 'All',
            'created_by' => $user->id,
            'description' => 'All Categories'
        ]);
        Category::create([
            'type' => 'Car',
            'description' => 'Car Description',
            'created_by' => $user->id
        ]);
        Category::create([
            'type' => 'Bike',
            'created_by' => $user->id,
            'description' => 'Bike Description'
        ]);
        Category::create([
            'type' => 'Cycle',
            'created_by' => $user->id,
            'description' => 'Cycle Description'
        ]);
        Category::create([
            'type' => 'Truck',
            'created_by' => $user->id,
            'description' => 'Truck Description'
        ]);
        Category::create([
            'type' => 'Bus',
            'created_by' => $user->id,
            'description' => 'Bus Description'
        ]);
        Category::create([
            'type' => 'Auto',
            'created_by' => $user->id,
            'description' => 'Auto Description'
        ]);
    }
}
