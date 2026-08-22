<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RendezVous;

class RendezVousController extends Controller
{
    /**
     * عرض جميع المواعيد.
     */
    public function index()
    {
        $rendezVous = RendezVous::with([
            'user',
            'creneau',
        ])
        ->latest()
        ->get();

        return view(
            'admin.rendezvous.index',
            compact('rendezVous')
        );
    }

    /**
     * تأكيد موعد.
     */
    public function confirmer(RendezVous $rendezVous)
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
     * إلغاء موعد.
     */
    public function annuler(RendezVous $rendezVous)
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