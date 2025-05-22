<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nisn' => $this->nisn,
            'user' => new UserResource($this->whenLoaded('user')),
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
