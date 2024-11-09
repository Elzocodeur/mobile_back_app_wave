<?php

namespace App\Http\Resources;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'surname' => $this->surname,
            'user_id' => $this->user_id,
            'role_id' => $this->role_id,
            'user'=>when($this->user_id, function () {
                return new UserResource($this->user);
            }),
            'role'=>$this->when($this->role_id, function () {
                return new RoleResource($this->role);
            })

        ];
    }
}
