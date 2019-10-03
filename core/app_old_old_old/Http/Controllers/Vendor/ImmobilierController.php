<?php

namespace App\Http\Controllers\Vendor;

use App\Vendor;
use App\Category;
use App\Immobilier;
use App\Subcategory;
use App\PreviewImage;
use App\FlashInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class ImmobilierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($slug)
    {
        
        $vendor_role = Auth::guard('vendor')->user()->id;
        $vendor = Vendor::find($vendor_role);
         if ($vendor->products != 0) {
          $today = new \Carbon\Carbon(Carbon::now());
          $existingVal = new \Carbon\Carbon($vendor->expired_date);
          if ($today->gt($existingVal)) {
            $vendor->products = 0;
            $vendor->expired_date = NULL;
            $vendor->save();
            send_email($vendor->email, $vendor->shop_name, $vendor->phone,$vendor->email,"Le forfait d'abonnement a expiré!", "Votre forfait d'abonnement a expiré. S'il vous plaît acheter un nouveau forfait d'abonnement.");
          }
        }
        $vendor_role = Auth::guard('vendor')->user()->shop_name;
        $data['categoris']=Category::where('name',$slug)
                                    ->where('status',1)
                                    ->first();
        $data['countries'] = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
        $data['slug']=[
            'slug'=>$slug
        ];
        $data['subcats'] = Subcategory::where('status', 1)
                            ->where('category_id',$data['categoris']->id)
                            ->get();
        $data['immobiliers'] = DB::table('immobiliers')
                            ->join('categories','immobiliers.category_id','=','categories.id')
                            ->where('categories.validation','=','yes')
                            ->get();
        
        $views= view('vendor.immobilier.create',$data);
        
        return  $views;
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
            'etat' => 'required',
            'ville' => 'required',
            'surface' => 'required',
            'piece' => 'required|integer',
            'chambre' => 'required|integer',
            'terrain' => 'required|integer',
            'departement' => 'required',
            'chauffage' => 'required',
            'description' => 'required',
            'type_offre' => 'required',
            'salle_de_bain' => 'required|integer'
        ]);

        $immobiliers = new Immobilier();
        $immobiliers->vendor_id = Auth::guard('vendor')->user()->id;
        $immobiliers->category_id = $request->categorie;
        $immobiliers->type_offre = $request->type_offre;
        $immobiliers->subcategory_id = $request->subcate_id;
        $immobiliers->nom = $request->nom;
        $immobiliers->slug = str_slug($request->nom,'-');
        $immobiliers->prix = $request->prix;
        $immobiliers->pays = $request->pays;
        $immobiliers->etat = $request->etat;
        $immobiliers->ville = $request->ville;
        $immobiliers->etage = $request->etage;
        $immobiliers->piece = $request->piece;
        $immobiliers->charge = $request->charge;
        $immobiliers->surface = $request->surface;
        $immobiliers->terrain = $request->terrain;
        $immobiliers->chambre = $request->chambre;
        $immobiliers->departement = $request->departement;
        $immobiliers->chauffage = $request->chauffage;
        $immobiliers->description = $request->description;
        $immobiliers->autre_info = $request->autre_info;
        $immobiliers->salle_de_bain = $request->salle_de_bain;
        $immobiliers->save();

        if($request->hasfile('images'))
        {

          /*  foreach($request->file('images') as $image)
           {

               $name=$image->getClientOriginalName();
               $image->move('assets/user/img/products/', $name); 
               var_dump($name);
               $data[] = $name;  
           } */
        

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
           $pi->immobilier_id = $immobiliers->id;
           $pi->image = $filename;
           $pi->big_image = $filename1;
           $pi->save();
         }
       }

        Session::flash('success', 'Immobilier ajouté avec succès!');
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
    public function edit($id) {
        $vendor_role = Auth::guard('vendor')->user()->id;
        $vendor = Vendor::find($vendor_role);
        $vendor_role = Auth::guard('vendor')->user()->shop_name;
        $data['countries'] = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
        
        $data['categoris']=Category::where('true_name','IMMOBILIERS')
                            ->where('status', 1)
                            ->first();
        $data['immobiliers'] = DB::table('immobiliers')->where('id',$id)->first();
    //    dd($data['immobiliers']->etat) ;
        $data['subcats'] = Subcategory::where('status', 1)
        ->where('category_id',$data['categoris']->id)
        ->get();
        return view('vendor.immobilier.edit', $data);
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
        'etat' => 'required',
        'ville' => 'required',
        'surface' => 'required',
        'piece' => 'required|integer',
        'chambre' => 'required|integer',
        'terrain' => 'required|integer',
        'departement' => 'required',
        'chauffage' => 'required',
        'description' => 'required',
        'type_offre' => 'required',
        'salle_de_bain' => 'required|integer'
    ]);

    $immobiliers = Immobilier::find($request->id);
    $immobiliers->vendor_id = Auth::guard('vendor')->user()->id;
    $immobiliers->category_id = $request->categorie;
    $immobiliers->type_offre = $request->type_offre;
    $immobiliers->subcategory_id = $request->subcate_id;
    $immobiliers->nom = $request->nom;
    $immobiliers->prix = $request->prix;
    $immobiliers->pays = $request->pays;
    $immobiliers->etat = $request->etat;
    $immobiliers->ville = $request->ville;
    $immobiliers->etage = $request->etage;
    $immobiliers->piece = $request->piece;
    $immobiliers->charge = $request->charge;
    $immobiliers->surface = $request->surface;
    $immobiliers->terrain = $request->terrain;
    $immobiliers->chambre = $request->chambre;
    $immobiliers->departement = $request->departement;
    $immobiliers->chauffage = $request->chauffage;
    $immobiliers->description = $request->description;
    $immobiliers->autre_info = $request->autre_info;
    $immobiliers->salle_de_bain = $request->salle_de_bain;
    $immobiliers->save();
    
    if($request->hasfile('images'))
    {

      /*  foreach($request->file('images') as $image)
       {

           $name=$image->getClientOriginalName();
           $image->move('assets/user/img/products/', $name); 
           var_dump($name);
           $data[] = $name;  
       } */
    


    foreach($request->file('images') as $img) {
       $pi = PreviewImage::where('immobilier_id', $immobiliers->id)->get();
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

       $pis = PreviewImage::where('immobilier_id', $immobiliers->id)
                           ->get();
       foreach ($pis as $pi) {
       $pi->immobilier_id = $immobiliers->id;
       $pi->image = $filename;
       $pi->big_image = $filename1;
       $pi->save();
       }
       
     }
   }
   $data['immobiliers'] = DB::table('immobiliers')
                                  /*   ->join('categories','immobiliers.category_id','=','categories.id')
                                    ->where('categories.validation','=','yes') */
                                    ->get();
    $data['categoris']=Category::where('name','IMMOBILIERS')->first();
    Session::flash('success', 'Immobilier mis à jour avec succès!');
    return view('vendor.immobilier.manage',$data);  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $immobilier = Immobilier::find($request->id);
        $immobilier->delete();
        Session::flash('success', 'Immobilié retiré avec succès!');
        return "success";
    }
}
