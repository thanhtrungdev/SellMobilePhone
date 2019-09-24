<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    $roles = ['Admin', 'User'];
    return [
        'name' => $faker->randomElement($roles)
    ];
});
