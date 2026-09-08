@extends('layouts.app')

@section('titre', 'Modifier le paiement')

@section('contenu')

    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('cotisations.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
        <h3 class="fw-bold mb-0">Modifier le paiement</h3>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('cotisations.update', $cotisation) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Membre</label>
                        <input type="text" class="form-control" value="{{ $cotisation->membre->nom_complet }}" disabled readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Période</label>
                        <input type="text" class="form-control" value="{{ $cotisation->periode_libelle }}" disabled readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Montant (FCFA) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="1" name="montant" value="{{ old('montant', $cotisation->montant) }}" class="form-control @error('montant') is-invalid @enderror" required>
                        @error('montant') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Date de paiement <span class="text-danger">*</span></label>
                        <input type="date" name="date_paiement" value="{{ old('date_paiement', $cotisation->date_paiement->format('Y-m-d')) }}" class="form-control @error('date_paiement') is-invalid @enderror" required>
                        @error('date_paiement') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('cotisations.index') }}" class="btn btn-outline-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-1"></i> Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>

@endsection
