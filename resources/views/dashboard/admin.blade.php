<!-- resources/views/dashboard/admin.blade.php -->
<x-app-layout>
    <x-slot name="title">Tableau de bord — Administrateur</x-slot>

    <!-- Stat Cards -->
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
                    <div class="stat-label">Cours actifs</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card gold">
                <i class="bi bi-clock-fill stat-icon"></i>
                <div>
                    <div class="stat-number">{{ $heuresMois }}h</div>
                    <div class="stat-label">Heures ce mois</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card dark">
                <i class="bi bi-collection-fill stat-icon"></i>
                <div>
                    <div class="stat-number">{{ $stats['ressources'] }}</div>
                    <div class="stat-label">Ressources</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        <!-- Graphique heures par mois -->
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-bar-chart-fill me-2"></i>
                    Heures validées — 6 derniers mois
                </div>
                <div class="card-body">
                    <canvas id="chartMois" height="120"></canvas>
                </div>
            </div>
        </div>

        <!-- Heures par département -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-pie-chart-fill me-2"></i>
                    Heures par département
                </div>
                <div class="card-body">
                    <canvas id="chartDept" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Activités en attente -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>
                        <i class="bi bi-hourglass-split me-2"></i>
                        Activités en attente
                    </span>
                    @if ($activitesEnAttente->count() > 0)
                        <span class="badge bg-warning text-dark">
                            {{ $activitesEnAttente->count() }}
                        </span>
                    @endif
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Enseignant</th>
                                <th>Ressource</th>
                                <th>Heures</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activitesEnAttente as $activite)
                                <tr>
                                    <td>
                                        <small>{{ $activite->enseignant->nom_complet }}</small>
                                    </td>
                                    <td>
                                        <small>{{ Str::limit($activite->ressource->titre, 25) }}</small>
                                    </td>
                                    <td>
                                        <strong style="color:#E65100;">
                                            {{ $activite->heures_calculees }}h
                                        </strong>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <form method="POST" action="{{ route('activites.valider', $activite) }}">
                                                @csrf
                                                <button class="btn btn-sm btn-success" title="Valider">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('activites.rejeter', $activite) }}">
                                                @csrf
                                                <button class="btn btn-sm btn-danger" title="Rejeter">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">
                                        <i class="bi bi-check-all me-1"></i>
                                        Tout est à jour !
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Top enseignants -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-trophy-fill me-2"></i>
                    Top enseignants ce mois
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Enseignant</th>
                                <th>Département</th>
                                <th>Heures</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topEnseignants as $index => $item)
                                <tr>
                                    <td>
                                        @if ($index === 0)
                                            <i class="bi bi-trophy-fill" style="color:#FFC107;"></i>
                                        @elseif($index === 1)
                                            <i class="bi bi-trophy-fill" style="color:#9E9E9E;"></i>
                                        @elseif($index === 2)
                                            <i class="bi bi-trophy-fill" style="color:#CD7F32;"></i>
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </td>
                                    <td>{{ $item->enseignant->nom_complet }}</td>
                                    <td>
                                        <small>{{ $item->enseignant->departement }}</small>
                                    </td>
                                    <td>
                                        <strong style="color:#2E7D32;">
                                            {{ $item->total_heures }}h
                                        </strong>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">
                                        Aucune donnée ce mois
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Données pour le graphique des mois
            
            const labelsMois = JSON.parse('{!! $statsParMois->map(function ($s) {
                    return date('M Y', mktime(0, 0, 0, $s->mois, 1, $s->annee));
                })->toJson() !!}');
            const dataMois = JSON.parse('{!! $statsParMois->pluck('total')->toJson() !!}');


            // Graphique barres — heures par mois
            new Chart(document.getElementById('chartMois'), {
                type: 'bar',
                data: {
                    labels: labelsMois,
                    datasets: [{
                        label: 'Heures validées',
                        data: dataMois,
                        backgroundColor: 'rgba(46, 125, 50, 0.7)',
                        borderColor: '#2E7D32',
                        borderWidth: 2,
                        borderRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 10
                            }
                        }
                    }
                }
            });

            // Données pour le graphique département
            const labelsDept = @json($heuresParDepartement->pluck('departement'));
            const dataDept = @json($heuresParDepartement->pluck('total'));

            const couleurs = [
                '#2E7D32', '#E65100', '#FFC107', '#1565C0',
                '#6A1B9A', '#00838F', '#AD1457', '#FF6F00'
            ];

            // Graphique donut — par département
            new Chart(document.getElementById('chartDept'), {
                type: 'doughnut',
                data: {
                    labels: labelsDept,
                    datasets: [{
                        data: dataDept,
                        backgroundColor: couleurs.slice(0, labelsDept.length),
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>
