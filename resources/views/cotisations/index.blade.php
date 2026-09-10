@extends('layouts.app')

@section('titre', 'Gestion des cotisations')

@php
    $moisNoms = [
        1 => 'Janvier',
        2 => 'Février',
        3 => 'Mars',
        4 => 'Avril',
        5 => 'Mai',
        6 => 'Juin',
        7 => 'Juillet',
        8 => 'Août',
        9 => 'Septembre',
        10 => 'Octobre',
        11 => 'Novembre',
        12 => 'Décembre'
    ];
@endphp

@section('contenu')

<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-cash-coin text-success me-2"></i>
            Gestion des cotisations
        </h2>

        <small class="text-muted">
            Gérez les paiements des membres.
        </small>
    </div>

    <div class="mt-3 mt-lg-0 d-flex gap-2">

        <a href="{{ route('exports.cotisations.pdf') }}"
           target="_blank"
           class="btn btn-outline-danger">

            <i class="bi bi-file-earmark-pdf me-1"></i>

            Export PDF

        </a>

        <a href="{{ route('cotisations.create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-circle me-1"></i>

            Nouvelle cotisation

        </a>

    </div>

</div>

{{-- Filtres --}}
<div class="card shadow-sm border-0 mb-4">

    <div class="card-body">

        <form method="GET" class="row g-3">

            <div class="col-md-4">

                <label class="form-label">
                    Mois
                </label>

                <select name="mois" class="form-select">

                    <option value="">
                        Tous les mois
                    </option>

                    @foreach($moisNoms as $numero => $nom)

                        <option value="{{ $numero }}"
                            @selected(($filtres['mois'] ?? '') == $numero)>

                            {{ $nom }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-4">

                <label class="form-label">
                    Année
                </label>

                <input
                    type="number"
                    name="annee"
                    class="form-control"
                    value="{{ $filtres['annee'] ?? '' }}"
                    placeholder="{{ now()->year }}">

            </div>

            <div class="col-md-4 d-flex align-items-end">

                <button class="btn btn-primary w-100">

                    <i class="bi bi-funnel me-1"></i>

                    Appliquer les filtres

                </button>

            </div>

        </form>

    </div>

</div>

{{-- Tableau --}}
<div class="card shadow-sm border-0">

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">

                <tr>

                    <th>Membre</th>

                    <th>Période</th>

                    <th>Montant</th>

                    <th class="d-none d-lg-table-cell">
                        Date de paiement
                    </th>

                    <th class="text-center">
                        Actions
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($cotisations as $cotisation)

                <tr>

                    <td class="fw-semibold">

                        {{ $cotisation->membre?->nom_complet ?? '-' }}

                    </td>

                    <td>

                        {{ $cotisation->periode_libelle }}

                    </td>

                    <td>

                        <span class="badge bg-success fs-6">

                            {{ number_format($cotisation->montant,0,',',' ') }} FCFA

                        </span>

                    </td>

                    <td class="d-none d-lg-table-cell">

                        {{ optional($cotisation->date_paiement)->format('d/m/Y') }}

                    </td>

                    <td class="text-center">

                        <div class="btn-group">

                            <a href="{{ route('cotisations.recu',$cotisation) }}"
                               target="_blank"
                               class="btn btn-outline-danger btn-sm"
                               title="Télécharger le reçu">

                                <i class="bi bi-file-earmark-pdf"></i>

                            </a>

                            <a href="{{ route('cotisations.edit',$cotisation) }}"
                               class="btn btn-outline-primary btn-sm"
                               title="Modifier">

                                <i class="bi bi-pencil-square"></i>

                            </a>

                            <button
                                class="btn btn-outline-danger btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $cotisation->id }}"
                                title="Supprimer">

                                <i class="bi bi-trash"></i>

                            </button>

                        </div>

                    </td>

                </tr>

                {{-- Modal --}}
                <div class="modal fade"
                     id="deleteModal{{ $cotisation->id }}"
                     tabindex="-1">

                    <div class="modal-dialog modal-dialog-centered">

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

                                Voulez-vous vraiment supprimer cette cotisation ?

                            </div>

                            <div class="modal-footer">

                                <button
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">

                                    Annuler

                                </button>

                                <form method="POST"
                                      action="{{ route('cotisations.destroy',$cotisation) }}">

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

                @empty

                <tr>

                    <td colspan="5"
                        class="text-center py-5 text-muted">

                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>

                        Aucune cotisation trouvée.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    @if($cotisations->hasPages())

        <div class="card-footer bg-white">

            {{ $cotisations->links() }}

        </div>

    @endif

</div>

@endsection