<?php

namespace App\Http\Controllers\Admin;

use Session;
use App\Category;
use App\Subcategory;
use App\Subsubcategory;
use App\ProductAttribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubcategoryController extends Controller
{

  public function index($id) {
    $data['category'] = Category::find($id);
    $data['subcats'] = Subcategory::where('category_id', $id)->get();
    $data['pas'] = ProductAttribute::where('status', 1)->get();
    return view('admin.subcategory.index', $data);
  }

  public function store(Request $request) {
    $validatedRequest = $request->validate([
      'name' => 'required',
    ]);

    $attributes = json_encode($request->except('_token', 'name', 'category_id'));
    $subcat = new Subcategory;
    $subcat->category_id = $request->category_id;
    $subcat->name = $request->name;
    $subcat->attributes = $attributes;
    $subcat->save();

    Session::flash('success', 'Sous-catégorie enregistrée avec succès');
    return redirect()->back();
  }

  public function update(Request $request) {
    $validatedRequest = $request->validate([
      'name' => 'required',
    ]);
    // return $request;
    $attributes = json_encode($request->except('_token', 'name', 'status', 'statusId'));
    $subcat = Subcategory::find($request->statusId);
    $subcat->name = $request->name;
    $subcat->attributes = $attributes;
    $subcat->status = $request->status;
    $subcat->save();

    Session::flash('success', 'Sous-catégorie mis à jour avec succès');
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
