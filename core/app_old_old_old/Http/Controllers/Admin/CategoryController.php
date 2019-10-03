<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use Session;

class CategoryController extends Controller
{
    public function index() {
      $data['cats'] = Category::latest()->paginate(10);
      return view('admin.category.index', $data);
    }

    public function store(Request $request) {
      $validatedRequest = $request->validate([
        'name' => 'required',
        'description_short'=>'required',
        'description_long'=>'required'
      ]);

      $category = new Category;
      $category->name = $request->name;
      $category->true_name = strtoupper($request->true_name);
      $category->description_short = $request->description_short;
      $category->description_long = $request->description_long;
      $category->validation = $request->validation;
      $category->save();

      Session::flash('success', 'Catégorie ajoutée avec succès');
      return redirect()->back();
    }

    public function update(Request $request) {
      $validatedRequest = $request->validate([
        'name' => 'required',
        'description_short'=>'required',
        'description_long'=>'required'
      ]);

      $cat = Category::find($request->statusId);
      $cat->name = $request->name;
      $cat->true_name = strtoupper($request->true_name);
      $cat->status = $request->status;
      $cat->description_short = $request->description_short;
      $cat->description_long = $request->description_long;
      $cat->validation = $request->validation;
      $cat->save();

      Session::flash('success', 'Catégorie mise à jour avec succès');
      return redirect()->back();
    }

    public function delete(Request $request){
      if($request->ajax()){
          $category = Category::find($request->id);
          $category->delete();
          return response()->json([
              'result' =>'success'
          ]);
      }

}
}
