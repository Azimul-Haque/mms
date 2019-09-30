<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public function groups() {
        return $this->hasMany('App\Group');
    }

    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];


    protected $hidden = [
        'password', 'remember_token',
    ];
}
