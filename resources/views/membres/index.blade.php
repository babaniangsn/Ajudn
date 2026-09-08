@extends('layouts.app')

@section('titre', 'Membres')

@section('contenu')

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <h3 class="fw-bold mb-0"><i class="bi bi-person-vcard me-2"></i>Membres de l'association</h3>
        <div class="d-flex gap-2">
            <a href="{{ route('exports.membres.pdf') }}" target="_blank" class="btn btn-outline-danger">
                <i class="bi bi-file-earmark-pdf me-1"></i> PDF
            </a>
            <a href="{{ route('membres.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus-fill me-1"></i> Nouveau membre
            </a>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2">
                <div class="col-md-7">
                    <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Rechercher par nom, prénom ou téléphone...">
                </div>
                <div class="col-md-3">
                    <select name="statut" class="form-select">
                        <option value="">Tous les statuts</option>
                        <option value="actif" @selected($statut === 'actif')>Actif</option>
                        <option value="inactif" @selected($statut === 'inactif')>Inactif</option>
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button class="btn btn-primary"><i class="bi bi-search me-1"></i> Filtrer</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Prénom &amp; Nom</th>
                        <th class="d-none d-md-table-cell">Téléphone</th>
                        <th class="d-none d-md-table-cell">Adhésion</th>
                        <th>Statut</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($membres as $membre)
                        <tr>
                            <td>{{ $membre->nom_complet }}</td>
                            <td class="d-none d-md-table-cell">{{ $membre->telephone ?: '—' }}</td>
                            <td class="d-none d-md-table-cell">{{ $membre->date_adhesion->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge {{ $membre->statut === 'actif' ? 'badge-statut-actif' : 'badge-statut-inactif' }}">
                                    {{ ucfirst($membre->statut) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('membres.show', $membre) }}" class="btn btn-outline-secondary" title="Détails"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('cotisations.create', ['membre_id' => $membre->id]) }}" class="btn btn-outline-success" title="Enregistrer un paiement"><i class="bi bi-cash-coin"></i></a>
                                    <a href="{{ route('membres.edit', $membre) }}" class="btn btn-outline-primary" title="Modifier"><i class="bi bi-pencil-square"></i></a>
                                    <button type="button" class="btn btn-outline-danger" title="Supprimer"
                                        data-bs-toggle="modal" data-bs-target="#supprimer{{ $membre->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <div class="modal fade" id="supprimer{{ $membre->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                Confirmez-vous la suppression du membre <strong>{{ $membre->nom_complet }}</strong> ?
                                                Toutes ses cotisations seront également supprimées.
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <form action="{{ route('membres.destroy', $membre) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-danger">Supprimer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Aucun membre trouvé.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($membres->hasPages())
            <div class="card-footer bg-white">
                {{ $membres->links() }}
            </div>
        @endif
    </div>

@endsection
