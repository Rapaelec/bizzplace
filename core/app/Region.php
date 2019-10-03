<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Region extends Model
{
    public static function  QueryGetDepartment($code_region){
        $query = DB::table('departments')->where('region_code',$code_region)->get();
        return $query;
    }
}
