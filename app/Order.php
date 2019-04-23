<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $hidden = ['id', 'client_id'];

    public function clients() {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function glassPanes() {
        return $this->hasMany(GlassPane::class);
    }

    public function scopeWithGlassPanes($query)
    {
        $query->with([
            'glassPanes',
            'glassPanes.cutModel',
            'glassPanes.cutModel.material',
            'glassPanes.cutModel.materialType',
            'glassPanes.glassModel',
            'glassPanes.glassModel.material',
            'glassPanes.glassModel.materialType',
            'glassPanes.holes',
            'glassPanes.services',
            'glassPanes.additionalService',
        ]);
    }
}
