<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function members() {
        return $this->hasMany('App\Member');
    }
}
