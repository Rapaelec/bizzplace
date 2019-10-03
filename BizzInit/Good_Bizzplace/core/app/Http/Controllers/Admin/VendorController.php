<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GeneralSetting as GS;
use App\Vendor;
use Session;

class VendorController extends Controller
{
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

      send_email( $vendor->email, $vendor->shop_name, "Requête acceptée", "Félicitations, votre demande de fournisseur a été acceptée.");

      return "success";
    }

    public function reject(Request $request) {
      $vendor = Vendor::find($request->vendorid);
      $vendor->approved = -1;
      $vendor->save();
      Session::flash('alert', 'Demande rejetée avec succès');

      send_email( $vendor->email, $vendor->shop_name, "Requête rejetée", "Désolé, votre demande auprès du vendeur a été rejetée.");

      return "success";
    }
}
