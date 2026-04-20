<!-- resources/views/activites/index.blade.php -->
<x-app-layout>
    <x-slot name="title">Activités pédagogiques</x-slot>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0" style="color:#2E7D32;">
                <i class="bi bi-clock-history me-2"></i>Activités pédagogiques
            </h4>
            <small class="text-muted">{{ $activites->total() }} activité(s)</small>
        </div>
        <a href="{{ route('activites.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Nouvelle activité
        </a>
    </div>

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('activites.index') }}" class="row g-2 align-items-end">
                @role('admin|secretaire')
                <div class="col-md-3">
                    <select name="enseignant_id" class="form-select">
                        <option value="">Tous les enseignants</option>
                        @foreach($enseignants as $e)
                            <option value="{{ $e->id }}"
                                {{ request('enseignant_id') == $e->id ? 'selected' : '' }}>
                                {{ $e->nom_complet }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endrole

                <div class="col-md-2">
                    <select name="statut" class="form-select">
                        <option value="">Tous les statuts</option>
                        <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="validee"    {{ request('statut') == 'validee'    ? 'selected' : '' }}>Validée</option>
                        <option value="rejetee"    {{ request('statut') == 'rejetee'    ? 'selected' : '' }}>Rejetée</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <input type="date" name="date_debut" class="form-control"
                           value="{{ request('date_debut') }}" placeholder="Date début">
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_fin" class="form-control"
                           value="{{ request('date_fin') }}" placeholder="Date fin">
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i>Filtrer
                    </button>
                    <a href="{{ route('activites.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau -->
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Enseignant</th>
                        <th>Ressource</th>
                        <th>Type action</th>
                        <th>Heures</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activites as $activite)
                    <tr>
                        <td>{{ $activite->date_activite->format('d/m/Y') }}</td>
                        <td>{{ $activite->enseignant->nom_complet }}</td>
                        <td>
                            <div>{{ $activite->ressource->titre }}</div>
                            <small class="text-muted">
                                {{ $activite->ressource->type_label }}
                                — {{ $activite->ressource->complexite }}
                            </small>
                        </td>
                        <td>
                            @if($activite->type_action === 'creation')
                                <span class="badge bg-success">Création</span>
                            @else
                                <span class="badge" style="background:#1565C0;">Mise à jour</span>
                            @endif
                        </td>
                        <td>
                            <strong style="color:#E65100;">
                                {{ $activite->heures_calculees }}h
                            </strong>
                        </td>
                        <td>{!! $activite->statut_badge !!}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('activites.show', $activite) }}"
                                   class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-eye"></i>
                                </a>

                                @role('admin|secretaire')
                                @if($activite->statut === 'en_attente')
                                <form method="POST"
                                      action="{{ route('activites.valider', $activite) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success"
                                            title="Valider">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                                <form method="POST"
                                      action="{{ route('activites.rejeter', $activite) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            title="Rejeter">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </form>
                                @endif
                                @endrole

                                @if($activite->statut === 'en_attente')
                                <form method="POST"
                                      action="{{ route('activites.destroy', $activite) }}"
                                      onsubmit="return confirm('Supprimer cette activité ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-clock fs-2 d-block mb-2"></i>
                            Aucune activité enregistrée
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($activites->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Affichage de {{ $activites->firstItem() }}
                à {{ $activites->lastItem() }}
                sur {{ $activites->total() }} résultats
            </small>
            {{ $activites->withQueryString()->links() }}
        </div>
        @endif
    </div>
</x-app-layout>