<?php
use App\Ad;
use App\Cart;
use App\Coupon;
use App\Vendor;
use App\CartCoupon;
use App\Deliveryman;
use App\PlacePayment;
use App\PreviewImage;
use App\Orderedproduct;
use App\Mail\MessageClient;
use App\GeneralSetting as GS;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;

if (! function_exists('send_email')) {

    function send_email($to, $name=null, $user_phone=null,$user_email=null,$subject=null, $message=null)
    {
        $settings = GS::first();
    	if($settings->email_notification == 1)
    	{
  		Mail::to($to)->send(new MessageClient($name,$user_phone,$user_email,$subject,$message));
    	}else{
  		Mail::to($to)->send(new MessageClient($name,$user_phone,$user_email,$subject,$message));
        }
    }
}

if (! function_exists('send_sms'))
{

    function send_sms( $to, $message)
    {
        $settings = GS::first();
		    if($settings->sms_notification == 1)
		{

			$sendtext = urlencode("$message");
		    $appi = $settings->sms_api;
			$appi = str_replace("{{number}}",$to,$appi);
			$appi = str_replace("{{message}}",$sendtext,$appi);
			$result = file_get_contents($appi);
		}

    }
}

if(!function_exists('show_ad')) {
    function show_ad($size) {
        $ad = Ad::where('size', $size)->inRandomOrder()->first();
        if($ad !=null){
        $ad->impression = $ad->impression + 1;
        $ad->save();
        if (!empty($ad)) {
            if($size == 1){
                $maxwd = '350px';
            }elseif($size == 3){
                $maxwd = '255px';
            }

          if ($ad->type == 1) {
            return '<a target="_blank" href="'.$ad->url.'" onclick="increaseAdView('.$ad->id.')"><img src="'.url('/').'/assets/user/ad_images/'.$ad->image.'" alt="Ad" class="rounded" style="width:100%; max-width:'.$maxwd.';"/></a>';
          }
          if($ad->type == 2) {
              return $ad->script;
          }
        } else {
          return '';
        }
    }
}

}

if(!function_exists('product_code')) {
  function product_code($limit)
  {
    return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
  }
}

// For Paytm
if(!function_exists("encrypt_e")) {
    function encrypt_e($input, $ky) {
        $key   = html_entity_decode($ky);
        $iv = "@@@@&&&&####$$$$";
        $data = openssl_encrypt ( $input , "AES-128-CBC" , $key, 0, $iv );
        return $data;
    }
}

if(!function_exists("decrypt_e")) {
    function decrypt_e($crypt, $ky) {
        $key   = html_entity_decode($ky);
        $iv = "@@@@&&&&####$$$$";
        $data = openssl_decrypt ( $crypt , "AES-128-CBC" , $key, 0, $iv );
        return $data;
    }
}

if(!function_exists("pkcs5_pad_e")) {
    function pkcs5_pad_e($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }
}

if(!function_exists("pkcs5_unpad_e")) {
    function pkcs5_unpad_e($text) {
        $pad = ord($text{strlen($text) - 1});
        if ($pad > strlen($text))
            return false;
        return substr($text, 0, -1 * $pad);
    }
}

if(!function_exists("generateSalt_e")) {
    function generateSalt_e($length) {
        $random = "";
        srand((double) microtime() * 1000000);

        $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
        $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
        $data .= "0FGH45OP89";

        for ($i = 0; $i < $length; $i++) {
            $random .= substr($data, (rand() % (strlen($data))), 1);
        }

        return $random;
    }
}

