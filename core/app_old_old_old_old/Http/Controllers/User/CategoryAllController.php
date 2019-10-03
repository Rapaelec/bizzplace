<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Allcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryAllController extends Controller
{
    public function detailAllCategorie($slug=null, $id){
            // dd('test');
            $today = new \Carbon\Carbon(Carbon::now());
      
            // bring their price back to pre price (without flash sale)
            $notflashsales = Allcategory::where('flash_status', 1)->get();
      
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
      
              $flashsales = Allcategory::whereDate('flash_date', $today)->where('flash_status', 1)->where('flash_interval', $fi_id)->orderBy('flash_request_date', 'DESC')->get();
      
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
      
            $data['allcategories'] = Allcategory::find($id);
            $name_vendor = DB::table('vendors')->join('allcategories','allcategories.vendor_id','=','vendors.id')
                          ->select('vendors.shop_name')
                          ->where('allcategories.product_code',$data['allcategories']->product_code)
                          ->first();
            $data['sales'] = $data['allcategories']->sales;
            $data['rproducts'] = Allcategory::with('previewimages')->where('subcategory_id', $data['allcategories']->subcategory_id)->where('deleted', 0)->inRandomOrder()->limit(10)->get();
            return view('allproducts.show', $data);
          }
}
