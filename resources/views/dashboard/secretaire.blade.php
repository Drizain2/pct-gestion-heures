<!-- resources/views/dashboard/secretaire.blade.php -->
<x-app-layout>
    <x-slot name="title">Tableau de bord — Secrétaire</x-slot>
    <div class="dashboard-header mb-5">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Bienvenue, Secretaire 👋</h2>
                <p class="text-muted mb-0">Visualisez et gérez les heures d'enseignement des differents enseignants.</p>
            </div>
        </div>

        <!-- Stats -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card" style="background-color: white;">
                    <div class="stat-icon" style="color: #2563EB; background: rgba(37, 99, 235, 0.1);"><i
                            class="bi bi-people-fill"></i></div>
                    <div class="stat-info">
                        <div class="stat-number" style="color: black;">{{ $stats['enseignants'] }}</div>
                        <div class="stat-label" style="color: black;">Enseignants</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="background-color: white;">
                    <div class="stat-icon" style="color: #8B5CF6; background: rgba(139, 92, 246, 0.1);"><i
                            class="bi bi-book-fill"></i></div>
                    <div class="stat-info">
                        <div class="stat-number" style="color: black;">{{ $stats['cours'] }}</div>
                        <div class="stat-label" style="color: black;">Cours</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="background-color: white;">
                    <div class="stat-icon" style="color: #F5A623; background: rgba(245, 166, 35, 0.1);"><i
                            class="bi bi-hourglass-split"></i></div>
                    <div class="stat-info">
                        <div class="stat-number" style="color: black;">{{ $stats['activites_attente'] }}</div>
                        <div class="stat-label" style="color: black;">En attente</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="background-color: white;">
                    <div class="stat-icon" style="color: #00A86B; background: rgba(0, 168, 107, 0.1);"><i
                            class="bi bi-check-circle-fill"></i></div>
                    <div class="stat-info">
                        <div class="stat-number" style="color: black;">{{ $stats['activites_validees'] }}</div>
                        <div class="stat-label" style="color: black;">Validées ce mois</div>
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
                                    <th>Cours</th>

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
                                            {{ Str::limit($activite->cours->intitule, 30) }}
                                            <br>
                                            <small class="text-muted">
                                                {{ $activite->complexite }}
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
                                                <form method="POST" action="{{ route('activites.valider', $activite) }}">
                                                    @csrf
                                                    <button class="btn btn-sm btn-success">
                                                        <i class="bi bi-check-lg me-1"></i>Valider
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('activites.rejeter', $activite) }}">
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