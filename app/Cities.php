<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    protected $fillable = [ 'name',];
    protected $visible = ['name', 'id'];

}
