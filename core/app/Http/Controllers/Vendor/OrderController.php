<?php

namespace App\Http\Controllers\Vendor;

use Auth;
use App\Order;
use App\Vendor;
use App\Orderedproduct;
use Illuminate\Http\Request;
use App\GeneralSetting as GS; 
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
  private $var=0;
  public function orders(Request $request) {
      if ($request->order_number) {
        $orderids = Order::join('orderedproducts', 'orders.id', '=', 'orderedproducts.order_id')
        ->select('orders.id')
        ->groupBy('orders.id')
        ->where('vendor_id', Auth::guard('vendor')->user()->id)
        ->where('orders.unique_id', $request->order_number)
        ->get();
        $orderidarr = [];
        foreach ($orderids as $key => $orderid) {
          $orderidarr[] = $orderid->id;
        }
        $data['orders'] = Order::whereIn('id', $orderidarr)->orderBy('id', 'DESC')->paginate(10);
      } else {
        // $orderids = Order::join('orderedproducts', 'orders.id', '=', 'orderedproducts.order_id')->select('orders.id')->groupBy('orders.id')->where('vendor_id', Auth::guard('vendor')->user()->id)->get();
        $orderids = Orderedproduct::join('orders', 'orders.id', '=', 'orderedproducts.order_id')
                                    ->join('vendors','vendors.id','=','orderedproducts.vendor_id')
                                    ->join('products','products.id','=','orderedproducts.product_id')
                                    ->select('orders.id')
                                    ->groupBy('orders.id')
                                    ->where('orderedproducts.vendor_id', Auth::guard('vendor')
                                    ->user()->id)
                                    ->get();
        // dd($orderids);
        $orderidarr = [];
        foreach ($orderids as $key => $orderid) {
          $orderidarr[] = $orderid->id;
        }
        $data['orders'] = Order::whereIn('id', $orderidarr)->orderBy('id', 'DESC')->paginate(10);
      }

      // dd($data['orders']);
      return view('vendor.orders.orders', $data);
    }

    public function orderdetails($orderid) {
      $data['orderedproducts'] = Orderedproduct::where('order_id', $orderid)->where('vendor_id', Auth::guard('vendor')->user()->id)->orderBy('id', 'DESC')->get();
      $data['subtotal'] = 0;
      $data['ccharge'] = 0;
      foreach ($data['orderedproducts'] as $op) {
        if (empty($op->offered_product_price)) {
          $data['subtotal'] += $op->product_price*$op->quantity;
        } else {
          $data['subtotal'] += $op->offered_product_price*$op->quantity;
        }
        $data['ccharge'] += $op->coupon_amount;
      }
      $data['order'] = Order::find($orderid);
      $data['total'] = Orderedproduct::where('order_id', $orderid)->where('vendor_id', 1)->sum('product_total');
      $data['tax'] = ($data['order']->tax/100)*$data['subtotal'];
      return view('vendor.orders.details', $data);
    }

    public function shippingchange(Request $request) {
      $op = Order::find($request->orderid);
      $op->shipping_status = $request->value;
      $op->save();
      return "success";
    }

    public function acceptOrder(Request $request) {
      $id_order = DB::table('orders')->where('unique_id',$request->orderid)->first()->id;
      $orders=Orderedproduct::where('orderedproducts.vendor_id',Auth::guard('vendor')->user()->id)
                    ->where('orderedproducts.order_id', $id_order)
                    ->first();
        $cmd = Order::findOrfail($id_order);
        $cmd->approve = 1;
        $orders->approve = 1;
        $orders->save();
        $cmd->save();
      send_email($orders->user->email, $orders->user->first_name,$orders->user->phone,$orders->user->email, 
      'Commande acceptée', 
      "Votre commande a été acceptée.<p><strong>Numéro de commande: </strong>".$orders->unique_id.
      "</p><p><strong>Détails de la commande: </strong><a href='".url('/')."/".$orders->id.
      "/détails de la commande'>".url('/')."/".$orders->id."/détails de la commande"."</a></p>");
      return "success";
    }

    public function cancelOrder(Request $request) {
      $orders=Orderedproduct::join('orders', 'orders.id', '=', 'orderedproducts.order_id')
                    ->join('vendors','vendors.id','=','orderedproducts.vendor_id')
                    ->join('products','products.id','=','orderedproducts.product_id')
                    ->where('orderedproducts.vendor_id',Auth::guard('vendor')->user()->id)
                    ->where('orderedproducts.order_id', $request->orderid)
                    ->get();
      foreach($orders as $order){
        $order->approve = -1;
      }
      $order->save();
      send_email($order->user->email, $order->user->first_name,$order->user->phone,$order->user->email, 'Commande rejetée', "Votre commande a été refusée.<p><strong>Numéro de commande: </strong>$order->unique_id</p><p><strong>Détails de la commande: </strong><a href='".url('/')."/".$order->id."/détails de la commande'>".url('/')."/".$order->id."/détails de la commande"."</a></p>");
      return "success";
    }


    public function PendingOrders(Request $request) {
      if(Auth::guard('vendor')->check()){
      if (empty($request->term)){
        $data['term'] = '';
        $data['orders'] = Orderedproduct::join('orders','orderedproducts.order_id','=','orders.id')
                          ->join('vendors','vendors.id','=','orderedproducts.vendor_id')
                          ->where('vendors.id',Auth::guard('vendor')->user()->id)
                          ->where('orders.approve',0)
                          ->where('orders.shipping_status',0)
                          ->orderBy('orders.id', 'DESC')
                          ->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('approve', 0)->where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('vendor.orders.orders', $data);
    }
  }
    public function AcceptedOrders(Request $request) {
      if(Auth::guard('vendor')->check()){
      if (empty($request->term)) {
        $data['term'] = '';
        $gs = GS::first();
        $data['orders'] = Orderedproduct::join('orders','orderedproducts.order_id','=','orders.id')
        ->join('vendors','vendors.id','=','orderedproducts.vendor_id')
        ->where('vendors.id',Auth::guard('vendor')->user()->id)
        ->where('orders.approve',1)
        ->orderBy('orders.id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('approve', 1)->where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('vendor.orders.orders', $data);
    }
    }

    public function RejectedOrders(Request $request) {
      if(Auth::guard('vendor')->check()){
      if (empty($request->term)) {
        $data['term'] = '';
        $data['orders'] = Order::where('approve', -1)->orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('approve', -1)->where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('vendor.orders.orders', $data);
    }
    }

    public function pendingDelivery(Request $request) {
      if(Auth::guard('vendor')->check()){
      if (empty($request->term)) {
        $data['term'] = '';
        $data['orders'] = Orderedproduct::join('orders','orderedproducts.order_id','=','orders.id')
                        ->join('vendors','vendors.id','=','orderedproducts.vendor_id')
                        ->where('vendors.id',Auth::guard('vendor')->user()->id)
                        ->where('orders.shipping_status',0)
                        ->orderBy('orders.id', 'DESC')
                        ->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('shipping_status', 0)->where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('vendor.orders.orders', $data);
    }
    }

    public function pendingInprocess(Request $request) {
      if(Auth::guard('vendor')->check()){
      if (empty($request->term)) {
        $data['term'] = '';
        $data['orders'] = Orderedproduct::join('orders','orderedproducts.order_id','=','orders.id')
        ->join('vendors','vendors.id','=','orderedproducts.vendor_id')
        ->where('vendors.id',Auth::guard('vendor')->user()->id)
        ->where('orders.shipping_status',1)
        ->orderBy('orders.id', 'DESC')
        ->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('shipping_status', 1)->where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('vendor.orders.orders', $data);
    }
    }

    public function delivered(Request $request) {
      if(Auth::guard('vendor')->check()){
      if (empty($request->term)) {
        $data['term'] = '';
        $data['orders'] = Orderedproduct::join('orders','orderedproducts.order_id','=','orders.id')
        ->join('vendors','vendors.id','=','orderedproducts.vendor_id')
        ->where('vendors.id',Auth::guard('vendor')->user()->id)
        ->where('orders.shipping_status',2)
        ->orderBy('orders.id', 'DESC')
        ->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('shipping_status', 2)->where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('vendor.orders.orders', $data);
    }
    }

    public function cashOnDelivery(Request $request) {
      if(Auth::guard('vendor')->check()){
      if (empty($request->term)) {
        $data['term'] = '';
        $data['orders'] = Orderedproduct::join('orders','orderedproducts.order_id','=','orders.id')
        ->join('vendors','vendors.id','=','orderedproducts.vendor_id')
        ->where('vendors.id',Auth::guard('vendor')->user()->id)
        ->where('orders.payment_method',1)
        ->orderBy('orders.id', 'DESC')
        ->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('payment_method', 1)->where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('vendor.orders.orders', $data);
    }
    }

    public function advance(Request $request) {
      if(Auth::guard('vendor')->check()){
      if (empty($request->term)) {
        $data['term'] = '';
        $data['orders'] = Orderedproduct::join('orders','orderedproducts.order_id','=','orders.id')
        ->join('vendors','vendors.id','=','orderedproducts.vendor_id')
        ->where('vendors.id',Auth::guard('vendor')->user()->id)
        ->where('orders.payment_method',2)
        ->orderBy('orders.id', 'DESC')
        ->paginate(10);;
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('payment_method', 2)->where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('vendor.orders.orders', $data);
    }
    }

   /*  public function shippingchange(Request $request) {
      $gs = GS::first();

      $order = Order::find($request->orderid);
      $order->shipping_status = $request->value;
      $order->save();

      $ops = Orderedproduct::where('order_id', $order->id)->get();

      foreach ($ops as $key => $op) {
        $op = Orderedproduct::find($op->id);
        $op->shipping_status = $request->value;
        $op->save();
      }

      $sentVendors = [];


      // if order is in process
      if ($order->shipping_status == 1) {
        // if in main city
        if ($order->shipping_method == 'in') {
          // sending mails to vendor
          foreach ($order->orderedproducts as $key => $op) {
            if (!in_array($op->vendor->id, $sentVendors)) {
              $sentVendors[] = $op->vendor->id;
              send_email($op->vendor->email, $op->vendor->shop_name, 'Product delivery is in process', "Thanks for sending your products. We will send these products to customer via courier within ".$gs->in_min." to ".$gs->in_max." days.<p><strong>Order number: </strong>".$order->unique_id."</p> <p><strong>Order details: </strong><a href='".url('/')."/vendor"."/".$order->id."/orderdetails'>".url('/')."/vendor"."/".$order->id."/orderdetails"."</a></p>");
            }
          }
          // sending mail to user
          send_email($order->user->email, $order->user->first_name,$order->user->phone,$order->user->email 'Product delivery is in process', "Your product delivery is in process. We have collected products from vendors and will send to you via courier within ".$gs->in_min." to ".$gs->in_max." days.<p><strong>Order Number: </strong>$order->unique_id</p><p><strong>Order details: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");
          send_sms($order->user->phone, "Your product delivery is in process. We have collected products from vendors and will send to you via courier within ".$gs->in_min." to ".$gs->in_max." days.<p><strong>Order Number: </strong>$order->unique_id</p><p><strong>Order details: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");
        }
        // if in around main city
        elseif ($order->shipping_method == 'around') {
          // sending mails to vendor
          foreach ($order->orderedproducts as $key => $op) {
            if (!in_array($op->vendor->id, $sentVendors)) {
              $sentVendors[] = $op->vendor->id;
            }
          }

          // sending mail to user
          send_email($order->user->email, $order->user->first_name,$order->user->phone,$order->user->email 'Product delivery is in process', "Your product delivery is in process. We have collected products from vendors and will send to you via courier within ".$gs->am_min." to ".$gs->am_max." days.<p><strong>Order Number: </strong>$order->unique_id</p><p><strong>Order details: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");
          send_sms($order->user->phone, "Your product delivery is in process. We have collected products from vendors and will send to you via courier within ".$gs->am_min." to ".$gs->am_max." days.<p><strong>Order Number: </strong>$order->unique_id</p><p><strong>Order details: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");
        }
        // if in around world
        elseif ($order->shipping_method == 'world') {
          // sending mails to vendor
          foreach ($order->orderedproducts as $key => $op) {
            if (!in_array($op->vendor->id, $sentVendors)) {
              $sentVendors[] = $op->vendor->id;
              send_email($op->vendor->email, $op->vendor->shop_name, 'Product delivery is in process', "Thanks for sending your products. We will send these products to customer via courier within ".$gs->aw_min." to ".$gs->aw_max." days.<p><strong>Order number: </strong>".$order->unique_id."</p> <p><strong>Order details: </strong><a href='".url('/')."/vendor"."/".$order->id."/orderdetails'>".url('/')."/vendor"."/".$order->id."/orderdetails"."</a></p>");
            }
          }
          // sending mail to user
          send_email($order->user->email, $order->user->first_name,$order->user->phone,$order->user->email 'Product delivery is in process', "Your product delivery is in process. We have collected products from vendors and will send to you via courier within ".$gs->aw_min." to ".$gs->aw_max." days.<p><strong>Order Number: </strong>$order->unique_id</p><p><strong>Order details: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");
          send_sms($order->user->phone, "Your product delivery is in process. We have collected products from vendors and will send to you via courier within ".$gs->aw_min." to ".$gs->aw_max." days.<p><strong>Order Number: </strong>$order->unique_id</p><p><strong>Order details: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");

        }
      }
      // if order  is shipped
      elseif ($order->shipping_status == 2) {
        $orderedproducts = Orderedproduct::where('order_id', $order->id)->get();
        foreach ($orderedproducts as $key => $orderedproduct) {
          $today = Carbon::now();
          $orderedproduct->shipping_date = $today;
          $orderedproduct->save();

          // increase product sales
          $product = Product::find($orderedproduct->product_id);
          $product->sales = $product->sales + $orderedproduct->quantity;
          $product->save();

          $vendor = Vendor::find($orderedproduct->vendor_id);
          $vendor->balance = $vendor->balance + $orderedproduct->product_total;
          $vendor->save();

          $tr = new Transaction;
          $tr->vendor_id = $orderedproduct->vendor_id;
          $tr->details = "Sold  <strong>" . $orderedproduct->product->title . "</strong>";
          $tr->amount = $orderedproduct->product_total;
          $tr->trx_id = str_random(16);
          $tr->after_balance = $vendor->balance + $orderedproduct->product_total;
          $tr->save();
        }

        // sending mails to vendor
        foreach ($order->orderedproducts as $key => $op) {
          if (!in_array($op->vendor->id, $sentVendors)) {
            $sentVendors[] = $op->vendor->id;
            send_email($op->vendor->email, $op->vendor->shop_name, 'Products delivered', "Thanks sending you products. We have delivered yours products to customer.<p><strong>Order number: </strong>".$order->unique_id."</p> <p><strong>Order details: </strong><a href='".url('/')."/vendor"."/".$order->id."/orderdetails'>".url('/')."/vendor"."/".$order->id."/orderdetails"."</a></p>");
          }
        }

        // sending mail to user
        send_email($order->user->email, $order->user->first_name,$order->user->phone,$order->user->email 'Products delivered', "Thanks for choosing <strong>".$gs->website_title."</strong> for shopping. We have been noticed that you have received the desired products delivery. Please give a review/suggestion so that we can enhance quality of our products.<p><strong>Order Number: </strong>$order->unique_id</p><p><strong>Order details: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");
        send_sms($order->user->phone, "Thanks for choosing <strong>".$gs->website_title."</strong> for shopping. We have been noticed that you have received the desired products delivery. Please give a review/suggestion so that we can enhance quality of our products.<p><strong>Order Number: </strong>$order->unique_id</p><p><strong>Order details: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");
      }


      return "success";
    } */
}
