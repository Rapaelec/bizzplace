<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GeneralSetting as GS;
use App\Order;
use App\Orderedproduct;
use App\Product;
use App\Vendor;
use Carbon\Carbon;
use App\Transaction;

class OrderController extends Controller
{
    public function all(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['orders'] = Order::orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }

      return view('admin.orders.index', $data);
    }

    public function cPendingOrders(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['orders'] = Order::where('approve', 0)->orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('approve', 0)->where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('admin.orders.index', $data);
    }

    public function cAcceptedOrders(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['orders'] = Order::where('approve', 1)->orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('approve', 1)->where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('admin.orders.index', $data);
    }

    public function cRejectedOrders(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['orders'] = Order::where('approve', -1)->orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('approve', -1)->where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('admin.orders.index', $data);
    }

    public function pendingDelivery(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['orders'] = Order::where('shipping_status', 0)->orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('shipping_status', 0)->where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('admin.orders.index', $data);
    }

    public function pendingInprocess(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['orders'] = Order::where('shipping_status', 1)->orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('shipping_status', 1)->where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('admin.orders.index', $data);
    }

    public function delivered(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['orders'] = Order::where('shipping_status', 2)->orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('shipping_status', 2)->where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('admin.orders.index', $data);
    }

    public function cashOnDelivery(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['orders'] = Order::where('payment_method', 1)->orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('payment_method', 1)->where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('admin.orders.index', $data);
    }

    public function advance(Request $request) {
      if (empty($request->term)) {
        $data['term'] = '';
        $data['orders'] = Order::where('payment_method', 2)->orderBy('id', 'DESC')->paginate(10);
      } else {
        $data['term'] = $request->term;
        $data['orders'] = Order::where('payment_method', 2)->where('unique_id', $request->term)->orderBy('id', 'DESC')->paginate(10);
      }
      return view('admin.orders.index', $data);
    }

    public function shippingchange(Request $request) {
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
              // send_email($refund->orderedproduct->user->email, $refund->orderedproduct->user->phone, $refund->orderedproduct->user->first_name, $refund->orderedproduct->user->email ,'Demande de remboursement acceptée', "Votre demande de remboursement pour <a href='".url('/')."/product/".$refund->orderedproduct->product->slug . "/" . $refund->orderedproduct->product->id."'>" .$refund->orderedproduct->product->title. "</a> a été accepté. Vous aurez ". $refund->orderedproduct->product_total ." " . $gs->base_curr_text . ".Nous vous contacterons plus tard.");
     
              send_email($op->vendor->email, $op->vendor->shop_name, $op->vendor->phone,$op->vendor->email, 'La livraison du produit est en cours', "Merci d'avoir commandé nos produits. Nous enverrons vos produits par courrier dans un délai de ".$gs->in_min." à ".$gs->in_max." jours.<p><strong>Numéro commande: </strong>".$order->unique_id."</p> <p><strong>Detail commande: </strong><a href='".url('/')."/vendor"."/".$order->id."/orderdetails'>".url('/')."/vendor"."/".$order->id."/orderdetails"."</a></p>");
            }
          }
          // sending mail to user
          send_email($order->user->email, $order->user->first_name, $order->user->phone, $order->user->email, 'La livraison du produit est en cours', "Votre livraison de produit est en cours. Nous avons collecté les produits des fournisseurs et vous les enverrons par courrier au plus tard de".$gs->in_min." à ".$gs->in_max." jours.<p><strong>Numéro commande: </strong>$order->unique_id</p><p><strong>Detail commande: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");
          send_sms($order->user->phone, "Votre livraison de produit est en cours. Nous avons collecté les produits des fournisseurs et vous les enverrons par courrier au plus tard ".$gs->in_min." to ".$gs->in_max." jours.<p><strong>Numéro commande: </strong>$order->unique_id</p><p><strong>Details commandes: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");
        }
        // if in around main city
        elseif ($order->shipping_method == 'around') {
          // sending mails to vendor
          foreach ($order->orderedproducts as $key => $op) {
            if (!in_array($op->vendor->id, $sentVendors)) {
              $sentVendors[] = $op->vendor->id;
              send_email($op->vendor->email, $op->vendor->shop_name,$op->vendor->phone,$op->vendor->email,'La livraison du produit est en cours', "Merci d'avoir envoyé vos produits. Nous enverrons ces produits au client par courrier dans un délai de ".$gs->am_min." à ".$gs->am_max." jours.<p><strong>Numéro commande: </strong>".$order->unique_id."</p> <p><strong>Details commandes: </strong><a href='".url('/')."/vendor"."/".$order->id."/orderdetails'>".url('/')."/vendor"."/".$order->id."/orderdetails"."</a></p>");
            }
          }
          
          // sending mail to user
          send_email($order->user->email, $order->user->first_name, $order->user->phone, $order->user->email, 'La livraison du produit est en cours', "Votre livraison de produit est en cours. Nous avons collecté les produits des fournisseurs et vous les enverrons par courrier au plus tard de".$gs->in_min." à ".$gs->in_max." jours.<p><strong>Numéro commande: </strong>$order->unique_id</p><p><strong>Detail commande: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");
          send_sms($order->user->phone, "Votre livraison de produit est en cours. Nous avons collecté les produits des fournisseurs et vous les enverrons par courrier au plus tard ".$gs->am_min." à ".$gs->am_max." jours.<p><strong>Numéro commande: </strong>$order->unique_id</p><p><strong>Details commandes: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");
        }
        // if in around world
        elseif ($order->shipping_method == 'world') {
          // sending mails to vendor
          foreach ($order->orderedproducts as $key => $op) {
            if (!in_array($op->vendor->id, $sentVendors)) {
              $sentVendors[] = $op->vendor->id;
              // send_email($op->vendor->email,$op->vendor->phone,$op->vendor->shop_name,$op->vendor->email, 'La livraison du produit est en cours', "Merci d'avoir envoyé vos produits. Nous enverrons ces produits au client par courrier dans un délai de ".$gs->aw_min." à ".$gs->aw_max." jours.<p><strong>Numéro commande: </strong>".$order->unique_id."</p> <p><strong>Details commandes: </strong><a href='".url('/')."/vendor"."/".$order->id."/orderdetails'>".url('/')."/vendor"."/".$order->id."/orderdetails"."</a></p>");
              send_email($op->vendor->email, $op->vendor->shop_name,$op->vendor->phone,$op->vendor->email,'La livraison du produit est en cours', "Merci d'avoir envoyé vos produits. Nous enverrons ces produits au client par courrier dans un délai de ".$gs->aw_min." à ".$gs->aw_max." jours.<p><strong>Numéro commande: </strong>".$order->unique_id."</p> <p><strong>Details commandes: </strong><a href='".url('/')."/vendor"."/".$order->id."/orderdetails'>".url('/')."/vendor"."/".$order->id."/orderdetails"."</a></p>");
            }
          }
          // sending mail to user
          send_email($order->user->email,$order->user->first_name, $order->user->phone, $order->user->email, 'La livraison du produit est en cours', "Votre livraison de produit est en cours. Nous avons collecté les produits des fournisseurs et vous les enverrons par courrier au plus tard ".$gs->aw_min." à ".$gs->aw_max." jours.<p><strong>Numéro commande: </strong>$order->unique_id</p><p><strong>Details commandes: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");
          // send_email($op->vendor->email, $op->vendor->shop_name,$op->vendor->phone,$op->vendor->email,'La livraison du produit est en cours', "Merci d'avoir envoyé vos produits. Nous enverrons ces produits au client par courrier dans un délai de ".$gs->aw_min." à ".$gs->aw_max." jours.<p><strong>Numéro commande: </strong>".$order->unique_id."</p> <p><strong>Details commandes: </strong><a href='".url('/')."/vendor"."/".$order->id."/orderdetails'>".url('/')."/vendor"."/".$order->id."/orderdetails"."</a></p>");
          send_sms($order->user->phone, "Votre livraison de produit est en cours. Nous avons collecté les produits des fournisseurs et vous les enverrons par courrier au plus tard ".$gs->aw_min." to ".$gs->aw_max." jours.<p><strong>Numéro commande: </strong>$order->unique_id</p><p><strong>Details commandes: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");

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
            send_email($op->vendor->email,$op->vendor->shop_name,$op->vendor->phone,$op->vendor->email, 'Produits livrés', "Merci de nous envoyer les produits. Nous avons livré les produits au client.<p><strong>Numéro commande: </strong>".$order->unique_id."</p> <p><strong>Details commandes: </strong><a href='".url('/')."/vendor"."/".$order->id."/orderdetails'>".url('/')."/vendor"."/".$order->id."/orderdetails"."</a></p>");
          }
        }

        // sending mail to user
        send_email($order->user->email, $order->user->first_name,$order->user->phone,$order->user->email, 'Produits livrés', "Merci d'avoir choisi <strong>".$gs->website_title."</strong> pour le shopping. Nous avons constaté que vous aviez reçu la livraison des produits souhaités. S'il vous plaît donner un avis / suggestion afin que nous puissions améliorer la qualité de nos produits.<p><strong>Numéro commande: </strong>$order->unique_id</p><p><strong>Details commandes: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");
        send_sms($order->user->phone, "Merci d'avoir choisi <strong>".$gs->website_title."</strong> for shopping. Nous avons constaté que vous aviez reçu la livraison des produits souhaités. S'il vous plaît donner un avis / suggestion afin que nous puissions améliorer la qualité de nos produits.<p><strong>Numéro commande: </strong>$order->unique_id</p><p><strong>Details commandes: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");
      }


      return "success";
    }

    public function acceptOrder(Request $request) {
      $order = Order::find($request->orderid);
      $order->approve = 1;
      $order->save();


      $ops = Orderedproduct::where('order_id', $order->id)->get();
      foreach ($ops as $key => $op) {
        $nop = Orderedproduct::find($op->id);
        $nop->approve = 1;
        $nop->save();
      }


      $sentVendors = [];

      // sending mails to vendor
      foreach ($order->orderedproducts as $key => $op) {
        if (!in_array($op->vendor->id, $sentVendors)) {
          $sentVendors[] = $op->vendor->id;
          send_email($op->vendor->email,$op->vendor->shop_name,$op->vendor->phone,$op->vendor->email, 'Commande acceptée', "Order ID #".$order->unique_id." a été accepté.<p><strong>Details commandes: </strong><a href='".url('/')."/vendor"."/".$order->id."/orderdetails'>".url('/')."/vendor"."/".$order->id."/orderdetails"."</a></p>");
        }
      }
      // sending mail to user
      send_email($order->user->email, $order->user->first_name,$order->user->phone,$order->user->email, 'Commande acceptée', "Votre commande a été accepté.<p><strong>Numéro commande: </strong>$order->unique_id</p><p><strong>Details commandes: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");
      send_sms($order->user->phone, "Votre commande a été accepté.<p><strong>Numéro commande: </strong>$order->unique_id</p><p><strong>Details commandes: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");
      return "success";
    }

    public function cancelOrder(Request $request) {
      $order = Order::find($request->orderid);
      $order->approve = -1;
      $order->save();

      $sentVendors = [];
      // sending mails to vendor
      foreach ($order->orderedproducts as $key => $op) {
        if (!in_array($op->vendor->id, $sentVendors)) {
          $sentVendors[] = $op->vendor->id;
          send_email($op->vendor->email,$op->vendor->shop_name,$op->vendor->phone,$op->vendor->email, 'Ordre rejeté', "Order ID #".$order->unique_id." a été refusé.<p><strong>Details commandes: </strong><a href='".url('/')."/vendor"."/".$order->id."/orderdetails'>".url('/')."/vendor"."/".$order->id."/orderdetails"."</a></p>");
        }
      }
      // sending mail to user
      send_email($order->user->email,$order->user->first_name,$order->user->phone,$order->user->email, 'Ordre rejeté', "Votre commande a été refusé.<p><strong>Numéro commande: </strong>$order->unique_id</p><p><strong>Details commandes: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");
      send_sms($order->user->phone, "Votre commande a été refusée.<p><strong>Numéro commande: </strong>$order->unique_id</p><p><strong>Details commandes: </strong><a href='".url('/')."/".$order->id."/orderdetails'>".url('/')."/".$order->id."/orderdetails"."</a></p>");
      return "success";
    }

    public function orderdetails($orderid) {
      $data['order'] = Order::find($orderid);
      $data['orderedproducts'] = Orderedproduct::where('order_id', $orderid)->get();
      return view('admin.orders.details', $data);
    }

}
