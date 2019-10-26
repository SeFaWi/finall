<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    protected $fillable = ['item_id','path'];
            public function  items(){
                return $this->belongsTo('App\Item');
            }
}
