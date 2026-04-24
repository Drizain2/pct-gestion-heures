<!-- resources/views/sequences/index.blade.php -->
<x-app-layout>
    <x-slot name="title">Séquences — {{ $cour->intitule }}</x-slot>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('cours.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i>Retour aux cours
            </a>
            <h4 class="fw-bold mb-0" style="color:#2E7D32;">
                <i class="bi bi-collection-fill me-2"></i>{{ $cour->intitule }}
            </h4>
            <small class="text-muted">
                {{ $cour->niveau }} — {{ $cour->semestre }} —
                {{ $sequences->count() }} séquence(s)
            </small>
        </div>
        <a href="{{ route('cours.sequences.create', $cour) }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Nouvelle séquence
        </a>
    </div>

    @forelse($sequences as $sequence)
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center"
             style="background:linear-gradient(135deg,#1B5E20,#2E7D32);">
            <span>
                <span class="badge bg-warning text-dark me-2">{{ $sequence->ordre }}</span>
                {{ $sequence->titre }}
                <small class="ms-2" style="opacity:0.8;">
                    ({{ $sequence->ressources_count }} ressource(s))
                </small>
            </span>
            <div class="d-flex gap-2">
                <a href="{{ route('cours.sequences.ressources.create', [$cour, $sequence]) }}"
                   class="btn btn-sm btn-warning">
                    <i class="bi bi-plus-lg me-1"></i>Ressource
                </a>
                <a href="{{ route('cours.sequences.edit', [$cour, $sequence]) }}"
                   class="btn btn-sm btn-light">
                    <i class="bi bi-pencil"></i>
                </a>
                <form method="POST"
                      action="{{ route('cours.sequences.destroy', [$cour, $sequence]) }}"
                      onsubmit="return confirm('Supprimer cette séquence et ses ressources ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-light">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>

        @if($sequence->description)
        <div class="px-3 pt-2 pb-0">
            <small class="text-muted">{{ $sequence->description }}</small>
        </div>
        @endif

        <!-- Ressources de la séquence -->
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Type</th>
                        <th>Complexité</th>
                        <th>Enseignant</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sequence->ressources as $ressource)
                    <tr>
                        <td><strong>{{ $ressource->titre }}</strong></td>
                        <td>
                            <span class="badge"
                                  style="background:{{ $ressource->type_couleur }}; font-size:0.78rem;">
                                {{ $ressource->type_label }}
                            </span>
                        </td>
                        <td>
                            @php
                                $couleur = match($ressource->complexite) {
                                    'niveau_1'  => 'bg-success',
                                    'niveau_2' => 'bg-warning text-dark',
                                    'niveau_3'=> 'bg-danger',
                                };
                            @endphp
                            <span class="badge {{ $couleur }}">
                                {{ $ressource->complexite }}
                            </span>
                        </td>
                        <td>{{ $ressource->enseignant->nom_complet }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                @can('update', $ressource)
                                <a href="{{ route('cours.sequences.ressources.edit', [$cour, $sequence, $ressource]) }}"
                                   class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endcan

                                @can('delete', $ressource)
                                <form method="POST"
                                      action="{{ route('cours.sequences.ressources.destroy', [$cour, $sequence, $ressource]) }}"
                                      onsubmit="return confirm('Supprimer cette ressource ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">
                            <i class="bi bi-inbox me-2"></i>Aucune ressource dans cette séquence
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @empty
    <div class="card">
        <div class="card-body text-center text-muted py-5">
            <i class="bi bi-collection fs-2 d-block mb-2"></i>
            Aucune séquence pour ce cours.
            <a href="{{ route('cours.sequences.create', $cours) }}" class="d-block mt-2">
                Créer la première séquence
            </a>
        </div>
    </div>
    @endforelse
</x-app-layout>