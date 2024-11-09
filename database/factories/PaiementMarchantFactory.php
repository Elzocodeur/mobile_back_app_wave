<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\PaiementMarchant;

class PaiementMarchantFactory extends Factory
{
    protected $model = PaiementMarchant::class;

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'marchand_id' => User::inRandomOrder()->first()->id,
            'montant' => $this->faker->randomFloat(2, 10, 1000), // Montant aléatoire entre 10 et 1000
        ];
    }
}
