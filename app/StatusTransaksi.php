<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusTransaksi extends Model
{
    protected $fillable = [
        'id_stransaksi', 'keterangan', 
    ];
}
