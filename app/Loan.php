<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    public function loaninstallments() {
        return $this->hasMany('App\Loaninstallment');
    }
}
