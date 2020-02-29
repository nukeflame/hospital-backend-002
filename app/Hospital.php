<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospital extends Model
{
    use softDeletes;
    
    /**
     * Get the hospital that owns the branches.
     */
    public function branches()
    {
        return $this->hasMany('App\HospitalBranch');
    }

    /**
     * Get the hospital that belongs the user.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * Get the client that owns the hospital.
     */
    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    /**
     * Get the client that owns the hospital.
     */
    
    public function staffs()
    {
        return $this->hasMany('App\Staff');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'hospital_roles')->withTimestamps();
    }
}
