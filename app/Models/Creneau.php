<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Creneau extends Model
{
    use HasFactory;

    protected $table = 'creneaux';

    protected $fillable = [
        'date',
        'heure_debut',
        'duree',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    public function rendezVous(): HasOne
    {
        return $this->hasOne(RendezVous::class);
    }
}