if(!function_exists("SaveOrUpdatePreviewImage")){
    function SaveOrUpdatePreviewImage($images,$toutproduit,$attribut=null){
        if($attribut!=null){
               // bring all the product images of that product
      $productimgs = PreviewImage::where($attribut, $toutproduit->id)->get();
      if(!empty($productimgs)){
        // then check whether a filename is missing in imgsdb if it is missing remove it from database and unlink it
      foreach($productimgs as $productimg) {
        if(!in_array($productimg->image, [])) {
            @unlink('assets/user/img/products/'.$productimg->image);
            @unlink('assets/user/img/products/'.$productimg->big_image);
            $productimg->delete();
        }
      }
      }
        }
        foreach($images as $img) {
            $filename = uniqid() . '.jpg';
            $filename1 = uniqid() . '.jpg';
            $location = 'assets/user/img/products/' . $filename;
            $location1 = 'assets/user/img/products/' . $filename1;
    
            $background = Image::canvas(570, 570);
            $resizedImage = Image::make($img)->resize(570, 570, function ($c) {
                $c->aspectRatio();
            });
            // insert resized image centered into background
            $background->insert($resizedImage, 'center');
            // save or do whatever you like
            $background->save($location);
    
    
            $background1 = Image::canvas(1140, 1140);
            $resizedImage1 = Image::make($img)->resize(1140, 1140, function ($c) {
                $c->aspectRatio();
            });
            // insert resized image centered into background
            $background1->insert($resizedImage1, 'center');
            // save or do whatever you like
            $background1->save($location1);
    
            $pi = new PreviewImage;
            $pi->allcategory_id = $toutproduit->id;
            $pi->image = $filename;
            $pi->big_image = $filename1;
            $pi->save();
          }
          return true;
    }
}
if(!function_exists("UpdatePreviewImage")){
    function SavePreviewImage($images,$toutproduit,$attribut){
       
        foreach($images as $img) {
            $filename = uniqid() . '.jpg';
            $filename1 = uniqid() . '.jpg';
            $location = 'assets/user/img/products/' . $filename;
            $location1 = 'assets/user/img/products/' . $filename1;
    
            $background = Image::canvas(570, 570);
            $resizedImage = Image::make($img)->resize(570, 570, function ($c) {
                $c->aspectRatio();
            });
            // insert resized image centered into background
            $background->insert($resizedImage, 'center');
            // save or do whatever you like
            $background->save($location);
    
    
            $background1 = Image::canvas(1140, 1140);
            $resizedImage1 = Image::make($img)->resize(1140, 1140, function ($c) {
                $c->aspectRatio();
            });
            // insert resized image centered into background
            $background1->insert($resizedImage1, 'center');
            // save or do whatever you like
            $background1->save($location1);
    
            $pi = new PreviewImage;
            $pi->allcategory_id = $toutproduit->id;
            $pi->image = $filename;
            $pi->big_image = $filename1;
            $pi->save();
          }
          return true;
    }
}

if(!function_exists("checkString_e")) {
    function checkString_e($value) {
        $myvalue = ltrim($value);
        $myvalue = rtrim($myvalue);
        if ($myvalue == 'null')
            $myvalue = '';
        return $myvalue;
    }
}

if(!function_exists("getChecksumFromArray")) {
    function getChecksumFromArray($arrayList, $key=null, $sort = 1) {
        if ($sort != 0) {
            ksort($arrayList);
        }
        $str         = getArray2Str($arrayList);
        $salt        = generateSalt_e(4);
        $finalString = $str . "|" . $salt;
        $hash        = hash("sha256", $finalString);
        $hashString  = $hash . $salt;
        $checksum    = encrypt_e($hashString, $key);
        return $checksum;
    }
}

if(!function_exists("verifychecksum_e")) {
    function verifychecksum_e($arrayList, $key, $checksumvalue) {
        $arrayList = removeCheckSumParam($arrayList);
        ksort($arrayList);
        $str        = getArray2StrForVerify($arrayList);
        $paytm_hash = decrypt_e($checksumvalue, $key);
        $salt       = substr($paytm_hash, -4);

        $finalString = $str . "|" . $salt;

        $website_hash = hash("sha256", $finalString);
        $website_hash .= $salt;

        $validFlag = "FALSE";
        if ($website_hash == $paytm_hash) {
            $validFlag = "TRUE";
        } else {
            $validFlag = "FALSE";
        }
        return $validFlag;
    }
}

