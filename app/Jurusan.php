<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    public function kelas() {
        return $this->hasMany('App\Kelas');
    }
}
