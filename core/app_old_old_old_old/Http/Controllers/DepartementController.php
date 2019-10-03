<?php

namespace App\Http\Controllers;

use App\Citie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartementController extends Controller
{
    public function getData(Request $request){ 
        $data=[];
        if($request->q){
            $search = $request->q;
        $data= DB::table("departments")
            		->select("name","code","region_code")
                    ->where('name','LIKE',"%$search%")
                    ->get();
            return response()->json($data);
        }
    } 
    
    public function JustUnTest(Request $request){
        $data=[];
        if($request->cod_depart){
            $queryget=Citie::QueryGetCitie($request->cod_depart);
            return json_decode($queryget);
        }
    }
}
