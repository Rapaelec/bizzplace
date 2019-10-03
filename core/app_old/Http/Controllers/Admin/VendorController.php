<?php

namespace App\Http\Controllers\Admin;

use Session;
use App\Role;
use App\Vendor;
use Illuminate\Http\Request;
use App\GeneralSetting as GS;
use App\Http\Controllers\Controller;

class VendorController extends Controller
{

  public function register(Request $request) {

    $gs = GS::first();
    if ($gs->registration == 0) {
      Session::flash('alert', 'L\'inscription est fermée par l\'administrateur');
      return back();
    }

    $validatedRequest = $request->validate([
        'shop_name' => 'nullable|unique:vendors',
        'email' => 'required|email|max:255|unique:vendors',
        'phone' => 'required',
        'password' => 'required|confirmed'
    ]);

    
    $vendor = new Vendor;
    if(empty($request->shop_name)){
      $vendor->shop_name = 'bizzplace';
    }else{
      $vendor->shop_name = $request->shop_name;
    }
    $vendor->email = $request->email;
    $vendor->phone = $request->phone;
    $vendor->password = bcrypt($request->password);
    $vendor->save();

    $role_vendeur = Role::where('name', 'vendeur_bizzplace')->first()->id;

    $vendor->roles()->attach($role_vendeur);

    return back()->with('message', 'Cliquer sur approuver pour activer votre compte ! Merci .');
}
    public function all(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['vendors'] = Vendor::orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['vendors'] = Vendor::where('shop_name', 'like', '%'.$request->term.'%')->orderBy('id', 'DESC')->paginate(10);
      }

      return view('admin.vendors.index', $data);
    }

    public function pending(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['vendors'] = Vendor::where('approved', 0)->orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['vendors'] = Vendor::where('approved', 0)->where('shop_name', 'like', '%'.$request->term.'%')->orderBy('id', 'DESC')->paginate(10);
      }
      return view('admin.vendors.index', $data);
    }

    public function accepted(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['vendors'] = Vendor::where('approved', 1)->orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['vendors'] = Vendor::where('approved', 1)->where('shop_name', 'like', '%'.$request->term.'%')->orderBy('id', 'DESC')->paginate(10);
      }
      return view('admin.vendors.index', $data);
    }

    public function rejected(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['vendors'] = Vendor::where('approved', -1)->orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['vendors'] = Vendor::where('approved', -1)->where('shop_name', 'like', '%'.$request->term.'%')->orderBy('id', 'DESC')->paginate(10);
      }
      return view('admin.vendors.index', $data);
    }

    public function accept(Request $request) {
      $vendor = Vendor::find($request->vendorid);
      $vendor->approved = 1;
      $vendor->save();
      Session::flash('success', 'Demande acceptée avec succès');

      send_email($vendor->email,$vendor->shop_name,$vendor->phone, $vendor->email, "Requête acceptée", "Félicitations, votre demande de fournisseur a été acceptée.");

      return "success";
    }

    public function reject(Request $request) {
      $vendor = Vendor::find($request->vendorid);
      $vendor->approved = -1;
      $vendor->save();
      Session::flash('alert', 'Demande rejetée avec succès');

      send_email($vendor->email, $vendor->shop_name,$vendor->phone,$vendor->email, "Requête rejetée", "Désolé, votre demande auprès du vendeur a été rejetée.");

      return "success";
    }
}
