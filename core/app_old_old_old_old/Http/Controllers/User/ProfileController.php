<?php

namespace App\Http\Controllers\User;

use Auth;
use Hash;
use Session;
use App\User;
use App\Admin;
use App\Order;
use Validator;
use App\Refund;
use App\Vendor;
use App\Favorit;
use App\AdressShipping;
use App\Orderedproduct;
use App\Mail\MessageClient;
use Illuminate\Http\Request;
use App\GeneralSetting as GS;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;
use App\Notifications\VendorNotification;

class ProfileController extends Controller
{
    public function profile() {
      $data['countries'] = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
      return view('user.profile',$data);
    }

    public  function demandeDevis(){
      if(Auth::check()){
        $data['user'] = User::find(Auth::user()->id);
        return view('user.devis.msg_devis',$data);
      }
    }

    public function infoupdate(Request $request) {
       
      $user = User::find(Auth::user()->id);
      if(!empty($user->reason_social)){
        
        $request->validate([
          'reason_social' => 'bail|required',
          'logo' => 'required',
          'phone' => 'bail|required|numeric|digits_between:8,32',
          'siret' => 'bail|required|numeric',
          'siren' => 'bail|required|numeric',
          'country'=>'bail|required',
          ]);
        if($request->hasFile('logo')) {
          $imagePath = 'assets/user/img/shop-logo/' . $user->logo;
          @unlink($imagePath);
          $image = $request->file('logo');
          $fileName = time() . '.jpg';
          
          $location = './assets/user/img/shop-logo/' . $fileName;
          $background = Image::canvas(250, 250);
          $resizedImage = Image::make($image)->resize(250, 250, function ($c) {
              $c->aspectRatio();
          });
          // insert resized image centered into background
          $background->insert($resizedImage, 'center');
          // save or do whatever you like
          $background->save($location);

          $user->logo = $fileName;
        }
        $user->siren = $request->siren;
        $user->siret = $request->siret;
      }
      else{
        $request->validate([
          'first_name' => 'bail|nullable|string',
          'last_name' => 'bail|nullable',
          'gender' => 'bail|nullable',
          'date_of_birth' => 'nullable',
          'phone' => 'bail|required|numeric|digits_between:8,24',
          'country'=>'bail|required',
          ]);
          $user->first_name = $request->first_name;
          $user->last_name = $request->last_name;
          $user->gender = $request->gender;
          $user->date_of_birth = $request->date_of_birth;
        }
        $in = $request->except('_token');
        $user->phone = $request->phone;
        $user->country = $request->country;
      
      $user->save();

      Session::flash('success', 'Informations mises à jour avec succès');
      return back();
    }

    public function changepassword() {
      return view('user.password');
    }

    public function sendmailToVendor(Request $request){
      $request->validate([
        'subject' => 'required',
        'message' => 'required'
    ]);
    $vendor = Vendor::find($request->vendorID);
    $to = $vendor->email;
    $user_name = Auth::user()->username;
    $user_email = Auth::user()->email;
    $user_phone = Auth::user()->phone;
    $subject = $request->subject;
    $message = $request->message;
    
    send_email($user_email, $user_name,$user_phone, $user_email,$subject, $message);
    $vendor->notify(new VendorNotification);
    Session::flash('success', 'Mail envoyé avec success !');
    return redirect()->back();
    }

    public function sendDevisToAdmin(Request $request){
    $request->validate([
        'sujet' => 'required',
        'message' => 'required'
    ]);
    $text = '';
    $status='';
    $admins = Admin::find(1);
    if($admins && $admins->email){
      $to = $admins->email;
    $user_name = Auth::user()->username;
    $user_email = Auth::user()->email;
    $user_phone = Auth::user()->phone;
    $subject = $request->sujet;
    $message = $request->message;
    send_email($to,$user_name,$user_phone,$user_email,$subject,$message);
    $admins->notify(new VendorNotification);
    $text = 'Mail envoyé avec success !';
    $status = 'success';
  }else{
    $text ="Une erreure interne est survenue lors de l'envoi !!!";
    $status = 'errors';
  }
  Session::flash($status, $text);
  return back();
    }

