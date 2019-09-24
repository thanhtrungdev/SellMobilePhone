<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\OrderDetail;
use App\Product;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(OrderDetail::class, function (Faker $faker) {
    $faker->addProvider('new Faker\Provider\PhoneNumber($faker)');
    $listOrderID = User::pluck('id');
    $listProductID = Product::pluck('id');
    return [
        'order_id' => $faker->randomElement($listOrderID),
        'product_id' => $faker->randomElement($listProductID),
        'amount' => rand(500000, 20000000),
        'discount_amount' => rand(50000, 500000),
        'quantity' => rand(1, 9),
        //'serial' => Str::random(10),
        /*'serial' => $faker->regexify('[A-Za-z0-9]{10}'),
        'imei_1' => $faker->unique()->imei(),
        'imei_2' => $faker->unique()->imei(),*/
    ];
});
