<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    //use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'current_price',
        'discount_percent',
        'description',
        'warranty_period',
        'quantity',
        'image',
        'date_create',
    ];

    public function categories() {
        return $this->belongsTo('App\Category');
    }

    public function brands() {
        return $this->belongsTo('App\Brand');
    }

    public function images() {
        return $this->hasMany('App\Image');
    }

    public function comments() {
        return $this->hasMany('App\Comment');
    }

    public function order_details() {
        return $this->hasMany('App\OrderDetail');
    }
}
