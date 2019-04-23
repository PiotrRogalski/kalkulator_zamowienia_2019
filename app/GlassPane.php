<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GlassPane extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $hidden = ['id', 'glass_model_id', 'cut_model_id', 'order_id'];

    public function glassModel() {
        return $this->hasOne(GlassModel::class,'id');
    }

    public function cutModel() {
        return $this->hasOne(CutModel::class,'id');
    }
}
