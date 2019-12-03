<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = [
        'id_pengaduan', 'pesan',  'id_user', 'id_role'
    ];
}
