<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $fillable = [
        'id','nama','alamat','telp','desc', 'lat', 'lang' 
    ];
}
