<?php

namespace App\Http\Resources\User;

use App\Role;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Staff;
use App\Hospital;
use App\Http\Resources\Module\ModuleCollection;
use App\Http\Resources\Hospital\Hospital as HospitalResource;
use  App\Http\Resources\Staff\Staff as StaffResource;
use App\Http\Resources\Role\RoleCollection;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $hospital = Hospital::where('client_id', $this->staff->client_id)->first();
        $perms = Role::find(1)->permissions;

        return [
            'id' => $this->id,
            'hospId' => $hospital->id,
            'staff' => new StaffResource($this->staff),
            'uniqId' => $this->uniqId,
            'idNo' => $this->id_no,
            'username' => $this->username,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'notf' => $this->notifications,
            'accessLevel' => $this->acc_level,
            'isActive' => $this->is_active,
            'roles' => $this->roles,
            'hospital' => new HospitalResource($hospital),
            'hospBranchId' => $this->staff->branch_id,
            'roomId' => $this->staff->department_id,
            'userModules' => $perms,
            'signInRoom' => [],
            'createdAt' => $this->created_at,
        ];
    }
}
