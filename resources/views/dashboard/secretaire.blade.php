<!-- resources/views/dashboard/secretaire.blade.php -->
<x-app-layout>
    <x-slot name="title">Tableau de bord — Secrétaire</x-slot>

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card green">
                <i class="bi bi-people-fill stat-icon"></i>
                <div>
                    <div class="stat-number">{{ $stats['enseignants'] }}</div>
                    <div class="stat-label">Enseignants</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card orange">
                <i class="bi bi-book-fill stat-icon"></i>
                <div>
                    <div class="stat-number">{{ $stats['cours'] }}</div>
                    <div class="stat-label">Cours</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card gold">
                <i class="bi bi-hourglass-split stat-icon"></i>
                <div>
                    <div class="stat-number">{{ $stats['activites_attente'] }}</div>
                    <div class="stat-label">En attente</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card dark">
                <i class="bi bi-check-circle-fill stat-icon"></i>
                <div>
                    <div class="stat-number">{{ $stats['activites_validees'] }}</div>
                    <div class="stat-label">Validées ce mois</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        <!-- Activités en attente -->
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>
                        <i class="bi bi-hourglass-split me-2"></i>
                        Activités en attente de validation
                    </span>
                    <a href="{{ route('activites.index', ['statut' => 'en_attente']) }}"
                       class="btn btn-sm btn-outline-light">
                        Voir tout
                    </a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Enseignant</th>
                                <th>Ressource</th>
                                <th>Type action</th>
                                <th>Heures</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activitesEnAttente as $activite)
                            <tr>
                                <td>{{ $activite->enseignant->nom_complet }}</td>
                                <td>
                                    {{ Str::limit($activite->ressource->titre, 30) }}
                                    <br>
                                    <small class="text-muted">
                                        {{ $activite->ressource->type_label }}
                                        — {{ $activite->ressource->complexite }}
                                    </small>
                                </td>
                                <td>
                                    @if($activite->type_action === 'creation')
                                        <span class="badge bg-success">Création</span>
                                    @else
                                        <span class="badge" style="background:#1565C0;">
                                            Mise à jour
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <strong style="color:#E65100;">
                                        {{ $activite->heures_calculees }}h
                                    </strong>
                                </td>
                                <td>{{ $activite->date_activite->format('d/m/Y') }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <form method="POST"
                                              action="{{ route('activites.valider', $activite) }}">
                                            @csrf
                                            <button class="btn btn-sm btn-success">
                                                <i class="bi bi-check-lg me-1"></i>Valider
                                            </button>
                                        </form>
                                        <form method="POST"
                                              action="{{ route('activites.rejeter', $activite) }}">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-check-all fs-3 d-block mb-2"></i>
                                    Aucune activité en attente
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