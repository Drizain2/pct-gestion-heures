<form
    action="{{ isset($enseignant) ? route('enseignants.update', $enseignant->id) : route('enseignants.store') }}"
    method="POST"
    class="needs-validation"
    novalidate
>
    @csrf
    @if(isset($enseignant))
        @method('PUT')
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h2 class="h5 mb-0">
                {{ isset($enseignant) ? 'Modifier un enseignant' : 'Créer un nouvel enseignant' }}
            </h2>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <!-- Ligne 1: Nom et Prénom -->
                <div class="col-md-6">
                    <label for="nom" class="form-label">
                        Nom <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control @error('nom') is-invalid @enderror"
                        id="nom"
                        name="nom"
                        value="{{ old('nom', $enseignant->nom ?? '') }}"
                        required
                    >
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="prenom" class="form-label">
                        Prénom <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control @error('prenom') is-invalid @enderror"
                        id="prenom"
                        name="prenom"
                        value="{{ old('prenom', $enseignant->prenom ?? '') }}"
                        required
                    >
                    @error('prenom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Ligne 2: Grade et Statut -->
                <div class="col-md-6">
                    <label for="grade" class="form-label">
                        Grade <span class="text-danger">*</span>
                    </label>
                    {{-- <input
                        type="text"
                        class="form-control @error('grade') is-invalid @enderror"
                        id="grade"
                        name="grade"
                        value="{{ old('grade', $enseignant->grade ?? '') }}"
                        required
                    > --}}
                    <select class="form-select @error('grade') is-invalid @enderror"
                        id="grade"
                        name="grade"
                        required>
                    <option value="" selected disabled>Sélectionnez un grade</option>
                    @foreach (["Assistant","Maitre-Assistant","Professeur"] as $grade )
                        <option value="{{ $grade }}" {{ old('grade', $enseignant->grade ?? '') == $grade ? 'selected' : '' }}>
                            {{ $grade }}
                        </option>
                    @endforeach
                    </select>
                    @error('grade')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="statut" class="form-label">
                        Statut <span class="text-danger">*</span>
                    </label>
                    <select
                        class="form-select @error('statut') is-invalid @enderror"
                        id="statut"
                        name="statut"
                        required
                    >
                        <option value="" selected disabled>Sélectionnez un statut</option>
                        <option value="Permanent" {{ old('statut', $enseignant->statut ?? '') == 'Permanent' ? 'selected' : '' }}>
                            Permanent
                        </option>
                        {{-- <option value="Contractuel" {{ old('statut', $enseignant->statut ?? '') == 'Contractuel' ? 'selected' : '' }}>
                            Contractuel
                        </option> --}}
                        <option value="Vacataire" {{ old('statut', $enseignant->statut ?? '') == 'Vacataire' ? 'selected' : '' }}>
                            Vacataire
                        </option>
                    </select>
                    @error('statut')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Ligne 3: Département et Email -->
                <div class="col-md-6">
                    <label for="departement" class="form-label">
                        Département <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control @error('departement') is-invalid @enderror"
                        id="departement"
                        name="departement"
                        value="{{ old('departement', $enseignant->departement ?? '') }}"
                        required
                    >
                    @error('departement')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">
                        Email <span class="text-danger">*</span>
                    </label>
                    <input
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        id="email"
                        name="email"
                        value="{{ old('email', $enseignant->email ?? '') }}"
                        required
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Ligne 4: Téléphone et Taux horaire -->
                <div class="col-md-6">
                    <label for="telephone" class="form-label">Téléphone</label>
                    <input
                        type="text"
                        class="form-control @error('telephone') is-invalid @enderror"
                        id="telephone"
                        name="telephone"
                        value="{{ old('telephone', $enseignant->telephone ?? '') }}"
                    >
                    @error('telephone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="taux_horaire" class="form-label">
                        Taux horaire (FCFA) <span class="text-danger">*</span>
                    </label>
                    <input
                        type="number"
                        step="0.01"
                        class="form-control @error('taux_horaire') is-invalid @enderror"
                        id="taux_horaire"
                        name="taux_horaire"
                        value="{{ old('taux_horaire', $enseignant->taux_horaire ?? '') }}"
                        required
                    >
                    @error('taux_horaire')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer bg-transparent d-flex justify-content-end gap-2">
            <a href="{{ route('enseignants.index') }}" class="btn btn-outline-secondary">
                Annuler
            </a>
            <button type="submit" class="btn btn-primary">
                {{ isset($enseignant) ? 'Mettre à jour' : 'Enregistrer' }}
            </button>
        </div>
        @if(!isset($enseignant))
           <div class="col-12">
               <div class="alert py-2" style="background: #f0fdf4;border-left:4px solid #2E7D32;">
                   <i class="bi bi-info-circle me-2" style="color: #2E7D32;"></i>
                   Un compte d'enseignant sera créer pour cet enseignant avec l'email saisie.
                   Le mot de passe par defaut sera : <strong>uvci@2026</strong>.
               </div>
           </div>
           @endif
    </div>
</form>

<!-- Script pour la validation côté client -->
<script>
    (function () {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>