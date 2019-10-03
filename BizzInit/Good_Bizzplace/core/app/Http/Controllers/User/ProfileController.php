<?php

namespace App\Http\Controllers\User;

use Auth;
use Hash;
use Session;
use App\User;
use App\Order;
use Validator;
use App\Refund;
use App\Vendor;
use App\Favorit;
use App\Orderedproduct;
use App\Mail\MessageClient;
use Illuminate\Http\Request;
use App\GeneralSetting as GS;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use App\Notifications\VendorNotification;

class ProfileController extends Controller
{
    public function profile() {
      return view('user.profile');
    }

    public function infoupdate(Request $request) {
      $request->validate([
        'first_name' => 'required',
        'last_name' => 'required',
        'gender' => 'required',
        'date_of_birth' => 'required',
        'phone' => 'required',
      ]);

      $in = $request->except('_token');
      $user = User::find(Auth::user()->id);
      if (empty($user->shipping_first_name)) {
        $in['shipping_first_name'] = $request->first_name;
      }
      if (empty($user->shipping_last_name)) {
        $in['shipping_last_name'] = $request->last_name;
      }
      if (empty($user->shipping_phone)) {
        $in['shipping_phone'] = $request->phone;
      }
      $user->fill($in)->save();

      Session::flash('success', 'Informations mises à jour avec succès');
      return back();
    }

    public function changepassword() {
      return view('user.password');
    }

    public function sendmailToVendor(Request $request){
      $validatedData = $request->validate([
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
    
    // send_email($to, $name, $subject, $message);
    Mail::to($to)->send(new MessageClient($user_name,$user_phone,$user_email,$subject,$message));
    $vendor->notify(new VendorNotification);
    Session::flash('success', 'Mail envoyé avec success !');
    return redirect()->back();
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

    public function orders(Request $request) {
      // return $request;
      if ($request->order_number) {
        $data['on'] = $request->order_number;
        $data['orders'] = Order::orderBy('id', 'DESC')->where('unique_id', $request->order_number)->paginate(10);
      } else {
        $data['on'] = '';
        $data['orders'] = Order::orderBy('id', 'DESC')->paginate(10);
      }

      return view('user.order.orders', $data);
    }

    public function orderdetails($orderid) {
      $data['order'] = Order::find($orderid);
      $data['orderedproducts'] = Orderedproduct::where('order_id', $orderid)->get();
      $data['subtotal'] = 0;
      $data['ccharge'] = 0;
      foreach ($data['orderedproducts'] as $op) {
        $data['ccharge'] += $op->coupon_amount;
      }

      return view('user.order.details', $data);
    }
    

    public function view_facture($orderid){
      $data['order'] = Order::find($orderid);
      $data['orderedproducts'] = Orderedproduct::where('order_id', $orderid)->get();
      $data['vendors']=DB::table('orderedproducts')
                            ->join('vendors','orderedproducts.vendor_id','=','vendors.id')
                            ->join('orders','orders.id','=','orderedproducts.order_id')
                            ->where('orders.shipping_status',2)
                            ->first();
      $data['subtotal'] = 0;
      $data['ccharge'] = 0;
      foreach ($data['orderedproducts'] as $op) {
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
      $user = User::find(Auth::user()->id);
      $user->fill($in)->save();

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
      $vendors = Vendor::all();
      return view('user.professional', compact('vendors'));
    }

    public function envoi_msg($id){
      $vendor =Vendor::find($id);
      return view('user.envoi_msg',compact('vendor'));
    }

}
