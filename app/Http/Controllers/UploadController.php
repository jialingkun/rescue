<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CodeBlue;
use App\Transaksi;  
// use \Input as Input;

class UploadController extends Controller
{
    
    public function create()
    {
        //
    }
    public function upload(Request $request){

    	$data = array();
	    $respon = null;
	    $status = 200;
	    $message = "Success";
	    
    	$foto = $request['file'];
    	$foto->move('foto', $foto->getClientOriginalName());
    	$data = array(
                   'data' =>$respon, 
                  'status_code' =>$status,
                  'message'     => $message,  
                );

      $this->insertUploadData($request['email'], $request['longitude'], $request['latitude'], $request['lokasi'],
        $request['foto'], $request['ambulan']);

    	return \Response::json($data, $status);

    }

    public function insertUploadData(String $email, String $longitude, String $latitude, String $lokasi, 
      String $foto, String $ambulan)
    {


        $user = CodeBlue::create([
            'email' => $email,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'lokasi' => $lokasi,
            'foto' => $foto,
            'ambulan' => $ambulan
            
        ]);
    }

    // public function uploadTransaksi(String $idPenolong, String $latitude, String $longitude, String $lokasi,                            String $foto)
    // {
    //     $user = Transaksi::create([
    //         'id_penolong'   => $idPenolong,
    //         'latitude'      => $latitude,
    //         'longitude'     => $longitude,
    //         'lokasi'        => $lokasi,
    //         '$foto'         => $foto
    //         ]);
    // }
    

    
}
