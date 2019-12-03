<?php

namespace App\Http\Controllers;
use App\MasterRange;

use Illuminate\Http\Request;

class MasterRangeController extends Controller
{

    public function index()
    {
        $data = MasterRange::all();
        $response = array(
            'data' => $data
        );
        return \Response::json($response);
    }
}
