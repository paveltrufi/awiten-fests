<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Festival extends Model
{
    public function artists() {
        return $this->belongsToMany('App\Artist');
    }

    public function genres() {
        return $this->belongsToMany('App\Genre');
    }
}
