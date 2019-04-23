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

    public function holes() {
        return $this->hasMany(Hole::class, 'glass_pane_id');
    }

    public function services() {
        return $this->hasMany(Service::class, 'glass_pane_id');
    }

    public function additionalService() {
        return $this->hasMany(AdditionalService::class, 'glass_pane_id');
    }
}
