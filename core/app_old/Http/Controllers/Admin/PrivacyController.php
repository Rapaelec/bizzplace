<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GeneralSetting as GS;
use Session;

class PrivacyController extends Controller
{
    public function index() {
      return view('admin.privacy.index');
    }

    public function update(Request $request) {
      $messages = [
        'privacy.required' => 'Le champ Termes et conditions est obligatoire'
      ];

      $validatedRequest = $request->validate([
        'privacy' => 'required'
      ], $messages);

      $gs = GS::first();
      $gs->privacy = $request->privacy;
      $gs->save();
      Session::flash('success', 'Politique de confidentialité mise à jour avec succès!');

      return redirect()->back();
    }
}
