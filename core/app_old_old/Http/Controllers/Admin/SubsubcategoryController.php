<?php

namespace App\Http\Controllers\Admin;

use App\Subcategory;
use App\Subsubcategory;
use App\ProductAttribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class SubsubcategoryController extends Controller
{
    public function index($id) {
        $data['subcategory'] = Subcategory::find($id);
        $data['subcats'] = Subsubcategory::where('subcategorie_id', $id)->get();
        $data['pas'] = ProductAttribute::where('status', 1)->get();
        return view('admin.subcategory1.index', $data);
      }
  
      public function store(Request $request) {
        $validatedRequest = $request->validate([
          'name' => 'required',
        ]);
  
        $attributes = json_encode($request->except('_token', 'name', 'subcategorie_id'));
        $subcat = new Subsubcategory;
        $subcat->subcategorie_id = $request->subcategory_id;
        $subcat->name = $request->name;
        $subcat->attributes = $attributes;
        $subcat->save();
  
        Session::flash('success', 'Sous sous categorie enregistrer avec success!!!');
        return redirect()->back();
      }
  
      public function update(Request $request) {
        $validatedRequest = $request->validate([
          'name' => 'required',
        ]);
        // return $request;
        $attributes = json_encode($request->except('_token', 'name', 'status', 'statusId'));
        $subcat = Subsubcategory::find($request->statusId);
        $subcat->name = $request->name;
        $subcat->attributes = $attributes;
        $subcat->status = $request->status;
        $subcat->save();
  
        Session::flash('success', 'Sous sous categorie mis à jour avec success !!!');
        return redirect()->back();
      }

      public function destroy(Request $request){
            if($request->ajax()){
                $subsubcategory = Subsubcategory::find($request->id);
                $subsubcategory->delete();
                return response()->json([
                    'result' =>'success'
                ]);
            }
      }
}
