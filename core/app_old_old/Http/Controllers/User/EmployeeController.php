<?php

namespace App\Http\Controllers\User;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Mail\messageToEmployee;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if((Auth::check()) and (Auth::user()->reason_social!=null)){
            $data['employees']=Employee::with('cartgifts')->get();
            $data['cartgifts']=DB::table('cartgifts')
                                   ->where('etat','En attente')
                                   ->get();
            /* $data['employee_cartgifts'] = DB::table('employees')
                            ->join('cartgifts','cartgifts.employe_id','=','employees.id')
                            ->where('employees.user_id',Auth::user()->id)
                            ->get(); */
           /*  if(($data['employee_cartgifts'])->isNotEmpty()){
                $data['employees']=$data['employee_cartgifts'];
            } */
            return view('user.enterprise.employes',$data);
        }
    }

    public function sendCartGiftToEmployee(Request $request){
        if($request->ajax()){
        $employe_entreprise = DB::table('employees')
        ->join('users','employees.user_id','=','users.id')
        ->join('cartgifts','cartgifts.employee_id','=','employees.id')
        ->where('employees.id',$request->id)
        ->first();
        
        $to = DB::table('employees')
                ->where('id',$request->id)
                ->first()
                ->email;
        if((!empty($employe_entreprise)) and (!empty($to))){
            $message = '<p>Hello M/Mme/Mlle: <strong>'.$employe_entreprise->nom.' '.$employe_entreprise->prenom.'</strong>, </p><br>
            <p>Vous venez de reçevoir votre carte privilège de la part de votre structure '. $employe_entreprise->reason_social .'<br></p>
            <center><a class="btn btn-default">'. mb_substr($employe_entreprise->num_cartgift,0,12) .'</a><br>
            <p>Durée de validité : <strong>'. $employe_entreprise->duree_utilisation .' jours</strong> à partir de la date de reception.</p>';
            send_email($to,$employe_entreprise->nom,$employe_entreprise->phone,$employe_entreprise->email ,'Carte cadeau', $message);
            return response()->json([
                'send'=>true,
                'message'=>'Email envoyé avec success !!!'
            ]);
        }else{
            return response()->json([
                'send'=>false,
                'message'=>'Aucune carte ne lui est encore attribuée !!!'
            ]);
        }
    }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $this->validate($request,[
            'select_file'=>'required|mimes:xls,xlsx,csv'
        ]);
        $path = $request->file('select_file')->getRealPath();
        $data= Excel::load($path)->get();
        if($data->count()>0){
            foreach($data->toArray() as $row){
                    $insert_data[]=array(
                      'matricule'=>$row['matricule'],
                      'nom' =>$row['nom'],
                      'prenom'=>$row['prenom'],
                      'email'=>$row['email'],
                      'telephone'=>$row['telephone'],
                      'user_id'=>Auth::user()->id
                    );
               
            }
            if(!empty($insert_data)){
                DB::table('employees')->insert($insert_data);
            }
        }
        return back()->with('message','Fichier uploader avec succes !!!');
    }
    public function export()
    {
        $list_employes = DB::table('employees')
                        ->join('cartgifts','cartgifts.employee_id','=','employees.id')
                        ->get()
                        ->toArray();
        $tabEmploye[] = array('Matricule','Nom','Prenom','Téléphone','Email','Code Carte');
        foreach($list_employes as $list_employe){
            $tabEmploye[]=array(
                'Matricule' => $list_employe->matricule,
                'Nom' => $list_employe->nom,
                'Prenom' =>$list_employe->prenom,
                'Téléphone'=>$list_employe->telephone,
                'Email' =>$list_employe->email,
                'Code Carte' =>$list_employe->num_cartgift
            );
        }
        Excel::create('Liste Employee', function($excel) use ($tabEmploye){
            $excel->setTitle('Liste Employee');
            $excel->sheet('Liste Employee', function($sheet) use ($tabEmploye){
               $sheet->fromArray($tabEmploye, null,'A1', false, false); 
            });
        })->download('xlsx');
        return back()->with('message','Exportation éffectuée avec succès !!!');
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
    public function edit(Request $request)
    {
        if($request->ajax()){
            $employes = DB::table('employees')->where('id',$request->id)->first();
            if($employes){
                return response()->json([
                    'fail'=>false,
                    'result'=>$employes
                ]);
            }
            else {
                return response()->json([
                    'fail'=>true,
                    'result'=>'Un problème interne est survenu avec cet employé'
                ]);
            }
        }
    }

    public function addcartgift(Request $request){
        $employe_id = DB::table('employees')->where('email',$request->email)->first()->id;
        $cartes_cardeau = DB::table('cartgifts')
                        ->where('num_cartgift',$request->num_cartgift)
                        ->update([
                            'employee_id' => $employe_id,
                            'etat'=>'En cours'
                             ]);
        Session::flash('message','Numéro de carte kdo ou privilège attribué avec success !!!');
        return redirect()->back();
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
    public function destroy(Request $request)
    {
        if($request->ajax()){
            $employe = Employee::find($request->id);
            $employe->delete();
            return response()->json([
                'result' =>'success'
            ]);
        }
    }
}
