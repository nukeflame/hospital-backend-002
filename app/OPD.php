<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OPD extends Model
{
    protected $table = "opd_details";
    
    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }
}
