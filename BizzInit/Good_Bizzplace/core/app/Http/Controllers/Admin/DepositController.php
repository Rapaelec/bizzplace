<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vendor;
use App\DepositRequest as DR;
use App\Deposit;
use App\Gateway;
use App\Transaction;
use App\GeneralSetting as GS;
use Session;


class DepositController extends Controller
{
    public function pending() {
      $data['deposits'] = DR::where('accepted', 0)->latest()->paginate(9);
      return view('admin.deposit.index', $data);
    }

    public function acceptedRequests() {
      $data['deposits'] = DR::where('accepted', 1)->latest()->paginate(9);
      return view('admin.deposit.index', $data);
    }

    public function rejectedRequests() {
      $data['deposits'] = DR::where('accepted', -1)->latest()->paginate(9);
      return view('admin.deposit.index', $data);
    }

    public function showReceipt() {
      $dID = $_GET['dID'];
      $deposit = DR::find($dID);
      return $deposit;
    }

    public function accept(Request $request) {
      $gs = GS::first();


      $dr = DR::find($request->dID);
      $dr->accepted = 1;
      $dr->save();

      $vendor = Vendor::find($dr->vendor_id);
      $vendor->balance = $vendor->balance + $dr->amount;
      $vendor->save();

      $gt= Gateway::find($request->gid);
      $charge = $gt->fixed_charge + (($gt->percent_charge*$dr->amount)/100);

      $deposit = new Deposit;
      $deposit->vendor_id = $vendor->id;
      $deposit->gateway_id = $gt->id;
      $deposit->amount = $dr->amount;
      $deposit->charge = $charge;
      $deposit->usd_amo = ($dr->amount+$charge)/$gt->rate;
      $deposit->trx = str_random(16);
      $deposit->status = 1;
      $deposit->save();


      $tr = new Transaction;
      $tr->vendor_id = $vendor->id;
      $tr->details = "Depot Via " . $dr->gateway->name;
      $tr->amount = $dr->amount;
      $tr->trx_id = str_random(16);
      $tr->after_balance = $vendor->balance;
      $tr->save();

       $message = "Votre demande de dépôt a été acceptée. " . $dr->amount . ' ' . $gs->base_curr_text . ' cela a été ajouté au solde de votre compte';
       send_email($vendor->email, $vendor->shop_name, "Deposit request accepted", $message);

      Session::flash('success', 'La demande a été acceptée avec succès');
      return redirect()->back();
    }

    public function depositLog() {
      $data['deposits'] = Deposit::latest()->paginate(9);
      return view('admin.deposit.depositLog', $data);
    }

    public function rejectReq(Request $request) {
      $gs = GS::first();


      $dr = DR::find($request->dID);
      $dr->accepted = -1;
      $dr->save();

      $vendor = Vendor::find($dr->vendor_id);

      $message = "Votre demande de dépôt de " . $dr->amount . " " . $gs->base_curr_text . " a été rejetée";
      send_email($vendor->email, $vendor->shop_name, "Demande de dépôt rejetée", $message);

      Session::flash('success', 'Votre requête a été rejetée');
      return redirect()->back();
    }
}
