<?php

namespace App\Http\Controllers\Admin;

use App\Packgift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PackgiftController extends Controller
{
    public function index() {
        $data['packgift'] = Packgift::latest()->get();
        return view('admin.packgifts.index', $data);
      }
  
    public function store(Request $request) {
       
        $rules = [
            'title'=>'required',
            's_desc'=>'required',
            'price'=>'required',
            'validity'=>'required',
            'img_pack'=>'bail|nullable|required|image|mimes:jpeg,png,gif'
                ];
        
        Validator::make($request->all(),$rules)->validate();
  
        $package = new Packgift;
        $package->title = $request->title;
        $package->description = $request->s_desc;
        $package->price = $request->price;
        $package->validity = $request->validity;
        $package->status = $request->status;
        $imgpackgift = $request->file('img_pack');
        if($imgpackgift){
            $imgpackgift_full_name = time().'.'.$imgpackgift->getClientOriginalName();
            $upload_path = public_path();
            $image_url = $upload_path.'\\'.$imgpackgift_full_name;
                $success = $imgpackgift->move($upload_path,$imgpackgift_full_name);
                if($success){
                    $package->img_pack = $upload_path;
                }
            }
        $package->save();
  
        Session::flash('success', 'Pack cadeau crée avec success !!!');
  
        return redirect()->back();
      }
  
      public function show($id){
        $cartgifts = DB::table('packgifts')
                     ->join('cartgifts','cartgifts.packgift_id','=','packgifts.id')
                     ->select('packgifts.title','cartgifts.*')
                     ->where('cartgifts.packgift_id','=',$id)
                     ->paginate(10);
        $packgift = DB::table('packgifts')->get();
        return view('admin.cartgift.index', compact('cartgifts','packgift'));
    }

      public function update(Request $request) {
        $rules = [
            'title'=>'required',
            's_desc'=>'required',
            'price'=>'required',
            'validity'=>'required',
            'img_pack'=>'bail|nullable|max:10000'
        ];
        
        Validator::make($request->all(),$rules)->validate();
  
        $package = Packgift::find($request->packageID);
        $package->title = $request->title;
        $package->description = $request->s_desc;
        $package->price = $request->price;
        $package->validity = $request->validity;
        $package->status = $request->status;
        $imgpackgift = $request->file('img_pack');
            if($imgpackgift){
                $imgpackgift_full_name = time().'.'.$imgpackgift->getClientOriginalName();
                $upload_path = config('images.path');
                $image_url = $upload_path.$imgpackgift_full_name;
                $success = $imgpackgift->move($upload_path,$imgpackgift_full_name);
                if($success){
                    $package->img_pack =  $upload_path;
                }
            }
        $package->save();
  
        Session::flash('success', 'Pack Cadeau mise à jour avec success !');
  
        return redirect()->back();
      }

      public function delete(Request $request){
        if($request->ajax()){
            $packgifts = Packgift::find($request->id);
            $packgifts->delete();
            return response()->json([
                'result' =>'success'
            ]);
        }
    }
}