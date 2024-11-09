<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;
use App\Models\User;
use App\Models\Role;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'role_id' => Role::inRandomOrder()->first()->id,
            'surname' => $this->faker->lastName,
        ];
    }
}
