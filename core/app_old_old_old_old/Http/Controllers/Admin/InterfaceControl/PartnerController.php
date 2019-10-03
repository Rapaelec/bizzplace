<?php

namespace App\Http\Controllers\Admin\InterfaceControl;

use Illuminate\Http\Request;
use App\GeneralSetting as GS;
use App\Partner;
use App\Http\Controllers\Controller;
use Image;
use Session;

class PartnerController extends Controller
{
    public function index() {
      $data['partners'] = Partner::all();
      $data['countries'] = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
      return view('admin.interfaceControl.partner.index', $data);
    }

    public function store(Request $request) {

      $validatedData = $request->validate([
          'partner' => 'required|mimes:jpeg,jpg,png',
          'url' => 'nullable',
          'reason_social'=>'required',
          'country_partner'=>'required',
          'town_partner'=>'required',
          'advertiser_sector'=>'required',
          'demand_sector'=>'required',
          'keyword'=>'required'
      ]);

      $partner = new Partner;
      $partner->url = $request->url;
      if($request->hasFile('partner')) {
        $image = $request->file('partner');
        $fileName = time() . '.jpg';
        $location = './assets/user/interfaceControl/partners/' . $fileName;
        Image::make($image)->save($location);
        $partner->image = $fileName;
      }
        $partner->reason_social = $request->reason_social;
        $partner->country_partner = $request->country_partner;
        $partner->town_partner= $request->town_partner;
        $partner->advertiser_sector= $request->advertiser_sector;
        $partner->demand_sector= $request->demand_sector;
        $partner->keyword= $request->keyword;
      $partner->save();
      Session::flash('success', 'Partenaire ajouté avec succès !');
      return redirect()->back();
    }

    public function delete(Request $request) {
      $partner = Partner::find($request->partnerID);
      $imagePath = './assets/user/interfaceControl/partners/' . $partner->image;
      @unlink($imagePath);
      $partner->delete();

      Session::flash('success', 'Partenaire supprimé avec succès!');
      return redirect()->back();
    }
    public function update(Request $request) {
      $partner = Partner::find($request->partnerID);
      if($partner->status==0){
        $partner->status=1;
        $message = 'Activation effectuée avec success !!!';
      }else{
        $partner->status=0;
        $message = 'Désactivation effectuée avec success !!!';
      }
      $partner->save();
      Session::flash('success', $message);
      return redirect()->back();
    }
}
