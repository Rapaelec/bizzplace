<?php

namespace App\Http\Controllers;

use App\Vendor;
use App\Mail\MessageClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Notifications\VendorNotification;

class sendMailController extends Controller
{
    public function sendmailToVendor(Request $request){
        $validatedData = $request->validate([
          'nom_client' => 'required',
          'adress_email' => 'required',
          'subject_client' => 'required',
          'phone_client' => 'required',
          'message_client' => 'required'
      ]);

      $to = $request->email_vendor;
      $vendor= Vendor::where('email',$to)->first();

      $user_name = $request->nom_client;
      $user_email = $request->adress_email;
      $user_phone = $request->phone_client;
      $subject = $request->subject_client;
      $message = $request->message_client;
      
      // send_email($to, $name, $subject, $message);
      Mail::to($to)->send(new MessageClient($user_name,$user_phone,$user_email,$subject,$message));
      $vendor->notify(new VendorNotification);
      Session::flash('success', 'Mail envoyé avec success !');
      return redirect()->back();
      }
}
