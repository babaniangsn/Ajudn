@extends('layouts.app')

@section('titre', 'Détails du membre')

@section('contenu')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>

        <div class="d-flex align-items-center flex-wrap gap-2">

            <h2 class="fw-bold mb-0">
                <i class="bi bi-person-badge-fill text-primary me-2"></i>
                {{ $membre->nom_complet }}
            </h2>

            <span class="badge {{ $membre->statut == 'actif' ? 'bg-success' : 'bg-danger' }}">
                {{ ucfirst($membre->statut) }}
            </span>

            <span class="badge {{ $estAJour ? 'bg-primary' : 'bg-warning text-dark' }}">
                {{ $estAJour ? 'À jour' : 'En retard' }}
            </span>

        </div>

        <p class="text-muted mt-2 mb-0">
            Informations générales et historique des cotisations.
        </p>

    </div>

    <div class="d-flex gap-2">

        <a href="{{ route('membres.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Retour
        </a>

        <a href="{{ route('cotisations.create',['membre_id'=>$membre->id]) }}"
           class="btn btn-success">
            <i class="bi bi-cash-coin me-1"></i>
            Nouveau paiement
        </a>

    </div>

</div>


<div class="row g-4 mb-4">

    <div class="col-lg-4">

        <div class="card border-0 shadow rounded-4 h-100">

            <div class="card-header bg-white border-0">

                <h5 class="fw-semibold mb-0">
                    <i class="bi bi-person-lines-fill text-primary me-2"></i>
                    Informations
                </h5>

            </div>

            <div class="card-body">

                <table class="table table-borderless mb-0">

                    <tr>
                        <th>Matricule</th>
                        <td>{{ $membre->matricule }}</td>
                    </tr>

                    <tr>
                        <th>Téléphone</th>
                        <td>{{ $membre->telephone ?: '—' }}</td>
                    </tr>

                    <tr>
                        <th>Adhésion</th>
                        <td>{{ $membre->date_adhesion->format('d/m/Y') }}</td>
                    </tr>

                    <tr>
                        <th>Carte</th>
                        <td>
                            @if($membre->carte)
                                <span class="badge bg-success">Oui</span>
                            @else
                                <span class="badge bg-secondary">Non</span>
                            @endif
                        </td>
                    </tr>

                </table>

            </div>

        </div>

    </div>


    <div class="col-lg-8">

        <div class="row g-3">

            <div class="col-md-4">

                <div class="card border-0 shadow rounded-4 text-center h-100">

                    <div class="card-body">

                        <i class="bi bi-wallet2 fs-1 text-success"></i>

                        <h3 class="fw-bold mt-2">
                            {{ number_format($totalPaye,0,',',' ') }}
                        </h3>

                        <small class="text-muted">
                            FCFA versés
                        </small>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card border-0 shadow rounded-4 text-center h-100">

                    <div class="card-body">

                        <i class="bi bi-cash-stack fs-1 text-primary"></i>

                        <h3 class="fw-bold">
                            {{ $membre->cotisations->count() }}
                        </h3>

                        <small class="text-muted">
                            Paiements
                        </small>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card border-0 shadow rounded-4 text-center h-100">

                    <div class="card-body">

                        <i class="bi bi-calendar-check fs-1 {{ $estAJour ? 'text-success' : 'text-warning' }}"></i>

                        <h5 class="fw-bold mt-2">
                            {{ $estAJour ? 'À jour' : 'En retard' }}
                        </h5>

                        <small class="text-muted">
                            Situation
                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<div class="card border-0 shadow rounded-4">

    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">

        <h5 class="mb-0 fw-semibold">
            <i class="bi bi-clock-history text-primary me-2"></i>
            Historique des paiements
        </h5>

        <span class="badge bg-primary">
            {{ $membre->cotisations->count() }} paiement(s)
        </span>

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">

                <tr>
                    <th>Référence</th>
                    <th>Période</th>
                    <th>Montant</th>
                    <th>Mode</th>
                    <th>Date</th>
                    <th class="text-center">Actions</th>
                </tr>

            </thead>

            <tbody>

            @forelse($membre->cotisations as $cotisation)

                <tr>

                    <td>{{ $cotisation->reference }}</td>

                    <td>{{ $cotisation->periode_libelle }}</td>

                    <td class="fw-semibold text-success">
                        {{ number_format($cotisation->montant,0,',',' ') }} FCFA
                    </td>

                    <td>
                        <span class="badge bg-light text-dark border">
                            {{ $cotisation->mode_paiement }}
                        </span>
                    </td>

                    <td>{{ $cotisation->date_paiement->format('d/m/Y') }}</td>

                    <td class="text-center">

                        <div class="btn-group btn-group-sm">

                            <a href="{{ route('cotisations.recu',$cotisation) }}"
                               target="_blank"
                               class="btn btn-outline-danger"
                               title="Reçu PDF">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </a>

                            <a href="{{ route('cotisations.edit',$cotisation) }}"
                               class="btn btn-outline-primary"
                               title="Modifier">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="text-center py-5 text-muted">

                        <i class="bi bi-receipt fs-1 d-block mb-3"></i>

                        Aucun paiement enregistré.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection