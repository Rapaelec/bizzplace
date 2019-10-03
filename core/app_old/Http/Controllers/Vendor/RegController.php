<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vendor;
use App\GeneralSetting as GS;
use Auth;
use Session;

class RegController extends Controller
{
    public function showRegForm() {
      return view('vendor.register');
    }

    public function register(Request $request) {
        // return $request->all();

        $gs = GS::first();
        if ($gs->registration == 0) {
          Session::flash('alert', 'L\'inscription est fermée par l\'administrateur');
          return back();
        }

        $validatedRequest = $request->validate([
            'shop_name' => 'required|unique:vendors',
            'email' => 'required|email|max:255|unique:vendors',
            'phone' => 'required|numeric',
            'siret' => 'required|numeric',
            'address' => 'required',
            'password' => 'required|confirmed'
        ]);


        $vendor = new Vendor;
        $vendor->shop_name = $request->shop_name;
        $vendor->phone = $request->phone;
        $vendor->siret_code = $request->siret;
        $vendor->email = $request->email;
        $vendor->address = $request->address;
        $vendor->password = bcrypt($request->password);
        $to = 'admin@gmail.com';
        $vendor->save();
        send_email($to,$vendor->shop_name,$vendor->phone, $vendor->email, "Validation d'un compte vendeur", "Veuillez-vous connecter à votre compte admin pour valider ce compte merci!!!.");
        return back()->with('message', 'Vos informations seront examinées par l\'administrateur. Nous vous informerons,après vérification par le biais de votre compte Email une fois que celle-ci aura été vérifiée! Merci .');
    }
}
