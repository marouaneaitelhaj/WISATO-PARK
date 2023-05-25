<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cities;
use App\Models\Quartier;

class QuartierSeeder extends Seeder
{
    public function run()
    {
        $file = file_get_contents(public_path('files/mv-quarters.json'));
        $data = json_decode($file);
        var_dump($file);
        var_dump($data);
    }
}
