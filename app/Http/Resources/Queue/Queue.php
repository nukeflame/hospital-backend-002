<?php

namespace App\Http\Resources\Queue;

use Illuminate\Http\Resources\Json\JsonResource;

class Queue extends JsonResource
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
            'queueNo' => $this->queue_no,
            'dateIn' => $this->timestamp_in,
            'patientName' => $this->patient_name,
            'fromRoom' => $this->from,
            'toRoom' => $this->to,
            'note' => $this->note,
        ];
    }
}
