<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodeBlue extends Model
{
    //

    protected $fillable = [
        'email', 'longitude', 'latitude', 'lokasi', 'foto', 'ambulan', 
    ];
}
