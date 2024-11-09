<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Client;
use App\Models\Role;

class ClientRepository
{
    public function createUser(array $data): User
    {
        return User::create($data);
    }

    public function createClient(array $data): Client
    {
        return Client::create($data);
    }

    public function findOrCreateRole(string $libelle): Role
    {
        return Role::firstOrCreate(['libelle' => $libelle]);
    }
}
