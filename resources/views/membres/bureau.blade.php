@extends('layouts.app')

@section('titre', 'Bureau de l\'association')

@section('contenu')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-person-badge-fill text-primary me-2"></i>
            Bureau de l'association
        </h2>
        <p class="text-muted mb-0">
            Liste des responsables et membres du bureau.
        </p>
    </div>

    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('membres.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Retour
        </a>

        <a href="{{ route('exports.bureau.pdf') }}" target="_blank" class="btn btn-outline-danger">
            <i class="bi bi-file-earmark-pdf me-1"></i>
            Imprimer PDF
        </a>
    </div>

</div>

<div class="card border-0 shadow rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nom</th>
                        <th>Rôle</th>
                        <th>Téléphone</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($membres as $membre)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $membre->nom_complet }}</div>
                            </td>
                            <td>
                                <span class="badge bg-primary rounded-pill">{{ $membre->role }}</span>
                            </td>
                            <td>{{ $membre->telephone ?: '—' }}</td>
                            <td>
                                @if($membre->statut == 'actif')
                                    <span class="badge bg-success">Actif</span>
                                @else
                                    <span class="badge bg-danger">Inactif</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                Aucun membre n'a encore un rôle de bureau.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
