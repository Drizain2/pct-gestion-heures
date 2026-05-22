<!-- resources/views/dashboard/admin.blade.php -->
<x-app-layout>
    <x-slot name="title">Tableau de bord — Administrateur</x-slot>
    <div class="dashboard-header mb-5">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Bienvenue, {{ Auth::user()->name }}</h2>
                <p class="text-muted mb-0">Gérez et supervisez les heures d'enseignement de l'ensemble du
                    corps professoral de l'UVCI pour l'année universitaire {{ $stats['annee_academique'] }}.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card blue">
                    <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $stats['enseignants'] ?? 0 }}</div>
                        <div class="stat-label">Enseignants</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card green">
                    <div class="stat-icon"><i class="bi bi-book-fill"></i></div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $stats['cours'] ?? 0 }}</div>
                        <div class="stat-label">Cours actifs</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card orange">
                    <div class="stat-icon"><i class="bi bi-clock-fill"></i></div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $heuresMois ?? 0 }}h</div>
                        <div class="stat-label">Heures ce mois</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card navy">
                    <div class="stat-icon"><i class="bi bi-collection-fill"></i></div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $stats['ressources'] ?? 0 }}</div>
                        <div class="stat-label">Ressources</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 py-4">
        <!-- Carte Graphique -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="fw-semibold mb-4">Heures validées - 6 derniers mois</h6>
                    <div class="card-body">
                        <canvas id="chartMois" height="120"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-4">
                        <i class="bi bi-pie-chart-fill text-primary me-2"></i>
                        Heures par département
                    </h5>

                    <!-- Diagramme circulaire -->
                    <div class="card-body">
                        <canvas id="chartDept" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- <style>
            .pie-chart {
                width: 220px;
                height: 220px;
                border-radius: 50%;
                background: conic-gradient(#0d6efd 0% 35%,
                        #6610f2 35% 60%,
                        #20c997 60% 80%,
                        #fd7e14 80% 95%,
                        #dc3545 95% 100%);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            }

            .pie-chart:hover {
                transform: scale(1.03);
                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            }

            .pie-chart::before {
                content: "";
                display: block;
                width: 60%;
                height: 60%;
                background: #fff;
                border-radius: 50%;
                margin: 20% auto;
                box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.06);
            }

            .legend-color {
                width: 16px;
                height: 16px;
                border-radius: 4px;
                display: inline-block;
                margin-right: 12px;
            }

            .legend-item {
                transition: transform 0.2s ease;
            }

            .legend-item:hover {
                transform: translateX(4px);
            }

            @media (max-width: 767px) {
                .pie-chart {
                    width: 180px;
                    height: 180px;
                }
            }
        </style> --}}
    </div>

    <style>
        @keyframes growUp {
            from {
                transform: scaleY(0);
                opacity: 0;
            }

            to {
                transform: scaleY(1);
                opacity: 1;
            }
        }
    </style>


    <div class="row align-items-stretch mb-4">
        <!-- Activités en attente -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>
                        <i class="bi bi-hourglass-split me-2"></i>
                        Activités en attente
                    </span>
                    @if ($activitesEnAttente->total() > 0)
                        <span class="badge badge-orange">
                            {{ $activitesEnAttente->total() }}
                        </span>
                    @endif
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Enseignant</th>
                                <th>Cours</th>
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
                                        <small>{{ Str::limit($activite->cours->intitule, 25) }}</small>
                                    </td>
                                    <td>
                                        <strong style="color:var(---orange);">
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
            <div class="card h-100">
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
                                        <strong style="color:var(---green);">
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

    <!--  enseignants ayant dépassés leur seuil-->

    <div class="col-12 fade-in-up">
        <div class="card">
            <div class="card-header">
                <h6 class="card-header-title">
                    <i class="bi bi-lightning-fill"></i>
                    Enseignants ayant dépassé leur charge
                </h6>
                @if ($enseignantsDepasses->count() > 0)
                    <span class="badge badge-orange">
                        {{ $enseignantsDepasses->count() }}
                    </span>
                @endif
            </div>
            <div class="card-body card-body-flush">
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr style="text-transform: capitalize" class="text-center">
                                <th>Enseignant</th>
                                <th>Grade</th>
                                <th>Seuil normal</th>
                                <th>Total heures</th>
                                <th>Heures complémentaires</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($enseignantsDepasses as $enseignant)
                                <tr class="text-center">
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar avatar-sm">
                                                {{ strtoupper(substr($enseignant->prenom, 0, 1)) }}
                                            </div>
                                            <span class="fw-600">{{ $enseignant->nom_complet }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-blue">{{ $enseignant->grade }}</span>
                                    </td>
                                    <td>{{ $enseignant->volume['seuil'] }}h</td>
                                    <td>
                                        <strong style="color:var(---blue)">
                                            {{ $enseignant->volume['total'] }}h
                                        </strong>
                                    </td>
                                    <td>
                                        <strong class="text-uvci-orange">
                                            +{{ $enseignant->volume['heures_complementaires'] }}h
                                        </strong>
                                    </td>
                                    <td>
                                        <a href="{{ route('activites.recapitulatif', $enseignant) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Voir
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="bi bi-check-all fs-3 d-block mb-2"></i>
                                        Aucun enseignant n'a dépassé son seuil
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
                '#0d6efd', '#6610f2', '#20c997', '#fd7e14', '#dc3545','6015e0','4D3992','58595B'
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
                    maintainAspectRatio: false,
                    cutout: '60%', // pour faire un donut
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    size: 11,
                                }
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>
