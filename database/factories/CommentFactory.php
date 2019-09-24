<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use App\User;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    $listUserID = User::pluck('id');
    $listProductID = User::pluck('id');
    return [
        'user_id' => $faker->randomElement($listUserID),
        'product_id' => $faker->randomElement($listProductID),
        'comment' => $faker->text,
    ];
});
