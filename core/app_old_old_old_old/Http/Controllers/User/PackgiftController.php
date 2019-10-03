<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Deposit;
use App\Gateway;
use App\Packgift;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PackgiftController extends Controller
{
    public function index(){
        $data['packgifts'] = Packgift::where('status', 1)->latest()->get();
        return view('user.packgifts.index', $data);
    }



    public function formshowpay(Request $request){
        $data['packgifts'] = Packgift::find($request->id);
        $data['gateways'] = Gateway::where('status', 1)->take(2)->get();
     
       return view('user.packgifts.showformpay', $data);
    }

    public function store(Request $request){
        $rules = [
            'user_name'=>'required',
            'user_lastname'=>'required',
            'user_phone'=>'required',
            'user_email'=>'required',
            'beneficiary_name'=>'required',
            'beneficiary_lastname'=>'required',
            'beneficiary_phone'=>'required',
            'beneficiary_email'=>'required',
            'beneficiary_password'=>'required',
            'beneficiary_message'=>'required',
        ];

        Validator::make($request->all(),$rules)->validate();
       /*  $users = new User;
        $users->first_name = $request->beneficiary_name;
        $users->last_name = $request->beneficiary_lastname;
        $users->email = $request->beneficiary_email;
        $users->phone = $request->beneficiary_phone;
        $users->message = $request->beneficiary_message;
        $users->status = 'no active';
        $users->password = Hash::make($request->beneficiary_password);

        $users->save(); */
        
        $data['track'] = Session::get('Track');
        $data['data'] = Deposit::where('status',0)->where('trx',$data)->first();
        $data['gateways'] = Gateway::where('status', 1)
        ->where('id',$request->moyen_paiment)
        ->first();
        $data['packgifts'] = Packgift::find($request->id_pack);
       
        
        return view('user.deposit.preview',$data);
    }
}
