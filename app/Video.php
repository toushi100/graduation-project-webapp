<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

   
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function objects(){
        return $this->hasMany('App\Objects');
    }

   
}