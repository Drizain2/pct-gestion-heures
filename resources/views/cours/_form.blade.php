<!-- resources/views/cour/_form.blade.php -->
<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Intitulé du cour <span class="text-danger">*</span></label>
        <input type="text" name="intitule"
            class="form-control @error('intitule') is-invalid @enderror"
            value="{{ old('intitule', $cour->intitule ?? '') }}"
            placeholder="Ex: Algorithmique et structures de données">
        @error('intitule') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Filière <span class="text-danger">*</span></label>
        <input type="text" name="filiere"
            class="form-control @error('filiere') is-invalid @enderror"
            value="{{ old('filiere', $cour->filiere ?? '') }}"
            placeholder="Ex: Génie Logiciel">
        @error('filiere') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Niveau <span class="text-danger">*</span></label>
        <select name="niveau" class="form-select @error('niveau') is-invalid @enderror">
            <option value="">-- Sélectionner --</option>
            @foreach(['L1','L2','L3','M1','M2'] as $n)
            <option value="{{ $n }}"
                {{ old('niveau', $cour->niveau ?? '') == $n ? 'selected' : '' }}>
                {{ $n }}
            </option>
            @endforeach
        </select>
        @error('niveau') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Semestre <span class="text-danger">*</span></label>
        <select name="semestre" class="form-select @error('semestre') is-invalid @enderror">
            <option value="">-- Sélectionner --</option>
            @foreach(['S1','S2','S3','S4','S5','S6','S7','S8','S9','S10'] as $s)
            <option value="{{ $s }}"
                {{ old('semestre', $cour->semestre ?? '') == $s ? 'selected' : '' }}>
                {{ $s }}
            </option>
            @endforeach
        </select>
        @error('semestre') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Nombre d'heures <span class="text-danger">*</span></label>
        <input type="number" name="nombre_heures"
            class="form-control @error('nombre_heures') is-invalid @enderror"
            value="{{ old('nombre_heures', $cour->nombre_heures ?? '') }}"
            min="1" placeholder="Ex: 45">
        @error('nombre_heures') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Nombre de crédits <span class="text-danger">*</span></label>
        <input type="number" name="nombre_credits"
            class="form-control @error('nombre_credits') is-invalid @enderror"
            value="{{ old('nombre_credits', $cour->nombre_credits ?? '') }}"
            min="1" placeholder="Ex: 3">
        @error('nombre_credits') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Année académique <span class="text-danger">*</span></label>
        <input type="text" name="annee_academique"
            class="form-control @error('annee_academique') is-invalid @enderror"
            value="{{ old('annee_academique', $anneeAcademique ?? date('Y').'-'.(date('Y')+1)) }}"
            placeholder="Ex: 2025-2026">
        @error('annee_academique') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Enseignants assignés</label>
        <select name="enseignants[]" class="form-select" multiple style="height:120px;">
            @foreach($enseignants as $enseignant)
            <option value="{{ $enseignant->id }}"
                {{ in_array($enseignant->id, old('enseignants', $enseignantsIds ?? [])) ? 'selected' : '' }}>
                {{ $enseignant->nom_complet }} — {{ $enseignant->grade }}
            </option>
            @endforeach
        </select>
        <small class="text-muted">
            <i class="bi bi-info-circle me-1"></i>
            Maintenez Ctrl pour sélectionner plusieurs enseignants
        </small>
    </div>
</div>