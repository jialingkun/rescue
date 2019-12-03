<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
   protected $fillable = [
        'id_review', 'id_transaksi', 'id_pengguna', 'review_pengguna', 'rating_pengguna', 'id_ambulan', 'review_ambulan', 'rating_ambulan', 
    ];
}
