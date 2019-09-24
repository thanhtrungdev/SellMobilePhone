<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    //use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'order_date',
        'ship_date',
        'ship_amount',
        'phone_receiver',
        'ship_address',
        'billing_address',
        'status',
    ];

    public function users() {
        return $this->belongsTo('App\User');
    }

    public function order_details() {
        return $this->hasMany('App\OrderDetail');
    }
}
