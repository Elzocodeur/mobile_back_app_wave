<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaiementMarchant;

class PaiementMarchantSeeder extends Seeder
{
    public function run(): void
    {
        PaiementMarchant::factory()->count(10)->create(); // Créez 10 paiements marchands
    }
}
