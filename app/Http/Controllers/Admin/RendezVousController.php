<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RendezVous;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RendezVousController extends Controller
{
    /**
     * Afficher tous les rendez-vous.
     */
    public function index(): View
    {
        $rendezVous = RendezVous::with(['user', 'creneau'])
            ->latest()
            ->get();

        return view('admin.rendezvous.index', compact('rendezVous'));
    }

    /**
     * Confirmer un rendez-vous.
     */
    public function confirmer(RendezVous $rendezVous): RedirectResponse
    {
        $rendezVous->update([
            'statut' => 'confirme',
        ]);

        return back()->with(
            'success',
            'Rendez-vous confirmé avec succès.'
        );
    }

    /**
     * Annuler un rendez-vous.
     */
    public function annuler(RendezVous $rendezVous): RedirectResponse
    {
        $rendezVous->update([
            'statut' => 'annule',
        ]);

        return back()->with(
            'success',
            'Rendez-vous annulé avec succès.'
        );
    }
}