<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdressShipping extends Model
{
  protected $table = 'adress_shipping';
    protected $guarded = [];

    public function user() {
      return $this->belongsTo('App\User');
    }

    public function vendor() {
      return $this->belongsTo('App\Vendor');
    }
    
    public function order() {
      return $this->belongsTo('App\Order');
    }
}
