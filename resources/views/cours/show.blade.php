<x-app-layout>
    <x-slot name="title">{{ $cour->intitule }}</x-slot>

    {{-- Page header --}}
    <div class="page-header">
        <div class="page-header-left">
            <h4><i class="bi bi-book-fill me-2"></i>{{ $cour->intitule }}</h4>
            <p>{{ $cour->filiere }} &middot; {{ $cour->niveau }} &middot; {{ $cour->semestre }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('cours.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Retour
            </a>
            <a href="{{ route('cours.edit', $cour) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil me-1"></i>Modifier
            </a>
        </div>
    </div>

    {{-- Stat cards --}}
    @php
        $totalRessources = $cour->sequences->sum(fn($s) => $s->ressources->count());
    @endphp
    <div class="row g-4 mb-4">
        <div class="col-6 col-xl-3">
            <div class="stat-card blue">
                <div class="stat-icon"><i class="bi bi-clock-fill"></i></div>
                <div class="stat-info">
                    <div class="stat-number">{{ $cour->nombre_heures }}h</div>
                    <div class="stat-label">Nombre d'heures</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="stat-card green">
                <div class="stat-icon"><i class="bi bi-award-fill"></i></div>
                <div class="stat-info">
                    <div class="stat-number">{{ $cour->nombre_credits }}</div>
                    <div class="stat-label">Crédits</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="stat-card orange">
                <div class="stat-icon"><i class="bi bi-collection-fill"></i></div>
                <div class="stat-info">
                    <div class="stat-number">{{ $cour->sequences->count() }}</div>
                    <div class="stat-label">Séquences</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="stat-card navy">
                <div class="stat-icon"><i class="bi bi-journal-bookmark-fill"></i></div>
                <div class="stat-info">
                    <div class="stat-number">{{ $totalRessources }}</div>
                    <div class="stat-label">Ressources</div>
                </div>
            </div>
        </div>
    </div>
    {{-- Infos + Enseignants --}}
    <div class="row g-4 mb-4">
        {{-- Infos du cours --}}
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2"></i>Informations du cours
                </div>
                <div class="card-body">
                    <dl class="row g-0 mb-0">
                        <dt class="col-5 text-muted fw-normal small">Filière</dt>
                        <dd class="col-7 fw-semibold mb-3">{{ $cour->filiere }}</dd>
                        <dt class="col-5 text-muted fw-normal small">Niveau</dt>
                        <dd class="col-7 mb-3">
                            <span class="badge badge-blue">{{ $cour->niveau }}</span>
                        </dd>
                        <dt class="col-5 text-muted fw-normal small">Semestre</dt>
                        <dd class="col-7 mb-3">
                            <span class="badge badge-gray">{{ $cour->semestre }}</span>
                        </dd>
                        <dt class="col-5 text-muted fw-normal small">Heures</dt>
                        <dd class="col-7 fw-semibold mb-3">{{ $cour->nombre_heures }}h</dd>

                        <dt class="col-5 text-muted fw-normal small">Crédits</dt>
                        <dd class="col-7 fw-semibold mb-3">{{ $cour->nombre_credits }}</dd>

                        <dt class="col-5 text-muted fw-normal small">Créé le</dt>
                        <dd class="col-7 mb-0 small">{{ $cour->created_at->format('d/m/Y') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        {{-- Enseignants assignés --}}
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-people-fill me-2"></i>Enseignants assignés</span>
                    <span class="badge badge-blue">{{ $cour->enseignants->count() }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Nom complet</th>
                                    <th>Grade</th>
                                    <th>Statut</th>
                                    <th>Département</th>
                                    <th>Année académique</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cour->enseignants as $enseignant)
                                    <tr>
                                        <td class="fw-semibold">{{ $enseignant->nom_complet }}</td>
                                        <td>
                                            <span class="badge badge-navy">{{ $enseignant->grade }}</span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $enseignant->statut === 'Permanent' ? 'badge-green' : 'badge-orange' }}">
                                                {{ $enseignant->statut }}
                                            </span>
                                        </td>
                                        <td class="text-muted small">{{ $enseignant->departement ?? '—' }}</td>
                                        <td class="small">
                                            {{ $annees[$enseignant->pivot->annee_academique_id] ?? '—' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="bi bi-person-x me-2"></i>Aucun enseignant assigné
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Séquences pédagogiques --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-collection me-2"></i>Séquences pédagogiques</span>
            <div class="d-flex align-items-center gap-2">
                <span class="badge badge-gray">{{ $cour->sequences->count() }} séquence(s)</span>
                <button type="button" class="btn btn-sm btn-primary"
                    data-bs-toggle="modal" data-bs-target="#modalAddSequence"
                    data-ordre="{{ $cour->sequences->max('ordre') + 1 }}">
                    <i class="bi bi-plus-lg me-1"></i>Ajouter
                </button>
            </div>
        </div>

        @if($cour->sequences->isEmpty())
            <div class="card-body text-center text-muted py-5">
                <i class="bi bi-collection" style="font-size:2.5rem; color:#cbd5e1;"></i>
                <p class="mt-3 mb-1">Aucune séquence enregistrée pour ce cours.</p>
                <button type="button" class="btn btn-sm btn-outline-primary mt-2"
                    data-bs-toggle="modal" data-bs-target="#modalAddSequence"
                    data-ordre="1">
                    <i class="bi bi-plus-lg me-1"></i>Créer la première séquence
                </button>
            </div>
        @else
            <div class="accordion accordion-flush" id="accordionSequences">
                @foreach($cour->sequences as $sequence)
                    <div class="accordion-item border-bottom">

                        {{-- En-tête séquence --}}
                        <h2 class="accordion-header d-flex align-items-stretch">
                            <button class="accordion-button flex-grow-1 {{ $loop->first ? '' : 'collapsed' }} py-3"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#seq-{{ $sequence->id }}"
                                aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                                <div class="d-flex align-items-center gap-3 w-100 me-2">
                                    <span class="badge badge-blue flex-shrink-0">
                                        {{ str_pad($sequence->ordre, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                    <span class="fw-semibold">{{ $sequence->titre }}</span>
                                    <span class="ms-auto badge badge-gray flex-shrink-0">
                                        {{ $sequence->ressources->count() }} ressource(s)
                                    </span>
                                </div>
                            </button>
                            {{-- Actions hors du bouton accordion --}}
                            <div class="d-flex align-items-center gap-1 px-3 border-start bg-light">
                                <form method="POST"
                                    action="{{ route('cours.sequences.destroy', [$cour, $sequence]) }}"
                                    onsubmit="return confirm('Supprimer la séquence « {{ addslashes($sequence->titre) }} » et toutes ses ressources ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        title="Supprimer la séquence">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </h2>

                        {{-- Corps séquence --}}
                        <div id="seq-{{ $sequence->id }}"
                            class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                            data-bs-parent="#accordionSequences">
                            <div class="accordion-body pt-3 pb-3 px-4">
                                {{-- Barre d'action ressources --}}
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="fw-semibold text-muted">
                                        <i class="bi bi-journal-bookmark me-1"></i>Ressources
                                    </small>
                                    <button type="button"
                                        class="btn btn-sm btn-outline-primary btn-add-ressource"
                                        data-bs-toggle="modal" data-bs-target="#modalAddRessource"
                                        data-action="{{ route('cours.sequences.ressources.store', [$cour, $sequence]) }}"
                                        data-sequence="{{ $sequence->titre }}">
                                        <i class="bi bi-plus-lg me-1"></i>Ajouter une ressource
                                    </button>
                                </div>

                                @if($sequence->ressources->isEmpty())
                                    <p class="text-muted small fst-italic mb-0">
                                        Aucune ressource pour cette séquence.
                                    </p>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Titre</th>
                                                    <th>Type</th>
                                                    <th>Complexité</th>
                                                    <th>Enseignant</th>
                                                    <th>Description</th>
                                                    <th style="width:60px;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($sequence->ressources as $ressource)
                                                    @php
                                                        $typeBadge = match($ressource->type) {
                                                            'contenu_textuel'      => 'badge-green',
                                                            'video'                => 'badge-blue',
                                                            'document'             => 'badge-gray',
                                                            'quiz'                 => 'badge-red',
                                                            'activite_interactive' => 'badge-orange',
                                                            'evaluation'           => 'badge-navy',
                                                            default                => 'badge-gray',
                                                        };
                                                        $complexiteBadge = match($ressource->complexite) {
                                                            'niveau_1' => 'badge-green',
                                                            'niveau_2' => 'badge-orange',
                                                            'niveau_3' => 'badge-red',
                                                            default    => 'badge-gray',
                                                        };
                                                    @endphp
                                                    <tr>
                                                        <td class="fw-semibold">{{ $ressource->titre }}</td>
                                                        <td>
                                                            <span class="badge {{ $typeBadge }}">
                                                                {{ $ressource->type_label }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge {{ $complexiteBadge }}">
                                                                {{ $ressource->complexite_label }}
                                                            </span>
                                                        </td>
                                                        <td class="small text-muted">
                                                            {{ $ressource->enseignant?->nom_complet ?? '—' }}
                                                        </td>
                                                        <td class="small text-muted" style="max-width:200px;">
                                                            {{ Str::limit($ressource->description, 60) ?: '—' }}
                                                        </td>
                                                        <td>
                                                            <form method="POST"
                                                                action="{{ route('cours.sequences.ressources.destroy', [$cour, $sequence, $ressource]) }}"
                                                                onsubmit="return confirm('Supprimer cette ressource ?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-danger"
                                                                    title="Supprimer">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Modal : Ajouter une séquence --}}
    <div class="modal fade" id="modalAddSequence" tabindex="-1" aria-labelledby="modalAddSequenceLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('cours.sequences.store', $cour) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddSequenceLabel">
                            <i class="bi bi-plus-circle me-2"></i>Nouvelle séquence
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-9">
                                <label class="form-label">Titre <span class="text-danger">*</span></label>
                                <input type="text" name="titre" class="form-control"
                                    placeholder="Ex: Introduction aux concepts de base" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Ordre</label>
                                <input type="number" name="ordre" id="inputOrdre"
                                    class="form-control" min="1" value="{{ $cour->sequences->max('ordre') + 1 }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3"
                                    placeholder="Description de la séquence..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal : Ajouter une ressource --}}
    <div class="modal fade" id="modalAddRessource" tabindex="-1" aria-labelledby="modalAddRessourceLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form method="POST" id="formAddRessource" action="">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddRessourceLabel">
                            <i class="bi bi-journal-plus me-2"></i>Nouvelle ressource
                            <small class="text-muted fw-normal ms-2" id="modalRessourceSequence"></small>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Titre <span class="text-danger">*</span></label>
                                <input type="text" name="titre" class="form-control"
                                    placeholder="Ex: Introduction à Laravel" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Type <span class="text-danger">*</span></label>
                                <select name="type" class="form-select" required>
                                    <option value="">-- Choisir un type --</option>
                                    <option value="contenu_textuel">Contenu textuel</option>
                                    <option value="video">Vidéo</option>
                                    <option value="document">Document</option>
                                    <option value="quiz">Quiz</option>
                                    <option value="activite_interactive">Activité interactive</option>
                                    <option value="evaluation">Évaluation</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Complexité <span class="text-danger">*</span></label>
                                <select name="complexite" class="form-select" required>
                                    <option value="">-- Choisir un niveau --</option>
                                    <option value="niveau_1">Niveau 1 — Contenus simples</option>
                                    <option value="niveau_2">Niveau 2 — Activités interactives</option>
                                    <option value="niveau_3">Niveau 3 — Serious games / simulations</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3"
                                    placeholder="Description de la ressource..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Mettre à jour l'ordre dans le modal séquence
        document.querySelectorAll('[data-bs-target="#modalAddSequence"]').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('inputOrdre').value = btn.dataset.ordre ?? 1;
            });
        });

        // Mettre à jour l'action du formulaire ressource selon la séquence choisie
        document.querySelectorAll('.btn-add-ressource').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('formAddRessource').action = btn.dataset.action;
                document.getElementById('modalRessourceSequence').textContent = '— ' + btn.dataset.sequence;
            });
        });
    </script>
    @endpush

</x-app-layout>