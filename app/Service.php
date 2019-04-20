<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    public $timestamps = false;
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $hidden = ['id', 'glass_pane_id'];

}
