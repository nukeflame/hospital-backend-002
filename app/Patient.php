<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use SoftDeletes;

    /**
     * Get the user that owns the patient.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function registerdBy()
    {
        return $this->belongsTo('App\Staff','reg_by');
    }

    public function town()
    {
        return $this->belongsTo('App\Town');
    }

    public function opd()
    {
        return $this->hasOne('App\OPD');
    }

    public function ipd()
    {
        return $this->hasOne('App\IPD');
    }

   public function queues()
   {
       return $this->hasMany('App\Queue');
   }
}
