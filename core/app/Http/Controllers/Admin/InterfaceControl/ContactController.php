<?php

namespace App\Http\Controllers\Admin\InterfaceControl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GeneralSetting as GS;
use Session;
use Image;

class ContactController extends Controller
{
    public function index() {
      return view('admin.interfaceControl.contact.index');
    }

    public function update(Request $request) {
      $messages = [
        'con_title.required' => 'Le titre est requis',
        'con_phone.required' => 'Le numéro de téléphone est requis',
        'con_email.required' => 'L\'email est requis',
        'con_address.required' => 'L\'adresse est requis',
      ];

      $validatedData = $request->validate([
        'con_address' => 'required',
        'con_phone' => 'required',
        'con_email' => 'required',
        'work_hours' => 'required',
      ], $messages);

      $gs = GS::first();
      $gs->con_address = $request->con_address;
      $gs->con_phone = $request->con_phone;
      $gs->con_email = $request->con_email;
      $gs->work_hours = $request->work_hours;
      $gs->save();

      Session::flash('success', 'Contact mis à jour avec succès!');
      return redirect()->back();
    }
}
