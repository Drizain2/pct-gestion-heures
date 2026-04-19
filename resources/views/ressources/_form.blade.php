<!-- resources/views/ressources/_form.blade.php -->
<div class="row g-3">
    <input type="hidden" name="sequence_id" value="{{ $sequence->id }}">

    <div class="col-12">
        <label class="form-label">Titre <span class="text-danger">*</span></label>
        <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror"
            value="{{ old('titre', $ressource->titre ?? '') }}" placeholder="Ex: Cours intro algorithmique">
        @error('titre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Type de ressource <span class="text-danger">*</span></label>
        <select name="type" class="form-select @error('type') is-invalid @enderror">
            <option value="">-- Sélectionner --</option>
            @foreach ([
        'contenu_textuel' => 'Contenu textuel',
        'video' => 'Vidéo pédagogique',
        'document' => 'Document',
        'quiz' => 'Quiz',
        'activite_interactive' => 'Activité interactive',
        'evaluation' => 'Évaluation',
    ] as $value => $label)
                <option value="{{ $value }}"
                    {{ old('type', $ressource->type ?? '') == $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Niveau de complexité <span class="text-danger">*</span></label>
        <select name="complexite" class="form-select @error('complexite') is-invalid @enderror">
            <option value="">-- Sélectionner --</option>
            <option
                value="niveau_1"{{ old('complexite', $ressource->complexite ?? '') == 'niveau_1' ? 'selected' : '' }}>
                niveau 1 - Contenus simples + quiz + evaluations</option>
            <option
                value="niveau_2"{{ old('complexite', $ressource->complexite ?? '') == 'niveau_2' ? 'selected' : '' }}>
                niveau 2 - Niveau 1 + activités interactives</option>
            <option
                value="niveau_3"{{ old('complexite', $ressource->complexite ?? '') == 'niveau_3' ? 'selected' : '' }}>
                niveau 3 - Serious games, simulations</option>
        </select>
        @error('complexite')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label">Enseignant responsable <span class="text-danger">*</span></label>
        <select name="enseignant_id" class="form-select @error('enseignant_id') is-invalid @enderror">
            <option value="">-- Sélectionner --</option>
            @foreach ($enseignants as $enseignant)
                <option value="{{ $enseignant->id }}"
                    {{ old('enseignant_id', $ressource->enseignant_id ?? ($enseignantSelectionne ?? '')) == $enseignant->id ? 'selected' : '' }}>
                    {{ $enseignant->nom_complet }} — {{ $enseignant->grade }}
                </option>
            @endforeach
        </select>
        @error('enseignant_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3" placeholder="Description optionnelle...">{{ old('description', $ressource->description ?? '') }}</textarea>
    </div>
</div>
