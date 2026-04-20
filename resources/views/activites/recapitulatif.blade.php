<x-app-layout>
    <x-slot name="title">Récapitulatif — {{ $enseignant->nom_complet }}</x-slot>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0" style="color:#2E7D32;">
                <i class="bi bi-person-lines-fill me-2"></i>
                {{ $enseignant->nom_complet }}
            </h4>
            <small class="text-muted">{{ $enseignant->grade }} — {{ $enseignant->departement }}</small>
        </div>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Retour
        </a>
    </div>

    <!-- Filtre période -->
    <div class="card mb-4">
        <div class="card-body py-3">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label mb-1 small">Date début</label>
                    <input type="date" name="debut" class="form-control"
                           value="{{ $debut }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label mb-1 small">Date fin</label>
                    <input type="date" name="fin" class="form-control"
                           value="{{ $fin }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>Filtrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats heures -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card green">
                <i class="bi bi-clock-fill stat-icon"></i>
                <div>
                    <div class="stat-number">{{ $volume['total'] }}h</div>
                    <div class="stat-label">Total heures</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card orange">
                <i class="bi bi-plus-circle-fill stat-icon"></i>
                <div>
                    <div class="stat-number">{{ $volume['creation'] }}h</div>
                    <div class="stat-label">Création</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card gold">
                <i class="bi bi-arrow-clockwise stat-icon"></i>
                <div>
                    <div class="stat-number">{{ $volume['mise_a_jour'] }}h</div>
                    <div class="stat-label">Mise à jour</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card dark">
                <i class="bi bi-list-check stat-icon"></i>
                <div>
                    <div class="stat-number">{{ $volume['nb_activites'] }}</div>
                    <div class="stat-label">Activités validées</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau activités -->
    <div class="card">
        <div class="card-header">
            <i class="bi bi-table me-2"></i>Détail des activités validées
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Ressource</th>
                        <th>Cours</th>
                        <th>Type</th>
                        <th>Complexité</th>
                        <th>Action</th>
                        <th>Heures</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activites as $activite)
                    <tr>
                        <td>{{ $activite->date_activite->format('d/m/Y') }}</td>
                        <td>{{ $activite->ressource->titre }}</td>
                        <td>
                            <small>{{ $activite->ressource->sequence->cours->intitule }}</small>
                        </td>
                        <td>
                            <span class="badge"
                                  style="background:{{ $activite->ressource->type_couleur }}; font-size:0.75rem;">
                                {{ $activite->ressource->type_label }}
                            </span>
                        </td>
                        <td>{{ $activite->ressource->complexite }}</td>
                        <td>
                            @if($activite->type_action === 'creation')
                                <span class="badge bg-success">Création</span>
                            @else
                                <span class="badge" style="background:#1565C0;">MAJ</span>
                            @endif
                        </td>
                        <td>
                            <strong style="color:#E65100;">{{ $activite->heures_calculees }}h</strong>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Aucune activité validée sur cette période
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($activites->count() > 0)
                <tfoot>
                    <tr style="background:#f5f5f5;">
                        <td colspan="6" class="text-end fw-bold">Total</td>
                        <td>
                            <strong style="color:#E65100; font-size:1.1rem;">
                                {{ $volume['total'] }}h
                            </strong>
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</x-app-layout>