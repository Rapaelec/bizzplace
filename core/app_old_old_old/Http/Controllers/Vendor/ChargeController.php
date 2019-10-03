<?php

namespace App\Http\Controllers\Vendor;

use Session;
use Validator;
use Illuminate\Http\Request;
use App\GeneralSetting as GS;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChargeController extends Controller
{
    public function index() {
      $data['vendors']=gs::where('vendor_id',Auth::guard('vendor')->user()->id)->first();
      return view('vendor.charge.index',$data);
    }

    public function shippingupdate(Request $request) {
        $validator = Validator::make($request->all(),[
          'in_min' => 'required',
          'in_max' => 'required',
          'am_min' => 'required',
          'am_max' => 'required',
          'aw_min' => 'required',
          'aw_max' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
                        // ->withInput();
        }
        
      $gs = GS::updateOrCreate([
        'vendor_id'=>Auth::guard('vendor')->user()->id],[
        'in_min' => $request->in_min,
        'in_max' => $request->in_max,
        'am_min' => $request->am_min,
        'am_max' => $request->am_max,
        'aw_min' => $request->aw_min,
        'aw_max' => $request->aw_max,
        'in_cash_on_delivery' => $request->in_cash_on_delivery !='' ? $request->in_cash_on_delivery : 0.00,
        'in_advanced' => $request->in_advanced != '' ? $request->in_advanced : 0.00,
        'around_cash_on_delivery' => $request->around_cash_on_delivery !='' ? $request->around_cash_on_delivery : 0.00,
        'around_advanced' => $request->around_advanced !='' ? $request->around_advanced : 0.00,
        'world_cash_on_delivery' => $request->world_cash_on_delivery!=''? $request->world_cash_on_delivery : 0.00,
        'world_advanced' => $request->world_advanced !='' ? $request->world_advanced : 0.00,
        'tax' => $request->tax !='' ? $request->tax : 0.00,
      ]);

      Session::flash('success', 'Mis à jour avec succés!');

      return back();
    }


}
