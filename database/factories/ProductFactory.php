<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Brand;
use App\Category;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $listCategoryID = Category::pluck('id');
    //$listBrandID = Brand::pluck('id');
    $listPhoneBrand = [1, 2, 3, 4];
    $warranties = [3, 6, 9, 12, 24, 36, 48, 60];
    $discount_percent = [0, 5/100, 10/100, 15/100, 20/100, 25/100, 30/100];
    $date = $faker->dateTime($max='now');

    $category = $faker->randomElement($listCategoryID);

    if($category == 1) {
        return [
            'category_id' => 1,
            'brand_id' => $faker->randomElement($listPhoneBrand),
            'name' => $faker->name,
            'current_price' => rand(100, 500),
            'discount_percent' => $faker->randomElement($discount_percent),
            'description' => $faker->text,
            'warranty_period' => $faker->randomElement($warranties),
            'quantity' => rand(0, 1000),
            'image' => 'img/products',
            'date_create' => $date,
        ];
    } else {
        return [
            'category_id' => 2,
            'brand_id' => 5,
            'name' => $faker->name,
            'current_price' => rand(100, 500),
            'discount_percent' => $faker->randomElement($discount_percent),
            'description' => $faker->text,
            'warranty_period' => $faker->randomElement($warranties),
            'quantity' => rand(0, 1000),
            'image' => 'img/products',
            'date_create' => $date,
        ];
    }

});
