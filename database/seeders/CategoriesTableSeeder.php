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
        Category::create(['type' => 'All', 'created_by' => $user->id]);
        Category::create(['type' => 'Car', 'created_by' => $user->id]);
        Category::create(['type' => 'Bike', 'created_by' => $user->id]);
        Category::create(['type' => 'Cycle', 'created_by' => $user->id]);
        Category::create(['type' => 'Truck', 'created_by' => $user->id]);
        Category::create(['type' => 'Bus', 'created_by' => $user->id]);
        Category::create(['type' => 'Auto', 'created_by' => $user->id]);
    }
}
