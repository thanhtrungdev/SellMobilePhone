<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    //use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'product_id',
        'comment'
    ];

    public function users() {
        return $this->belongsTo('App\User');
    }

    public function products() {
        return $this->belongsTo('App\Product');
    }
}
