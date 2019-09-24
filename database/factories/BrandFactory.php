<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Brand;
use Faker\Generator as Faker;

$factory->define(Brand::class, function (Faker $faker) {
    $brands = ['Samsung', 'iPhone', 'Vsmart', 'Xiaomi', 'N/A'];
    return [
        'name'=> $faker->randomElement($brands)
    ];
});
