<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GlassModel extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $hidden = ['id', 'material_id', 'material_type_id'];

}
