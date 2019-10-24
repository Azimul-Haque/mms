<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public function group() {
        return $this->belongsTo('App\Group');
    }

    public function savings() {
        return $this->hasMany('App\Saving');
    }

    public function loans() {
        return $this->hasMany('App\Loan');
    }
}
