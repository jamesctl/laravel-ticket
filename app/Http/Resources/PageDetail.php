<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PageDetail extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'page_detail_id' => $this->id,
            'page_detail_section' => $this->section,
            'page_detail_key' => $this->pd_key,
            'page_detail_value' => $this->pd_value,
        ];
    }
}
