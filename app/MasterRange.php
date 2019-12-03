<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterRange extends Model
{
    protected $fillable = [
        'start', 'end'
    ];
}
