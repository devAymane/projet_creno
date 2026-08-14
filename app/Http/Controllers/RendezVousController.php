<?php

namespace App\Http\Controllers;

use App\Models\Creneau;
use App\Models\RendezVous;
use Illuminate\Http\Request;

class RendezVousController extends Controller
{
    public function index()
    {
        $rendezVous = auth()->user()
            ->rendezVous()
            ->with('creneau')
            ->latest()
            ->get();

        return view('rendezvous.index', compact('rendezVous'));
    }

    public function store(Request $request, Creneau $creneau)
    {
        $user = auth()->user();

        if ($creneau->rendezVous) {
            return back()->with('error', 'Ce créneau est déjà réservé.');
        }

        if ($creneau->date->isPast()) {
            return back()->with('error', 'Ce créneau est déjà passé.');
        }

        RendezVous::create([
            'user_id' => $user->id,
            'creneau_id' => $creneau->id,
            'statut' => 'en_attente',
        ]);

        return redirect()
            ->route('rendezvous.index')
            ->with('success', 'Rendez-vous réservé avec succès.');
    }

    public function destroy(RendezVous $rendezVous)
    {
        if ($rendezVous->user_id !== auth()->id()) {
            abort(403);
        }

        $rendezVous->update([
            'statut' => 'annule',
        ]);

        return back()->with('success', 'Rendez-vous annulé avec succès.');
    }
}