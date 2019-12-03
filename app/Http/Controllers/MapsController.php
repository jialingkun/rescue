<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Factory;
use App\Ambulan;
use App\Hospital;
use App\Aed;

class MapsController extends Controller
{

    public function index()
    {
        // Mapper::map(-7.2990122, 112.7703221, ['marker' => false]);

        $dataAed = Aed::all();
        $dataAmbulance = Ambulan::all();
        $dataHospital = Hospital::all();

        // foreach ($dataAed as $key => $value) {
            
        //     Mapper::informationWindow($value->lat, $value->lang, '<b>'.$value->nama.'</b><br />'.$value->alamat.'<br />'.$value->desc, ['icon' => 'https://cdn4.iconfinder.com/data/icons/cologne/32x32/heart.png']);
            
        // }

        // foreach ($dataAmbulance as $key => $value) {
            
        //     Mapper::informationWindow($value->lat, $value->lang, '<b>Ambulance '.$value->kode.'</b><br />'.$value->nama_rs.'<br />'.$value->alamat_rs.'<br />'.$value->no_telp_rs.'<br />'.$value->no_pol_ambulan, ['icon' => 'http://www.freenew.net/upload/picon/1/ambulance-rush-10.png']);
            
        // }

        // foreach ($dataHospital as $key => $value) {
            
        //     Mapper::informationWindow($value->lat, $value->lang, '<b>'.$value->nama.'</b><br />'.$value->alamat.'<br />'.$value->telp.'<br />'.$value->desc, ['icon' => 'https://cdn2.iconfinder.com/data/icons/fatcow/32x32/hospital.png']);
            
        // }

        $data = array(
            'dataAed' => $dataAed,
            'dataAmbulance' => $dataAmbulance,
            'dataHospital' => $dataHospital,
        );

        return view('backend.maps.maps')->with($data);
    }

}
