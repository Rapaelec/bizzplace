<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function category() {
        return $this->belongsTo('App\Category');
      }
      public function previewimages() {
        return $this->hasMany('App\PreviewImage');
      }
      public function subcategory() {
        return $this->belongsTo('App\Subcategory');
      }

      public function vendor() {
        return $this->belongsTo('App\Vendor');
      }
}
