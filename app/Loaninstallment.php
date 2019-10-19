<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loaninstallment extends Model
{
    public function loan() {
        return $this->belongsTo('App\Loan');
    }
}
