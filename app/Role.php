<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany('App\PermCategory', 'roles_permissions')->withPivot('hosp_branch_id', 'can_view', 'can_create', 'can_edit', 'can_delete')->withTimestamps();
    }

    public function hospitals()
    {
        return $this->belongsToMany('App\Hospital', 'hospital_roles');
    }
}
