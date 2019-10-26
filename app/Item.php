<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name','Status','description','available','categorie_id','delivery','city_id','user_id','address',
    ];
            public function  user(){
                return $this->belongsTo('App\user');
            }
            public function  cities(){
                return $this->belongsTo('App\cities','city_id');
            }
            public function  categorie(){
                return $this->belongsTo('App\Categories');
            }
            public function  images(){
                return $this->hasMany('App\image');
            }
    public function imageFrist() {
        return $this->hasOne('App\image')->latest();
    }

}
