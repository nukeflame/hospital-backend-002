<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Broadcasting\PrivateChannel;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */

    public function receivesBroadcastNotificationsOn()
    {
        return 'users.' . $this->id;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the patient record associated with the user.
     */
    public function patient()
    {
        return $this->hasOne('App\Patient');
    }

    public function staff()
    {
        return $this->hasOne('App\Staff');
    }

    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role', 'user_roles');
    }

    /**
     * The hospitals that belong to the user.
     */
    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }
    
    /**
     * The branches that belong to the user.
     */
    public function branch()
    {
        return $this->belongsTo('App\HospitalBranch');
    }

    /**
    * The room_status that belong to the user.
    */
    public function room_status()
    {
        return $this->hasMany('App\RoomStatus');
    }

    public function customizes()
    {
        return $this->belongsToMany('App\CustomizeSetting', 'user_customizes', 'user_id', 'customize_id');
    }
}
