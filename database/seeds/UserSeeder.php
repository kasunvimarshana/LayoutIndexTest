<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use App\User;
use App\Enums\RoleEnum;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => 'SuperAdmin',
            'email' => 'superadmin@mail.com',
            'password' => Hash::make('admin'),
            'role_id' => RoleEnum::SuperAdmin
        ]);
        
        User::create([
            'name' => 'User',
            'email' => 'user@mail.com',
            'password' => Hash::make('user'),
            'role_id' => RoleEnum::User
        ]);
    }
}
