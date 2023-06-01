<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Camera;

class CameraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cameraRole = Role::where('name', 'camera')->first();

        $cameras = [
            [
                'name' => 'Camera 1',
                'url' => 'https://example.com/camera1',
            ],
            [
                'name' => 'Camera 2',
                'url' => 'https://example.com/camera2',
            ],
        ];

        foreach ($cameras as $cameraData) {
            $camera = new Camera();
            $camera->name = $cameraData['name'];
            $camera->url = $cameraData['url'];
            $camera->role_id = $cameraRole->id;
            $camera->save();
        }
    }
}
