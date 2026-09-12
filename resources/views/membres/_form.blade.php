@php
    $membre = $membre ?? null;
@endphp

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4">

        <div class="row g-4">

            <!-- Prénom -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    <i class="bi bi-person-fill text-primary me-1"></i>
                    Prénom <span class="text-danger">*</span>
                </label>

                <input
                    type="text"
                    name="prenom"
                    value="{{ old('prenom', $membre->prenom ?? '') }}"
                    class="form-control @error('prenom') is-invalid @enderror"
                    placeholder="Ex : Babacar"
                    required>

                @error('prenom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nom -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    <i class="bi bi-person-badge-fill text-primary me-1"></i>
                    Nom <span class="text-danger">*</span>
                </label>

                <input
                    type="text"
                    name="nom"
                    value="{{ old('nom', $membre->nom ?? '') }}"
                    class="form-control @error('nom') is-invalid @enderror"
                    placeholder="Ex : Ndiaye"
                    required>

                @error('nom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Téléphone -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    <i class="bi bi-telephone-fill text-success me-1"></i>
                    Téléphone
                </label>

                <input
                    type="tel"
                    name="telephone"
                    value="{{ old('telephone', $membre->telephone ?? '') }}"
                    class="form-control @error('telephone') is-invalid @enderror"
                    placeholder="77 123 45 67">

                @error('telephone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Date d'adhésion -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    <i class="bi bi-calendar-event-fill text-danger me-1"></i>
                    Date d'adhésion <span class="text-danger">*</span>
                </label>

                <input
                    type="date"
                    name="date_adhesion"
                    value="{{ old('date_adhesion', optional($membre?->date_adhesion)->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
                    class="form-control @error('date_adhesion') is-invalid @enderror"
                    required>

                @error('date_adhesion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Statut -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    <i class="bi bi-person-check-fill text-info me-1"></i>
                    Statut <span class="text-danger">*</span>
                </label>

                <select
                    name="statut"
                    class="form-select @error('statut') is-invalid @enderror"
                    required>

                    <option value="actif"
                        @selected(old('statut', $membre->statut ?? 'actif') == 'actif')>
                        ✅ Actif
                    </option>

                    <option value="inactif"
                        @selected(old('statut', $membre->statut ?? '') == 'inactif')>
                        ❌ Inactif
                    </option>

                </select>

                @error('statut')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Rôle -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    <i class="bi bi-person-vcard-fill text-primary me-1"></i>
                    Rôle au bureau
                </label>

                <select
                    name="role"
                    class="form-select @error('role') is-invalid @enderror">

                    <option value=""
                        @selected(old('role', $membre?->role ?? '') === '')>
                        Aucun rôle
                    </option>

                    <option value="Président"
                        @selected(old('role', $membre?->role ?? '') == 'Président')>
                        Président
                    </option>

                    <option value="Vice-président"
                        @selected(old('role', $membre?->role ?? '') == 'Vice-président')>
                        Vice-président
                    </option>

                    <option value="Secrétaire"
                        @selected(old('role', $membre?->role ?? '') == 'Secrétaire')>
                        Secrétaire
                    </option>

                    <option value="Trésorier"
                        @selected(old('role', $membre?->role ?? '') == 'Trésorier')>
                        Trésorier
                    </option>

                    <option value="Trésorière"
                        @selected(old('role', $membre?->role ?? '') == 'Trésorière')>
                        Trésorière
                    </option>

                    <option value="Membre"
                        @selected(old('role', $membre?->role ?? '') == 'Membre')>
                        Membre
                    </option>

                </select>

                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Carte -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    <i class="bi bi-credit-card-fill text-warning me-1"></i>
                    Carte membre <span class="text-danger">*</span>
                </label>

                <select
                    name="carte"
                    class="form-select @error('carte') is-invalid @enderror"
                    required>

                    <option value="1"
                        @selected(old('carte', $membre?->carte ?? 1) == 1)>
                        🟢 Avec carte
                    </option>

                    <option value="0"
                        @selected(old('carte', $membre?->carte ?? 0) == 0)>
                        ⚪ Sans carte
                    </option>

                </select>

                @error('carte')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <hr class="my-4">

        <div class="d-flex justify-content-end gap-2">

            <a href="{{ route('membres.index') }}"
               class="btn btn-outline-secondary rounded-pill px-4">
                <i class="bi bi-arrow-left me-1"></i>
                Annuler
            </a>

            <button type="submit"
                    class="btn btn-primary rounded-pill px-4">

                <i class="bi bi-check-circle-fill me-1"></i>

                {{ isset($membre) ? 'Mettre à jour' : 'Enregistrer' }}

            </button>

        </div>

    </div>
</div>