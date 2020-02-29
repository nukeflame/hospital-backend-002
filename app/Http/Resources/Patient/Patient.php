<?php

namespace App\Http\Resources\Patient;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\User as UserResource;
use App\Http\Resources\Staff\Staff as StaffResource;

class Patient extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'otherNames' => $this->othernames,
            'surname' => $this->surname,
            'patientNo' => $this->uniq_id,
            'idNo' => $this->id_no,
            'avatar' => $this->avatar,
            'gender' => $this->sex,
            'age' => $this->age,
            'address' => $this->location,
            'phone' => $this->phone,
            'telephone' => $this->telephone,
            'nationality' => $this->nationality,
            'email' => $this->email,
            'idType' => $this->idType,
            'months' => $this->months,
            'days' => $this->days,
            'years' => $this->years,
            'refNo' => $this->refNo,
            'residence' => $this->residence,
            'town' => $this->town,
            'postalAddress' => $this->postalAddress,
            'relationship' => $this->relationship,
            'emergName' => $this->emergName,
            'emergContacts' => $this->emergContacts,
            'postalCode' => $this->postalCode,
            'streetRoad' => $this->streetRoad,
            'location' => $this->location,
            'entryDate' => $this->adm_date,
            'regUser' => new StaffResource($this->registerdBy),
            'userDetails' => new UserResource($this->user),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            //UserResource
            'value' => $this->surname,
            'name' => $this->surname,
            'fullname' => $this->surname  . " " . $this->othernames,
        ];
    }
}
