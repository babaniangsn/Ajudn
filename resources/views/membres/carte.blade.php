@extends('layouts.app')

@section('titre', 'Cartes des membres')

@section('contenu')

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3 no-print">

    <div>
        <h2 class="fw-bold text-primary mb-1">
            <i class="bi bi-credit-card-2-front-fill me-2"></i>
            Gestion des cartes des membres
        </h2>

        <p class="text-muted mb-0">
            Consultez les membres possédant une carte ou non.
        </p>
    </div>

    <div class="d-flex gap-2">

        <a href="{{ route('membres.index') }}"
           class="btn btn-outline-secondary rounded-pill">
            <i class="bi bi-arrow-left me-1"></i>
            Retour
        </a>

        <button onclick="window.print()"
                class="btn btn-primary rounded-pill">
            <i class="bi bi-printer-fill me-1"></i>
            Imprimer
        </button>

    </div>

</div>

<div class="row mb-4 no-print">

    <div class="col-md-4">

        <div class="card border-0 shadow-sm bg-primary text-white rounded-4">

            <div class="card-body text-center">

                <i class="bi bi-people-fill fs-1"></i>

                <h3 class="fw-bold mt-2">
                    {{ $membres->count() }}
                </h3>

                <p class="mb-0">
                    Membres affichés
                </p>

            </div>

        </div>

    </div>

    <div class="col-md-8">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <label class="fw-semibold mb-3">
                    Filtrer les cartes
                </label>

                <div class="btn-group w-100">

                    <a href="{{ route('membres.carte',['filtre'=>'tous']) }}"
                       class="btn {{ $filtre=='tous' ? 'btn-primary' : 'btn-outline-primary' }}">

                        Tous

                    </a>

                    <a href="{{ route('membres.carte',['filtre'=>'avec']) }}"
                       class="btn {{ $filtre=='avec' ? 'btn-primary' : 'btn-outline-primary' }}">

                        Avec carte

                    </a>

                    <a href="{{ route('membres.carte',['filtre'=>'sans']) }}"
                       class="btn {{ $filtre=='sans' ? 'btn-primary' : 'btn-outline-primary' }}">

                        Sans carte

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="d-none d-print-block text-center mb-4">

    <h2 class="fw-bold">
        AJUDN
    </h2>

    <h5>
        Liste des cartes des membres
    </h5>

    <small>
        Généré le {{ now()->format('d/m/Y à H:i') }}
    </small>

</div>

<div class="card shadow-sm border-0 rounded-4">

    <div class="card-header bg-white">

        <h5 class="mb-0 fw-bold">

            <i class="bi bi-table me-2 text-primary"></i>

            Liste des membres

        </h5>

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-primary">

                <tr>

                    <th>#</th>
                    <th>Membre</th>
                    <th>Téléphone</th>
                    <th>Statut</th>
                    <th>Carte</th>

                </tr>

            </thead>

            <tbody>

                @forelse($membres as $index => $membre)

                <tr>

                    <td>{{ $index + 1 }}</td>

                    <td class="fw-semibold">
                        {{ $membre->nom_complet }}
                    </td>

                    <td>
                        {{ $membre->telephone ?: 'Non renseigné' }}
                    </td>

                    <td>

                        @if($membre->statut == 'actif')

                            <span class="badge bg-success">
                                Actif
                            </span>

                        @else

                            <span class="badge bg-danger">
                                Inactif
                            </span>

                        @endif

                    </td>

                    <td>

                        @if($membre->carte)

                            <span class="badge bg-primary">
                                <i class="bi bi-check-circle-fill me-1"></i>
                                Avec carte
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                <i class="bi bi-x-circle-fill me-1"></i>
                                Sans carte
                            </span>

                        @endif

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5"
                        class="text-center py-5 text-muted">

                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>

                        Aucun membre trouvé.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection