<?php

namespace App\Http\Controllers;

use App\Product;
use Carbon\Carbon;
use App\Allcategory;
use App\FlashInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryAllController extends Controller
{
    public function show($slug=null, $id){
        $data['allcategories']=Allcategory::join('vendors','vendors.id','=','allcategories.vendor_id')
                                    ->where('vendor_id',$id)
                                    ->select('allcategories.id',
                                    'title',
                                    'category_id',
                                    'price',
                                    'slug',
                                    'description_items',
                                    'vendor_id')
                                    ->paginate(10);
        $data['minprice'] = Allcategory::min('price');
        $data['maxprice'] = Allcategory::max('price');
        $data['items']='allcategory';
        $data['sortby'] ='sort_by';
        $data['term'] = 'term';
        return view('user.otherproducts.show', $data);
      }
  public function detailOtherproduct($slug=null,$id){
   
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
    
      $data['product'] = Allcategory::find($id);
      if($data['product']){
      $name_vendor = DB::table('vendors')
                    ->join('allcategories','allcategories.vendor_id','=','vendors.id')
                    ->select('vendors.shop_name')
                    ->first();
      $data['allcategories'] = Allcategory::with('previewimages')->where('subcategory_id', $data['product']->subcategory_id)->where('deleted', 0)->inRandomOrder()->limit(10)->get();
      $response = view('allproducts.show', $data);
      return $response;
    }
  } 
}
