<?php

namespace App\Http\Controllers\Admin;

use App\Cartgift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CartgiftController extends Controller
{
    public function index(){
        $cartgifts = DB::table('packgifts')
        ->join('cartgifts','cartgifts.packgift_id','=','packgifts.id')
        ->select('packgifts.title','cartgifts.*')
        ->paginate(10);
       return view('admin.cartgift.allcartgift', compact('cartgifts')); 
    }
    public function store(Request $request){
        $rules = [
            'nombre_carte'=>'bail|required',
            'packgift'=>'bail|required',
            'nbre_caractere'=>'bail|required',
            'dure_util'=>'bail|required'
        ];

        Validator::make($request->all(),$rules)->validate();
        for($i=0;$i<$request->nombre_carte;$i++){
            $cartgift = new Cartgift;
            $code = $this->random($request->nbre_caractere);
            $cartgift->packgift_id = $request->packgift;
            $cartgift->num_cartgift = Hash::make($code);
            $cartgift->duree_utilisation = $request->dure_util;
            $cartgift->save();
        }

        Session::flash('success', 'Carte(s) cadeaux crée avec success !');
        return redirect()->back();

    }

    private function random($universal_key) {
        $string = "";
        $user_ramdom_key = "(aLABbC0cEd1[eDf2FghR3ij4kYXQl5Um-OPn6pVq7rJs8*tuW9I+vGw@xHTy&#)K]Z%§!M_S";
        srand((double)microtime()*time());
        for($i=0; $i<$universal_key; $i++) {
        $string .= $user_ramdom_key[rand()%strlen($user_ramdom_key)];
        }
        return $string;
        }

    public function update(){

    }
    public function delete(Request $request){
        if($request->ajax()){
            $cartgifts = Cartgift::find($request->id);
            $cartgifts->delete();
            return response()->json([
                'result' =>'success'
            ]);
        }
    }
}
