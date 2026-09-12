@extends('layouts.app')

@section('titre', 'Nouvelle cotisation')

@php
$moisNoms = [
    1=>'Janvier',2=>'Février',3=>'Mars',4=>'Avril',
    5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Août',
    9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Décembre'
];
@endphp

@section('contenu')

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">
            <i class="bi bi-cash-stack text-success me-2"></i>
            Nouvelle cotisation
        </h3>
        <p class="text-muted mb-0">
            Enregistrer le paiement d'un membre de l'association.
        </p>
    </div>

    <a href="{{ route('cotisations.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>
        Retour
    </a>
</div>

@if($errors->any())
<div class="alert alert-danger shadow-sm">
    <div class="fw-semibold mb-2">
        <i class="bi bi-exclamation-triangle-fill me-1"></i>
        Veuillez corriger les erreurs suivantes
    </div>

    <ul class="mb-0">
        @foreach($errors->all() as $erreur)
            <li>{{ $erreur }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card shadow border-0 rounded-4">

    <div class="card-header bg-success text-white rounded-top-4">
        <h5 class="mb-0">
            <i class="bi bi-receipt-cutoff me-2"></i>
            Informations de paiement
        </h5>
    </div>

    <div class="card-body p-4">

        <form method="POST" action="{{ route('cotisations.store') }}">
            @csrf

            <div class="row g-4">

                <div class="col-6">
                    <label class="form-label fw-semibold">
                        Membre <span class="text-danger">*</span>
                    </label>

                    <select
                        name="membre_id"
                        class="form-select @error('membre_id') is-invalid @enderror"
                        required>

                        <option value="">Choisir un membre</option>

                        @foreach($membres as $membre)
                            <option
                                value="{{ $membre->id }}"
                                @selected(old('membre_id',$membreSelectionne)==$membre->id)>
                                {{ $membre->nom_complet }}
                            </option>
                        @endforeach

                    </select>

                    @error('membre_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Montant
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
                            value="{{ old('montant') }}"
                            class="form-control @error('montant') is-invalid @enderror"
                            placeholder="500+"
                            required>

                        @error('montant')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Mois
                    </label>

                    <select
                        name="mois"
                        class="form-select @error('mois') is-invalid @enderror">

                        @foreach($moisNoms as $numero=>$nom)
                            <option
                                value="{{ $numero }}"
                                @selected(old('mois',now()->month)==$numero)>
                                {{ $nom }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Année
                    </label>

                    <input
                        type="number"
                        name="annee"
                        value="{{ old('annee',now()->year) }}"
                        class="form-control @error('annee') is-invalid @enderror"
                        required>

                    @error('annee')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Date du paiement
                    </label>

                    <input
                        type="date"
                        name="date_paiement"
                        value="{{ old('date_paiement',now()->format('Y-m-d')) }}"
                        class="form-control @error('date_paiement') is-invalid @enderror"
                        required>

                    @error('date_paiement')
                        <div class="invalid-feedback">{{ $message }}</div>
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
                        class="btn btn-success">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    Enregistrer la cotisation
                </button>

            </div>

        </form>

    </div>

</div>

@endsection