<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Session;

class VerificationController extends Controller
{
    public function showEmailVerForm() {
      if(Auth::check() && Auth::user()->email_verified == 0) {

        // sending verification code in email...
        if (Auth::user()->email_sent == 0) {
          $to = Auth::user()->email;
          $name = Auth::user()->name;
          $subject = "Code de vérification de l'email";
          $message = "Votre code de vérification est: " . Auth::user()->email_ver_code;
          send_email( $to, $name, $subject, $message);

          // making the 'email_sent' 1 after sending mail...
          $user = User::find(Auth::user()->id);
          $user->email_sent = 1;
          $user->save();
        }

        return view('user.verification.emailVerification');
      }

      return redirect()->route('user.home');
    }

    public function showSmsVerForm() {
        if(Auth::check() && Auth::user()->sms_verified == 0) {
          // sending verification code in email...
          if (Auth::user()->sms_sent == 0) {
            $to = Auth::user()->phone;
            $message = "Votre code de vérification est: " . Auth::user()->sms_ver_code;
            send_sms( $to, $message);

            // making the 'email_sent' 1 after sending mail...
            $user = User::find(Auth::user()->id);
            $user->sms_sent = 1;
            $user->save();
          }
          return view('user.verification.smsVerification');

        }
        return redirect()->route('user.home');
    }

    public function emailVerification(Request $request) {
      $messages = [
        'email_ver_code.required' => 'Le code de vérification par courrier électronique est requis',
      ];
      $validatedData = $request->validate([
          'email_ver_code' => 'required',
      ],$messages);
      $user = User::find(Auth::user()->id);
      if($user->email_ver_code == $request->email_ver_code) {
        $user->email_sent = 0;
        $user->email_verified = 1;
        $user->save();
        return redirect()->route('user.home');
      }
      Session::flash('error', "Le code de vérification ne correspond pas!");
      return redirect()->back();
    }

    public function smsVerification(Request $request) {
      $messages = [
        'sms_ver_code.required' => 'Le code de vérification par SMS est requis',
      ];
      $validatedData = $request->validate([
          'sms_ver_code' => 'required',
      ],$messages);
      $user = User::find(Auth::user()->id);
      if($user->sms_ver_code == $request->sms_ver_code) {
        $user->sms_sent = 0;
        $user->sms_verified = 1;
        $user->save();
        return redirect()->route('user.home');
      }
      Session::flash('error', "Le code de vérification ne correspond pas!");
      return redirect()->back();
    }

    public function sendVcode(Request $request)
   {
       $user = User::find(Auth::id());
       $chktm = $user->vsent+1000;
       if ($chktm > time())
       {
           $delay = $chktm-time();
           return back()->with('alert', 'S\'il vous plaît essayer après '.$delay.' seconds');
       }
       else
       {
           $email = $request->email;
           $mobile = $request->phone;
           $code = rand(1000, 9999);
           $msg = 'Votre code de vérification est: '.$code;
           $user->email_ver_code = $code ;
           $user->email_sent = 1 ;
           $user->vsent = time();
           $user->save();

           if(isset($email))
           {
               send_email($user->email, $user->username, 'Verification Code', $msg);
               return back()->with('success', 'Code de vérification de l\'e-mail envoyé avec succès');
           }
           elseif(isset($mobile))
           {
               send_sms($user->mobile, $msg);
               return back()->with('success', 'Code de vérification SMS envoyé avec succès');
           }
           else
           {
               return back()->with('alert', 'Envoi échoué');
           }

       }

   }
}
