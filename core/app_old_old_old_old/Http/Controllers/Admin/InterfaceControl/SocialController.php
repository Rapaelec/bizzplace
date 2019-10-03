<?php

namespace App\Http\Controllers\Admin\InterfaceControl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GeneralSetting as GS;
use App\Social;
use Session;

class SocialController extends Controller
{
    public function index() {
      $data['socials'] = Social::all();
      return view('admin.interfaceControl.social.index', $data);
    }

    public function store(Request $request) {
      $messages = [
        'icon.required' => 'La police Font Awesome est requis !',
        'title.required' => 'Le champs URL est requis !',
      ];
      $validatedData = $request->validate([
          'icon' => 'required',
          'title' => 'required',
      ], $messages);
      $social = new Social;
      $social->fontawesome_code = $request->icon;
      $social->url = $request->title;
      $social->save();
      Session::flash('success', 'Nouveau lien reseau social ajouté avec succès!');
      return redirect()->back();
    }

    public function delete(Request $request) {
      $social = Social::find($request->socialID);
      $social->delete();
      Session::flash('success', 'Reseau social supprimé avec succès');
      return redirect()->back();
    }
}
