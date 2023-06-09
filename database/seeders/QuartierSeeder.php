<?php


namespace Database\Seeders;



use Illuminate\Database\Seeder;
use App\Models\cities;
use App\Models\Quartier;

class QuartierSeeder extends Seeder
{
    public function run()
    {
        $file = file_get_contents('public/files/saad.json');
        // $file = file_get_contents('public/files/saad.json');

        $data = json_decode($file, true);

        foreach ($data as $cityName => $quartiers) {
            $city = cities::where('CITY', $cityName)->first();

            if ($city) {
                foreach ($quartiers as $quartierData) {
                    $quartier = new Quartier();
                    $quartier->quartier_name = $quartierData['QUARTER'];
                    $quartier->city_id = $city->id;
                    $quartier->save();
                }
            }
        }
    }
}
