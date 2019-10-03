<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function subcategories() {
      return $this->hasMany('App\Subcategory');
    }

    public function products() {
      return $this->hasMany('App\Product');
    }
    public function evenements() {
      return $this->hasMany('App\Evenement');
    }
    public function services() {
      return $this->hasMany('App\Service');
    }
    public function immobiliers() {
      return $this->hasMany('App\Immobilier');
    }
    public function allcategories() {
      return $this->hasMany('App\Allcategory');
    }
    public function emplois() {
      return $this->hasMany('App\Emploi');
    }

}
