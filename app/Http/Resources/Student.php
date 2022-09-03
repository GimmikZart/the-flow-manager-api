<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Student extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'lastname'      => $this->lastname,
            'gender'        => $this->gender,
            'dateOfBirth'   => $this->dateOfBirth,
            'registered'    => $this->registered,
            'avatar'        => $this->avatar,
            'email'         => $this->email,
            'telephone'     => $this->telephone,
            'paid'          => $this->paid,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
