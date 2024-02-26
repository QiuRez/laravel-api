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
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'role_string' => $this->when($this->role == 1, function () {
                return 'Администратор';
            }, function () {
                return 'Пользователь';
            }),
            'created_at' => date('Y-m-d', strtotime($this->created_at)),
            'updated_at' => date('Y-m-d', strtotime($this->updated_at)),
        ];
    }
}
