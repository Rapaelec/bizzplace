<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deliveryman extends Model
{
    protected $table = 'deliverymans';

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }
}
