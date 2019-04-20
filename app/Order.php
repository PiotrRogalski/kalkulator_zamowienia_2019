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
}
