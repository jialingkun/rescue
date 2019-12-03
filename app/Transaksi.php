<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
	protected $primaryKey = 'id_transaksi';
    protected $fillable = [

        'id_status', 'id_ambulan', 'id_penolong', 'id_korban', 'latitude', 'longitude', 'lokasi',
         'followup', 'foto', 'waktu_pertolongan_awam', 'waktu_pertolongan_ambulan', 'waktu_selesai','tipe_transaksi', 
        'id_transaksi', 'range_id'

    ];

    public function getCreatedAtAttribute($value)
    {
        return date('d-M-Y H:i:s', strtotime($value));
    }

    public function getFotoAttribute($value)
    {
        return \URL::to('foto/'.$value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ambulanTrx()
    {
        return $this->belongsTo('App\Ambulan', 'id_ambulan', 'id_ambulan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statusTrx()
    {
        return $this->belongsTo('App\StatusTransaksi', 'id_status', 'id_stransaksi');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function korban()
    {
        return $this->belongsTo('App\User', 'id_korban');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function range()
    {
        return $this->belongsTo('App\MasterRange', 'range_id');
    }

}
