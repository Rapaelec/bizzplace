<?php


namespace  App\Http\Controllers\Vendor;

use App\Deliveryman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class DeliverymanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deliveryman()
    {
        $data['livreurs'] = Deliveryman::latest()->paginate(10);
        $data['vendor_deliverymans']=DB::table('vendors')->join('deliverymans','vendors.id','=','deliverymans.vendor_id')->get();
        return view('vendor.deliveryman.manage',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vendor.deliveryman.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $validatedRequest = $request->validate([
              'name' => 'required',
              'phone'=> 'required',
              'email'=> 'required|email',
              'place_of_residence'=> 'required',
              'delivery_price'=> 'required|integer',
              'distance'=> 'required|integer',
              'command_weight'=> 'required'
            ]);
      
            $livreurs = new Deliveryman;
            $livreurs->name = $request->name;
            $livreurs->phone = $request->phone;
            $livreurs->email = $request->email;
            $livreurs->place_of_residence = $request->place_of_residence;
            $livreurs->delivery_price = $request->delivery_price;
            $livreurs->distance = $request->distance;
            $livreurs->command_weight = $request->command_weight;
            $livreurs->vendor_id = Auth()->user()->id;

            $livreurs->save();
      
            Session::flash('success', 'Livreur crée avec success !!!');
            return redirect()->route('vendor.deliveryman.manage');
    }

    /**
     * Active the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function active(Request $request)
    {
        $livreurs = Deliveryman::find($request->id);
        if($livreurs->status==1){
            $livreurs->status = 0;
            $status  = 'Non Actif';
            $livreurs->save();
        }else{
            $livreurs->status = 1;
            $status  = 'Actif';
            $livreurs->save();
        }
        Session::flash('success', 'Livreur '.$status);
        return "success";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $livreurs = Deliveryman::find($id);
        return view('vendor.deliveryman.create',compact('livreurs'));
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
        $validatedRequest = $request->validate([
            'name' => 'required',
            'phone'=> 'required',
            'email'=> 'required|email',
            'place_of_residence'=> 'required',
            'delivery_price'=> 'required|integer',
            'distance'=> 'required|integer',
            'command_weight'=> 'required'
          ]);
    
          $livreurs = Deliveryman::find($request->id);
          $livreurs->name = $request->name;
          $livreurs->phone = $request->phone;
          $livreurs->email = $request->email;
          $livreurs->place_of_residence = $request->place_of_residence;
          $livreurs->delivery_price = $request->delivery_price;
          $livreurs->distance = $request->distance;
          $livreurs->command_weight = $request->command_weight;
          $livreurs->status = $request->status;

          $livreurs->save();
    
          Session::flash('success', 'Information livreur mise à jour avec success !!!');
          return redirect()->route('vendor.deliveryman.manage');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $livreurs = Deliveryman::find($request->id);
        $livreurs->delete();
        Session::flash('success', 'Livreur supprimé avec success !');
        return "success";
    }
}
