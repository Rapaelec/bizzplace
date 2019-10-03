<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function cartgifts(){
        return $this->hasMany(Cartgift::class);
    }
}
