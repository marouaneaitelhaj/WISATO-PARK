<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Camera;
class RoleTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$role_admin = new Role();
		$role_admin->name = 'admin';
		$role_admin->selfmade = 0;
		$role_admin->description = 'admin User';
		$role_admin->save();

		$role_reviewer = new Role();
		$role_reviewer->name = 'gardien';
		$role_reviewer->selfmade = 0;
		$role_reviewer->description = 'gardien';
		$role_reviewer->save();

		$role_reviewer = new Role();
		$role_reviewer->name = 'chef zone';
		$role_reviewer->selfmade = 0;
		$role_reviewer->description = 'chef zone';
		$role_reviewer->save();

		$role_reviewer = new Role();
		$role_reviewer->name = 'client';
		$role_reviewer->selfmade = 1;
		$role_reviewer->description = 'Client';
		$role_reviewer->save();

		$role_reviewer = new Role();
		$role_reviewer->name = 'camera';
		$role_reviewer->selfmade = 1;
		$role_reviewer->description = 'Camera';
		$role_reviewer->save();



	}
}
