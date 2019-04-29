<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $hidden = [ 'deleted_at'];
//    protected $hidden = ['id', 'deleted_at'];

}
