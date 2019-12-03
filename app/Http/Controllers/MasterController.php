<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hospital;
use App\Aed;
use App\Ambulan;
use App\Service\DataTableService;

class MasterController extends Controller
{
    
    protected $dataTableService;
    public function __construct(DataTableService $dataTableService)
    {
        $this->dataTableService     = $dataTableService;
    }

    public function listHospital()
    {
        return view('backend.master.hospital.list');
    }

    public function dataHospital()
    {
        $hospital = Hospital::all();
        return $this->dataTableService->generate($hospital, 'nodetail');
    }

    public function detailHospital($id)
    {
        $hospital = Hospital::where('id', $id)->first();
        return response()->json($hospital);
    }

    public function addHospital(Request $request)
    {
        $req = $request->except('id','_method','_token');
        $data = Hospital::create($req);
        return response()->json($data);
    }

    public function updateHospital(Request $request, $id)
    {
        $req = $request->except('id','_method','_token');
        $data = Hospital::where('id', $id)->update($req);
        return response()->json($data);
    }
    
    public function deleteHospital(Request $request, $id){
        $data = Hospital::where('id',$id)->delete();
        return response()->json($data);
    }

    public function listAed()
    {
        return view('backend.master.aed.list');
    }

    public function dataAed()
    {
        $aed = Aed::all();
        return $this->dataTableService->generate($aed, 'nodetail');
    }

    public function detailAed($id)
    {
        $aed = Aed::where('id', $id)->first();
        return response()->json($aed);
    }

    public function addAed(Request $request)
    {
        $req = $request->except('id','_method','_token');
        $data = Aed::create($req);
        return response()->json($data);
    }

    public function updateAed(Request $request, $id)
    {
        $req = $request->except('id','_method','_token');
        $data = Aed::where('id', $id)->update($req);
        return response()->json($data);
    }
    
    public function deleteAed(Request $request, $id){
        $data = Aed::where('id',$id)->delete();
        return response()->json($data);
    }

    public function masterHospital()
    {
        $data = Hospital::all();
        $response = array(
            'data' => $data
        );
        return \Response::json($response);
    }

    public function masterAED()
    {
        $data = Aed::all();
        $response = array(
            'data' => $data
        );
        return \Response::json($response);
    }

    public function masterAmbulan()
    {
        $data = Ambulan::all();
        $response = array(
            'data' => $data
        );
        return \Response::json($response);
    }

}
