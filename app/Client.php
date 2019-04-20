<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $hidden = ['id', 'place_of_delivery_id'];


//    public function task()
//    {
//        return $this->belongsTo(Task::class);
//    }
}
