<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public function groups() {
        return $this->hasMany('App\Group');
    }

    public function loaninstallments() {
        return $this->hasMany('App\Loaninstallment');
    }

    public function savinginstallments() {
        return $this->hasMany('App\Savinginstallment');
    }

    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];


    protected $hidden = [
        'password', 'remember_token',
    ];
}
