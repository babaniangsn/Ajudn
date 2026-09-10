@extends('layouts.app')

@section('titre', 'Tableau de bord')

@section('contenu')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-speedometer2 text-primary me-2"></i>
            Tableau de bord
        </h2>
        <small class="text-muted">
            {{ now()->translatedFormat('l d F Y') }}
        </small>
    </div>
</div>

{{-- Statistiques --}}
<div class="row g-4 mb-4">

    <div class="col-md-6 col-xl-3">
        <div class="stat-card bg-grad-blue">
            <i class="bi bi-people-fill stat-icon"></i>

            <div class="stat-label">
                Total des membres
            </div>

            <div class="stat-valeur">
                {{ number_format($totalMembres) }}
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="stat-card bg-grad-green">
            <i class="bi bi-check-circle-fill stat-icon"></i>

            <div class="stat-label">
                Membres à jour
            </div>

            <div class="stat-valeur">
                {{ number_format($membresAJour) }}
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="stat-card bg-grad-orange">
            <i class="bi bi-exclamation-triangle-fill stat-icon"></i>

            <div class="stat-label">
                En retard
            </div>

            <div class="stat-valeur">
                {{ number_format($membresEnRetard) }}
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="stat-card bg-grad-purple">
            <i class="bi bi-cash-stack stat-icon"></i>

            <div class="stat-label">
                Total encaissé
            </div>

            <div class="stat-valeur">
                {{ number_format($totalCotisations,0,',',' ') }}
            </div>

            <small>FCFA</small>
        </div>
    </div>

</div>

{{-- Derniers paiements --}}
<div class="card shadow-sm border-0 mb-4">

    <div class="card-header bg-white d-flex justify-content-between align-items-center">

        <h5 class="mb-0">
            <i class="bi bi-clock-history me-2"></i>
            Derniers paiements
        </h5>

        <a href="{{ route('cotisations.index') }}"
           class="btn btn-sm btn-primary">

            <i class="bi bi-list-ul me-1"></i>
            Voir tout

        </a>

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">

                <tr>
                    <th>Membre</th>
                    <th>Période</th>
                    <th>Montant</th>
                    <th>Date</th>
                </tr>

            </thead>

            <tbody>

                @forelse($dernieresCotisations as $cotisation)

                    <tr>

                        <td>
                            {{ $cotisation->membre?->nom_complet ?? '-' }}
                        </td>

                        <td>
                            {{ $cotisation->periode_libelle }}
                        </td>

                        <td class="fw-semibold text-success">
                            {{ number_format($cotisation->montant,0,',',' ') }} FCFA
                        </td>

                        <td>
                            {{ optional($cotisation->date_paiement)->format('d/m/Y') }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="4" class="text-center text-muted py-5">

                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>

                            Aucun paiement enregistré.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

{{-- Membres non à jour --}}
<div class="card shadow-sm border-0">

    <div class="card-header bg-white d-flex justify-content-between align-items-center">

        <h5 class="mb-0">

            <i class="bi bi-person-x-fill me-2"></i>

            Membres sans cotisation ({{ now()->translatedFormat('F Y') }})

        </h5>

        <span class="badge bg-warning text-dark fs-6">

            {{ $membresNonInscrits->count() }}

        </span>

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">

                <tr>

                    <th>Nom complet</th>
                    <th>Téléphone</th>
                    <th>Statut</th>
                    <th class="text-end">Action</th>

                </tr>

            </thead>

            <tbody>

                @forelse($membresNonInscrits as $membre)

                    <tr>

                        <td class="fw-semibold">
                            {{ $membre->nom_complet }}
                        </td>

                        <td>
                            {{ $membre->telephone ?: '-' }}
                        </td>

                        <td>

                            <span class="badge bg-success">

                                Actif

                            </span>

                        </td>

                        <td class="text-end">

                            <a href="{{ route('cotisations.create',['membre_id'=>$membre->id]) }}"
                               class="btn btn-sm btn-primary">

                                <i class="bi bi-cash-coin me-1"></i>

                                Enregistrer

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="4" class="text-center py-5 text-success">

                            <i class="bi bi-check-circle-fill fs-2 d-block mb-2"></i>

                            Tous les membres sont à jour.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection