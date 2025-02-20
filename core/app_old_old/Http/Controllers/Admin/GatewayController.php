<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Gateway as Gateway;
use Session;
use Image;

class GatewayController extends Controller
{
    public function index() {
      $data['gateways'] = Gateway::first();
      return view('admin.gateway.index', $data);
    }

    public function store(Request $request) {
      $gatewayID = $request->id;
      $messages = [
        'gateimg.mimes' => 'Le logo de la passerelle doit être un fichier de type: jpeg, jpg, png.',
        'minamo.required' => 'Une limite minimale par transaction est requise',
        'minamo.numeric' => 'La limite minimale par transaction doit être le nombre',
        'maxamo.required' => 'La limite maximale par transaction est requise',
        'maxamo.numeric' => 'La limite maximale par transaction doit être le nombre',
        'chargefx.required' => 'Des frais fixes sont requis',
        'chargefx.numeric' => 'La charge fixe doit être un numéro',
        'chargepc.required' => 'Charge en pourcentage est requis',
        'chargepc.numeric' => 'Charge en pourcentage doit être le nombre',

      ];
      $validatedData = $request->validate([
          'name' => 'required',
          'gateimg' => 'mimes:jpeg,jpg,png',
          'rate' => 'required',
          'minamo' => 'required|numeric',
          'maxamo' => 'required|numeric',
          'chargefx' => 'required|numeric',
          'chargepc' => 'required|numeric',
      ], $messages);
      $gateway = new Gateway;
      for ($i=900; $i < 1200 ; $i++) {
        $gw = Gateway::find($i);
        if (empty($gw)) {
          $gateway->id = $i;
          break;
        }
      }
      $gateway->name = $request->name;
      $gateway->main_name = $request->name;
      $gateway->minamo = $request->minamo;
      $gateway->maxamo = $request->maxamo;
      $gateway->rate = $request->rate;
      if($request->hasFile('gateimg')) {
        $fileName = $gateway->id . '.jpg';
        $image = $request->file('gateimg');
        $location = 'assets/gateway/' . $fileName;
        Image::make($image)->resize(800, 800)->save($location);
      }
      $gateway->fixed_charge = $request->chargefx;
      $gateway->percent_charge = $request->chargepc;

      $gateway->val3 = $request->val3;

      $gateway->status = $request->status;

      $gateway->save();

      Session::flash('success', 'Passerelle ajoutée avec succès');

      return redirect()->back();
    }

    public function update(Request $request) {
      $gatewayID = $request->id;
      $messages = [
        'gateimg.mimes' => 'Le logo de la passerelle doit être un fichier de type: jpeg, jpg, png.',
        'minamo.required' => 'Une limite minimale par transaction est requise',
        'minamo.numeric' => 'La limite minimale par transaction doit être le nombre',
        'maxamo.required' => 'La limite maximale par transaction est requise',
        'maxamo.numeric' => 'La limite maximale par transaction doit être le nombre',
        'chargefx.required' => 'Des frais fixes sont requis',
        'chargefx.numeric' => 'La charge fixe doit être un numéro',
        'chargepc.required' => 'Charge en pourcentage est requis',
        'chargepc.numeric' => 'Charge en pourcentage doit être le nombre',

      ];
      $validatedData = $request->validate([
          'name' => 'required',
          'rate' => 'required|numeric',
          'gateimg' => 'mimes:jpeg,jpg,png',
          'minamo' => 'required|numeric',
          'maxamo' => 'required|numeric',
          'chargefx' => 'required|numeric',
          'chargepc' => 'required|numeric',
      ], $messages);

      $gateway = Gateway::find($gatewayID);
      $gateway->name = $request->name;
      $gateway->rate = $request->rate;
      $gateway->minamo = $request->minamo;
      $gateway->maxamo = $request->maxamo;
      if($request->hasFile('gateimg')) {
        $gateImagePath = 'assets/gateway/' . $gateway->id . '.jpg';
        if(file_exists($gateImagePath)) {
          unlink($gateImagePath);
        }
        $image = $request->file('gateimg');
        $fileName = $gateway->id . '.jpg';
        $location = 'assets/gateway/' . $fileName;
        Image::make($image)->resize(800, 800)->save($location);
      }
      $gateway->fixed_charge = $request->chargefx;
      $gateway->percent_charge = $request->chargepc;
      if ($gatewayID > 899) {
        $gateway->val3 = $request->val3;
      }
      if ($gatewayID == 101) {
        $gateway->val1 = $request->val1;
      }
      if ($gatewayID == 102) {
        $gateway->val1 = $request->val1;
        $gateway->val2 = $request->val2;
      }
      if($gatewayID == 103) {
        $gateway->val1 = $request->val1;
        $gateway->val2 = $request->val2;
      }
      if($gatewayID == 104) {
        $gateway->val1 = $request->val1;
        $gateway->val2 = $request->val2;
      }
      if($gatewayID == 105) {
        $gateway->val1 = $request->val1;
        $gateway->val2 = $request->val2;
        $gateway->val3 = $request->val3;
        $gateway->val4 = $request->val4;
        $gateway->val5 = $request->val5;
        $gateway->val6 = $request->val6;
        $gateway->val7 = $request->val7;
      }
      if($gatewayID == 106) {
        $gateway->val1 = $request->val1;
        $gateway->val2 = $request->val2;
      }
      if($gatewayID == 107) {
        $gateway->val1 = $request->val1;
        $gateway->val2 = $request->val2;
      }
      if($gatewayID == 108) {
        $gateway->val1 = $request->val1;
      }
      if($gatewayID == 501) {
        $gateway->val1 = $request->val1;
        $gateway->val2 = $request->val2;
      }
      if($gatewayID == 502) {
        $gateway->val1 = $request->val1;
        $gateway->val2 = $request->val2;
        $gateway->val3 = $request->val3;
      }
      if($gatewayID == 503) {
        $gateway->val1 = $request->val1;
        $gateway->val2 = $request->val2;
      }
      if($gatewayID == 504) {
        $gateway->val1 = $request->val1;
        $gateway->val2 = $request->val2;
      }
      if($gatewayID == 505) {
        $gateway->val1 = $request->val1;
        $gateway->val2 = $request->val2;
      }
      if($gatewayID == 506) {
        $gateway->val1 = $request->val1;
        $gateway->val2 = $request->val2;
      }
      if($gatewayID == 507) {
        $gateway->val1 = $request->val1;
        $gateway->val2 = $request->val2;
      }
      if($gatewayID == 508) {
        $gateway->val1 = $request->val1;
        $gateway->val2 = $request->val2;
      }
      if($gatewayID == 509) {
        $gateway->val1 = $request->val1;
        $gateway->val2 = $request->val2;
      }
      if($gatewayID == 510) {
        $gateway->val1 = $request->val1;
        $gateway->val2 = $request->val2;
      }
      if ($gatewayID == 512) {
        $gateway->val1 = $request->val1;
      }
      if($gatewayID == 513) {
        $gateway->val1 = $request->val1;
        $gateway->val2 = $request->val2;
      }
      $gateway->status = $request->status;

      $gateway->save();

      Session::flash('success', $gateway->name.' informations mises à jour avec succès!');

      return redirect()->back();
    }
}
