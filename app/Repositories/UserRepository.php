<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function createUser(array $data): User
    {
        // Vérification des clés requises dans $data avant de créer l'utilisateur
        if (!isset($data['telephone'], $data['email'], $data['password'], $data['cni'], $data['date_naissance'], $data['nom'], $data['prenom'])) {
            throw new \InvalidArgumentException('Les clés nécessaires sont manquantes dans les données utilisateur.');
        }

        return User::create([
            'telephone' => $data['telephone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'cni' => $data['cni'],
            'date_naissance' => $data['date_naissance'],
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
        ]);
    }
}

