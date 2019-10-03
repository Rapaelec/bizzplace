<?php

namespace App\Http\Controllers;

use App\Product;
use App\Service;
use Carbon\Carbon;
use App\FlashInterval;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function show($slug=null, $id) {
        $today = new \Carbon\Carbon(Carbon::now());
  
        // bring their price back to pre price (without flash sale)
        $notflashsales = Product::where('flash_status', 1)->get();
  
        foreach ($notflashsales as $key => $notflashsale) {
          if (empty($notflashsale->offer_type)) {
            $notflashsale->current_price = NULL;
            $notflashsale->search_price = $notflashsale->price;
            $notflashsale->flash_div_refresh = 0;
            $notflashsale->save();
  
          } else {
            if ($notflashsale->offer_type == 'percent') {
              $notflashsale->current_price = $notflashsale->price - ($notflashsale->price*($notflashsale->offer_amount/100));
              $notflashsale->search_price = $notflashsale->current_price;
              $notflashsale->flash_div_refresh = 0;
              $notflashsale->save();
            } else {
              $notflashsale->current_price = $notflashsale->price - $notflashsale->offer_amount;
              $notflashsale->search_price = $notflashsale->current_price;
              $notflashsale->flash_div_refresh = 0;
              $notflashsale->save();
            }
          }
        }
  
        // next count_down_to time calculation
        $time = Carbon::now()->format('H:i');
        $fi = FlashInterval::whereTime('start_time', '<=', $time)->whereTime('end_time', '>', $time)->first();
  
        // if current time is in flash interval
        if ($fi) {
          $endtime = $fi->end_time;
          $fi_id = $fi->id;
          $date = date('M j, Y', strtotime($today));
          $data['countto'] = $date.' '.$endtime.':00';
  
          $flashsales = Product::whereDate('flash_date', $today)->where('flash_status', 1)->where('flash_interval', $fi_id)->orderBy('flash_request_date', 'DESC')->get();
  
          foreach ($flashsales as $key => $flashsale) {
            if ($flashsale->flash_type == 1) {
              $flashsale->current_price = $flashsale->price - ($flashsale->price*($flashsale->flash_amount/100));
              $flashsale->search_price = $flashsale->current_price;
              $flashsale->flash_div_refresh = 1;
              $flashsale->save();
            } else {
              $flashsale->current_price = $flashsale->price - $flashsale->flash_amount;
              $flashsale->search_price = $flashsale->current_price;
              $flashsale->flash_div_refresh = 1;
              $flashsale->save();
            }
          }
        }
  
        $services = Service::find($id);
        if($data['services']){
        $name_vendor = DB::table('vendors')
                      ->join('services','services.vendor_id','=','vendors.id')
                      ->select('vendors.shop_name')
                      ->first();
        $services->number_views++;
        $services->save();
        $data['services'] = $services;
        $data['r_services'] = Service::with('previewimages')->where('subcategory_id', $data['services']->subcategory_id)->where('deleted', 0)->inRandomOrder()->limit(10)->get();
        $response = new \Illuminate\Http\Response(view('service.show', $data));
        $response->withCookie(cookie()->forever('shop_name',$name_vendor->shop_name));
        return $response;
      }
    }
}
