<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            "lat" => $this->lat ,
            "lng" => $this->lng ,
            "city" => $this->city ,
            "street_name" => $this->street_name ,
            "building" => $this->building,
            'floor' => $this->floor,
            'mobile_number' => $this->mobile_number,
            'address_name' => $this->address_name,
            "additional_directions" => $this->additional_directions
        ];
    }
}
