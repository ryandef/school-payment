<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PembayaranDetail extends Model
{
    public function pembayaran() {
        return $this->belongsTo('App\Pembayaran');
    }
}
