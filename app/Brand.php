<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    //use SoftDeletes;

    public $timestamps = false;

    protected $fillable = ['name'];

    public function products() {
        return $this->hasMany('App\Product');
    }
}
