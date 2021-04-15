<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name'           =>  $this->name,
            'userId'         =>  $this->id,
            'email'          =>  $this->email,
            'gender'         =>  !empty($this->gender_id) ? (int)$this->gender_id  : 1,
            'date_of_birth'  => $this->date_of_birth
        ];
    }
}
