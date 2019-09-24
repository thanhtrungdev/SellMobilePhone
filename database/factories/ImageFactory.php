<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Image;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    $listProductID = Product::pluck('id');
    return [
        'product_id' => $faker->randomElement($listProductID),
        'name' => $faker->name,
        'path' => 'public\img'
    ];
});
