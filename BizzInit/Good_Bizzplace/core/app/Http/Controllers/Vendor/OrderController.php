<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Vendor;
use App\Orderedproduct;
use App\Order;

class OrderController extends Controller
{
    public function orders(Request $request) {
      if ($request->order_number) {
        $orderids = Order::join('orderedproducts', 'orders.id', '=', 'orderedproducts.order_id')->select('orders.id')->groupBy('orders.id')->where('vendor_id', 1)->where('orders.unique_id', $request->order_number)->get();
        $orderidarr = [];
        foreach ($orderids as $key => $orderid) {
          $orderidarr[] = $orderid->id;
        }
        $data['orders'] = Order::whereIn('id', $orderidarr)->orderBy('id', 'DESC')->paginate(10);
      } else {
        $orderids = Order::join('orderedproducts', 'orders.id', '=', 'orderedproducts.order_id')->select('orders.id')->groupBy('orders.id')->where('vendor_id', 1)->get();
        $orderidarr = [];
        foreach ($orderids as $key => $orderid) {
          $orderidarr[] = $orderid->id;
        }
        $data['orders'] = Order::whereIn('id', $orderidarr)->orderBy('id', 'DESC')->paginate(10);
      }

      // return $data['orders'];
      return view('vendor.orders.orders', $data);
    }

    public function orderdetails($orderid) {
      $data['orderedproducts'] = Orderedproduct::where('order_id', $orderid)->where('vendor_id', 1)->orderBy('id', 'DESC')->get();
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
      $order = Order::find($request->orderid);
      $order->approve = 1;
      $order->save();
      send_email($order->user->email, $order->user->first_name, 'Commande acceptée', "Votre commande a été acceptée.<p><strong>Numéro de commande: </strong>$order->unique_id</p><p><strong>Détails de la commande: </strong><a href='".url('/')."/".$order->id."/détails de la commande'>".url('/')."/".$order->id."/détails de la commande"."</a></p>");
      return "success";
    }

    public function cancelOrder(Request $request) {
      $order = Order::find($request->orderid);
      $order->approve = -1;
      $order->save();
      send_email($order->user->email, $order->user->first_name, 'Commande rejetée', "Votre commande a été refusée.<p><strong>Numéro de commande: </strong>$order->unique_id</p><p><strong>Détails de la commande: </strong><a href='".url('/')."/".$order->id."/détails de la commande'>".url('/')."/".$order->id."/détails de la commande"."</a></p>");
      return "success";
    }


    public function PendingOrders(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['orders'] = Order::where('approve', 0)->orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('approve', 0)->where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('vendor.orders.orders', $data);
    }

    public function AcceptedOrders(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['orders'] = Order::where('approve', 1)->orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('approve', 1)->where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('vendor.orders.orders', $data);
    }

    public function RejectedOrders(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['orders'] = Order::where('approve', -1)->orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('approve', -1)->where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('vendor.orders.orders', $data);
    }

    public function pendingDelivery(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['orders'] = Order::where('shipping_status', 0)->orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('shipping_status', 0)->where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('vendor.orders.orders', $data);
    }

    public function pendingInprocess(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['orders'] = Order::where('shipping_status', 1)->orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('shipping_status', 1)->where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('vendor.orders.orders', $data);
    }

    public function delivered(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['orders'] = Order::where('shipping_status', 2)->orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('shipping_status', 2)->where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('vendor.orders.orders', $data);
    }

    public function cashOnDelivery(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['orders'] = Order::where('payment_method', 1)->orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('payment_method', 1)->where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('vendor.orders.orders', $data);
    }

    public function advance(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['orders'] = Order::where('payment_method', 2)->orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('payment_method', 2)->where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('vendor.orders.orders', $data);
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
          send_email($order->user->email, $order->user->first_name, 'Product delivery is in process', "Your product delivery is in process. We have collected products from vendors and will send to you via courier within ".$gs->in_min." to ".$gs->in_max." days.<p><strong>Order Number: </strong>$order->unique_id</p><p><strong>Order details: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");
          send_sms($order->user->phone, "Your product delivery is in process. We have collected products from vendors and will send to you via courier within ".$gs->in_min." to ".$gs->in_max." days.<p><strong>Order Number: </strong>$order->unique_id</p><p><strong>Order details: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");
        }
        // if in around main city
        elseif ($order->shipping_method == 'around') {
          // sending mails to vendor
          foreach ($order->orderedproducts as $key => $op) {
            if (!in_array($op->vendor->id, $sentVendors)) {
              $sentVendors[] = $op->vendor->id;
              send_email($op->vendor->email, $op->vendor->shop_name, 'Product delivery is in process', "Thanks for sending your products. We will send these products to customer via courier within ".$gs->am_min." to ".$gs->am_max." days.<p><strong>Order number: </strong>".$order->unique_id."</p> <p><strong>Order details: </strong><a href='".url('/')."/vendor"."/".$order->id."/orderdetails'>".url('/')."/vendor"."/".$order->id."/orderdetails"."</a></p>");
            }
          }

          // sending mail to user
          send_email($order->user->email, $order->user->first_name, 'Product delivery is in process', "Your product delivery is in process. We have collected products from vendors and will send to you via courier within ".$gs->am_min." to ".$gs->am_max." days.<p><strong>Order Number: </strong>$order->unique_id</p><p><strong>Order details: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");
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
          send_email($order->user->email, $order->user->first_name, 'Product delivery is in process', "Your product delivery is in process. We have collected products from vendors and will send to you via courier within ".$gs->aw_min." to ".$gs->aw_max." days.<p><strong>Order Number: </strong>$order->unique_id</p><p><strong>Order details: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");
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
        send_email($order->user->email, $order->user->first_name, 'Products delivered', "Thanks for choosing <strong>".$gs->website_title."</strong> for shopping. We have been noticed that you have received the desired products delivery. Please give a review/suggestion so that we can enhance quality of our products.<p><strong>Order Number: </strong>$order->unique_id</p><p><strong>Order details: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");
        send_sms($order->user->phone, "Thanks for choosing <strong>".$gs->website_title."</strong> for shopping. We have been noticed that you have received the desired products delivery. Please give a review/suggestion so that we can enhance quality of our products.<p><strong>Order Number: </strong>$order->unique_id</p><p><strong>Order details: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");
      }


      return "success";
    } */
}
