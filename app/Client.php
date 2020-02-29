<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
    
    /**
     * Get the hospitals that belongs to a client.
     */
    public function hospitals()
    {
        return $this->hasMany('App\Hospital');
    }

    /**
     * Get the staff that belongs to a client.
     */
    public function sfaffs()
    {
        return $this->hasMany('App\Staff', 'client_id', 'id');
    }

    public function modules()
    {
        return $this->belongsToMany('App\Module', 'modules_permission', 'client_id', 'module_id')->withTimestamps();
    }
}
