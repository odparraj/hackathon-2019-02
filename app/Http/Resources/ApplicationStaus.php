<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationStaus extends JsonResource
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

            "first_name" => $this->first_name,
            "middle_name" => $this->middle_name,
            "last_name" => $this->last_name,
            "second_last_name" => $this->second_last_name,
            "email" => $this->email,
            "cellphone" => $this->cellphone,
            "max_amount" => $this->max_amount,

            "applications" => ApplicationJsonResource::collection($this->applications)
        ];
    }
}
