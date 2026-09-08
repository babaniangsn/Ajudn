<?php

namespace App\Http\Controllers;

use App\Models\Cotisation;
use App\Models\Membre;
use Illuminate\View\View;

/**
 * Affiche le tableau de bord avec les statistiques clés de l'association.
 */
class DashboardController extends Controller
{
    public function index(): View
    {
        $totalMembres = Membre::count();

        $membresAJour = Membre::actifs()
            ->whereHas('cotisations', function ($q) {
                $q->where('mois', now()->month)->where('annee', now()->year);
            })->count();

        $membresActifs = Membre::actifs()->count();
        $membresEnRetard = max($membresActifs - $membresAJour, 0);

        $membresNonInscrits = Membre::actifs()
            ->whereDoesntHave('cotisations', function ($q) {
                $q->where('mois', now()->month)->where('annee', now()->year);
            })
            ->orderBy('nom')
            ->get();

        $totalCotisations = (float) Cotisation::sum('montant');

        $dernieresCotisations = Cotisation::with('membre')
            ->latest('date_paiement')
            ->take(8)
            ->get();

        return view('dashboard.index', [
            'totalMembres' => $totalMembres,
            'membresAJour' => $membresAJour,
            'membresEnRetard' => $membresEnRetard,
            'membresNonInscrits' => $membresNonInscrits,
            'totalCotisations' => $totalCotisations,
            'dernieresCotisations' => $dernieresCotisations,
        ]);
    }
}
