<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }
}
