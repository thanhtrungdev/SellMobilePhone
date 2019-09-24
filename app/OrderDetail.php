<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    //use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'product_id',
        'amount',
        'discount_amount',
        'quantity',
        'serial',
        'imei_1',
        'imei_2',
    ];

    public function orders() {
        return $this->belongsTo('App\Order');
    }

    public function products() {
        return $this->belongsTo('App\Product');
    }
}
