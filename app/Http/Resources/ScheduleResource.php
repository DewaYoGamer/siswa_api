<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'classroom_id' => new ClassroomResource($this->whenLoaded('classroom')),
            'subject' => new SubjectResource($this->whenLoaded('subject')),
            'teacher' => new TeacherResource($this->whenLoaded('teacher')),
            'students' => $this->students->map(function ($student) {
                return [
                    'id' => $student->id,
                    'nisn' => $student->nisn,
                    'user' => [
                        'name' => $student->user->name,
                        'email' => $student->user->email,
                        'role' => $student->user->role,
                    ]
                ];
            }),
        ];
    }
}
