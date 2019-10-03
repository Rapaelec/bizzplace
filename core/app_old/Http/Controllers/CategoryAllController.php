<?php

namespace App\Http\Controllers;

use App\Allcategory;
use Illuminate\Http\Request;
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
                                    'description_items',
                                    'vendor_id')
                                    ->paginate(10);
        // dd($data['allcategories'],$id);
        $data['minprice'] = Allcategory::min('price');
        $data['maxprice'] = Allcategory::max('price');
        $data['items']='allcategory';
        $data['sortby'] ='sort_by';
        $data['term'] = 'term';
        return view('user.otherproducts.show', $data);
      }
}
