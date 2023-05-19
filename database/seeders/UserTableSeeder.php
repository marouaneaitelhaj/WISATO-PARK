<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Role;

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
		$role_operator       = Role::where('name', 'operator')->first();

		$admin = new User();

		$admin->name = 'Admin Name';
		$admin->email = 'admin@gmail.com';
		$admin->status = 1;
		$admin->password = bcrypt('123456');
		$admin->numberPhone = '0123456789';
		$admin->save();

		$admin->roles()->attach($role_admin);
	}
}
