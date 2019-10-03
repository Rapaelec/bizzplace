<?php

namespace App\Http\Controllers\Admin\withdrawMoney;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\WithdrawMethod as WM;
use Validator;
use Session;
use Image;

class withdrawMethodController extends Controller
{
    public function withdrawMethod() {
      $wms = WM::all();
      $data['wms'] = $wms;
      return view('admin.withdrawMoney.withdrawMethod.withdrawMethod', $data);
    }

    public function store(Request $request) {
      // return $request->all();
      $rules = [
        'wimg' => 'required',
        'methodName' => 'required',
        'minimum' => 'required|numeric',
        'maximum' => 'required|numeric',
        'charged' => 'required|numeric',
        'chargep' => 'required|numeric',
        'processTime' => 'required'
      ];

      $messages = [
        'wimg.required' => 'Withdraw logo is required',
        'methodName.required' => 'Le nom de la méthode est obligatoire',
        'minimum.required' => 'Fixer une limite de transaction minimale',
        'minimum.numeric' => 'La transaction minimale doit être un nombre',
        'maximum.required' => 'Définir une limite de transaction maximale',
        'maximum.numeric' => 'La transaction maximale doit être un nombre',
        'charged.required' => 'Fixer des frais fixes pour chaque transaction',
        'charged.numeric' => 'Frais fixes par transaction est un nombre',
        'chargep.required' => 'Définir un pourcentage de charge par transaction',
        'chargep.numeric' => 'Le pourcentage de charge par transaction est un nombre',
      ];


      $validatedRequest = $request->validate($rules, $messages);

      $wm = new WM;
      $wm->name = $request->methodName;

      if($request->hasFile('wimg')) {
        $image = $request->file('wimg');
        $fileName = time() . '.jpg';
        $location = './assets/withdraw/' . $fileName;
        $resizedImage = Image::make($image)->resize(800, 800)->save($location);
        $wm->logo = $fileName;
      }

      $wm->min_limit = $request->minimum;
      $wm->max_limit = $request->maximum;
      $wm->fixed_charge = $request->charged;
      $wm->percentage_charge = $request->chargep;
      $wm->process_time = $request->processTime;
      $wm->save();

      Session::flash('success', 'Ajoutée avec succès!');
      return redirect()->back();
    }

    public function edit() {
      $wmID = $_GET['wmID'];
      // return $wmID;
      $wm = WM::find($wmID);
      return $wm;
    }

    public function update(Request $request) {
      // return $request->all();
      $rules = [
        'name' => 'required',
        'min' => 'required|numeric',
        'max' => 'required|numeric',
        'charged' => 'required|numeric',
        'chargep' => 'required|numeric',
        'processtm' => 'required'
      ];

      $messages = [
        'name.required' => 'Le nom de la méthode est obligatoire',
        'min.required' => 'Fixer une limite de transaction minimale',
        'min.numeric' => 'La transaction minimale doit être un nombre',
        'max.required' => 'Définir une limite de transaction maximale',
        'max.numeric' => 'transaction maximale doit être un nombre',
        'charged.required' => 'Fixer des frais fixes pour chaque transaction',
        'charged.numeric' => 'Frais fixes par transaction est un nombre',
        'chargep.required' => 'Définir un pourcentage de charge par transaction',
        'chargep.numeric' => 'Le pourcentage de charge par transaction est un nombre',
        'processtm.required' => 'Le temps de traitement est obligatoire'
      ];

      $validator = Validator::make($request->all(), $rules, $messages);

      if ($validator->fails()) {
        $validator->errors()->add('error', 'true');
        return response()->json($validator->errors());
      }

      $wm = WM::find($request->wmID);
      $wm->name = $request->name;
      if($request->hasFile('wimg')) {
        // $imgPath = './assets/withdraw/' . $wm->logo;
        // if (file_exists($imgPath)) {
        //   unlink($imgPath);
        // }
        if (!empty($wm->logo)) {
          unlink('assets/withdraw/' . $wm->logo);
        }
        $image = $request->file('wimg');
        $fileName = time() . '.jpg';
        $location = './assets/withdraw/' . $fileName;
        $resizedImage = Image::make($image)->resize(800, 800)->save($location);
        $wm->logo = $fileName;
      }
      $wm->min_limit = $request->min;
      $wm->max_limit = $request->max;
      $wm->fixed_charge = $request->charged;
      $wm->percentage_charge = $request->chargep;
      $wm->process_time = $request->processtm;
      $wm->save();

      return "success";
    }

    public function destroy(Request $request) {
      // return $wmID;
      $wm = WM::find($request->wmID);
      // $wm->delete();
      $wm->deleted = 1;
      $wm->save();
      return "success";
    }

    public function enable(Request $request) {
        // return $wmID;
        $wm = WM::find($request->wmID);
        // $wm->delete();
        $wm->deleted = 0;
        $wm->save();
        return "success";
    }
}
