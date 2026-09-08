@extends('layouts.app')

@section('titre', 'Enregistrer un paiement')

@php
    $moisNoms = [1=>'Janvier',2=>'Février',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Août',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Décembre'];
@endphp

@section('contenu')

    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('cotisations.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
        <h3 class="fw-bold mb-0">Enregistrer un paiement de cotisation</h3>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('cotisations.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label">Membre <span class="text-danger">*</span></label>
                        <select name="membre_id" class="form-select @error('membre_id') is-invalid @enderror" required>
                            <option value="">-- Sélectionner un membre --</option>
                            @foreach ($membres as $membre)
                                <option value="{{ $membre->id }}" @selected(old('membre_id', $membreSelectionne) == $membre->id)>
                                    {{ $membre->nom_complet }}
                                </option>
                            @endforeach
                        </select>
                        @error('membre_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Montant (FCFA) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="1" name="montant" value="{{ old('montant') }}" class="form-control @error('montant') is-invalid @enderror" required>
                        @error('montant') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Mois de la période <span class="text-danger">*</span></label>
                        <select name="mois" class="form-select @error('mois') is-invalid @enderror" required>
                            @foreach ($moisNoms as $num => $nom)
                                <option value="{{ $num }}" @selected(old('mois', now()->month) == $num)>{{ $nom }}</option>
                            @endforeach
                        </select>
                        @error('mois') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Année de la période <span class="text-danger">*</span></label>
                        <input type="number" name="annee" value="{{ old('annee', now()->year) }}" class="form-control @error('annee') is-invalid @enderror" required>
                        @error('annee') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Date de paiement <span class="text-danger">*</span></label>
                        <input type="date" name="date_paiement" value="{{ old('date_paiement', now()->format('Y-m-d')) }}" class="form-control @error('date_paiement') is-invalid @enderror" required>
                        @error('date_paiement') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('cotisations.index') }}" class="btn btn-outline-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-1"></i> Enregistrer le paiement</button>
                </div>
            </form>
        </div>
    </div>

@endsection
