<?php

namespace App\Http\Controllers;

use App\Region;
use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegionsController extends Controller
{
    public function getData(Request $request){ 
        $data=[];
        if($request->q){
            $search = $request->q;
        $data= DB::table("regions")
            		->select("code","name")
                    ->where('name','LIKE',"%$search%")
            		->get();
        return response()->json($data);
        }
    }
    public function JustUnTest(Request $request){
        $data=[];
        if($request->cod_region){
            $queryget=Region::QueryGetDepartment($request->cod_region);
            return json_decode($queryget);
        }
    }
}
