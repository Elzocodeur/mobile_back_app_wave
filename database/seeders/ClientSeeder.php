<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Role;

class ClientSeeder extends Seeder
{
    public function run()
    {
        // Assurez-vous que les rôles existent d'abord
        $roles = ['client', 'admin', 'distributeur', 'marchand'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['libelle' => $role]);
        }

        Client::factory()->count(10)->create();
    }
}
