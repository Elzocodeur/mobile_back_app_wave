<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Role;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition()
    {
        return [
            'libelle' => $this->faker->randomElement(['client', 'admin', 'distributeur', 'marchand']),
        ];
    }
}
