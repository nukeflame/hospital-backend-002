<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    public function clients()
    {
        return $this->belongsToMany('App\Client', 'modules_permission', 'module_id', 'client_id')->withTimestamps();
    }
}
