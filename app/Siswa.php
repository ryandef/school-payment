<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    public function kelas() {
        return $this->belongsTo('App\Kelas');
    }

    public function tahun_ajaran() {
        return $this->belongsTo('App\TahunAjaran');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function pembayaran() {
        return $this->hasMany('App\Pembayaran');
    }

    public function log_kelas() {
        return $this->hasMany('App\LogKelas');
    }
}
