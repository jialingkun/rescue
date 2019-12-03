<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ambulan extends Model
{
    protected $fillable = [
        'id_ambulan','username','id_role','kode','token', 'no_pol_ambulan', 'alamat_rs', 'no_telp_rs', 'nama_rs','FCMToken' 
    ];
}
