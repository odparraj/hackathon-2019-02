<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationJsonResource extends JsonResource
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
            "id" => $this->id,
            "amount" => $this->amount,
            "total_paid" => $this->total_paid,
            "due_date" => $this->due_date,
            "mora" =>  $this->mora,
            "status" => new Status($this->status)
        ];
    }
}
