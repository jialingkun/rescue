<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Service\DataTableService;
class UserController extends Controller
{
    protected $dataTableService;
      public function __construct(DataTableService $dataTableService)
      {
        $this->dataTableService     = $dataTableService;
      }
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

    public function lengkapiAkun(Request $request)
    {
        $data = array();
        $respon = null;
        $status = 200;
        $message = "Success";
        
        if(User::where('token', '=', $request['token'])->count() > 0 )
        {

            $user = User::where('token','=',$request['token'])->update([
                                    'name' => $request['name'],
                                    
                                        'no_hp' => $request['no_hp'],
                                        'alamat' => $request['alamat'],
                                        'no_darurat' => $request['no_darurat'],
                                        'pesan' => $request['pesan'],
                                        'pin_alamat' =>$request['pinAlamat'],
                                        'pin_latitude' =>$request['pinLatitude'],
                                        'pin_longitude' =>$request['pinLongitude'],
                                    
                                     ]);
            $message = "Success fill account";
            
        }
        else
        {
            $status = 202;
            $message = "Your account signed in another device";
        }
        $data = array(
                   'data' =>$respon, 
                  'status_code' =>$status,
                  'message'     => $message,  
                );
       return \Response::json($data, $status);


    }

    public function getUserData(Request $request)
    {
        $status = 200;
        $message = "Success";
        $data = array();
           // $user = User::where('token', '=',$request['token'])->first();
         if(User::where('token', '=', $request['token'])->count() > 0 )
         {
            $dataku = User::where('token','=',$request['token'])->first();

            $data = array(
                    'name' => $dataku['name'],
                    'email' => $dataku['email'],
                    'no_hp' => $dataku['no_hp'],
                    'alamat' => $dataku['alamat'],
                    'no_darurat' => $dataku['no_darurat'],
                    'pesan' => $dataku['pesan'],
                    'path' => $dataku['photo_path'],
                    'pinAlamat' =>$dataku['pin_alamat']
                );            
         }
         else{
            $status = 202;
            $message = "Your account signed in another device";
         }

         $respon =array(
                'data'=>$data,
                'status_code'=>$status,
                'message'=>$message,
                );

            return \Response::json($respon, $status);
    
        }

    public function logoutUser(Request $request)
    {
        $status = 200;
        $message = "Success";
        $data = null;               
        if(User::where('token', '=', $request['token'])->count() > 0 )
         {
           $user = User::where('token','=',$request['token'])->update([
                                    'token' =>null,
                                    'FCMToken' =>null,                                    
                                     ]);          
         }
        else
        {
            $status = 202;
            $message = "Your account signed in another device";
        }

        $respon =array(
                'data'=>$data,
                'status_code'=>$status,
                'message'=>$message,
                );

        return \Response::json($respon, $status);

    }

    public function updateLokasi(Request $request)
    {
        $status = 200;
        $message = "Success";
        $data = null;
        if(User::where('token', '=', $request['token'])->count() > 0 )
         {
           $user = User::where('token','=',$request['token'])->update([
                                    'latitude' =>$request['latitude'], 
                                    'longitude'=>$request['longitude'],                                   
                                     ]);          
         }
        else
        {
            $status = 202;
            $message = "Your account signed in another device";
        }

        $respon =array(
                'data'=>$data,
                'status_code'=>$status,
                'message'=>$message,
                );

        return \Response::json($respon, $status);
    }


    public function updateFCM(Request $request)
    {
        $status = 200;
        $message = "Success";
        $data = null;
        if(User::where('token', '=', $request['token'])->count() > 0 )
         {

            $pengguna = User::where('token', '=', $request['token'])->first();
            if($pengguna->status==1)
            {

           $user = User::where('token','=',$request['token'])->update([
                                    'FCMToken' =>$request['fcm'],                                    
                                     ]);   
            }
            else
            {
                $status = 206;
                $message = "Akun anda diblokir";
            }

         }
        else
        {
            $status = 202;
            $message = "Your account signed in another device";
        }

        $respon =array(
                'data'=>$data,
                'status_code'=>$status,
                'message'=>$message,
                );

        return \Response::json($respon, $status);
    }

    public function uploadProfilPicture(Request $request)
    {
        $data = array();
        $respon = null;
        $status = 200;
        $message = "Success";


         if(User::where('token', '=', $request['token'])->count() > 0 )
         {
             $foto = $request['profil'];
             if($foto != null)
             {

             $foto->move('profil', $foto->getClientOriginalName());
             $user = User::where('token','=',$request['token'])->update([
                                    'photo_path' =>$request['path'],                                    
                                     ]);          
             }

         }
        else
        {
            $status = 202;
            $message = "Your account signed in another device";
        }

       

        $data = array(
                   'data' =>$respon, 
                  'status_code' =>$status,
                  'message'     => $message,  
                );
        return \Response::json($data, $status);
    }

    public function indexPengguna(){
      return view('backend.pengguna.index');
    }

    public function indexAdmin(){
      return view('backend.admin.index');
    }

    public function data(Request $request){
        $data = User::select('users.id_user as id','users.id_user','roles.keterangan as id_role','users.name','users.no_hp','users.alamat','users.no_darurat','users.status')
                ->leftJoin('roles','users.id_role','=','roles.id_role')
                ->where('users.id_role','!=',3);
        return $this->dataTableService->generate($data, 'editonly');
    }

    public function detail(Request $request,$id){
        $data = User::select('users.id_user as id_user', 'users.id_user as id', 'roles.keterangan as id_role','users.name','users.email','users.no_hp','users.alamat','users.no_darurat','users.pesan','users.status')
                ->leftJoin('roles','users.id_role','=','roles.id_role')
                ->where('users.id_user',$id)->first();
        return response()->json($data);
    }

    public function dataAdmin(Request $request){
        $data = User::select('users.id_user as id','users.id_user','roles.keterangan as id_role','users.name','users.no_hp')
                ->leftJoin('roles','users.id_role','=','roles.id_role')
                ->where('users.id_role','=',3);
        return $this->dataTableService->generate($data, 'editonly');
    }

    public function detailAdmin(Request $request,$id){
        $data = User::select('users.id_user as id_user', 'users.id_user as id', 'roles.keterangan as id_role','users.name','users.email','users.no_hp','users.alamat','users.no_darurat','users.pesan','users.status')
                ->leftJoin('roles','users.id_role','=','roles.id_role')
                ->where('users.id_user',$id)->first();
        return response()->json($data);
    }

    public function updateStatus(Request $request,$id){
        $data = User::where('users.id_user',$id)->update(array(
                'status' => $request->status
            ));
        return response()->json($data);
    }

    public function updateAdmin(Request $request){
        $data = User::where('users.id_user',\Auth::user()->id_user)->update(array(
                'kode' => \Hash::make($request->password1)
            ));
        return response()->json($data);
    }
    public function createAdmin(Request $request){
        $data = User::create(array(
                'id_role'   => 3,
                'name'      => $request->name,
                'email'     => $request->email,
                'no_hp'     => $request->no_hp, 
                'kode'      => \Hash::make($request->kode)
            ));
        $update = User::where('id_user',$data->id_user)->update(array(
                    'id_role' => 3
                ));
        return response()->json($data);
    }

}
