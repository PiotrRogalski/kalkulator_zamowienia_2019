<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CutModel extends Model
{
    public $timestamps = false;
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $hidden = ['id', 'material_id', 'material_type_id'];

}
