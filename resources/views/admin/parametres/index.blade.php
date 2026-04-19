<!-- resources/views/admin/parametres/index.blade.php -->
<x-app-layout>
    <x-slot name="title">Paramètres système</x-slot>

    <div class="row g-4">

        <!-- Paramètres système -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-gear-fill me-2"></i>Paramètres généraux
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.parametres.systeme') }}">
                        @csrf
                        @foreach ($parametres as $groupe => $items)
                            <h6 class="text-uppercase fw-bold mb-3 mt-3"
                                style="color:#2E7D32; font-size:0.8rem; letter-spacing:1px;">
                                {{ $groupe }}
                            </h6>
                            @foreach ($items as $param)
                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ $param->description ?? $param->cle }}
                                    </label>
                                    <input type="text" name="parametres[{{ $param->cle }}]" class="form-control"
                                        value="{{ $param->valeur }}">
                                </div>
                            @endforeach
                        @endforeach
                        <button type="submit" class="btn btn-primary w-100 mt-2">
                            <i class="bi bi-check-lg me-1"></i>Enregistrer
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Paramètres de calcul des heures -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-calculator me-2"></i>Tableau de calcul des heures
                </div>
                <div class="card-body p-0">
                    <form method="POST" action="{{ route('admin.parametres.calcul') }}">
                        @csrf
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Type ressource</th>
                                    <th>Complexité</th>
                                    <th>Création (h)</th>
                                    <th>MAJ (h)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($parametresCalcul as $param)
                                                                <tr>
                                                                    <td>
                                                                        <small>{{ $param->description }}</small>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge {{ match ($param->niveau_complexite) {
                                        'niveau_1' => 'bg-success',
                                        'niveau_2' => 'bg-warning text-dark',
                                        'niveau_3' => 'bg-danger',
                                    } }}">{{ $param->niveau_complexite }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" step="0.5" name="heures[{{ $param->id }}][creation]"
                                                                            class="form-control form-control-sm" style="width:70px;"
                                                                            value="{{ $param->coefficient_creation }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" step="0.5" name="heures[{{ $param->id }}][maj]"
                                                                            class="form-control form-control-sm" style="width:70px;"
                                                                            value="{{ $param->coefficient_mise_a_jour }}">
                                                                    </td>
                                                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="p-3">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-check-lg me-1"></i>
                                Mettre à jour le tableau de calcul
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Années académiques -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-calendar-fill me-2"></i>Années académiques
                </div>
                <div class="card-body">
                    <div class="row g-3">

                        <!-- Formulaire ajout -->
                        <div class="col-md-4">
                            <form method="POST" action="{{ route('admin.annees.store') }}">
                                @csrf
                                <div class="mb-2">
                                    <input type="text" name="libelle" class="form-control" placeholder="Ex: 2026-2027"
                                        value="{{ old('libelle') }}">
                                    @error('libelle')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <input type="date" name="date_debut" class="form-control"
                                        value="{{ old('date_debut') }}">
                                </div>
                                <div class="mb-2">
                                    <input type="date" name="date_fin" class="form-control"
                                        value="{{ old('date_fin') }}">
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-plus-lg me-1"></i>Ajouter
                                </button>
                            </form>
                        </div>

                        <!-- Liste années -->
                        <div class="col-md-8">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Libellé</th>
                                        <th>Début</th>
                                        <th>Fin</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($annees as $annee)
                                        <tr>
                                            <td><strong>{{ $annee->libelle }}</strong></td>
                                            <td>{{ $annee->date_debut->format('d/m/Y') }}</td>
                                            <td>{{ $annee->date_fin->format('d/m/Y') }}</td>
                                            <td>
                                                @if ($annee->active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    @if (!$annee->active)
                                                        <form method="POST"
                                                            action="{{ route('admin.annees.activer', $annee) }}">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success"
                                                                title="Activer">
                                                                <i class="bi bi-check-circle"></i>
                                                            </button>
                                                        </form>
                                                        <form method="POST" action="{{ route('admin.annees.destroy', $annee) }}"
                                                            onsubmit="return confirm('Supprimer ?')">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>