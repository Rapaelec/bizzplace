<?php

namespace App\Http\Controllers;

use Auth;
use App\Ad;
use Session;
use App\Cart;
use Validator;
use App\Emploi;
use App\Favorit;
use App\Product;
use App\Service;
use App\Category;
use App\Evenement;
use Carbon\Carbon;
use App\Immobilier;
use App\PreviewImage;
use App\FlashInterval;
use App\ProductReview;
use App\Orderedproduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
  public function show($slug=null, $id) {
    $data['products']=Product::join('vendors','vendors.id','=','products.vendor_id')
                                ->where('products.category_id',3)
                                ->where('vendor_id',$id)
                                ->select('products.id',
                                'current_price',
                                'title',
                                'category_id',
                                'price',
                                'vendor_id')
                                ->paginate(10);
                            // dd($data);
    $data['minprice'] = Product::min('price');
    $data['maxprice'] = Product::max('price');
    $department_json = Storage::get('json/departments.json');
    $region_json = Storage::get('json/regions.json');
    $localite_json = Storage::get('json/cities.json');
    $data['departements']=collect(json_decode($department_json, true));
    $data['regions']=collect(json_decode($region_json, true));
    $data['localites']=collect(json_decode($localite_json, true));
    $data['items']='products';
    $data['sortby'] ='sort_by';
    $data['term'] = 'term';
    return view('user.product.show', $data);
  }

  public function showTriProduct(Request $request,$category=null, $subcateogry=null){
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

    $productids = [];
    $reqattrs = $request->except('keyword','maxprice', 'minprice', 'sort_by', 'term', 'page', 'type','departement','region','localite');
    $count = 0;
    if ($reqattrs) {
      $data['reqattrs'] = $reqattrs;
    } else {
      $data['reqattrs'] = [];
    }

    $products = Product::where('subcategory_id', $subcateogry)->get();
    // return $products;
    // return count($reqattrs);

    foreach ($products as $key => $product) {
      $proattrs = json_decode($product->attributes, true);
      $count = 0;

      foreach ($proattrs as $key => $proattr) {
        // return $proattrs[$key]; //Array[3] 0:"M" 1:"L" 2:"XL"

        if (!empty($reqattrs[$key])) {
          if (!empty(array_intersect($reqattrs[$key], $proattrs[$key]))) {
            $count++;
          }
        }
      }

      if ($count == count($reqattrs)) {
        $productids[] = $product->id;
      }
    }
    // return $productids;
    $departement = $request->departement;
    $region = $request->region;
    $keywords = $request->keyword;
    $category = Category::where('slug',$request->slug)->first()->id; //Prends en compte le nom de la categorie
    $subcategory = $request->subcategory;
    $minprice = $request->minprice;
    $maxprice = $request->maxprice;
    $sortby = $request->sort_by;
    $type = $request->type;
    $data['sortby'] = $request->sort_by;
    $term = $request->term;
    $data['term'] = $request->term;
    // return $category;
    // return $subcategory;
    // dd($subcategory);
    $data['minprice'] = Product::min('price');
    $data['maxprice'] = Product::max('price');
    // $data['vendors'] = Vendor::where('categories_id',$category)->get();
    // ;
    
    
    $data['products']=Product::when($category, function ($query, $category) {
                        return $query->where('category_id', $category);
                    })
                     ->when($subcategory, function ($query, $subcategory)  {
                        return $query->where('subcategory_id', $subcategory);
                    })
                    ->when($keywords, function ($query, $keywords)  {
                        return $query->where('keywords', $keywords);
                    })
                    ->when($departement, function($query, $departement){
                      return $query->where('departement',$departement);
                    })
                    ->when($minprice, function ($query, $minprice)  {
                        return $query->where('price', '>=', $minprice);
                    })
                    ->when($maxprice, function ($query, $maxprice)  {
                      return $query->where('price', '<=', $maxprice);
                    })
                    ->when($sortby, function ($query, $sortby)  {
                      if ($sortby == 'date_desc') {
                        return $query->orderBy('created_at', 'DESC');
                      } elseif ($sortby == 'date_asc') {
                        return $query->orderBy('created_at', 'ASC');
                      } elseif ($sortby == 'price_desc') {
                        return $query->orderBy('search_price', 'DESC');
                      } elseif ($sortby == 'price_asc') {
                        return $query->orderBy('search_price', 'ASC');
                      } elseif ($sortby == 'sales_desc') {
                        return $query->orderBy('sales', 'DESC');
                      } elseif ($sortby == 'rate_desc') {
                        return $query->orderBy('avg_rating', 'DESC');
                      }
                    })
                    ->when($type, function ($query, $type)  {
                      if ($type == 'special') {
                        return $query->whereNotNull('current_price');
                      }
                    })
                    ->when(!$sortby, function ($query, $sortby)  {
                        return $query->orderBy('id', 'DESC');
                    })
                    ->when($term, function ($query, $term)  {
                      return $query->where('title', 'like', '%'.$term.'%');
                    })
                    ->when($productids, function ($query, $productids)  {
                        return $query->whereIn('id', $productids);
                      })
                    ->where('deleted', 0)
                    ->where('vendor_id',$request->id)
                    ->paginate(10);
                    // dd($data['products']);
                    // dd($minprice,$maxprice,$sortby, $term);
                    // foreach($data['products'] as $key => $dat){
                    //    dump($dat->unique('vendor_id')[0]->vendor->logo);
                    //   foreach($dat as $vend){
                    //     dump($vend->vendor->logo->unique);
                    //   }
                    // }
                    // dd($data['products']);
                    if(count($data['products'])>0){
                      $data['counts'] = count($data['products']);
                      $data['items']='products';
                    }
 $data['immobiliers'] = Immobilier::when($category, function ($query, $category) {
                  return $query->where('category_id', $category);
})
                  ->when($subcategory, function ($query, $subcategory)  {
                      return $query->where('subcategory_id', $subcategory);
                    })
                  ->when($keywords, function ($query, $keywords)  {
                      return $query->where('keywords', $keywords);
                  })
                  ->when($minprice, function ($query, $minprice)  {
                    return $query->where('prix', '>=', $minprice);
                  })
                  ->when($departement, function($query, $departement){
                    return $query->where('departement',$departement);
                  })
                  ->when($maxprice, function ($query, $maxprice)  {
                    return $query->where('prix', '<=', $maxprice);
                  })
                  ->when($sortby, function ($query, $sortby)  {
                    if ($sortby == 'date_desc') {
                      return $query->orderBy('created_at', 'DESC');
                    } elseif ($sortby == 'date_asc') {
                      return $query->orderBy('created_at', 'ASC');
                    } elseif ($sortby == 'price_desc') {
                      return $query->orderBy('search_price', 'DESC');
                    } elseif ($sortby == 'price_asc') {
                      return $query->orderBy('search_price', 'ASC');
                    } elseif ($sortby == 'sales_desc') {
                      return $query->orderBy('sales', 'DESC');
                    } elseif ($sortby == 'rate_desc') {
                      return $query->orderBy('avg_rating', 'DESC');
                    }
                  })
                  ->when($type, function ($query, $type)  {
                    if ($type == 'special') {
                      return $query->whereNotNull('current_price');
                    }
                  })
                  ->when($term, function ($query, $term)  {
                    return $query->where('nom', 'like', '%'.$term.'%');
                  })
                  ->when($keywords, function ($query, $keywords)  {
                    return $query->where('keywords', $keywords);
                   })
                  ->when($productids, function ($query, $productids)  {
                    return $query->whereIn('id', $productids);
                  })
                  ->where('deleted', 0)
                  ->where('vendor_id',$request->id)
                  ->paginate(12)
                  ;
                  if((count($data['immobiliers']))>0){
                    $data['counts'] = count($data['immobiliers']);
                    $data['items']='immobiliers';
                  }
$data['r_evenements'] = Evenement::when($category, function ($query, $category) {
                    return $query->where('category_id', $category);
                })
                ->when($subcategory, function ($query, $subcategory)  {
                    return $query->where('subcategory_id', $subcategory);
                })
                ->when($minprice, function ($query, $minprice)  {
                    return $query->where('prix', '>=', $minprice);
                })
                ->when($departement, function($query, $departement){
                  return $query->where('departement',$departement);
                })
                ->when($keywords, function ($query, $keywords)  {
                  return $query->where('keywords', $keywords);
                })
                ->when($maxprice, function ($query, $maxprice)  {
                    return $query->where('prix', '<=', $maxprice);
                })
                ->when($sortby, function ($query, $sortby)  {
                  if ($sortby == 'date_desc') {
                    return $query->orderBy('created_at', 'DESC');
                  } elseif ($sortby == 'date_asc') {
                    return $query->orderBy('created_at', 'ASC');
                  } elseif ($sortby == 'price_desc') {
                    return $query->orderBy('search_price', 'DESC');
                  } elseif ($sortby == 'price_asc') {
                    return $query->orderBy('search_price', 'ASC');
                  } elseif ($sortby == 'sales_desc') {
                    return $query->orderBy('sales', 'DESC');
                  } elseif ($sortby == 'rate_desc') {
                    return $query->orderBy('avg_rating', 'DESC');
                  }
                })
                ->when($type, function ($query, $type)  {
                  if ($type == 'special') {
                    return $query->whereNotNull('current_price');
                  }
                })
                ->when($term, function ($query, $term)  {
                  return $query->where('nom', 'like', '%'.$term.'%');
                })
                ->when($keywords, function ($query, $keywords)  {
                  return $query->where('keywords', $keywords);
                })
                ->when($productids, function ($query, $productids)  {
                  return $query->whereIn('id', $productids);
                })
                ->where('deleted', 0)
                ->where('vendor_id',$request->id)
                ->paginate(12)
                ;
   
                if(count($data['r_evenements'])>0){
                  $data['counts']= count($data['r_evenements']);
                  $data['items']='r_evenements';
                }
$data['emplois'] = Emploi::when($category, function ($query, $category) {
                    return $query->where('category_id', $category);
                })
                ->when($subcategory, function ($query, $subcategory)  {
                    return $query->where('subcategory_id', $subcategory);
                })
                ->when($minprice, function ($query, $minprice)  {
                    return $query->where('prix', '>=', $minprice);
                })
                ->when($region, function ($query, $region) {
                    return $query->where('region', '=', $region);
                })
                ->when($keywords, function ($query, $keywords)  {
                  return $query->where('keywords', $keywords);
                })
                ->when($maxprice, function ($query, $maxprice)  {
                    return $query->where('prix', '<=', $maxprice);
                })
                ->when($departement, function($query, $departement){
                  return $query->where('departement',$departement);
                })
                ->when($sortby, function ($query, $sortby)  {
                  if ($sortby == 'date_desc') {
                    return $query->orderBy('created_at', 'DESC');
                  } elseif ($sortby == 'date_asc') {
                    return $query->orderBy('created_at', 'ASC');
                  } elseif ($sortby == 'price_desc') {
                    return $query->orderBy('search_price', 'DESC');
                  } elseif ($sortby == 'price_asc') {
                    return $query->orderBy('search_price', 'ASC');
                  } elseif ($sortby == 'sales_desc') {
                    return $query->orderBy('sales', 'DESC');
                  } elseif ($sortby == 'rate_desc') {
                    return $query->orderBy('avg_rating', 'DESC');
                  }
                })
                ->when($type, function ($query, $type)  {
                  if ($type == 'special') {
                    return $query->whereNotNull('current_price');
                  }
                })
                ->when($term, function ($query, $term)  {
                  return $query->where('nom', 'like', '%'.$term.'%');
                })
                ->when($productids, function ($query, $productids)  {
                  return $query->whereIn('id', $productids);
                })
                ->where('deleted', 0)
                ->where('vendor_id',$request->id)
                ->paginate(12)
                ;
                if(count($data['emplois'])>0){
                  $data['counts']= count($data['emplois']);
                  $data['items']='emplois';
                }
$data['services'] = Service::when($category, function ($query, $category) {
                  return $query->where('category_id', $category);
              })
              ->when($subcategory, function ($query, $subcategory)  {
                  return $query->where('subcategory_id', $subcategory);
              })
              ->when($minprice, function ($query, $minprice)  {
                  return $query->where('prix', '>=', $minprice);
              })
              ->when($keywords, function ($query, $keywords)  {
                return $query->where('keywords', $keywords);
              })
              ->when($maxprice, function ($query, $maxprice)  {
                  return $query->where('prix', '<=', $maxprice);
              })
              ->when($departement, function($query, $departement){
                return $query->where('departement',$departement);
              })
              ->when($sortby, function ($query, $sortby)  {
                if ($sortby == 'date_desc') {
                  return $query->orderBy('created_at', 'DESC');
                } elseif ($sortby == 'date_asc') {
                  return $query->orderBy('created_at', 'ASC');
                } elseif ($sortby == 'price_desc') {
                  return $query->orderBy('search_price', 'DESC');
                } elseif ($sortby == 'price_asc') {
                  return $query->orderBy('search_price', 'ASC');
                } elseif ($sortby == 'sales_desc') {
                  return $query->orderBy('sales', 'DESC');
                } elseif ($sortby == 'rate_desc') {
                  return $query->orderBy('avg_rating', 'DESC');
                }
              })
              ->when($type, function ($query, $type)  {
                if ($type == 'special') {
                  return $query->whereNotNull('current_price');
                }
              })
              ->when($term, function ($query, $term)  {
                return $query->where('nom', 'like', '%'.$term.'%');
              })
              ->when($productids, function ($query, $productids)  {
                return $query->whereIn('id', $productids);
              })
              ->where('deleted', 0)
              ->where('vendor_id',$request->id)
              ->paginate(12)
              ;
              if(count($data['services'])>0){
                $data['counts']= count($data['services']);
                $data['items']='services';
              }
                $data['categories'] = Category::where('status', 1)->get();
                //Chargement des fichiers jsons
                $department_json = Storage::get('json/departments.json');
                $region_json = Storage::get('json/regions.json');
                $localite_json = Storage::get('json/cities.json');
                $data['departements']=collect(json_decode($department_json, true));
                $data['regions']=collect(json_decode($region_json, true));
                $data['localites']=collect(json_decode($localite_json, true));
                $data['shopad'] = Ad::where('size', 3)->inRandomOrder()->first();
    // dd($data['products']);        
    return view('user.product.showTrie', $data);
  }
    public function detailProduct($slug=null, $id) {
      // dd('test');
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

      $data['product'] = Product::find($id);
      $name_vendor = DB::table('vendors')->join('products','products.vendor_id','=','vendors.id')
                    ->select('vendors.shop_name')
                    ->where('products.product_code',$data['product']->product_code)
                    ->first();
      $data['sales'] = $data['product']->sales;
      $data['rproducts'] = Product::with('previewimages')->where('subcategory_id', $data['product']->subcategory_id)->where('deleted', 0)->inRandomOrder()->limit(10)->get();
      $response = new \Illuminate\Http\Response(view('product.show', $data));
      $response->withCookie(cookie()->forever('shop_name',$name_vendor->shop_name));
      return $response;
    }

    public function detaills($slug=null, $id) {
      // dd('test');
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

      $data['product'] = Product::find($id);
      $name_vendor = DB::table('vendors')->join('products','products.vendor_id','=','vendors.id')
                    ->select('vendors.shop_name')
                    ->where('products.product_code',$data['product']->product_code)
                    ->first();
      $data['sales'] = $data['product']->sales;
      $data['rproducts'] = Product::with('previewimages')->where('subcategory_id', $data['product']->subcategory_id)->where('deleted', 0)->inRandomOrder()->limit(10)->get();
      $response = new \Illuminate\Http\Response(view('product.show', $data));
      $response->withCookie(cookie()->forever('shop_name',$name_vendor->shop_name));
      return $response;
    }

    public function getcomments(Request $request) {
      $reviews = ProductReview::where('product_id', $request->product_id)->orderBy('id', 'DESC')->get();
      return $reviews;
    }

    public function reviewsubmit(Request $request) {

      $validator = Validator::make($request->all(), [
        'rating' => [
          function ($attribute, $value, $fail) {
              if (empty($value)) {
                  $fail('Un vote est requise');
              }
          },
        ]
      ]);

      if($validator->fails()) {
          // adding an extra field 'error'...
          $validator->errors()->add('error', 'true');
          return response()->json($validator->errors());
      }

      $productreview = new ProductReview;
      $productreview->user_id = Auth::user()->id;
      $productreview->product_id = $request->product_id;
      $productreview->rating = floatval($request->rating);
      $productreview->comment = $request->comment;
      $productreview->save();

      $product = Product::find($request->product_id);
      $product->avg_rating = ProductReview::where('product_id', $request->product_id)->avg('rating');
      $product->save();

      Session::flash('success', 'Révisé avec succès');

      return "success";
    }


    // add to cart...
    public function getproductdetails(Request $request) {
      if (Auth::check()) {
        $sessionid = Auth::user()->id;
      } else {
        $sessionid = session()->get('browserid');
      }

      // get details of the selected product
      $product = Product::find($request->productid);
      $preimg = PreviewImage::where('product_id', $product->id)->first();
      $product['preimg'] = $preimg->image;


      // if this product is already in the cart then just update the quantity...
      if (Cart::where('cart_id', $sessionid)->where('product_id', $product->id)->count() > 0) {
        $cart = Cart::where('cart_id', $sessionid)->where('product_id', $product->id)->first();
        $cart->quantity = $cart->quantity + 1;
        $cart->save();
        return response()->json(['status'=>'quantityincr', 'productid'=>$product->id, 'quantity'=>$cart->quantity]);
      }


      // if a new product is added to cart
      $cart = new Cart;
      $cart->cart_id = $sessionid;
      $cart->product_id = $product->id;
      $cart->title = $product->title;
      $cart->price = $product->price;
      $cart->quantity = $request->quantity;
      $cart->save();

      $product['quantity'] = $request->quantity;
      return response()->json(['status'=>'productadded', 'product'=>$product, 'quantity'=>$product['quantity']]);
    }

    public function favorit(Request $request) {
      $count = Favorit::where('user_id', Auth::user()->id)->where('product_id', $request->productid)->count();
      if ($count > 0) {
        Favorit::where('user_id', Auth::user()->id)->where('product_id', $request->productid)->delete();
        return "unfavorit";
      } else {
        $favorit = new Favorit;
        $favorit->user_id = Auth::user()->id;
        $favorit->product_id = $request->productid;
        $favorit->save();
        return "favorit";
      }
    }

    public function productratings($pid) {
      $prs = ProductReview::where('product_id', $pid)->get();
      return $prs;
    }

    public function avgrating($pid) {
      $avgrating = ProductReview::where('product_id', $pid)->avg('rating');
      if (empty($avgrating)) {
        $avgrating = 0;
      }
      return $avgrating;
    }
}
