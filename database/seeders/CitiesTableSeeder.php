<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\cities;

class citiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = file_get_contents("public/files/wi.json");
        $data = json_decode($cities, true);
        

        $cities = $data['MAROC_CITIES'];

        foreach ($cities as $cityData) {
            cities::create($cityData);
        }
    }
}
