<?php

namespace App\Http\Controllers\Vendor;

use Auth;
use Session;
use App\Vendor;
use Illuminate\Http\Request;
use Intervention\Image\Image;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class SettingController extends Controller
{
    public function settings() {
      return view('vendor.settings');
    }

    public function update(Request $request) {
      // return $request;
      $vendor = Vendor::find(1);

      $request->validate([
        'shop_name' => [
        'required',
         /*  Rule::unique('vendors')->ignore($vendor->id), */
        ],
        'phone' => 'required',
        'address' => 'required',
        'zip_code' => 'required',
        'siret_code' => 'required',
        'regions_sect'=> 'required',
        'departement_sect'=>'required',
        'ville_sect'=>'required'
      ]);

      $in = Input::except('_token', 'logo','regions_sect','departement_sect','ville_sect');
      if($request->hasFile('logo')) {
        $imagePath = 'assets/user/img/shop-logo/' . $vendor->logo;
        @unlink($imagePath);
        $image = $request->file('logo');
        $fileName = time() . '.jpg';
        $location = './assets/user/img/shop-logo/' . $fileName;
        $background = Image::canvas(250, 250);
        $resizedImage = Image::make($image)->resize(250, 250, function ($c) {
            $c->aspectRatio();
        });
        // insert resized image centered into background
        $background->insert($resizedImage, 'center');
        // save or do whatever you like
        $background->save($location);
        $in['logo'] = $fileName;
      }
      $in['code_region']=$request->regions_sect;
      $in['code_depart']=$request->departement_sect;
      $in['code_ville']=$request->ville_sect;
      $vendor->fill($in)->save();
      Session::flash('success', 'Mis à jour éffectuée avec succés!');
      return redirect()->back();
    }
}
