<?php

use App\User;
use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
                    'name' => "Administrator",
                    'email' => "admin@admin.com",
                    'password' => Hash::make('admin@1234'),
                ]);
        $role = new Role();

        $role->name = Role::ADMIN;
        $admin->role()->save($role);
        $admin->save();

    }
}
