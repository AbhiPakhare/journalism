<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Journal;
use Faker\Generator as Faker;

$factory->define(Journal::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
		'reference_id' => time(),
        'reviewer_id' => User::all()->random()->id,
		'status' => $faker->randomElement(['Waiting', 'Approved', 'Rejected', 'Pending', 'Pending Payment']),
		'payment_status' => $faker->randomElement([0, 1]),
		'created_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s')
    ];
});
