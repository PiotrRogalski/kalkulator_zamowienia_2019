<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
//    protected $hidden = ['id', 'place_of_delivery_id'];

    public function placeOfDelivery() {
        return $this->hasOne(PlaceOfDelivery::class, 'id','place_of_delivery_id');
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
