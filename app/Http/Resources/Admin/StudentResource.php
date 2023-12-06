<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,

            'photo' => $this->photo,
            'date_of_birth' => $this->date_of_birth,
            'governorate' => $this->governorate,
            'area' => $this->area,
            'residence_area' => $this->residence_area,
            'specialization' => $this->specialization,
            'academic_year_id' => $this->academic_year_id,
            'provider_id' => $this->provider_id,
            'provider_type' => $this->provider_type,
            'device_token' => $this->device_token,
            'academic_year' => $this->whenLoaded('academicYear', new AcademicYearResource($this->academicYear)),

            'hasVerifiedEmail' => $this->hasVerifiedEmail(),
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
