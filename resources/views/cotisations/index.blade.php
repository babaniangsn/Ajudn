@extends('layouts.app')

@section('titre', 'Cotisations')

@php
    $moisNoms = [1=>'Janvier',2=>'Février',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Août',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Décembre'];
@endphp

@section('contenu')

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <h3 class="fw-bold mb-0"><i class="bi bi-cash-coin me-2"></i>Cotisations</h3>
        <div class="d-flex gap-2">
            <a href="{{ route('exports.cotisations.pdf') }}" target="_blank" class="btn btn-outline-danger">
                <i class="bi bi-file-earmark-pdf me-1"></i> PDF
            </a>
            <a href="{{ route('cotisations.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Enregistrer un paiement
            </a>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2">
                <div class="col-md-3">
                    <select name="mois" class="form-select">
                        <option value="">Tous les mois</option>
                        @foreach ($moisNoms as $num => $nom)
                            <option value="{{ $num }}" @selected(($filtres['mois'] ?? '') == $num)>{{ $nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="annee" value="{{ $filtres['annee'] ?? '' }}" class="form-control" placeholder="Année (ex: {{ now()->year }})">
                </div>
                <div class="col-md-3 d-grid">
                    <button class="btn btn-primary"><i class="bi bi-funnel me-1"></i> Filtrer</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Membre</th>
                        <th>Période</th>
                        <th>Montant</th>
                        <th class="d-none d-md-table-cell">Date de paiement</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cotisations as $cotisation)
                        <tr>
                            <td>{{ $cotisation->membre?->nom_complet }}</td>
                            <td>{{ $cotisation->periode_libelle }}</td>
                            <td>{{ number_format($cotisation->montant, 0, ',', ' ') }} FCFA</td>
                            <td class="d-none d-md-table-cell">{{ $cotisation->date_paiement->format('d/m/Y') }}</td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('cotisations.recu', $cotisation) }}" target="_blank" class="btn btn-outline-danger" title="Reçu PDF"><i class="bi bi-file-earmark-pdf"></i></a>
                                    <a href="{{ route('cotisations.edit', $cotisation) }}" class="btn btn-outline-primary" title="Modifier"><i class="bi bi-pencil-square"></i></a>
                                    <button type="button" class="btn btn-outline-danger" title="Supprimer" data-bs-toggle="modal" data-bs-target="#suppCot{{ $cotisation->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                                <div class="modal fade" id="suppCot{{ $cotisation->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">Confirmez-vous la suppression de ce paiement ?</div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <form action="{{ route('cotisations.destroy', $cotisation) }}" method="POST">
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
                        <tr><td colspan="5" class="text-center text-muted py-4">Aucune cotisation trouvée.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($cotisations->hasPages())
            <div class="card-footer bg-white">{{ $cotisations->links() }}</div>
        @endif
    </div>

@endsection
