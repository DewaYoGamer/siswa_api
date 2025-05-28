<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'birth_date' => $this->birth_date,
            'religion' => $this->religion,
            'address' => $this->address,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'active' => $this->active
        ];
    }
}
