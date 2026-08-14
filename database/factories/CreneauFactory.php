<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Creneau>
 */
class CreneauFactory extends Factory
{
    public function definition(): array
    {
        return [
            'date' => fake()->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'heure_debut' => fake()->time('H:i'),
            'duree' => 30,
        ];
    }
}