<?php

namespace Database\Seeders;

use App\Models\Creneau;
use App\Models\RendezVous;
use App\Models\User;
use Illuminate\Database\Seeder;

class RendezVousSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Client Test',
            'email' => 'client@test.com',
            'role' => 'client',
        ]);

        Creneau::factory()
            ->count(5)
            ->create()
            ->each(function (Creneau $creneau) use ($user) {
                RendezVous::create([
                    'user_id' => $user->id,
                    'creneau_id' => $creneau->id,
                    'statut' => 'en_attente',
                ]);
            });
    }
}