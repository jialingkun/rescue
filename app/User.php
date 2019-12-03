<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'id_user';
    protected $fillable = [
        'name', 'email', 'no_hp', 'kode', 'no_hp', 'status', 'tipe', 'token', ' alamat', 'no_darurat', 'pesan', 'latitude', 'longitude', 'photo_path', 'pin_alamat', 'pin_latitude', 'pin_longitude',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function getAuthPassword()
    {
        return $this->kode;
    }
}
