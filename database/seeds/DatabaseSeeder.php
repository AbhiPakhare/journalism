<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        $this->call(RoleSeeder::class);
        $this->call(AdminRoleSeeder::class);
        $this->call(CategorySeeder::class);
		$this->call(MakeUsersSeeder::class);
    }
}
