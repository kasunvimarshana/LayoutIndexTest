<?php

use Illuminate\Database\Seeder;

use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Role::create([
            'id' => 1,
            'name' => ucwords('SuperAdmin')
        ]);
        
        Role::create([
            'id' => 2,
            'name' => ucwords('user')
        ]);
    }
}
