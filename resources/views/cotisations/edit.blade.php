@extends('layouts.app')

@section('titre', 'Modifier une cotisation')

@section('contenu')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-pencil-square text-primary me-2"></i>
            Modifier une cotisation
        </h2>

        <small class="text-muted">
            Modifiez les informations du paiement.
        </small>
    </div>

    <a href="{{ route('cotisations.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>
        Retour
    </a>

</div>

@if ($errors->any())
<div class="alert alert-danger">
    <strong>Des erreurs ont été détectées :</strong>
    <ul class="mb-0 mt-2">
        @foreach ($errors->all() as $erreur)
            <li>{{ $erreur }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card shadow-sm border-0">

    <div class="card-body">

        <form method="POST" action="{{ route('cotisations.update', $cotisation) }}">

            @csrf
            @method('PUT')

            <div class="row g-4">

                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Membre
                    </label>

                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person-fill"></i>
                        </span>

                        <input type="text"
                               class="form-control bg-light"
                               value="{{ $cotisation->membre->nom_complet }}"
                               readonly>
                    </div>

                </div>

                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Période
                    </label>

                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-calendar-event"></i>
                        </span>

                        <input type="text"
                               class="form-control bg-light"
                               value="{{ $cotisation->periode_libelle }}"
                               readonly>
                    </div>

                </div>

                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Montant (FCFA)
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            FCFA
                        </span>

                        <input
                            type="number"
                            name="montant"
                            min="1"
                            step="1"
                            value="{{ old('montant', $cotisation->montant) }}"
                            class="form-control @error('montant') is-invalid @enderror"
                            required>

                        @error('montant')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>

                </div>

                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Date de paiement
                    </label>

                    <input
                        type="date"
                        name="date_paiement"
                        value="{{ old('date_paiement', $cotisation->date_paiement->format('Y-m-d')) }}"
                        class="form-control @error('date_paiement') is-invalid @enderror"
                        required>

                    @error('date_paiement')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                </div>

            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">

                <a href="{{ route('cotisations.index') }}"
                   class="btn btn-outline-secondary">

                    <i class="bi bi-x-circle me-1"></i>
                    Annuler

                </a>

                <button type="submit"
                        class="btn btn-primary">

                    <i class="bi bi-check-circle me-1"></i>
                    Enregistrer les modifications

                </button>

            </div>

        </form>

    </div>

</div>

@endsection