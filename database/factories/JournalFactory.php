<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Journal;
use Faker\Generator as Faker;

$factory->define(Journal::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
		'reference_id' => time(),
		'status' => $faker->randomElement(['Waiting', 'Approved', 'Rejected']),
		'created_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s')
    ];
});
