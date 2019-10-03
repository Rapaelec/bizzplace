<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vendor;
use Auth;
use Validator;
use Session;

class LoginController extends Controller
{
    public function login() {
      return view('vendor.login');
    }

    public function authenticate(Request $request) {
        if (Auth::check()) {
          Session::flash('alert', 'Vous êtes déjà connecté en tant que vendeur');
          return back();
        }

        $vendor = Vendor::where('email', $request->email)->first();
        if (!empty($vendor) && ($vendor->approved == 0 || $vendor->approved == -1)) {
          return back()->with('missmatch', 'Le nom d’utilisateur / mot de passe ne correspond pas!');
        }

        $validatedRequest = $request->validate([
            'email_vendor_authenticate' => 'required',
            'password_vendor_authenticate' => 'required'
        ]);

        if (Auth::guard('vendor')->attempt([
          'email' => $request->email_vendor_authenticate,
          'password' => $request->password_vendor_authenticate,
        ])) {
            return redirect()->route('vendor.dashboard');
        } else {
            return back()->with('missmatch', 'Le nom d’utilisateur / mot de passe ne correspond pas!');
        }
    }

    public function logout($id = null) {
      Auth::guard('vendor')->logout();
      if ($id) {
          $vendor = Vendor::find($id);
          if ($vendor->status == 'blocked') {
              Session::flash('alert', 'Votre compte a été banni');
          }
      }
      session()->flash('message', 'Juste déconnecté!');
      return redirect()->route('user.home');
    }
}
