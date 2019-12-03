<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionHelper extends Model
{
    protected $fillable = [
        'transaction_id','user_id' 
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaction()
    {
        return $this->belongsTo('App\Transaksi', 'transaction_id', 'id_transaksi');
    }

}
