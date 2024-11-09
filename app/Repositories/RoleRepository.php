<?php
namespace App\Repositories;

use App\Models\Role;

class RoleRepository
{
    public function getOrCreateRole($roleId): Role
    {
        return Role::firstOrCreate(['id' => $roleId]);
    }
}
