<x-app-layout>
    <x-slot name="title">Gestion des Cours</x-slot>

    <div class="page-header">
        <div class="page-header-left">
            <h4>
                <i class="bi bi-book-fill me-2"></i>
                Gestion des Cours
            </h4>
            <p>{{ $cours->total() }} cours enregistré(s)</p>
        </div>
        <a href="{{ route('cours.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Nouveau cours
        </a>
    </div>

    <!-- Filtres -->
    <div class="filter-card">
        <form method="GET" action="{{ route('cours.index') }}">
            <div class="filter-grid">
                <div class="filter-field">
                    <label class="form-label">Recherche</label>
                    <input type="text" name="search" class="form-control" placeholder="Intitulé, filière..."
                        value="{{ request('search') }}">
                </div>
                <div class="filter-field">
                    <label class="form-label">Niveau</label>
                    <select name="niveau" class="form-select">
                        <option value="">Tous les niveaux</option>
                        @foreach(['L1', 'L2', 'L3', 'M1', 'M2'] as $n)
                            <option value="{{ $n }}" {{ request('niveau') == $n ? 'selected' : '' }}>
                                {{ $n }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-field">
                    <label class="form-label">Semestre</label>
                    <select name="semestre" class="form-select">
                        <option value="">Tous les semestres</option>
                        @foreach(['S1', 'S2', 'S3', 'S4', 'S5', 'S6', 'S7', 'S8', 'S9', 'S10'] as $s)
                            <option value="{{ $s }}" {{ request('semestre') == $s ? 'selected' : '' }}>
                                {{ $s }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i> Filtrer
                    </button>
                    <a href="{{ route('cours.index') }}" class="btn btn-outline-secondary" title="Réinitialiser">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tableau -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Intitulé</th>
                            <th>Filière</th>
                            <th>Niveau</th>
                            <th>Semestre</th>
                            <th>Heures</th>
                            <th>Crédits</th>
                            <th>Enseignants</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cours as $c)
                            <tr>
                                <td class="text-muted">{{ $loop->iteration }}</td>
                                <td><strong>{{ $c->intitule }}</strong></td>
                                <td>{{ $c->filiere }}</td>
                                <td>
                                    <span class="badge badge-blue me-1 mb-1">
                                        {{ $c->niveau }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-gray">{{ $c->semestre }}</span>
                                </td>
                                <td>{{ $c->nombre_heures }}h</td>
                                <td>{{ $c->nombre_credits }}</td>
                                <td>
                                    @forelse($c->enseignants as $enseignant)
                                        <span class="badge badge-navy">
                                            {{ $enseignant->nom_complet }}
                                        </span>
                                    @empty
                                        <span class="text-muted small">Aucun enseignant</span>
                                    @endforelse
                                </td>
                                <td>
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('cours.show', $c) }}" class="btn btn-sm btn-outline-success"
                                            data-bs-toggle="tooltip" title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('cours.edit', $c) }}" class="btn btn-sm btn-outline-warning"
                                            data-bs-toggle="tooltip" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form method="POST" action="{{ route('cours.destroy', $c) }}"
                                            onsubmit="return confirm('Supprimer ce cours ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="bi bi-book" style="font-size: 3.5rem; color: #cbd5e1;"></i>
                                        <h5 class="mt-3 fw-semibold">Aucun cours enregistré</h5>
                                        <p class="text-muted mb-3">
                                            Commence par ajouter ton premier cours pour l’année académique en cours.
                                        </p>
                                        <a href="{{ route('cours.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-lg me-1"></i> Nouveau cours
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($cours->hasPages())
            <div class="card-footer d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Affichage de {{ $cours->firstItem() }}
                    à {{ $cours->lastItem() }}
                    sur {{ $cours->total() }} résultats
                </small>
                {{ $cours->withQueryString()->links() }}
            </div>
        @endif
    </div>

    <!-- ========================================= -->
    <!-- GESTION DES RESSOURCES PEDAGOGIQUES -->
    <!-- ========================================= -->

    <div class="container py-4">

        <!-- Titre -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h2 class="fw-bold mb-3 align-items-center fs-5" style="color:var(---blue);">
                    <i class="bi bi-book-fill me-2"></i>
                    Gestion des ressources pédagogiques
                </h2>

                <p class="text-muted mb-0">
                    Ajoutez des vidéos, PDF, contenus textuels et documents pédagogiques
                    pour chaque cours.
                </p>
            </div>
        </div>

        <!-- FORMULAIRE COMPLET -->
        <div class="card shadow-sm border-0 mb-4">

            <div class="card-header">
                <i class="bi bi-book me-2"></i>Informations du cours &amp; Ressources pédagogiques
            </div>

            <div class="card-body">

                <div class="row g-3">

                    <!-- Informations du cours -->

                    <div class="col-md-6">
                        <label class="form-label">Nom du cours</label>
                        <input type="text" class="form-control" placeholder="Ex : Développement Web">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nom du professeur</label>
                        <input type="text" class="form-control" placeholder="Ex : M. Koffi Jean">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Filière</label>
                        <select class="form-select">
                            <option>Choisir une filière</option>
                            <option>Developpement d'Applications</option>
                            <option>Marketing Digital</option>
                            <option>Base de Données</option>
                            <option>Data Science</option>
                            <option>Cybersécurité</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Niveau</label>
                        <select class="form-select">
                            <option>L1</option>
                            <option>L2</option>
                            <option>L3</option>
                            <option>M1</option>
                            <option>M2</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">semestre</label>
                        <select class="form-select">
                            <option>S1</option>
                            <option>S2</option>
                            <option>S3</option>
                            <option>S4</option>
                            <option>S5</option>
                            <option>S6</option>
                            <option>S7</option>
                            <option>S8</option>
                            <option>S9</option>
                            <option>S10</option>
                        </select>
                    </div>


                    <div class="col-md-4">
                        <label class="form-label">Séquence pédagogique</label>
                        <input type="text" class="form-control" placeholder="Ex : Séquence 1">
                    </div>

                    <!-- Ressources pédagogiques -->

                    <div class="col-md-4">
                        <label class="form-label">Type de ressource</label>
                        <select class="form-select">
                            <option>Vidéo pédagogique</option>
                            <option>PDF</option>
                            <option>Contenu textuel</option>
                            <option>Document pédagogique</option>
                            <option>Quiz</option>
                            <option>Évaluation</option>
                            <option>Activité interactive</option>
                        </select>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Titre de la ressource</label>
                        <input type="text" class="form-control" placeholder="Ex : Introduction à Laravel">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="4"
                            placeholder="Décrivez la ressource pédagogique..."></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ajouter une vidéo</label>
                        <input type="file" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ajouter un PDF / document</label>
                        <input type="file" class="form-control">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Contenu textuel</label>
                        <textarea class="form-control" rows="5"
                            placeholder="Saisissez le contenu pédagogique ici..."></textarea>
                    </div>

                    <!-- Bouton -->

                    <div class="col-md-12 text-end mt-3">
                        <button class="btn btn-primary px-4">
                            <i class="bi bi-plus-circle me-2"></i>
                            Enregistrer la ressource
                        </button>
                    </div>

                </div>

            </div>
        </div>

        <!-- Tableau des ressources -->

        <div class="card shadow-sm border-0">

            <div class="card-header">
                <i class="bi bi-table me-2"></i>Liste des ressources pédagogiques
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Titre</th>
                                <th>Professeur</th>
                                <th>Filière</th>
                                <th>Fichier</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td>1</td>
                                <td>
                                    <span class="badge badge-red">
                                        Vidéo
                                    </span>
                                </td>
                                <td>Introduction HTML</td>
                                <td>M. Koffi Jean</td>
                                <td>Génie Logiciel</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        Voir
                                    </a>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning">
                                        Modifier
                                    </button>

                                    <button class="btn btn-sm btn-danger">
                                        Supprimer
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>2</td>
                                <td>
                                    <span class="badge badge-gray">
                                        PDF
                                    </span>
                                </td>
                                <td>Guide Bootstrap</td>
                                <td>Mme Konan</td>
                                <td>Data Science</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-success">
                                        Télécharger
                                    </a>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning">
                                        Modifier
                                    </button>

                                    <button class="btn btn-sm btn-danger">
                                        Supprimer
                                    </button>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>
        </div>

    </div>












</x-app-layout>