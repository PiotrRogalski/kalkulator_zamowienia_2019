<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hole extends Model
{
    public $timestamps = false;
    use SoftDeletes;
}
