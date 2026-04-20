<!-- resources/views/activites/create.blade.php -->
<x-app-layout>
    <x-slot name="title">Nouvelle activité</x-slot>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-plus-circle-fill me-2"></i>Enregistrer une activité
                </div>
                <div class="card-body p-4">

                    <!-- Info calcul automatique -->
                    <div class="alert alert-success py-2 mb-4">
                        <i class="bi bi-calculator me-2"></i>
                        Les heures sont <strong>calculées automatiquement</strong>
                        selon le type et la complexité de la ressource.
                    </div>

                    <form method="POST" action="{{ route('activites.store') }}">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">
                                    Enseignant <span class="text-danger">*</span>
                                </label>
                                <select name="enseignant_id"
                                    class="form-select @error('enseignant_id') is-invalid @enderror"
                                    {{ auth()->user()->hasRole('enseignant') ? 'disabled' : '' }}>
                                    <option value="">-- Sélectionner --</option>
                                    @foreach ($enseignants as $e)
                                        <option value="{{ $e->id }}"
                                            {{ old('enseignant_id', $enseignantSelectionne) == $e->id ? 'selected' : '' }}>
                                            {{ $e->nom_complet }}
                                        </option>
                                    @endforeach
                                </select>
                                @if (auth()->user()->hasRole('enseignant'))
                                    <input type="hidden" name="enseignant_id" value="{{ $enseignantSelectionne }}">
                                @endif
                                @error('enseignant_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Date de l'activité <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="date_activite"
                                    class="form-control @error('date_activite') is-invalid @enderror"
                                    value="{{ old('date_activite', date('Y-m-d')) }}">
                                @error('date_activite')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">
                                    Ressource concernée <span class="text-danger">*</span>
                                </label>
                                <select name="ressource_id"
                                    class="form-select @error('ressource_id') is-invalid @enderror"
                                    id="ressource_select">
                                    <option value="">-- Sélectionner une ressource --</option>
                                    @foreach ($ressources as $ressource)
                                        <option value="{{ $ressource->id }}"
                                            data-niveau="{{ $ressource->complexite_label }}"
                                            data-sequences="{{ $ressource->sequence->cours?->sequences()->count() }}"
                                            {{ old('ressource_id') == $ressource->id ? 'selected' : '' }}>
                                            {{ $ressource->titre }}
                                            ({{ $ressource->sequence->cours?->intitule }}
                                            — {{ $ressource->complexite_label }})
                                        </option>
                                    @endforeach
                                </select>

                                <!-- Info calcul en temps réel -->
                                <div class="alert alert-info py-2 mt-2" style="display: none" id="calcul_info">
                                    <i class="bi bi-calculator me-2"></i>
                                    <strong>Aperçu du calcul :</strong>
                                    <span id="calcul_detail"></span>
                                </div>
                                @error('ressource_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Info ressource sélectionnée -->
                            <div class="col-12" id="ressource_info" style="display:none;">
                                <div class="alert py-2" style="background:#f0fdf4; border-left:4px solid #2E7D32;">
                                    <strong>Ressource :</strong>
                                    <span id="info_type"></span> —
                                    <span id="info_complexite"></span>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">
                                    Type d'action <span class="text-danger">*</span>
                                </label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type_action" id="creation"
                                            value="creation" {{ old('type_action') == 'creation' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="creation">
                                            <span class="badge bg-success me-1">Création</span>
                                            Nouvelle ressource produite
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type_action"
                                            id="mise_a_jour" value="mise_a_jour"
                                            {{ old('type_action') == 'mise_a_jour' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="mise_a_jour">
                                            <span class="badge" style="background:#1565C0;">
                                                Mise à jour
                                            </span>
                                            Ressource existante mise à jour
                                        </label>
                                    </div>
                                </div>
                                @error('type_action')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Commentaire</label>
                                <textarea name="commentaire" class="form-control" rows="3" placeholder="Détails optionnels sur l'activité...">{{ old('commentaire') }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('activites.index') }}" class="btn btn-outline-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Affiche les infos de la ressource sélectionnée
            document.getElementById('ressource_select').addEventListener('change', function() {
                const option = this.options[this.selectedIndex];
                const info = document.getElementById('calcul_info');
                const typeAction = document.querySelector('input[name="type_action"]:checked');
                const detail = document.getElementById("calcul_detail")

                if (this.value && typeAction) {
                    const nbSeq = option.dataset.sequences;
                    const niveau = option.dataset.niveau;
                    info.style.display = "flex";
                    detail.textContent = `${nbSeq} séquence(s) × coefficient (${niveau}) = calcul auto a la sauvegarde`
                } else {
                    info.style.display = 'none';
                }
            });

            document.querySelectorAll('input[name="type_action"]').forEach(radio => {
                radio.addEventListener("change", () => {
                    document.getElementById("ressource_select").dispatchEvent(new Event("change"));
                })
            })
        </script>
    @endpush
</x-app-layout>
