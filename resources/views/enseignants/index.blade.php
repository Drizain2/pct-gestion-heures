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
                            <button type="button" class="btn" style="background-color: white; border:none;">
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
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #0ea5e9 ; color: white;">
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
    @forelse($enseignants as $enseignant)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>
        <div class="d-flex align-items-center">
            <div class="avatar-sm bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center">
                {{ strtoupper(substr($enseignant->prenom, 0, 1) . substr($enseignant->nom, 0, 1)) }}
            </div>
            <strong>{{ $enseignant->nom }}</strong>
        </div>
    </td>
    <td>{{ $enseignant->prenom }}</td>
    <td>{{ $enseignant->email }}</td>
    <td>{{ $enseignant->grade }}</td>
    <td>
        @if($enseignant->statut == 'Permanent')
            <span class="badge bg-success">Permanent</span>
        @elseif($enseignant->statut == 'Vacataire')
            <span class="badge bg-warning text-dark">Vacataire</span>
        @else
            <span class="badge bg-secondary">{{ $enseignant->statut }}</span>
        @endif
    </td>
    <td>{{ $enseignant->departement }}</td>
    <td class="fw-bold">{{ number_format($enseignant->taux_horaire, 0, ',', ' ') }} FCFA</td>
    <td>
        <div class="btn-group">
            <a href="{{ route('enseignants.show', $enseignant->id) }}" class="btn btn-sm btn-info" title="Voir">
                <i class="fas fa-eye"></i>
            </a>
            <a href="{{ route('enseignants.edit', $enseignant->id) }}" class="btn btn-sm btn-primary" title="Modifier">
                <i class="fas fa-edit"></i>
            </a>
            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $enseignant->id }}" title="Supprimer">
                <i class="fas fa-trash"></i>
            </button>
        </div>

        {{-- Modal Confirmation Suppression --}}
        <div class="modal fade" id="deleteModal{{ $enseignant->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmer la suppression</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Tu es sûr de vouloir supprimer <strong>{{ $enseignant->prenom }} {{ $enseignant->nom }}</strong> ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <form action="{{ route('enseignants.destroy', $enseignant->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Oui, supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="9" class="text-center py-4">Aucun enseignant trouvé</td>
</tr>
@endforelse
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
        
        @if($enseignants->count() > 0)
        <tfoot style="border-top: 2px solid #0ea5e9;">
            <tr class="table-secondary fw-bold">
                <td colspan="7" style="text-align:right;">TOTAL TAUX HORAIRE :</td>
                <td style="text-align:right; font-family:monospace;">
                    {{ number_format($enseignants->sum('taux_horaire'), 0, ',', ' ') }} FCFA
                </td>
                <td></td>
            </tr>
        </tfoot>
        @endif
    </table>
                            
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
                                <select name="departement" class="form-control select2" required>
                                    <option value="">Choisir...</option>
                                    <option value="Informatique">Informatique</option>
                                    <option value="Mathématiques">Mathématiques</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Taux horaire <span class="text-danger">*</span></label>
                                <div class="input-group">
                                <input type="number" name="taux_horaire" class="form-control"
                                 min="1000" max="50000" step="500" 
                                 placeholder="Ex: 9000" required>
                                 
                                <span class="input-group-text">FCFA / heure</span>
                            </div>
                            <small class="form-text text-muted"> Entre 1 000 et 50 000 FCFA
                            </div>
                            <div class="form-text">Minimum 1000 FCFA, par pas de 500</div>
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

