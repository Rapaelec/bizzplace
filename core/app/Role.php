<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];

    public function users()
    {
     return $this->belongsToMany(User::class);
    }

    public function vendors(){
        return $this->belongsToMany('App\Vendor')->withPivot('role_vendor');
    }
}
