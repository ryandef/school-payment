<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFirstChar(){
        return strtoupper(substr($this->name, 0, 1));
    }

    public function getType() {
        if($this->type == 1) {
            return "Kepala Sekolah";
        } else if($this->type == 2) {
            return "Staff Tata Usaha";
        } else if($this->type == 3) {
            return "Staff Administrasi";
        } else if($this->type == 4) {
            return "Siswa";
        }
    }

    public function siswa() {
        return $this->hasOne('App\Siswa');
    }
}
