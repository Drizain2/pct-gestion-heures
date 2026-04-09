<!-- resources/views/dashboard/admin.blade.php -->
<x-app-layout>
    <x-slot name="title">Tableau de bord</x-slot>

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card green">
                <i class="bi bi-people-fill stat-icon"></i>
                <div>
                    <div class="stat-number">24</div>
                    <div class="stat-label">Enseignants</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card orange">
                <i class="bi bi-book-fill stat-icon"></i>
                <div>
                    <div class="stat-number">48</div>
                    <div class="stat-label">Cours actifs</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card gold">
                <i class="bi bi-clock-fill stat-icon"></i>
                <div>
                    <div class="stat-number">320h</div>
                    <div class="stat-label">Heures ce mois</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card dark">
                <i class="bi bi-collection-fill stat-icon"></i>
                <div>
                    <div class="stat-number">156</div>
                    <div class="stat-label">Ressources</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau récent -->
    <div class="card">
        <div class="card-header">
            <i class="bi bi-clock-history me-2"></i>Activités récentes
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Enseignant</th>
                        <th>Activité</th>
                        <th>Ressource</th>
                        <th>Heures</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            Aucune activité enregistrée
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>