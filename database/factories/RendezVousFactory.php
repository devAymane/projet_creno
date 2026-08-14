<?php

namespace Database\Factories;

use App\Models\Creneau;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\RendezVous>
 */
class RendezVousFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'creneau_id' => Creneau::factory(),
            'statut' => 'en_attente',
        ];
    }
}