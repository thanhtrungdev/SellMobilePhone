<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    //use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'name',
        'path'
    ];

    public function products() {
        return $this->belongsTo('App\Product');
    }
}
