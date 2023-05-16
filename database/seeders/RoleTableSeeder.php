<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

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
	    $role_admin->description = 'Admin User';
	    $role_admin->save();

	    $role_reviewer = new Role();
	    $role_reviewer->name = 'operator';
	    $role_reviewer->description = 'Operator';
	    $role_reviewer->save();
    }
}
