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

    public function savinginstallments() {
        return $this->hasMany('App\Savinginstallment');
    }

    public function loans() {
        return $this->hasMany('App\Loan');
    }
}
