<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();

    	$role = new Role;
    	$role->name = 'admin';
    	$role->save();

        $role->perms()->sync([1,2]);

        $role = new Role;
    	$role->name = 'user';
    	$role->save();
        
        $role->perms()->sync(1);
        
    }
}
