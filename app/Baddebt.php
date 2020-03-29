<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Baddebt extends Model
{
    public function debtpayments() {
        return $this->hasMany('App\Debtpayment');
    }
}
