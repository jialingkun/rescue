<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aed extends Model
{
    protected $fillable = [
        'id','nama','alamat','desc', 'lat', 'lang' 
    ];
}
