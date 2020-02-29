<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermCategory extends Model
{
    protected $table = "permission_categories";

    public function group()
    {
        return $this->belongsTo('App\PermGroup');
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Role', 'roles_permissions')->withPivot('can_view', 'can_add', 'can_edit', 'can_delete')->withTimestamps();
    }
}
