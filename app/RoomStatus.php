<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomStatus extends Model
{
    protected $table = 'room_status';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function department()
    {
        return $this->belongsTo('App\Department', 'room_id');
    }

    public function branch()
    {
        return $this->belongsTo('App\HospitalBranch', 'branch_id');
    }
}
