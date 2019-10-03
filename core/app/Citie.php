<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Citie extends Model
{
    protected $table  = 'cities';

    public static function  QueryGetCitie($code_depart){
        $query = DB::table('cities')->where('department_code',$code_depart)->get();
        return $query;
    }
}
