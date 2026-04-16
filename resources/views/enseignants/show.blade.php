<x-app-layout>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Détails de l'enseignant</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('enseignants.edit', $enseignant->id) }}" class="btn btn-primary">
                <i class="bi bi-pencil me-1"></i> Modifier
            </a>
            <a href="{{ route('enseignants.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Retour à la liste
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <!-- Photo (optionnel) -->
                <div class="col-md-4 text-center mb-4 mb-md-0">
                    <div class="bg-light p-4 rounded-circle mx-auto" style="width: 150px; height: 150px; line-height: 150px;">
                        <i class="bi bi-person fs-1 text-muted"></i>
                    </div>
                    <h2 class="h4 mt-3">
                        {{ $enseignant->prenom }} {{ $enseignant->nom }}
                    </h2>
                    <p class="text-muted">
                        {{ ucfirst($enseignant->statut) }}
                    </p>
                </div>

                <!-- Détails -->
                <div class="col-md-8">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Grade :</label>
                                <p>{{ $enseignant->grade }}</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Département :</label>
                                <p>{{ $enseignant->departement }}</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email :</label>
                                <p>
                                    <a href="mailto:{{ $enseignant->email }}" class="text-decoration-none">
                                        {{ $enseignant->email }}
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Téléphone :</label>
                                <p>
                                    @if($enseignant->telephone)
                                        <a href="tel:{{ $enseignant->telephone }}" class="text-decoration-none">
                                            {{ $enseignant->telephone }}
                                        </a>
                                    @else
                                        Non renseigné
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Taux horaire :</label>
                                <p>{{ number_format($enseignant->taux_horaire, 0, ',', ' ') }} FCFA</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-transparent text-end">
            <small class="text-muted">
                Créé le {{ $enseignant->created_at->format('d/m/Y à H:i') }}
                @if($enseignant->updated_at != $enseignant->created_at)
                    | Modifié le {{ $enseignant->updated_at->format('d/m/Y à H:i') }}
                @endif
            </small>
        </div>
    </div>
</div>
</x-app-layout>