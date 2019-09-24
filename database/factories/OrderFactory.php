<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use App\User;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    $listUserID = User::pluck('id');
    $status = ['Đang xữ lý', 'Đang giao hàng', 'Đã giao hàng', 'Hủy đơn hàng'];
    $date1 = $faker->date($format='Y-m-d', $max='now');
    $date2 = $faker->date($format='Y-m-d', $max='now');
    if($date1<=$date2) {
        $order_date = $date1;
        $ship_date = $date2;
    }
    else {
        $order_date = $date2;
        $ship_date = $date2;
    }
    return [
        'user_id' => $faker->randomElement($listUserID),
        'order_date' => $order_date,
        'ship_date' => $ship_date,
        'ship_amount' => 0,
        'phone_receiver' => $faker->phoneNumber,
        'ship_address' => $faker->address,
        'billing_address' => $faker->address,
        'status' => $faker->randomElement($status),
    ];
});
