<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IPD extends Model
{
    protected $table = "ipd_details";
    
    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }
}
