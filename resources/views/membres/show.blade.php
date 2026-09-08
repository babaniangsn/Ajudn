@extends('layouts.app')

@section('titre', 'Détails du membre')

@section('contenu')

    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('membres.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
        <h3 class="fw-bold mb-0">{{ $membre->nom_complet }}</h3>
        <span class="badge {{ $membre->statut === 'actif' ? 'badge-statut-actif' : 'badge-statut-inactif' }}">{{ ucfirst($membre->statut) }}</span>
        <span class="badge {{ $estAJour ? 'badge-ajour' : 'badge-retard' }}">{{ $estAJour ? 'À jour' : 'En retard' }}</span>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">Informations personnelles</div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-5">Téléphone</dt><dd class="col-7">{{ $membre->telephone ?: '—' }}</dd>
                        <dt class="col-5">Date d'adhésion</dt><dd class="col-7">{{ $membre->date_adhesion->format('d/m/Y') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">Résumé des cotisations</div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                    <div class="stat-valeur text-primary">{{ number_format($totalPaye, 0, ',', ' ') }} FCFA</div>
                    <div class="text-muted mb-3">Total versé</div>
                    <a href="{{ route('cotisations.create', ['membre_id' => $membre->id]) }}" class="btn btn-success">
                        <i class="bi bi-plus-circle me-1"></i> Enregistrer un paiement
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Historique des paiements</div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Période</th>
                        <th>Montant</th>
                        <th>Mode</th>
                        <th>Date de paiement</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($membre->cotisations as $cotisation)
                        <tr>
                            <td>{{ $cotisation->reference }}</td>
                            <td>{{ $cotisation->periode_libelle }}</td>
                            <td>{{ number_format($cotisation->montant, 0, ',', ' ') }} FCFA</td>
                            <td>{{ $cotisation->mode_paiement }}</td>
                            <td>{{ $cotisation->date_paiement->format('d/m/Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('cotisations.recu', $cotisation) }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Reçu PDF">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </a>
                                <a href="{{ route('cotisations.edit', $cotisation) }}" class="btn btn-sm btn-outline-primary" title="Modifier">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Aucun paiement enregistré pour ce membre.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
