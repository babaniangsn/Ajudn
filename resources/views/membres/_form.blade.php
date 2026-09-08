@php $membre = $membre ?? null; @endphp

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Prénom <span class="text-danger">*</span></label>
        <input type="text" name="prenom" value="{{ old('prenom', $membre->prenom ?? '') }}" class="form-control @error('prenom') is-invalid @enderror" required>
        @error('prenom') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Nom <span class="text-danger">*</span></label>
        <input type="text" name="nom" value="{{ old('nom', $membre->nom ?? '') }}" class="form-control @error('nom') is-invalid @enderror" required>
        @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Téléphone</label>
        <input type="text" name="telephone" value="{{ old('telephone', $membre->telephone ?? '') }}" class="form-control @error('telephone') is-invalid @enderror" placeholder="77 123 45 67">
        @error('telephone') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Date d'adhésion <span class="text-danger">*</span></label>
        <input type="date" name="date_adhesion" value="{{ old('date_adhesion', isset($membre) ? $membre->date_adhesion->format('Y-m-d') : now()->format('Y-m-d')) }}" class="form-control @error('date_adhesion') is-invalid @enderror" required>
        @error('date_adhesion') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Statut <span class="text-danger">*</span></label>
        <select name="statut" class="form-select @error('statut') is-invalid @enderror" required>
            <option value="actif" @selected(old('statut', $membre->statut ?? 'actif') === 'actif')>Actif</option>
            <option value="inactif" @selected(old('statut', $membre->statut ?? '') === 'inactif')>Inactif</option>
        </select>
        @error('statut') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('membres.index') }}" class="btn btn-outline-secondary">Annuler</a>
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-1"></i> Enregistrer</button>
</div>
