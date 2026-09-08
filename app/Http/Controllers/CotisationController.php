<?php

namespace App\Http\Controllers;

use App\Models\Cotisation;
use App\Models\Membre;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Gère l'enregistrement des paiements de cotisation et la génération des reçus.
 */
class CotisationController extends Controller
{
    public function index(Request $request): View
    {
        $cotisations = Cotisation::with('membre')
            ->when($request->filled('mois'), fn ($q) => $q->where('mois', $request->query('mois')))
            ->when($request->filled('annee'), fn ($q) => $q->where('annee', $request->query('annee')))
            ->orderByDesc('date_paiement')
            ->paginate(10)
            ->withQueryString();

        return view('cotisations.index', [
            'cotisations' => $cotisations,
            'filtres' => $request->only(['mois', 'annee']),
        ]);
    }

    public function create(Request $request): View
    {
        return view('cotisations.create', [
            'membres' => Membre::orderBy('nom')->get(),
            'membreSelectionne' => $request->integer('membre_id'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $donnees = $request->validate([
            'membre_id' => ['required', 'exists:membres,id'],
            'montant' => ['required', 'numeric', 'min:1'],
            'mois' => ['required', 'integer', 'between:1,12'],
            'annee' => ['required', 'integer', 'digits:4'],
            'date_paiement' => ['required', 'date'],
        ], [
            'membre_id.required' => 'Veuillez sélectionner un membre.',
            'montant.required' => 'Le montant est obligatoire.',
            'montant.min' => 'Le montant doit être supérieur à zéro.',
            'mois.required' => 'Le mois de la période est obligatoire.',
            'annee.required' => "L'année de la période est obligatoire.",
            'date_paiement.required' => 'La date de paiement est obligatoire.',
        ]);

        $dejaPaye = Cotisation::where('membre_id', $donnees['membre_id'])
            ->where('mois', $donnees['mois'])
            ->where('annee', $donnees['annee'])
            ->exists();

        if ($dejaPaye) {
            return back()->withInput()
                ->with('error', 'Ce membre a déjà réglé sa cotisation pour cette période.');
        }

        $donnees['reference'] = Cotisation::genererReference();

        Cotisation::create($donnees);

        return redirect()->route('cotisations.index')
            ->with('success', 'Le paiement a été enregistré avec succès.');
    }

    public function edit(Cotisation $cotisation): View
    {
        return view('cotisations.edit', [
            'cotisation' => $cotisation,
            'membres' => Membre::orderBy('nom')->get(),
        ]);
    }

    public function update(Request $request, Cotisation $cotisation): RedirectResponse
    {
        $donnees = $request->validate([
            'montant' => ['required', 'numeric', 'min:1'],
            'date_paiement' => ['required', 'date'],
        ]);

        $cotisation->update($donnees);

        return redirect()->route('cotisations.index')
            ->with('success', 'Le paiement a été mis à jour.');
    }

    public function destroy(Cotisation $cotisation): RedirectResponse
    {
        $cotisation->delete();

        return redirect()->route('cotisations.index')
            ->with('success', 'Le paiement a été supprimé.');
    }

    /**
     * Génère le reçu PDF d'un paiement de cotisation.
     */
    public function recu(Cotisation $cotisation): Response
    {
        $cotisation->load('membre');

        $pdf = Pdf::loadView('pdf.recu', ['cotisation' => $cotisation])
            ->setPaper('a5', 'portrait');

        return $pdf->stream('recu-'.$cotisation->reference.'.pdf');
    }
}
