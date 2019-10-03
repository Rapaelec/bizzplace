<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VilleController extends Controller
{
    public function getData(Request $request){ 
        $data=[];
        if($request->q){
            $search = $request->q;
        $data= DB::table("cities")
            		->select("id","name")
                    ->where('name','LIKE',"%$search%")
            		->get();
            return response()->json($data);
        }
    }
}
