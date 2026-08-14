<?php

namespace App\Http\Controllers;

use App\Models\Creneau;
use Illuminate\Http\Request;

class CreneauController extends Controller
{
    /**
     * Afficher la liste des créneaux.
     */
    public function index()
    {
        $creneaux = Creneau::with('rendezVous')
            ->orderBy('date')
            ->orderBy('heure_debut')
            ->get();

        return view('creneaux.index', compact('creneaux'));
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        return view('creneaux.create');
    }

    /**
     * Enregistrer un nouveau créneau.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => ['required', 'date', 'after_or_equal:today'],
            'heure_debut' => ['required', 'date_format:H:i'],
            'duree' => ['required', 'integer', 'min:15', 'max:480'],
        ]);

        // Vérifier qu'il n'existe pas déjà un créneau
        // à la même date et à la même heure.
        $exists = Creneau::where('date', $validated['date'])
            ->where('heure_debut', $validated['heure_debut'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'heure_debut' => 'Un créneau existe déjà à cette date et cette heure.',
                ]);
        }

        Creneau::create($validated);

        return redirect()
            ->route('creneaux.index')
            ->with('success', 'Créneau créé avec succès.');
    }

    /**
     * Afficher un créneau.
     */
    public function show(Creneau $creneau)
    {
        $creneau->load('rendezVous.user');

        return view('creneaux.show', compact('creneau'));
    }

    /**
     * Afficher le formulaire de modification.
     */
    public function edit(Creneau $creneau)
    {
        return view('creneaux.edit', compact('creneau'));
    }

    /**
     * Modifier un créneau.
     */
    public function update(Request $request, Creneau $creneau)
    {
        $validated = $request->validate([
            'date' => ['required', 'date', 'after_or_equal:today'],
            'heure_debut' => ['required', 'date_format:H:i'],
            'duree' => ['required', 'integer', 'min:15', 'max:480'],
        ]);

        $exists = Creneau::where('date', $validated['date'])
            ->where('heure_debut', $validated['heure_debut'])
            ->where('id', '!=', $creneau->id)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'heure_debut' => 'Un autre créneau existe déjà à cette date et cette heure.',
                ]);
        }

        $creneau->update($validated);

        return redirect()
            ->route('creneaux.index')
            ->with('success', 'Créneau modifié avec succès.');
    }

    /**
     * Supprimer un créneau.
     */
    public function destroy(Creneau $creneau)
    {
        // Ne pas supprimer un créneau déjà réservé.
        if ($creneau->rendezVous) {
            return back()->with('error', 'Impossible de supprimer un créneau déjà réservé.');
        }

        $creneau->delete();

        return redirect()
            ->route('creneaux.index')
            ->with('success', 'Créneau supprimé avec succès.');
    }
}