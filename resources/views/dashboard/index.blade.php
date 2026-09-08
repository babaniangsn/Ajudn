@extends('layouts.app')

@section('titre', 'Tableau de bord')

@section('contenu')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0"><i class="bi bi-speedometer2 me-2"></i>Tableau de bord</h3>
        <span class="text-muted">{{ now()->translatedFormat('l d F Y') }}</span>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card bg-grad-blue">
                <i class="bi bi-people-fill stat-icon"></i>
                <div class="stat-label">Total des membres</div>
                <div class="stat-valeur">{{ $totalMembres }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card bg-grad-green">
                <i class="bi bi-check-circle-fill stat-icon"></i>
                <div class="stat-label">Membres à jour</div>
                <div class="stat-valeur">{{ $membresAJour }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card bg-grad-orange">
                <i class="bi bi-exclamation-triangle-fill stat-icon"></i>
                <div class="stat-label">Membres en retard</div>
                <div class="stat-valeur">{{ $membresEnRetard }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card bg-grad-purple">
                <i class="bi bi-cash-stack stat-icon"></i>
                <div class="stat-label">Total encaissé</div>
                <div class="stat-valeur">{{ number_format($totalCotisations, 0, ',', ' ') }}</div>
                <div class="stat-label">FCFA</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Derniers paiements enregistrés</span>
            <a href="{{ route('cotisations.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Membre</th>
                        <th>Période</th>
                        <th>Montant</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dernieresCotisations as $c)
                        <tr>
                            <td>{{ $c->membre?->nom_complet }}</td>
                            <td>{{ $c->periode_libelle }}</td>
                            <td>{{ number_format($c->montant, 0, ',', ' ') }} FCFA</td>
                            <td>{{ $c->date_paiement->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Aucun paiement enregistré pour le moment.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Membres sans inscription pour {{ now()->translatedFormat('F Y') }}</span>
            <span class="badge bg-warning text-dark">{{ $membresNonInscrits->count() }}</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Prénom &amp; Nom</th>
                        <th>Téléphone</th>
                        <th>Statut</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($membresNonInscrits as $membre)
                        <tr>
                            <td>{{ $membre->nom_complet }}</td>
                            <td>{{ $membre->telephone ?: '—' }}</td>
                            <td><span class="badge badge-statut-actif">Actif</span></td>
                            <td class="text-end">
                                <a href="{{ route('cotisations.create', ['membre_id' => $membre->id]) }}" class="btn btn-sm btn-outline-primary">
                                    Enregistrer le paiement
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-success py-4">Tous les membres actifs sont à jour ce mois-ci.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
