<?php

namespace App\Http\Controllers\Admin;

use App\Vendor;
use App\Category;
use Carbon\Carbon;
use App\Subcategory;
use App\FlashInterval;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CentralAchatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['flashints'] = FlashInterval::all();
        $data['cats'] = Category::where('status', 1)->get();
        $data['subcats'] = Subcategory::where('status', 1)->get();
        $vendor = Vendor::find(1);
        if ($vendor->products != 0) {
          $today = new \Carbon\Carbon(Carbon::now());
          $existingVal = new \Carbon\Carbon($vendor->expired_date);
          if ($today->gt($existingVal)) {
            $vendor->products = 0;
            $vendor->expired_date = NULL;
            $vendor->save();
            send_email($vendor->email, $vendor->shop_name, "Le forfait d'abonnement a expiré!", "Votre forfait d'abonnement a expiré. S'il vous plaît acheter un nouveau forfait d'abonnement.");
          }
        }
        return view('admin.central_achat.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