    public function billingdetail($id){
      $data['vendorInfos']=Vendor::find($id);
      return view('user.billingdetails',$data);
    }

    public function updatePassword(Request $request) {
        $messages = [
            'password.required' => 'Le nouveau mot de passe est obligatoire',
            'password.confirmed' => "Le mot de passe ne correspond pas"
        ];

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ], $messages);
        // if given old password matches with the password of this authenticated user...
        if(Hash::check($request->old_password, Auth::user()->password)) {
            $oldPassMatch = 'matched';
        } else {
            $oldPassMatch = 'not_matched';
        }
        if ($validator->fails() || $oldPassMatch=='not_matched') {
            if($oldPassMatch == 'not_matched') {
              $validator->errors()->add('oldPassMatch', true);
            }
            return redirect()->back()->withErrors($validator);
        }

        // updating password in database...
        $user = User::find(Auth::user()->id);
        $user->password = bcrypt($request->password);
        $user->save();

        Session::flash('success', 'Le mot de passe a été changé avec succès!');

        return redirect()->back();
    }

    public function shipping() {
      $data['countries'] = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
      return view('user.shipping', $data);
    }

    public function wishlist() {
      $data['user'] = User::find(Auth::user()->id);
      return view('user.wishlist', $data);
    }

    public function orders(Request $request){
      if ($request->vendorId) {
        $data['on'] = $request->vendorId;
        $data['orders'] = Orderedproduct::join('orders','orders.id','=','orderedproducts.order_id')
                          ->join('vendors','vendors.id','=','orderedproducts.vendor_id')
                          ->orderBy('orders.id', 'DESC')
                          ->where('orderedproducts.vendor_id', $request->vendorId)
                          ->select('orderedproducts.vendor_id','orders.id','unique_id','orders.created_at','orders.total','orders.payment_method','orderedproducts.approve','orderedproducts.shipping_status')
                          ->paginate(5);
      } else {
        $data['on'] = '';
        $data['orders'] = Order::orderBy('id', 'DESC')->paginate(10);
      }
      $data['vendors']=Vendor::find($request->vendorId);
      return view('user.order.orders', $data);
    }

    public function orderdetails($orderid,Request $request) {
      $data['order'] = Orderedproduct::join('orders','orders.id','=','orderedproducts.order_id')
            ->join('vendors','vendors.id','=','orderedproducts.vendor_id')
            ->where('orderedproducts.vendor_id',$request->vendorId)
            ->where('orderedproducts.order_id', $orderid)
            ->first();
      $data['orderedproducts'] = Orderedproduct::where('order_id', $orderid)->get();
      $data['subtotal'] = 0;
      // dd($data['orderedproducts']);
      $data['ccharge'] = 0;
      foreach ($data['orderedproducts'] as $op) {
        $data['ccharge'] += $op->coupon_amount;
      }
      return view('user.order.details', $data);
    }
    

    public function view_facture($orderid=null,$vendorId){
      $data['order'] = Order::find($orderid);
      $data['InforLivraisons'] = AdressShipping::where('order_id', $orderid)
                                                ->where('user_id', Auth::user()->id)
                                                ->first();
      $data['orderedproducts'] = Orderedproduct::where('order_id', $orderid)->get();
      $data['vendors']= DB::table('orderedproducts')
                            ->join('vendors','orderedproducts.vendor_id','=','vendors.id')
                            ->join('products','orderedproducts.product_id','=','products.id')
                            ->join('orders','orders.id','=','orderedproducts.order_id')
                            ->select('product_code',
                              'products.title',
                              'orderedproducts.quantity',
                              'orderedproducts.product_price',
                              'orderedproducts.coupon_amount',
                              'logo',
                              'shop_name',
                              'vendors.address',
                              'vendors.phone',
                              'vendors.email')
                            ->where('orders.shipping_status',2)
                            ->where('orderedproducts.vendor_id',$vendorId)
                            ->where('orderedproducts.user_id',Auth::user()->id)
                            ->where('orderedproducts.order_id',$orderid)
                            ->get();
      $data['subtotal'] = 0;
      $data['ccharge'] = 0;
      $data['total']=0;
      foreach ($data['vendors'] as $op) {
        $data['total']=(round($op->product_price, 2)*$op->quantity)+$data['total'];
        $data['ccharge'] += $op->coupon_amount;
      }
      return view('user.order.facture', $data);
    }

    public function complain(Request $request) {
      $request->validate([
        'comment_type' => 'required',
        'comment' => 'required'
      ]);

      $op = Orderedproduct::find($request->opid);
      $op->comment_type = $request->comment_type;
      $op->comment = $request->comment;
      $op->save();
      Session::flash('success', 'Plainte éffectuée avec succès');
      return "success";
    }

    public function refund(Request $request) {
      $request->validate([
        'reason' => 'required'
      ]);

      $refund = new Refund;
      $refund->orderedproduct_id = $request->opid;
      $refund->status = 0;
      $refund->reason = $request->reason;
      $refund->save();
      Session::flash('success', 'Demande de remboursement envoyée avec succès');
      return "success";
    }

    public function shippingupdate(Request $request) {
      // return $request;
      $messages = [
        'shipping_first_name.required' => 'First Name is required',
        'shipping_last_name.required' => 'Last Name is required',
        'shipping_email.required' => 'Email is required',
        'shipping_phone.required' => 'Phone is required',
      ];

      $request->validate([
        'shipping_first_name' => 'required',
        'shipping_last_name' => 'required',
        'shipping_email' => 'required',
        'shipping_phone' => 'required',
        'address' => 'required',
        'country' => 'required',
        'state' => 'required',
        'city' => 'required',
        'zip_code' => 'required',
      ], $messages);

      $in = $request->except('_token');
      $adres_shipping = AdressShipping::where('user_id',Auth::user()->id);
      $adres_shipping->update([
        'shipping_first_name'=>$request->shipping_first_name,
        'shipping_last_name'=>$request->shipping_last_name,
        'shipping_email'=>$request->shipping_email,
        'shipping_phone'=>$request->shipping_phone,
        'address'=>$request->address,
        'country'=>$request->country,
        'city'=>$request->city,
        'zip_code'=>$request->zip_code,
        'state'=>$request->state
      ]);

      Session::flash('success', 'Adresse de livraison mise à jour avec succès');
      return back();
    }

    public function billing() {
      $data['countries'] = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
      return view('user.billing', $data);
    }


    public function billingupdate(Request $request) {
      // return $request;
      $messages = [
        'billing_first_name.required' => 'First Name is required',
        'billing_last_name.required' => 'Last Name is required',
        'billing_email.required' => 'Email is required',
        'billing_phone.required' => 'Phone is required',
        'billing_address.required' => 'Address is required',
        'billing_country.required' => 'Country is required',
        'billing_state.required' => 'State is required',
        'billing_city.required' => 'City is required',
        'billing_zip_code.required' => 'Zip code is required',
      ];

      $request->validate([
        'billing_first_name' => 'required',
        'billing_last_name' => 'required',
        'billing_email' => 'required',
        'billing_phone' => 'required',
        'billing_address' => 'required',
        'billing_country' => 'required',
        'billing_state' => 'required',
        'billing_city' => 'required',
        'billing_zip_code' => 'required',
      ], $messages);

      $in = $request->except('_token');
      $user = User::find(Auth::user()->id);
      $user->fill($in)->save();

      Session::flash('success', "Mise à jour effectuer avec success !!!");
      return back();
    }

    public function listprofessional(){
      $vendors = Orderedproduct::distinct()
                ->join('orders', 'orders.id', '=', 'orderedproducts.order_id')
                ->join('vendors','vendors.id','=','orderedproducts.vendor_id')
                ->select('vendors.id')
                ->where('orderedproducts.user_id',Auth::user()->id)
                ->get();
      
      $data['vendors']=$vendors;
     
      return view('user.professional', $data);
    }

    public function envoi_msg($id){
      $vendor =Vendor::find($id);
      return view('user.envoi_msg',compact('vendor'));
    }

}
