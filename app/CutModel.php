<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CutModel extends Model
{
    public $timestamps = false;
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $hidden = ['deleted_at'];
//    protected $hidden = ['id', 'material_id', 'material_type_id', 'deleted_at'];

    public function material() {
        return $this->hasOne(Material::class,'id', 'material_id');
    }

    public function materialType() {
        return $this->hasOne(MaterialType::class, 'id','material_type_id');
    }
}
