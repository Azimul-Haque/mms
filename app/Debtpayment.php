<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Debtpayment extends Model
{
    public function baddebt() {
        return $this->belongsTo('App\Baddebt');
    }
}
