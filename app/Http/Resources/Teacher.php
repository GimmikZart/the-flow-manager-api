<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Teacher extends JsonResource
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
            'avatar'        => $this->avatar,
            'name'          => $this->name,
            'lastname'      => $this->lastname,
            'gender'        => $this->gender,
            'dateOfBirth'   => $this->dateOfBirth,
            'registered'    => $this->registered,
            'email'         => $this->email,
            'fiscalCode'    => $this->fiscalCode,
            'telephone'     => $this->telephone,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
