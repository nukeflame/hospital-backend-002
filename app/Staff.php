<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = "staff";
 
    /**
     * Get the client that owns the hospital.
     */
    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }
}
