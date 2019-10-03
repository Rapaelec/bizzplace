<?php

namespace App\Http\Controllers\Vendor;

use Auth;
use Image;
use Session;
use App\Cart;
use App\Admin;
use App\Order;
use App\Vendor;
use App\Gateway;
use Stripe\Token;
use Stripe\Charge;
use Stripe\Stripe;
use App\CartCoupon;
use App\Lib\BlockIo;
use App\Transaction;
use App\Orderpayment;
use App\PlacePayment;
use App\GeneralSetting;
use App\Orderedproduct;
use App\Lib\coinPayments;
use Illuminate\Http\Request;
use App\Lib\CoinPaymentHosted;
use App\Http\Controllers\Controller;

class GatewayController extends Controller {
    /* public function gateways($orderid = null) {
        $data['gateways'] = Gateway::where('status', 1)->get();
        $data['orderid'] = $orderid;
        return view('user.gateways', $data);
    }
 */
    public function paymentDataInsert(Request $request) {
        if ($request->validation <= 0) {
            return back()->with('alert', 'Compte invalide');
        } else {
           
            $gate = Gateway::findOrFail(101);
            if (isset($gate)){
                $usdamo = $request->amount/$gate->rate;
                $payment['order_id'] = $request->orderid;
                $payment['vendor_id'] = Auth::guard('vendor')->user()->id;
                $payment['gateway_id'] = $gate->id;
                $payment['amount'] = $request->amount;
                $payment['usd_amo'] = round($usdamo, 2);
                $payment['btc_amo'] = 0;
                $payment['btc_wallet'] = "";
                $payment['trx'] = str_random(16);
                $payment['try'] = 0;
                $payment['status'] = 0;
                if($payment['amount']==15){
                    $payment['fields_formule']='formule1';
                }elseif($payment['amount']==22){
                    $payment['fields_formule']='formule2';
                }   
                $payment['statut_compte'] = 'vendor';

                Orderpayment::create($payment);
                Session::put('Track', $payment['trx']);
                return redirect()->route('vendor.paymentPreview');
            }else{
                return back()->with('alert', 'Veuillez sélectionner une passerelle');
            }
        }
    }

    public function paymentPreview(){
        $track = Session::get('Track');
        $data = Orderpayment::where('status', 0)->where('trx', $track)->first();
        $pt = 'Payment Preview';
        return view('vendor.payment.preview', compact('pt', 'data'));
    }

    public function paymentConfirmFormule(Request $request) {
        $gnl = GeneralSetting::first();
        $track = Session::get('Track');
        // dd($track);
        $data = Orderpayment::where('trx', $track)->orderBy('id', 'DESC')->first();
        // return $data;
        // dd($data);
        if (is_null($data)) {
            return redirect()->route('user.gateways')->with('alert', 'Demande de paiement invalide');
        }
        if ($data->status != 0) {
            return redirect()->route('user.gateways')->with('alert', 'Demande de paiement invalide');
        }
        $gatewayData = Gateway::where('id', $data->gateway_id)->first();
        if ($data->gateway_id == 101) {
            $paypal['amount'] = $request->amount;
            // dd($paypal['amount']);
            $paypal['id_bizzplace'] = Admin::find(1)->id;
            $paypal['sendto'] = $gatewayData->val1;
            $paypal['track'] = $track;
            // dd('hhh');
            return view('vendor.payment.paymentViews.paypal', compact('paypal', 'gnl'));
        }
    }
}