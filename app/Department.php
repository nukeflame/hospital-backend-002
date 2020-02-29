<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function staff()
    {
        return $this->hasMany('App\Staff');
    }

    public function room_status()
    {
        return $this->hasMany('App\RoomStatus', 'room_id');
    }
}
