<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    public function getImage() {
        $path   = 'img/bank/';
        return url($path . $this->image);
    }
}
