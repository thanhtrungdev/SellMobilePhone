<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRole extends Model
{
    //use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'role_id',
    ];

    public function users() {
        return $this->belongsTo('App\User');
    }

    public function roles() {
        return $this->belongsTo('App\Role');
    }
}
