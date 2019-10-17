<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Savingname extends Model
{
    public function savings() {
        return $this->hasMany('App\Saving');
    }
}
