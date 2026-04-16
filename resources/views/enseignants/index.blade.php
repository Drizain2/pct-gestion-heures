<x-app-layout>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Liste des enseignants</h1>
            <a href="{{ route('enseignants.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Ajouter un enseignant
            </a>
        </div>

        <!-- Barre de recherche -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('enseignants.index') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control"
                            placeholder="Rechercher par nom, prénom, email..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="bi bi-search me-1"></i> Rechercher
                        </button>
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
                                <th scope="col">Statut</th>
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
                                    <td>
                                        <span
                                            class="badge
                                        @if ($enseignant->statut == 'permanent') bg-success
                                        @elseif($enseignant->statut == 'contractuel') bg-warning
                                        @else bg-info @endif">
                                            {{ ucfirst($enseignant->statut) }}
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
</x-app-layout>
