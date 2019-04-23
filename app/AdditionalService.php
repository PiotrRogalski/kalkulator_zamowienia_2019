<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdditionalService extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $hidden = ['id', 'glass_pane_id', 'deleted_at'];

    public function glassPane() {
        return $this->belongsTo(GlassPane::class, 'glass_pane_id');
    }

}