if(!function_exists("getArray2Str")) {
    function getArray2Str($arrayList) {
        $findme   = 'REFUND';
        $findmepipe = '|';
        $paramStr = "";
        $flag = 1;
        foreach ($arrayList as $key => $value) {
            $pos = strpos($value, $findme);
            $pospipe = strpos($value, $findmepipe);
            if ($pos !== false || $pospipe !== false)
            {
                continue;
            }

            if ($flag) {
                $paramStr .= checkString_e($value);
                $flag = 0;
            } else {
                $paramStr .= "|" . checkString_e($value);
            }
        }
        return $paramStr;
    }
}

if(!function_exists("getArray2StrForVerify")) {
    function getArray2StrForVerify($arrayList) {
        $paramStr = "";
        $flag = 1;
        foreach ($arrayList as $key => $value) {
            if ($flag) {
                $paramStr .= checkString_e($value);
                $flag = 0;
            } else {
                $paramStr .= "|" . checkString_e($value);
            }
        }
        return $paramStr;
    }
}

if(!function_exists("redirect2PG")) {
    function redirect2PG($paramList, $key) {
        $hashString = getchecksumFromArray($paramList);
        $checksum   = encrypt_e($hashString, $key);
    }
}


if(!function_exists("removeCheckSumParam")) {
    function removeCheckSumParam($arrayList) {
        if (isset($arrayList["CHECKSUMHASH"])) {
            unset($arrayList["CHECKSUMHASH"]);
        }
        return $arrayList;
    }
}

if(!function_exists("getTxnStatus")) {
    function getTxnStatus($requestParamList) {
        return callAPI(PAYTM_STATUS_QUERY_URL, $requestParamList);
    }
}

if(!function_exists("initiateTxnRefund")) {
    function initiateTxnRefund($requestParamList) {
        $CHECKSUM                     = getChecksumFromArray($requestParamList, PAYTM_MERCHANT_KEY, 0);
        $requestParamList["CHECKSUM"] = $CHECKSUM;
        return callAPI(PAYTM_REFUND_URL, $requestParamList);
    }
}

if(!function_exists("callAPI")) {
    function callAPI($apiURL, $requestParamList) {
        $jsonResponse      = "";
        $responseParamList = array();
        $JsonData          = json_encode($requestParamList);
        $postData          = 'JsonData=' . urlencode($JsonData);
        $ch                = curl_init($apiURL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($postData)
        ));
        $jsonResponse      = curl_exec($ch);
        $responseParamList = json_decode($jsonResponse, true);
        return $responseParamList;
    }
}

if(!function_exists("sanitizedParam")) {
    function sanitizedParam($param) {
        $pattern[0]     = "%,%";
        $pattern[1]     = "%#%";
        $pattern[2]     = "%\(%";
        $pattern[3]     = "%\)%";
        $pattern[4]     = "%\{%";
        $pattern[5]     = "%\}%";
        $pattern[6]     = "%<%";
        $pattern[7]     = "%>%";
        $pattern[8]     = "%`%";
        $pattern[9]     = "%!%";
        $pattern[10]    = "%\\$%";
        $pattern[11]    = "%\%%";
        $pattern[12]    = "%\^%";
        $pattern[13]    = "%=%";
        $pattern[14]    = "%\+%";
        $pattern[15]    = "%\|%";
        $pattern[16]    = "%\\\%";
        $pattern[17]    = "%:%";
        $pattern[18]    = "%'%";
        $pattern[19]    = "%\"%";
        $pattern[20]    = "%;%";
        $pattern[21]    = "%~%";
        $pattern[22]    = "%\[%";
        $pattern[23]    = "%\]%";
        $pattern[24]    = "%\*%";
        $pattern[25]    = "%&%";
        $sanitizedParam = preg_replace($pattern, "", $param);
        return $sanitizedParam;
    }
}

