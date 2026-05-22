{{-- Informations du cours --}}
<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Intitulé du cours <span class="text-danger">*</span></label>
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
            placeholder="Ex: Génie Logiciel"
            list="departements-list"
            autocomplete="off">
        <datalist id="departements-list">
            @foreach($departements ?? [] as $dept)
                <option value="{{ $dept }}">
            @endforeach
        </datalist>
        @error('filiere') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label">Niveau <span class="text-danger">*</span></label>
        <select name="niveau" class="form-select @error('niveau') is-invalid @enderror">
            <option value="">-- Sélectionner --</option>
            @foreach(['L1','L2','L3','M1','M2'] as $n)
                <option value="{{ $n }}" {{ old('niveau', $cour->niveau ?? '') == $n ? 'selected' : '' }}>
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
                <option value="{{ $s }}" {{ old('semestre', $cour->semestre ?? '') == $s ? 'selected' : '' }}>
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
        <select name="annee_academique_id"
            class="form-select @error('annee_academique_id') is-invalid @enderror">
            <option value="">-- Sélectionner --</option>
            @foreach($annees as $annee)
                <option value="{{ $annee->id }}"
                    {{ old('annee_academique_id', $anneeAcademiqueId ?? '') == $annee->id ? 'selected' : '' }}>
                    {{ $annee->libelle }}{{ $annee->active ? ' (active)' : '' }}
                </option>
            @endforeach
        </select>
        @error('annee_academique_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Enseignants assignés</label>
        <select name="enseignants[]" class="form-select @error('enseignants') is-invalid @enderror"
            multiple style="height:120px;">
            @foreach($enseignants as $enseignant)
                <option value="{{ $enseignant->id }}"
                    {{ in_array($enseignant->id, old('enseignants', $enseignantsIds ?? [])) ? 'selected' : '' }}>
                    {{ $enseignant->nom_complet }} — {{ $enseignant->grade }}
                </option>
            @endforeach
        </select>
        <small class="text-muted">
            <i class="bi bi-info-circle me-1"></i>Maintenez Ctrl pour sélectionner plusieurs enseignants
        </small>
        @error('enseignants') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
</div>

{{-- Séquences pédagogiques --}}
<div class="mt-4" x-data="sequencesManager">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0 fw-semibold">
            <i class="bi bi-collection me-2"></i>Séquences pédagogiques
            <span class="badge bg-secondary ms-1" x-text="sequences.length"></span>
        </h6>
        <button type="button" @click="addSequence()" id="bouttonaddsequence" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-plus-circle me-1"></i>Ajouter une séquence
        </button>
    </div>

    @if($errors->has('sequences') || $errors->hasAny(preg_grep('/^sequences\./', array_keys($errors->messages()))))
        <div class="alert alert-danger py-2 mb-3">
            <i class="bi bi-exclamation-triangle me-2"></i>Veuillez corriger les erreurs dans les séquences.
        </div>
    @endif

    <div x-show="sequences.length === 0" class="alert alert-light border text-muted text-center py-3">
        <i class="bi bi-collection me-2"></i>Aucune séquence — cliquez sur « Ajouter une séquence » pour commencer.
    </div>

    <template x-for="(sequence, sIndex) in sequences" :key="sIndex">
        <div class="card mb-3 border">

            <div class="card-header d-flex justify-content-between align-items-center bg-light py-2">
                <span class="fw-semibold small"
                    x-text="'Séquence ' + (sIndex + 1) + (sequence.titre ? ' — ' + sequence.titre : '')">
                </span>
                <button type="button" @click="removeSequence(sIndex)" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-trash"></i>
                </button>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-9">
                        <label class="form-label form-label-sm">Titre <span class="text-danger">*</span></label>
                        <input type="text"
                            :name="'sequences[' + sIndex + '][titre]'"
                            x-model="sequence.titre"
                            class="form-control form-control-sm"
                            placeholder="Ex: Introduction aux concepts de base">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label form-label-sm">Ordre</label>
                        <input type="number"
                            :name="'sequences[' + sIndex + '][ordre]'"
                            x-model="sequence.ordre"
                            class="form-control form-control-sm"
                            min="1">
                    </div>

                    <div class="col-12">
                        <label class="form-label form-label-sm">Description</label>
                        <textarea
                            :name="'sequences[' + sIndex + '][description]'"
                            x-model="sequence.description"
                            class="form-control form-control-sm"
                            rows="2"
                            placeholder="Description de la séquence..."></textarea>
                    </div>

                    {{-- Ressources de la séquence --}}
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="fw-semibold text-muted">
                                <i class="bi bi-journal-bookmark me-1"></i>Ressources pédagogiques
                                <span class="badge bg-light text-dark border ms-1"
                                    x-text="sequence.ressources.length"></span>
                            </small>
                            <button type="button" @click="addRessource(sIndex)"
                                class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-plus me-1"></i>Ajouter une ressource
                            </button>
                        </div>

                        <p x-show="sequence.ressources.length === 0"
                            class="text-muted small fst-italic mb-0 ps-1">
                            Aucune ressource pour cette séquence.
                        </p>

                        <template x-for="(ressource, rIndex) in sequence.ressources" :key="rIndex">
                            <div class="card border-0 bg-light mb-2">
                                <div class="card-body p-3">
                                    <div class="row g-2 align-items-start">

                                        <div class="col-md-5">
                                            <label class="form-label form-label-sm">
                                                Titre <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                :name="'sequences[' + sIndex + '][ressources][' + rIndex + '][titre]'"
                                                x-model="ressource.titre"
                                                class="form-control form-control-sm"
                                                placeholder="Ex: Introduction à Laravel">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label form-label-sm">
                                                Type <span class="text-danger">*</span>
                                            </label>
                                            <select
                                                :name="'sequences[' + sIndex + '][ressources][' + rIndex + '][type]'"
                                                x-model="ressource.type"
                                                class="form-select form-select-sm">
                                                <option value="">-- Type --</option>
                                                <option value="contenu_textuel">Contenu textuel</option>
                                                <option value="video">Vidéo</option>
                                                <option value="document">Document</option>
                                                <option value="quiz">Quiz</option>
                                                <option value="activite_interactive">Activité interactive</option>
                                                <option value="evaluation">Évaluation</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label form-label-sm">
                                                Complexité <span class="text-danger">*</span>
                                            </label>
                                            <select
                                                :name="'sequences[' + sIndex + '][ressources][' + rIndex + '][complexite]'"
                                                x-model="ressource.complexite"
                                                class="form-select form-select-sm">
                                                <option value="">-- Niveau --</option>
                                                <option value="niveau_1">Niveau 1</option>
                                                <option value="niveau_2">Niveau 2</option>
                                                <option value="niveau_3">Niveau 3</option>
                                            </select>
                                        </div>

                                        <div class="col-md-1 d-flex align-items-end justify-content-end">
                                            <button type="button"
                                                @click="removeRessource(sIndex, rIndex)"
                                                class="btn btn-sm btn-outline-danger mb-0">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label form-label-sm">Description</label>
                                            <textarea
                                                :name="'sequences[' + sIndex + '][ressources][' + rIndex + '][description]'"
                                                x-model="ressource.description"
                                                class="form-control form-control-sm"
                                                rows="2"
                                                placeholder="Description de la ressource..."></textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                </div>
            </div>
        </div>
    </template>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('sequencesManager', () => ({
        sequences: [],
        addSequence() {
            this.sequences.push({
                titre: '',
                ordre: this.sequences.length + 1,
                description: '',
                ressources: [],
            });
        },
        removeSequence(index) {
            this.sequences.splice(index, 1);
            this.sequences.forEach((s, i) => { s.ordre = i + 1; });
        },
        addRessource(sIndex) {
            this.sequences[sIndex].ressources.push({
                titre: '',
                type: '',
                complexite: '',
                description: '',
                enseignant_id: '',
            });
        },
        removeRessource(sIndex, rIndex) {
            this.sequences[sIndex].ressources.splice(rIndex, 1);
        },
    }));
});
</script>
