<!-- resources/views/dashboard/enseignant.blade.php -->
<x-app-layout>
    <x-slot name="title">Mon espace</x-slot>

    @if (!$enseignant)
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Votre profil enseignant n'est pas encore configuré.
            Contactez l'administrateur.
        </div>
    @else
        <!-- Bienvenue -->
        <div class="card mb-4" style="background:linear-gradient(135deg,#1B5E20,#2E7D32); color:#fff;">
            <div class="card-body p-4 d-flex align-items-center gap-3">
                <div
                    style="width:60px; height:60px; border-radius:50%;
                        background:rgba(255,255,255,0.2);
                        display:flex; align-items:center; justify-content:center;
                        font-size:1.5rem; font-weight:700;">
                    {{ strtoupper(substr($enseignant->prenom, 0, 1)) }}
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">Bonjour, {{ $enseignant->prenom }} !</h5>
                    <small style="opacity:0.8;">
                        {{ $enseignant->grade }} — {{ $enseignant->departement }}
                    </small>
                </div>
                <div class="ms-auto text-end">
                    <div style="font-size:0.85rem; opacity:0.8;">
                        {{ now()->translatedFormat('l d F Y') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Mes stats -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card green">
                    <i class="bi bi-clock-fill stat-icon"></i>
                    <div>
                        <div class="stat-number">{{ $stats['heures_mois'] }}h</div>
                        <div class="stat-label">Heures ce mois</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card orange">
                    <i class="bi bi-clock-history stat-icon"></i>
                    <div>
                        <div class="stat-number">{{ $stats['heures_totales'] }}h</div>
                        <div class="stat-label">Total heures</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card gold">
                    <i class="bi bi-hourglass-split stat-icon"></i>
                    <div>
                        <div class="stat-number">{{ $stats['en_attente'] }}</div>
                        <div class="stat-label">En attente</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card dark">
                    <i class="bi bi-collection-fill stat-icon"></i>
                    <div>
                        <div class="stat-number">{{ $stats['ressources'] }}</div>
                        <div class="stat-label">Mes ressources</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">

            <!-- Mes dernières activités -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-clock-history me-2"></i>Mes dernières activités
                        </span>
                        <a href="{{ route('activites.create') }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-plus-lg me-1"></i>Nouvelle
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Cours</th>
                                    <th>Action</th>
                                    <th>Complexité</th>
                                    <th>Nb. Séquences</th>
                                    <th>Volume</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($derniereActivites as $activite)
                                    <tr>
                                        <td>{{ $activite->date_activite->format('d/m/Y') }}</td>
                                        <td>{{ Str::limit($activite->cours?->intitule, 30) }}</td>
                                        <td>
                                            @if ($activite->type_action === 'creation')
                                                <span class="badge bg-success">Création</span>
                                            @else
                                                <span class="badge" style="background:#1565C0;">MAJ</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($activite->complexite === 'niveau_1')
                                                <span class="badge bg-success">Niveau 1</span>
                                            @elseif ($activite->complexite === 'niveau_2')
                                                <span class="badge" style="background:#1565C0;">Niveau 2</span>
                                            @else
                                                <span class="badge" style="background:#1565C0;">Niveau 3</span>
                                            @endif
                                        </td>
                                        <td>{{ $activite->nb_sequences }}</td>
                                        <td>
                                            <strong style="color:#E65100;">
                                                {{ $activite->heures_calculees }}h
                                            </strong>
                                        </td>
                                        <td>{!! $activite->statut_badge !!}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                            Aucune activité enregistrée
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Répartition par type -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-pie-chart-fill me-2"></i>
                        Mes heures par type
                    </div>
                    <div class="card-body">
                        @if ($repartitionTypes->isEmpty())
                            <div class="text-center text-muted py-4">
                                Aucune donnée disponible
                            </div>
                        @else
                            <canvas id="chartTypes" height="220"></canvas>
                        @endif
                    </div>
                </div>

                <!-- Lien récapitulatif -->
                <div class="card mt-3">
                    <div class="card-body text-center py-3">
                        <a href="{{ route('activites.recapitulatif', $enseignant) }}" class="btn btn-primary w-100">
                            <i class="bi bi-file-earmark-text me-2"></i>
                            Voir mon récapitulatif complet
                        </a>
                    </div>
                </div>
            </div>

        </div>

    @endif

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            @if (!$repartitionTypes->isEmpty())
                const labelsTypes = @json(
                    $repartitionTypes->map(function ($r) {
                        switch ($r->type) {
                            case 'contenu_textuel':
                                return 'Contenu textuel';
                            case 'video':
                                return 'Vidéo';
                            case 'document':
                                return 'Document';
                            case 'quiz':
                                return 'Quiz';
                            case 'activite_interactive':
                                return 'Activité interactive';
                            case 'evaluation':
                                return 'Évaluation';
                            default:
                                return $r->type;
                        }
                    }));

                const dataTypes = @json($repartitionTypes->pluck('total'));

                new Chart(document.getElementById('chartTypes'), {
                    type: 'doughnut',
                    data: {
                        labels: labelsTypes,
                        datasets: [{
                            data: dataTypes,
                            backgroundColor: [
                                '#2E7D32', '#1565C0', '#6A1B9A',
                                '#E65100', '#00838F', '#AD1457'
                            ],
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
            @endif
        </script>
    @endpush
</x-app-layout>
