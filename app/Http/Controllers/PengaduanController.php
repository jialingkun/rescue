<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\User;
use App\Pengaduan;
use App\Ambulan;
use App\Service\DataTableService;
class PengaduanController extends Controller
{
    protected $dataTableService;
    public function __construct(DataTableService $dataTableService)
    {
        $this->dataTableService     = $dataTableService;
    }

    public function pengaduanUser(Request $request)
    {
    	$respon = null;
        $status = 200;
        $message = "Success";


        if(User::where('token', '=', $request['token'])->count() > 0 )
        {
        	$user = User::where('token', '=', $request['token'])->first();
            $pengaduan = Pengaduan::create([
            'id_user' => $user->id_user,
            'id_role' => "1",
            'pesan' => $request['pesan'],
            ]);
            
        }
        else if(Ambulan::where('token', '=', $request['token'])->count() > 0 )
        {
            $ambulan = Ambulan::where('token', '=', $request['token'])->first();
            $pengaduan = Pengaduan::create([
            'id_user' => $ambulan->id_ambulan,
            'id_role' => "2",
            'pesan' => $request['pesan'],
            ]);
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

    public function pengaduanAmbulan(Request $request)
    {
    	$respon = null;
        $status = 200;
        $message = "Success";

       
        if(Ambulan::where('token', '=', $request['token'])->count() > 0 )
        {
        	$ambulan = Ambulan::where('token', '=', $request['token'])->first();
            $pengaduan = Pengaduan::create([
            'id_user' => $ambulan->id_ambulan,
            'id_role' => "2",
            'pesan' => $request['pesan'],
            ]);
            
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


    public function template(Request $request)
	{
		$respon = null;
        $status = 200;
        $message = "Success";








        $data = array(
                   'data' =>$respon, 
                  'status_code' =>$status,
                  'message'     => $message,  
                );
        return \Response::json($data, $status);
	}

    public function indexPengaduan(){
      return view('backend.pengaduan.index');
    }

    public function data(Request $request){
        $data = Pengaduan::select('id_pengaduan','id_pengaduan as id','users.name as id_user','pengaduans.pesan')
                ->leftJoin('users','users.id_user','=','pengaduans.id_user');
        return $this->dataTableService->generate($data, 'editonlyPengaduan');
    }

    public function detail(Request $request,$id){

        $data = Pengaduan::select('id_pengaduan','users.name as id_user', 'pengaduans.pesan')
                ->leftJoin('users','pengaduans.id_user','=','users.id_user')
                ->where('pengaduans.id_pengaduan',$id)->first();
        return response()->json($data);
    }
}
