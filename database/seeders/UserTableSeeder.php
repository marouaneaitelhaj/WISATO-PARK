<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Role;
use Faker\Factory as Faker;


class UserTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$role_admin 		 = Role::where('name', 'admin')->first();
		$gardien       = Role::where('name', 'gardien')->first();
		$chefzone = Role::where('name', 'chef zone')->first();

		$faker = Faker::create();
		$admin = new User();
		$admin->name = 'Saad ERRARHICHE';
		$admin->email = 'Saaderr@gmail.com';
		$admin->status = 1;
		$admin->password = bcrypt('123456');
		$admin->Phone = '0123456781';
		$admin->cin = $faker->unique()->numerify('#########'); // Generate a unique 9-digit number
		$admin->save();

		$gardian = new User();
		$gardian->name = 'MAROUANE AIT EL HAJ';
		$gardian->email = 'marwaneait@gmail.com';
		$gardian->status = 1;
		$gardian->password = bcrypt('123456');
		$gardian->Phone = '0123456782';
		$gardian->cin = $faker->unique()->numerify('#########');
		$gardian->save();

		$chefzone = new User();
		$chefzone->name = 'Amine Majidi';
		$chefzone->email = 'aminemaj@gmail.com';
		$chefzone->status = 1;
		$chefzone->password = bcrypt('123456');
		$chefzone->Phone = '0123456783';
		$chefzone->cin = $faker->unique()->numerify('#########');
		$chefzone->save();

		$gardian->roles()->attach($gardien);
		$chefzone->roles()->attach($chefzone);
		$admin->roles()->attach($role_admin);

		User::factory()->count(50)->create();

		$allusers = User::all();
		foreach ($allusers as $user) {
			if ($user->id != 1 && $user->id != 2 && $user->id != 3) {
				$value = rand(1, 2);
				if ($value == 1) {
					$user->roles()->attach($gardien);
				} else {
					$user->roles()->attach($chefzone);
				}
			}
		}
	}
}
