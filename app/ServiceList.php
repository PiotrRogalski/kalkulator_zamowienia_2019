<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceList extends Model
{
    public $timestamps = false;
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $hidden = ['deleted_at'];
}
