<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HolePrice extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $hidden = ['id'];

}
