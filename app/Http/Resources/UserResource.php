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
            'telephone' => $this->telephone,
            'password' => $this->password,
            'cni' => $this->cni,
            'date_naissance' => $this->date_naissance,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'qrcode' => $this->qrcode,
            'statut_compte' => $this->statut_compte
        ];
    }
}
