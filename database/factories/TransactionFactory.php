<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Transaction;
use App\Models\User;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition()
    {
        $sender = User::inRandomOrder()->first();
        $receiver = User::inRandomOrder()->where('id', '!=', $sender->id)->first();

        return [
            'montant_envoyer' => $this->faker->randomFloat(2, 100, 1000),
            'montant_recu' => $this->faker->randomFloat(2, 95, 995), // exemple avec un petit frais déduit
            'type_transaction' => $this->faker->randomElement(['depot', 'retrait']),
            'statut' => $this->faker->randomElement(['effectué', 'annulé']),
            'sender_id' => $sender->id,
            'recever_id' => $receiver->id,
        ];
    }
}
