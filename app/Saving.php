<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    public function member() {
        return $this->belongsTo('App\Member');
    }

    public function savingname() {
        return $this->belongsTo('App\Savingname');
    }
}
