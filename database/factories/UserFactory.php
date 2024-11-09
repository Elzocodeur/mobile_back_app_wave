<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'telephone' => $this->faker->randomElement(['77', '76', '78', '75']) . $this->faker->numerify('#######'),
            'password' => bcrypt('1111'), // mot de passe par défaut
            'email' => $this->faker->unique()->safeEmail(),
            'cni' => $this->faker->unique()->numerify('###########'),
            'date_naissance' => $this->faker->date(),
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'qrcode' => Str::random(10),
            'statut_compte' => $this->faker->randomElement(['actif', 'inactif']),
        ];
    }
}
