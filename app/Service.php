<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $hidden = ['id', 'glass_pane_id', 'service_list_id'];

    public function glassPane() {
        return $this->belongsTo(GlassPane::class, 'glass_pane_id');
    }
    public function serviceList() {
        return $this->hasOne(ServiceList::class, 'id');
    }

}
