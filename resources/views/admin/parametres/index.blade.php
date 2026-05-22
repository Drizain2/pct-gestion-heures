<x-app-layout>
    <x-slot name="title">Paramètres système</x-slot>

    <div class="d-flex gap-4 align-items-start">

        {{-- ── Navigation verticale (gauche) ─────────────────────────── --}}
        <div class="nav flex-column nav-pills me-2" id="params-tab" style="position:sticky; top: 75px; min-width: 100px;
            role="tablist" aria-orientation="vertical">

            <button class="nav-link active text-start mb-1" id="tab-general-tab"
                data-bs-toggle="pill" data-bs-target="#tab-general" type="button" role="tab">
                <i class="bi bi-gear-fill me-2"></i>Paramètres généraux
            </button>

            <button class="nav-link text-start mb-1" id="tab-calcul-tab" data-bs-toggle="pill"
                data-bs-target="#tab-calcul" type="button" role="tab">
                <i class="bi bi-calculator me-2"></i>Tableau de calcul
            </button>

            <button class="nav-link text-start" id="tab-annees-tab" data-bs-toggle="pill" data-bs-target="#tab-annees"
                type="button" role="tab">
                <i class="bi bi-calendar-fill me-2"></i>Années académiques
            </button>
        </div>

        {{-- ── Contenu (droite) ───────────────────────────────────────── --}}
        <div class="tab-content flex-grow-1" id="params-tabContent">

            {{-- Onglet 1 : Paramètres généraux --}}
            <div class="tab-pane fade show active" id="tab-general" role="tabpanel">
                <div class="card">
                    {{-- <div class="card-header">
                        <i class="bi bi-gear-fill me-2"></i>Paramètres généraux
                    </div> --}}
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('admin.parametres.systeme') }}">
                            @csrf
                            @foreach ($parametres as $groupe => $items)
                                <h6 class="text-uppercase fw-bold mb-3 mt-3"
                                    style="color:var(---blue); font-size:0.8rem; letter-spacing:1px;">
                                    {{ $groupe }}
                                </h6>
                                @foreach ($items as $param)
                                    <div class="mb-3">
                                        <label class="form-label">
                                            {{ $param->description ?? $param->cle }}
                                        </label>
                                        <input type="text" name="parametres[{{ $param->cle }}]"
                                            class="form-control" value="{{ $param->valeur }}">
                                    </div>
                                @endforeach
                            @endforeach
                            <button type="submit" class="btn btn-primary mt-2">
                                <i class="bi bi-check-lg me-1"></i>Enregistrer
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Onglet 2 : Tableau de calcul des heures --}}
            <div class="tab-pane fade" id="tab-calcul" role="tabpanel">
                <div class="card">
                    {{-- <div class="card-header">
                        <i class="bi bi-calculator me-2"></i>Tableau de calcul des heures
                    </div> --}}
                    <div class="card-body p-0">
                        <form method="POST" action="{{ route('admin.parametres.calcul') }}">
                            @csrf
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th style="width:50%">Type ressource</th>
                                        <th class="text-center" style="width:15%">Complexité</th>
                                        <th class="text-center" style="width:15%">Création (h)</th>
                                        <th class="text-center" style="width:15%">MAJ (h)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($parametresCalcul as $param)
                                        <tr>
                                            <td style="width:50%"><small>{{ $param->description }}</small></td>
                                            <td class="text-center" style="width:15%">
                                                <span
                                                    class="badge {{ match ($param->niveau_complexite) {
                                                        'niveau_1' => 'badge-green',
                                                        'niveau_2' => 'badge-blue',
                                                        'niveau_3' => 'badge-navy',
                                                    } }}">{{ $param->niveau_complexite }}</span>
                                            </td>
                                            <td class="text-center" style="width:15%">
                                                <input type="number" step="0.5"
                                                    name="heures[{{ $param->id }}][creation]"
                                                    class="form-control form-control-sm"
                                                    value="{{ $param->coefficient_creation }}">
                                            </td>
                                            <td>
                                                <input type="number" step="0.5"
                                                    name="heures[{{ $param->id }}][maj]"
                                                    class="form-control form-control-sm"
                                                    value="{{ $param->coefficient_mise_a_jour }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="p-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i>Mettre à jour le tableau de calcul
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Onglet 3 : Années académiques --}}
            <div class="tab-pane fade" id="tab-annees" role="tabpanel">
                <div class="card">
                    {{-- <div class="card-header">
                        <i class="bi bi-calendar-fill me-2"></i>Années académiques
                    </div> --}}
                    <div class="card-body p-4">
                        <div class="row g-4">
                            {{-- Liste années --}}
                            <div class="col-md-12">
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
                                                        <span class="badge badge-green">Active</span>
                                                    @else
                                                        <span class="badge badge-gray">Inactive</span>
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
                                                            <form method="POST"
                                                                action="{{ route('admin.annees.destroy', $annee) }}"
                                                                onsubmit="return confirm('Supprimer ?')">
                                                                @csrf @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-danger">
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
                        <button data-bs-toggle="modal" data-bs-target="#add-year" type="button" class="btn btn-primary mt-2 text-center justify-content-end">
                            <i class="bi bi-plus-lg me-1"></i>Ajouter une nouvelle année
                        </button>
                    </div>

                       {{-- Formulaire ajout --}}
                            <div class="modal" id="add-year">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="add-year-label"><i class="bi bi-plus-lg me-1"></i>Ajouter une année</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                <form method="POST" action="{{ route('admin.annees.store') }}">
                                    @csrf
                                    <div class="mb-2">
                                        <input type="text" name="libelle" class="form-control"
                                            placeholder="Ex: 2026-2027" value="{{ old('libelle') }}">
                                        @error('libelle')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small text-muted">Date de début</label>
                                        <input type="date" name="date_debut" class="form-control"
                                            value="{{ old('date_debut') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small text-muted">Date de fin</label>
                                        <input type="date" name="date_fin" class="form-control"
                                            value="{{ old('date_fin') }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-plus-lg me-1"></i>Ajouter
                                    </button>
                                </form>
                                </div>
                                </div>
                                </div>
                            </div>
                </div>
            </div>

        </div>{{-- /tab-content --}}
    </div>{{-- /d-flex --}}

    {{-- Rouvrir le bon onglet après un submit --}}
    @if (session('tab'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const btn = document.getElementById('{{ session('tab') }}-tab');
                if (btn) btn.click();
            });
        </script>
    @endif

</x-app-layout>
