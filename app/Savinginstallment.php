<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Savinginstallment extends Model
{
    public function savingsingle() {
        return $this->belongsTo('App\Saving', 'saving_id'); // just saving likhle error dicche
    }
}
