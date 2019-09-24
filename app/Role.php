<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    //use SoftDeletes;

    public $timestamps = false;

    protected $fillable = ['name'];

    public function user_roles() {
        return $this->hasMany('App\UserRole');
    }
}
