<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreviewImage extends Model
{
    public function product() {
      return $this->belongsTo('App\Product');
    }
    public function immobilier() {
      return $this->belongsTo('App\Immobilier');
    }
    public function allcategories() {
      return $this->hasMany('App\Allcategory');
    }
}
