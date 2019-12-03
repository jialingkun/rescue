<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerifController extends Controller
{
    public function verif()
    {
    	return request()->all();
    }


}
