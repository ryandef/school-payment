<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    public function getFile() {
        $path   = 'img/bukti/';
        return url($path . $this->bukti);
    }

    public function bank() {
        return $this->belongsTo('App\Bank');
    }

    public function siswa() {
        return $this->belongsTo('App\Siswa');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function tahun_ajaran() {
        return $this->belongsTo('App\TahunAjaran');
    }

    public function kelas() {
        return $this->belongsTo('App\Kelas');
    }

    public function detail() {
        return $this->hasMany('App\PembayaranDetail');
    }

    public function getStatus() {
        if($this->status == 0) {
            if($this->bukti == null) {
                return "<span class='badge badge-primary'>Pending</span>";
            } else {
                return "<span class='badge badge-warning'>Menunggu Verifikasi</span>";
            }

        } else if($this->status == 1) {
            return "<span class='badge badge-success'>Lunas</span>";
        } else if($this->status == -1) {
            if($this->bukti == null) {
                return "<span class='badge badge-danger'>Expired</span>";
            } else {
                return "<span class='badge badge-danger'>Ditolak</span>";
            }

        }
    }
}
