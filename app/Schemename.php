<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schemename extends Model
{
    public function loan() {
        return $this->hasOne('App\Loan');
    }
}
