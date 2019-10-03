<?php

namespace App\Http\Controllers\Vendor;

use App\Vendor;
use App\Category;
use App\Allcategory;
use App\Subcategory;
use App\PreviewImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class CategoryAllController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($slug)
    {
        $data['countries'] = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
        $data['categoris']=$slug;
        $category_id = Category::where('true_name',strtoupper($slug))->first()->id;
        $data['subcats'] = Subcategory::where('category_id',$category_id)->get();
        return view('vendor.viewAllcategory.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $imgs = $request->file('images');
    
        $allowedExts = array('jpg', 'png', 'jpeg');
        $request->validate([
            'images'=> 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg',
            'nom' => 'required',
            'prix'  => 'required|integer',
            'pays' => 'required ',
            'ville' => 'required',
            'region'=>'required',
            'departement' => 'required',
            'description' => 'required',
        ]);

        $allcategories = new Allcategory();
        $allcategories->vendor_id = Auth::guard('vendor')->user()->id;
        $allcategories->category_id = $request->categorie;
        $allcategories->subcategory_id = $request->subcate_id;
        $allcategories->title = $request->nom;
        $allcategories->slug = str_slug($request->nom,'-');
        $allcategories->price = $request->prix;
        $allcategories->pays = $request->pays;
        $allcategories->region = $request->region;
        $allcategories->ville = $request->ville;
        $allcategories->departement = $request->departement;
        $allcategories->description_items = $request->description;
        $allcategories->save();

        if($request->hasfile('images'))
        {

        foreach($request->file('images') as $img) {
           $pi = new PreviewImage;
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
           $pi->allcategory_id = $allcategories->id;
           $pi->image = $filename;
           $pi->big_image = $filename1;
           $pi->save();
         }
       }
       
        Session::flash('success', 'Enregistrement effectué avec succès!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['countries'] = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
        $data['allcategoris'] = DB::table('allcategories')->where('id',$id)->first();
        $data['categoris']= Category::where('id',$data['allcategoris']->category_id)
                                ->where('status', 1)
                                ->first();
        $data['subcats'] = Subcategory::where('status', 1)
                        ->where('category_id',$data['categoris']->id)
                        ->get();
        
        return view('vendor.viewAllcategory.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $imgs = $request->file('images');
    
        $allowedExts = array('jpg', 'png', 'jpeg');
        $request->validate([
            'images'=> 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg',
            'nom' => 'required',
            'prix'  => 'required|integer',
            'pays' => 'required ',
            'ville' => 'required',
            'region'=>'required',
            'departement' => 'required',
            'description' => 'required',
        ]);

        $allcategories = Allcategory::find($request->id);
        $allcategories->vendor_id = Auth::guard('vendor')->user()->id;
        $allcategories->category_id = $request->categorie;
        $allcategories->subcategory_id = $request->subcate_id;
        $allcategories->title = $request->nom;
        $allcategories->slug = str_slug($request->nom,'-');
        $allcategories->price = $request->prix;
        $allcategories->pays = $request->pays;
        $allcategories->region = $request->region;
        $allcategories->ville = $request->ville;
        $allcategories->departement = $request->departement;
        $allcategories->description_items = $request->description;
        $allcategories->save();

        if($request->hasfile('images'))
        {

        foreach($request->file('images') as $img) {
           $pi = new PreviewImage;
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
           $pi->allcategory_id = $allcategories->id;
           $pi->image = $filename;
           $pi->big_image = $filename1;
           $pi->save();
         }
       }
       
        Session::flash('success', 'Mise à jour effectué avec succès!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $allcategories = Allcategory::find($request->id);
        $allcategories->delete();
        Session::flash('success', 'Produit retiré avec succès!');
        return "success";
    }
}
