<?php

namespace Database\Seeders;

use App\Models\Creneau;
use Illuminate\Database\Seeder;

class CreneauSeeder extends Seeder
{
    public function run(): void
    {
        Creneau::factory()->count(10)->create();
    }
}