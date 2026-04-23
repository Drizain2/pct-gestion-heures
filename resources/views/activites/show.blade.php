<!-- resources/views/activites/show.blade.php -->
<x-app-layout>
    <x-slot name="title">Détail activité</x-slot>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('activites.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Retour
                </a>
                {!! $activite->statut_badge !!}
            </div>

            <div class="card">
                <div class="card-header">
                    <i class="bi bi-clock-history me-2"></i>Détail de l'activité
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Enseignant</small>
                            <strong>{{ $activite->enseignant->nom_complet }}</strong>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Date</small>
                            <strong>{{ $activite->date_activite->format('d/m/Y') }}</strong>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Cours</small>
                            <strong>{{ $activite->cours?->intitule }}</strong>
                            <small class="text-muted d-block">
                                {{ $activite->nb_sequences }} séquence(s)
                            </small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Complexité</small>
                            <span class="badge bg-secondary">
                                {{ $activite->complexite }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Type d'action</small>
                            @if($activite->type_action === 'creation')
                                <span class="badge bg-success">Création</span>
                            @else
                                <span class="badge" style="background:#1565C0;">Mise à jour</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Heures calculées</small>
                            <strong style="color:#E65100; font-size:1.3rem;">
                                {{ $activite->heures_calculees }}h
                            </strong>
                        </div>

                        @if($activite->commentaire)
                        <div class="col-12">
                            <small class="text-muted d-block">Commentaire</small>
                            <p class="mb-0">{{ $activite->commentaire }}</p>
                        </div>
                        @endif

                        @if($activite->validee_par)
                        <div class="col-12">
                            <hr>
                            <small class="text-muted d-block">
                                {{ $activite->statut === 'validee' ? 'Validée' : 'Rejetée' }} par
                            </small>
                            <strong>{{ $activite->validateurUser?->name }}</strong>
                            le {{ $activite->validee_le->format('d/m/Y à H:i') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>