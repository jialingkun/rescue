<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ambulan;
use App\Service\DataTableService;
class AmbulanController extends Controller
{
    //
    protected $dataTableService;
    public function __construct(DataTableService $dataTableService)
    {
        $this->dataTableService     = $dataTableService;
    }
	public function loginAPI(Request $request)
    {

        $data = array();
        $respon = array();
        $token = null;
        $status = 200;
        $message = "Success login";


             if (Ambulan::where('username', '=', $request['username'])->where('kode', '=', $request['kode'])->count() > 0 )
             {
                // Authentication passed...

                $token = \Auth::getSession()->getId();


                $user = Ambulan::where('username','=',$request['username'])->update([
                'token' => $token

                 ]);
                $dataku = Ambulan::where('username','=',$request['username'])->first();

                 $respon = array(
                    'id_ambulan' =>$dataku['id_ambulan'],
                    'username'=>$dataku['username'],
                    'kode' => $dataku['kode'],
                    'token' => $dataku['token'],
                    'no_pol_ambulan' => $dataku['no_pol_ambulan'],
                    'nama_rs' => $dataku['nama_rs'],
                    'alamat_rs' => $dataku['alamat_rs'],
                  );

            }


        else
        {
            $message = "Wrong Code";
            $status = 202;
        }
        $data['data'] = $respon;
        $data['message'] = $message;
        $data['status_code'] = $status;

         return \Response::json($data, $status);
    }

    public function updateFCM(Request $request)
    {
    	$status = 200;
        $message = "Success";
        $data = null;

        if(Ambulan::where('token', '=', $request['token'])->count() > 0 )
         {
           $user = Ambulan::where('token','=',$request['token'])->update([
                                    'FCMToken' =>$request['fcm'],
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

    public function index(){
      return view('backend.ambulan.index');
    }

    public function data(Request $request){
        $data = Ambulan::select('id_ambulan as id','id_ambulan','username','kode','no_pol_ambulan','nama_rs','alamat_rs','no_telp_rs');
        return $this->dataTableService->generate($data, 'nodetail');
    }

    public function detail(Request $request,$id){
        $data = Ambulan::select('id_ambulan as id','id_ambulan','username','kode','no_pol_ambulan','nama_rs','alamat_rs','no_telp_rs')
                ->where('id_ambulan',$id)->first();
        return response()->json($data);
    }

    public function update(Request $request,$id){
        $req = $request->except('id','_method','_token');
        $data = Ambulan::where('id_ambulan',$id)->update($req);
        return response()->json($data);
    }

    public function create(Request $request){
        $req = $request->except('id','_method','_token');
        $req['id_role'] = 2;
        $data = Ambulan::create($req);
        return response()->json($data);
    }

    public function delete(Request $request, $id){
        $data = Ambulan::where('id_ambulan',$id)->delete();
        return response()->json($data);
    }

    public function logoutAmbulan(Request $request)
    {
        $status = 200;
        $message = "Success";
        $data = null;
        if(Ambulan::where('token', '=', $request['token'])->count() > 0 )
         {
           $user = Ambulan::where('token','=',$request['token'])->update([
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

}
