<x-app-layout>
    <div class="page-wrapper">

        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Liste des enseignants</h1>
                <a href="{{ route('enseignants.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Ajouter un enseignant
                </a>
            </div>

            <!-- Barre de recherche -->
            <div class="filter-card">
                <form action="{{ route('enseignants.index') }}" method="GET">
                    <div class="filter-grid">
                        <div class="filter-field">
                            <input type="text" name="search" class="form-control"
                                placeholder="Rechercher par nom, prénom, email..." value="{{ request('search') }}">
                        </div>
                        <div class="filter-field">
                            <select name="grade" class="form-select">
                                <option value="">Tous les grades</option>
                                <option value="Assistant" {{ request('grade') == 'Assistant' ? 'selected' : '' }}>
                                    Assistant
                                </option>
                                <option value="Maitre-Assistant"
                                    {{ request('grade') == 'Maitre-Assistant' ? 'selected' : '' }}>
                                    Maître-Assistant</option>
                                <option value="Professeur" {{ request('grade') == 'Professeur' ? 'selected' : '' }}>
                                    Professeur
                                </option>
                            </select>
                        </div>
                        <div class="filter-field">
                            <select name="statut" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="Permanent" {{ request('statut') == 'Permanent' ? 'selected' : '' }}>
                                    Permanent
                                </option>
                                <option value="Vacataire" {{ request('statut') == 'Vacataire' ? 'selected' : '' }}>
                                    Vacataire
                                </option>
                            </select>
                        </div>
                        <div class="filter-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> Rechercher
                            </button>
                            <a href="{{ route('enseignants.index') }}" class="btn btn-ghost" title="Réinitialiser">
                                <i class="bi bi-arrow-clockwise"></i> Réinitialiser
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tableau des enseignants -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Prénom</th>
                                <th scope="col">Email</th>
                                <th scope="col">Grade</th>
                                <th scope="col" class="text-center">Statut</th>
                                <th scope="col">Département</th>
                                <th scope="col">Taux horaire</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($enseignants as $enseignant)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $enseignant->nom }}</td>
                                    <td>{{ $enseignant->prenom }}</td>
                                    <td>{{ $enseignant->email }}</td>
                                    <td>{{ $enseignant->grade }}</td>
                                  <td class="text-center">
                                     <span class="badge {{ strtolower(trim($enseignant->statut)) == 'permanent' ? 'badge-green' : 'badge-blue' }}">
                                    {{ ucfirst(strtolower($enseignant->statut)) }}
                                    </span>
                                 </td>
                                    <td>{{ $enseignant->departement }}</td>
                                    <td>{{ number_format($enseignant->taux_horaire, 0, ',', ' ') }} FCFA</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- Bouton Voir -->
                                            <a href="{{ route('enseignants.show', $enseignant->id) }}"
                                                class="btn btn-sm btn-outline-info" title="Voir les détails">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <!-- Bouton Modifier -->
                                            <a href="{{ route('enseignants.edit', $enseignant->id) }}"
                                                class="btn btn-sm btn-outline-primary" title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <!-- Bouton Supprimer -->
                                            <form action="{{ route('enseignants.destroy', $enseignant->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet enseignant ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    title="Supprimer">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        Aucun enseignant trouvé.
                                    </td>
                                    <tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $enseignant->nom }}</td>
    <td>{{ $enseignant->prenoms }}</td>
    <td>{{ $enseignant->email }}</td>
    <td>{{ $enseignant->statut }}</td>
    <td>{{ $enseignant->departement }}</td>
    <td>{{ $enseignant->taux_horaire }}</td>
    
    <!-- Colle ici à la place de ton ancien <td> Actions -->
    <td>
        <div class="d-none d-md-inline-flex">
            <a href="{{ route('enseignants.show', $enseignant->id) }}" class="btn btn-info btn-sm mr-1" title="Voir">
                <i class="fas fa-eye"></i>
            </a>
            <a href="{{ route('enseignants.edit', $enseignant->id) }}" class="btn btn-warning btn-sm mr-1" title="Modifier">
                <i class="fas fa-edit"></i>
            </a>
            <form action="{{ route('enseignants.destroy', $enseignant->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" title="Supprimer" onclick="return confirm('Supprimer ?')">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
       <div class="dropdown d-inline-block d-md-none">
    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
        <i class="fas fa-ellipsis-v"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="{{ route('enseignants.show', $enseignant->id) }}">
            <i class="fas fa-eye text-info mr-2"></i> Voir
        </a>
        <a class="dropdown-item btn-edit" href="#"
           data-id="{{ $enseignant->id }}"
           data-nom="{{ $enseignant->nom }}"
           data-prenoms="{{ $enseignant->prenoms }}"
           data-email="{{ $enseignant->email }}"
           data-departement="{{ $enseignant->departement }}"
           data-taux="{{ $enseignant->taux_horaire }}">
            <i class="fas fa-edit text-warning mr-2"></i> Modifier
        </a>
        <div class="dropdown-divider"></div>
        <form action="{{ route('enseignants.destroy', $enseignant->id) }}" method="POST" class="form-delete">
            @csrf
            @method('DELETE')
            <button type="button" class="dropdown-item text-danger btn-delete">
                <i class="fas fa-trash mr-2"></i> Supprimer
            </button>
        </form>
    </div>
</div>
    </td>
</tr>

                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $enseignants->links('pagination::bootstrap-5') }}
        </div>
    </div>
<!-- Modal Ajouter/Modifier Enseignant -->
<div class="modal fade" id="enseignantModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="modalTitle">Ajouter un enseignant</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="enseignantForm" method="POST">
                @csrf
                <div id="methodField"></div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nom</label>
                                <input type="text" name="nom" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Prénoms</label>
                                <input type="text" name="prenoms" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Département</label>
                                <select name="departement" class="form-control" required>
                                    <option value="">Choisir...</option>
                                    <option value="Informatique">Informatique</option>
                                    <option value="Mathématiques">Mathématiques</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Taux horaire</label>
                                <input type="number" name="taux_horaire" class="form-control" required>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-app-layout>

