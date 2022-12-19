<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'id' => $this->id,
            'course_name' => $this->course_name,
            'course_code' => $this->course_code,
            'department_code' => $this->department_code,
            'credit_hours' => $this->credit_hours,
            'semester' => $this->pivot->semester,
        ];
    }
}
