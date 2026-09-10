<?php

namespace App\Http\Controllers;

use App\Models\Membre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * CRUD complet de gestion des membres de l'association.
 */
class MembreController extends Controller
{
    public function index(Request $request): View
    {
        $membres = Membre::query()
            ->recherche($request->query('q'))
            ->when($request->filled('statut'), fn ($q) => $q->where('statut', $request->query('statut')))
            ->orderBy('nom')
            ->paginate(10)
            ->withQueryString();

        return view('membres.index', [
            'membres' => $membres,
            'q' => $request->query('q'),
            'statut' => $request->query('statut'),
        ]);
    }

    public function create(): View
    {
        return view('membres.create', [
            'matricule' => Membre::genererMatricule(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $donnees = $this->validerDonnees($request);
        $donnees['matricule'] = Membre::genererMatricule();

        Membre::create($donnees);

        return redirect()->route('membres.index')
            ->with('success', 'Le membre a été ajouté avec succès.');
    }

    public function show(Membre $membre): View
    {
        $membre->load(['cotisations' => fn ($q) => $q->orderByDesc('date_paiement')]);

        return view('membres.show', [
            'membre' => $membre,
            'estAJour' => $membre->estAJour(),
            'totalPaye' => $membre->cotisations->sum('montant'),
        ]);
    }

    public function carte(Request $request): View
    {
        $filtre = $request->query('filtre', 'tous');

        $membres = Membre::query()
            ->when($filtre === 'avec', fn ($q) => $q->where('carte', true))
            ->when($filtre === 'sans', fn ($q) => $q->where('carte', false))
            ->orderBy('nom')
            ->get();

        return view('membres.carte', [
            'membres' => $membres,
            'filtre' => $filtre,
        ]);
    }

    public function edit(Membre $membre): View
    {
        return view('membres.edit', compact('membre'));
    }

    public function update(Request $request, Membre $membre): RedirectResponse
    {
        $donnees = $this->validerDonnees($request, $membre->id);

        $membre->update($donnees);

        return redirect()->route('membres.index')
            ->with('success', 'Les informations du membre ont été mises à jour.');
    }

    public function destroy(Membre $membre): RedirectResponse
    {
        $membre->delete();

        return redirect()->route('membres.index')
            ->with('success', 'Le membre a été supprimé.');
    }

    private function validerDonnees(Request $request, ?int $membreId = null): array
    {
        return $request->validate([
            'nom' => ['required', 'string', 'max:100'],
            'prenom' => ['required', 'string', 'max:100'],
            'telephone' => ['nullable', 'string', 'max:30'],
            'date_adhesion' => ['required', 'date'],
            'statut' => ['required', 'in:actif,inactif'],
            'carte' => ['required', 'boolean'],
        ], [
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'date_adhesion.required' => "La date d'adhésion est obligatoire.",
            'statut.required' => 'Le statut est obligatoire.',
            'carte.required' => 'Le statut de la carte est obligatoire.',
            'carte.boolean' => 'Le statut de la carte est invalide.',
        ]);
    }
}
