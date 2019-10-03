<?php

namespace App\Http\Controllers\User;

use App\Order;
use App\Deliveryman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UpdateTotalController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    { 
        $priceVendor = Deliveryman::find($request->id)->delivery_price;
        $total=getTotal(Auth::user()->id);
        $ttc=$priceVendor+$total;
        if($priceVendor){
            $orders = Order::where('user_id',Auth::user()->id)->first();
            $orders->total = $ttc;
            $orders->save();
            return response()->json([
                'fail'=>false,
                'montant'=>$ttc
              ])->withCookie(cookie()->forever('montanttc',$ttc));
        }else{
            return response()->json([
                'fail'=>true
              ]);
        }
           
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
