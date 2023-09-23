<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'job_title' => $this->job_title,
            'email' => $this->email,
            'mobile_no' => $this->mobile_no,
            'hourly_rate' => $this->hourly_rate,
            'currency' => $this->currency,
        ];
    }
}