if(!function_exists("callNewAPI")) {
    function callNewAPI($apiURL, $requestParamList) {
        $jsonResponse = "";
        $responseParamList = array();
        $JsonData =json_encode($requestParamList);
        $postData = 'JsonData='.urlencode($JsonData);
        $ch = curl_init($apiURL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($postData))
        );
        $jsonResponse = curl_exec($ch);
        $responseParamList = json_decode($jsonResponse,true);
        return $responseParamList;
    }
}

//Total commande pour chaque vendeur
if(!function_exists("getTotalOrderForVendor")){
    function getTotalOrderForVendor($OrderId,$vendorId){
        $total=0;
        $productSums = Orderedproduct::join('orders', 'orders.id', '=', 'orderedproducts.order_id')
                    ->join('vendors','vendors.id','=','orderedproducts.vendor_id')
                    ->join('products','products.id','=','orderedproducts.product_id')
                    ->select('orders.id','orderedproducts.product_total')
                    ->where('orderedproducts.vendor_id',$vendorId)
                    ->where('orderedproducts.order_id', $OrderId)
                    ->get();
        foreach($productSums as $productSum){
            $total=$total+$productSum->product_total;
        }
        return $total;
    }
}
// For Paytm

if(!function_exists("getPriceSum")) {
  function getPriceSum($cartid, $productid) {
    $cart = Cart::where('cart_id', $cartid)->where('product_id', $productid)->first();
    $priceSum = $cart->price*$cart->quantity;
    return $priceSum;
  }
}

if(!function_exists("getSubTotal")) {
  function getSubTotal($cartid) {

    $cartItems = Cart::where('cart_id', $cartid)->get();
    $amo = 0;
    foreach ($cartItems as $item) {
      if (!empty($item->current_price)) {
        $amo += $item->current_price*$item->quantity;
      } else {
        $amo += $item->price*$item->quantity;
      }
    }

    $char = 0;
    $coupon = Session::get('coupon_code');
    if(session()->has('coupon_code') && Coupon::where('coupon_code', $coupon)->count() == 1){
      $cdetails = Coupon::where('coupon_code', $coupon)->latest()->first();
      if ($cdetails->coupon_type == 'percentage'){
        $char = ($amo*$cdetails->coupon_amount)/100;
      }else{
        if($cdetails->coupon_min_amount <= $amo){
          $char = $cdetails->coupon_amount;
        }
      }
    }
    $subtotal = $amo - $char;

    return round($subtotal, 2);
  }
}

if(!function_exists("getTotal")) {
  function getTotal($cartid,$amout_deliveryman=null) {
    $subtotal = getSubTotal($cartid);
    $gs = GS::first();

    if (PlacePayment::where('cart_id', $cartid)->count() > 0) {
      $pm = PlacePayment::where('cart_id', $cartid)->first()->payment;
      $place = PlacePayment::where('cart_id', $cartid)->first()->place;

      // if payment method is cash on delivery
      if ($pm == 1) {
        if ($place == 'in') {
          $scharge = $gs->in_cash_on_delivery;
        } elseif ($place == 'around') {
          $scharge = $gs->around_cash_on_delivery;
        } else {
          $scharge = $gs->world_cash_on_delivery;
        }
      }
      // if payment method is cash on advance
      else {
        if ($place == 'in') {
          $scharge = $gs->in_advanced;
        } elseif ($place == 'around') {
          $scharge = $gs->around_advanced;
        } else {
          $scharge = $gs->world_advanced;
        }
      }
    } else {
      $scharge = 0;
    }
    
        if(empty($amout_deliveryman)){
            $total =  $subtotal + (($gs->tax*$subtotal)/100);
            $total = $total+$scharge;
        }
        else{
            $total =  $subtotal + (($gs->tax*$subtotal)/100);
            $total = $total+$amout_deliveryman;
        }
    return round($total, 2);
  }
}
