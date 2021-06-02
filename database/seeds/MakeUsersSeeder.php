<?php

use App\Role;
use App\User;
use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MakeUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$manager = User::create([
			'name' => "Manager",
			'email' => "manager@gmail.com",
			'password' => Hash::make('abcd@1234'),
		]);
        $role = new Role();
        $role->name = 'Manager';
        $manager->role()->save($role);

		$reviewer = User::create([
			'name' => "Reviewer",
			'email' => "reviewer@gmail.com",
			'password' => Hash::make('abcd@1234'),
		]);
        $role = new Role();
        $role->name = 'Reviewer';
		$categories = Category::select('id')->get()->toArray();
        $reviewer->role()->save($role);
		$reviewer->categories()->sync($categories);
		$reviewer->save();

        $user = User::create([
            'name' => "User",
            'email' => "user@gmail.com",
            'password' => Hash::make('abcd@1234'),
            'is_verified' => true
        ]);
        $role = new Role();
        $role->name = 'User';
        $user->role()->save($role);
    }
}
