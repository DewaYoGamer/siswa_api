<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $user = new UserResource($this->whenLoaded('user'));
        return [
            'id' => $this->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => $user->address,
            'gender' => $user->gender,
            'religion' => $user->religion,
            'birth_date' => $user->birth_date,
            'active' => $user->active,
            'nisn' => $this->nisn,
            'grade' => $this->grade,
            'parent_name' => $this->parent_name,
            'parent_phone' => $this->parent_phone,
            'schedules' => $this->schedules->map(function ($schedule) {
                return [
                    'id' => $schedule->id,
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                    'classroom' => $schedule->classroom,
                    'subject' => $schedule->subject,
                    'teacher' => $schedule->teacher,
                ];
            }),
        ];
    }
}
