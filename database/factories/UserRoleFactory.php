<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Role;
use App\User;
use App\UserRole;
use Faker\Generator as Faker;

$factory->define(UserRole::class, function (Faker $faker) {
    $listUserID = User::pluck('id');
    //$listRoleID = Role::pluck('id');
    return [
        'user_id' => $faker->randomElement($listUserID),
        //'role_id' => $faker->randomElement($listRoleID),
        'role_id' => 2,
    ];
});
