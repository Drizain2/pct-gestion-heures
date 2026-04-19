<!-- resources/views/cours/show.blade.php -->
<x-app-layout>
    <x-slot name="title">Détail du cours</x-slot>

    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('cours.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Retour
                </a>
                <a href="{{ route('cours.edit', $cour) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil me-1"></i>Modifier
                </a>
                <a href="{{ route('cours.sequences.create', $cour) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil me-1"></i>créer
                </a>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-book-fill me-2"></i>{{ $cour->intitule }}
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <small class="text-muted d-block">Filière</small>
                            <strong>{{ $cour->filiere }}</strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Niveau</small>
                            <span class="badge" style="background:#2E7D32;">{{ $cour->niveau }}</span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Semestre</small>
                            <span class="badge bg-secondary">{{ $cour->semestre }}</span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Nombre d'heures</small>
                            <strong>{{ $cour->nombre_heures }}h</strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Crédits</small>
                            <strong>{{ $cour->nombre_credits }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enseignants assignés -->
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-people-fill me-2"></i>Enseignants assignés
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nom complet</th>
                                <th>Grade</th>
                                <th>Statut</th>
                                <th>Année académique</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cour->enseignants as $enseignant)
                            <tr>
                                <td>{{ $enseignant->nom_complet }}</td>
                                <td>
                                    <span class="badge" style="background:#E65100;">
                                        {{ $enseignant->grade }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $enseignant->statut === 'Permanent' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ $enseignant->statut }}
                                    </span>
                                </td>
                                <td>{{ $enseignant->pivot->annee_academique }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    Aucun enseignant assigné
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>