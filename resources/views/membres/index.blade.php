@extends('layouts.app')

@section('titre', 'Membres')

@section('contenu')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-people-fill text-primary me-2"></i>
            Membres de l'association
        </h2>
        <p class="text-muted mb-0">
            Gérez les membres, leurs informations et leurs cotisations.
        </p>
    </div>

    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('membres.carte') }}" class="btn btn-outline-primary">
            <i class="bi bi-credit-card-2-front me-1"></i>
            Cartes
        </a>

        <a href="{{ route('exports.membres.pdf') }}" target="_blank" class="btn btn-outline-danger">
            <i class="bi bi-file-earmark-pdf me-1"></i>
            Export PDF
        </a>

        <a href="{{ route('membres.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus-fill me-1"></i>
            Nouveau membre
        </a>
    </div>

</div>

<div class="card shadow-sm border-0 rounded-4 mb-4">

    <div class="card-body">

        <form method="GET">

            <div class="row g-3">

                <div class="col-lg-6">
                    <label class="form-label fw-semibold">
                        Rechercher
                    </label>

                    <input
                        type="text"
                        name="q"
                        value="{{ $q }}"
                        class="form-control"
                        placeholder="Nom, prénom ou téléphone...">
                </div>

                <div class="col-lg-3">
                    <label class="form-label fw-semibold">
                        Statut
                    </label>

                    <select name="statut" class="form-select">
                        <option value="">Tous</option>
                        <option value="actif" @selected($statut=='actif')>Actif</option>
                        <option value="inactif" @selected($statut=='inactif')>Inactif</option>
                    </select>
                </div>

                <div class="col-lg-3 d-grid">
                    <label class="form-label invisible">.</label>

                    <button class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>
                        Rechercher
                    </button>
                </div>

            </div>

        </form>

    </div>

</div>

<div class="card border-0 shadow rounded-4">

    <div class="card-header bg-white border-0 py-3">

        <div class="d-flex justify-content-between align-items-center">

            <h5 class="mb-0 fw-semibold">
                <i class="bi bi-list-ul me-2 text-primary"></i>
                Liste des membres
            </h5>

            <span class="badge bg-primary">
                {{ $membres->total() }} membre(s)
            </span>

        </div>

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">

                <tr>
                    <th>Membre</th>
                    <th class="d-none d-lg-table-cell">Rôle</th>
                    <th class="d-none d-lg-table-cell">Téléphone</th>
                    <th class="d-none d-lg-table-cell">Adhésion</th>
                    <th>Statut</th>
                    <th class="text-center">Actions</th>
                </tr>

            </thead>

            <tbody>

            @forelse($membres as $membre)

                <tr>

                    <td>
                        <div class="fw-semibold">
                            {{ $membre->nom_complet }}
                        </div>

                        
                    </td>

                    <td class="d-none d-lg-table-cell">
                        @if($membre->role)
                            <span class="badge bg-primary rounded-pill">{{ $membre->role }}</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>

                    <td class="d-none d-lg-table-cell">
                        {{ $membre->telephone ?: '—' }}
                    </td>

                    <td class="d-none d-lg-table-cell">
                        {{ $membre->date_adhesion->format('d/m/Y') }}
                    </td>

                    <td>

                        @if($membre->statut=='actif')
                            <span class="badge bg-success">
                                Actif
                            </span>
                        @else
                            <span class="badge bg-danger">
                                Inactif
                            </span>
                        @endif

                    </td>

                    <td class="text-center">

                        <div class="btn-group btn-group-sm">

                            <a href="{{ route('membres.show',$membre) }}"
                               class="btn btn-outline-secondary"
                               title="Voir">
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="{{ route('cotisations.create',['membre_id'=>$membre->id]) }}"
                               class="btn btn-outline-success"
                               title="Cotisation">
                                <i class="bi bi-cash-coin"></i>
                            </a>

                            <a href="{{ route('membres.edit',$membre) }}"
                               class="btn btn-outline-primary"
                               title="Modifier">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <button
                                class="btn btn-outline-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#supprimer{{ $membre->id }}"
                                title="Supprimer">

                                <i class="bi bi-trash"></i>

                            </button>

                        </div>

                        <div class="modal fade"
                             id="supprimer{{ $membre->id }}"
                             tabindex="-1">

                            <div class="modal-dialog">

                                <div class="modal-content">

                                    <div class="modal-header">

                                        <h5 class="modal-title">
                                            Confirmation
                                        </h5>

                                        <button
                                            class="btn-close"
                                            data-bs-dismiss="modal">
                                        </button>

                                    </div>

                                    <div class="modal-body">

                                        Voulez-vous vraiment supprimer
                                        <strong>{{ $membre->nom_complet }}</strong> ?

                                        <div class="alert alert-warning mt-3 mb-0">
                                            Toutes ses cotisations seront également supprimées.
                                        </div>

                                    </div>

                                    <div class="modal-footer">

                                        <button
                                            class="btn btn-secondary"
                                            data-bs-dismiss="modal">
                                            Annuler
                                        </button>

                                        <form method="POST"
                                              action="{{ route('membres.destroy',$membre) }}">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-danger">
                                                Supprimer
                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5" class="text-center py-5 text-muted">

                        <i class="bi bi-people fs-1 d-block mb-3"></i>

                        Aucun membre trouvé.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    @if($membres->hasPages())

        <div class="card-footer bg-white">

            {{ $membres->links() }}

        </div>

    @endif

</div>

@endsection