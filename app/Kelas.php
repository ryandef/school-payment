<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    public function jurusan() {
        return $this->belongsTo('App\Jurusan');
    }

    public function siswa() {
        return $this->hasMany('App\Siswa');
    }

    public function getNama() {
        return $this->tingkat.' '.$this->jurusan->kode.' '.$this->indeks;
    }
}
