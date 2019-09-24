<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    $categories = ['Điện Thoại', 'Phụ Kiện'];
    return [
        'name'=> $faker->randomElement($categories)
    ];
});
