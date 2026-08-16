<?php

namespace App\Http\Controllers;

use App\Models\Creneau;
use App\Models\RendezVous;
use Carbon\Carbon;
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

        // 1. Vérifier si le créneau est déjà réservé
        if ($creneau->rendezVous()->exists()) {
            return back()->with(
                'error',
                'Ce créneau est déjà réservé.'
            );
        }

        // 2. Calculer début et fin du nouveau créneau
        $debut = Carbon::createFromFormat(
            'Y-m-d H:i',
            $creneau->date->format('Y-m-d') . ' ' . $creneau->heure_debut
        );

        $fin = $debut->copy()->addMinutes($creneau->duree);

        // 3. Vérifier que le créneau n'est pas passé
        if ($fin->isPast()) {
            return back()->with(
                'error',
                'Ce créneau est déjà passé.'
            );
        }

        // 4. Récupérer les rendez-vous actifs du client
        $rendezVousExistants = $user->rendezVous()
            ->where('statut', '!=', 'annule')
            ->with('creneau')
            ->get();

        // 5. Vérifier les chevauchements
        foreach ($rendezVousExistants as $rendezVous) {

            $ancienDebut = Carbon::createFromFormat(
                'Y-m-d H:i',
                $rendezVous->creneau->date->format('Y-m-d')
                . ' '
                . $rendezVous->creneau->heure_debut
            );

            $ancienFin = $ancienDebut->copy()
                ->addMinutes($rendezVous->creneau->duree);

            /*
             * Chevauchement si :
             *
             * nouveau début < ancien fin
             * ET
             * nouveau fin > ancien début
             */
            if (
                $debut->lt($ancienFin)
                && $fin->gt($ancienDebut)
            ) {
                return back()->with(
                    'error',
                    'Ce créneau chevauche un de vos rendez-vous.'
                );
            }
        }

        // 6. Créer le rendez-vous
        RendezVous::create([
            'user_id' => $user->id,
            'creneau_id' => $creneau->id,
            'statut' => 'en_attente',
        ]);

        return redirect()
            ->route('rendezvous.index')
            ->with(
                'success',
                'Rendez-vous réservé avec succès.'
            );
    }

    public function destroy(RendezVous $rendezVous)
    {
        // Un client ne peut annuler que son propre rendez-vous
        if ($rendezVous->user_id !== auth()->id()) {
            abort(403);
        }

        $rendezVous->update([
            'statut' => 'annule',
        ]);

        return back()->with(
            'success',
            'Rendez-vous annulé avec succès.'
        );
    }
}