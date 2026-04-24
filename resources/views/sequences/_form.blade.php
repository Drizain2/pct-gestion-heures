<!-- resources/views/sequences/_form.blade.php -->
<div class="row g-3">
    <input type="hidden" name="cours_id" value="{{ $cour->id }}">

    <div class="col-md-8">
        <label class="form-label">Titre <span class="text-danger">*</span></label>
        <input type="text" name="titre"
               class="form-control @error('titre') is-invalid @enderror"
               value="{{ old('titre', $sequence->titre ?? '') }}"
               placeholder="Ex: Introduction aux algorithmes">
        @error('titre') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Ordre <span class="text-danger">*</span></label>
        <input type="number" name="ordre"
               class="form-control @error('ordre') is-invalid @enderror"
               value="{{ old('ordre', $sequence->ordre ?? $ordre ?? 1) }}"
               min="1">
        @error('ordre') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3"
                  placeholder="Description optionnelle...">{{ old('description', $sequence->description ?? '') }}</textarea>
    </div>
</div>