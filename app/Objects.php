<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Objects extends Model
{
    

    public function searchableAs()
    {
        return 'frame';
    }
    public $timestamps = false;

    public function videoObject(){
        return $this->belongsTo('App\Video');
    }
}
