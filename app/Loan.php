<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    public function loanname() {
        return $this->belongsTo('App\Loanname');
    }

    public function loaninstallments() {
        return $this->hasMany('App\Loaninstallment');
    }
}
