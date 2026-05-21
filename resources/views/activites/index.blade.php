<x-app-layout>
    <x-slot name="title">Activités pédagogiques</x-slot>

    <div class="page-header">
        <div class="page-header-left">
            <h4>
                <i class="bi bi-clock-history me-2"></i>
                Activités pédagogiques
            </h4>
            <p>{{ $activites->total() }} activité(s) enregistrée(s)</p>
        </div>
        <a href="{{ route('activites.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Nouvelle activité
        </a>
    </div>

    {{-- Filtres --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('activites.index') }}">
            <div class="filter-grid">

                @role('admin|secretaire')
                <div class="filter-field">
                    <select name="enseignant_id">
                        <option value="">Tous les enseignants</option>
                        @foreach($enseignants as $e)
                            <option value="{{ $e->id }}"
                                {{ request('enseignant_id') == $e->id ? 'selected' : '' }}>
                                {{ $e->nom_complet }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endrole

                <div class="filter-field">
                    <select name="statut">
                        <option value="">Tous les statuts</option>
                        <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="validee"    {{ request('statut') == 'validee'    ? 'selected' : '' }}>Validée</option>
                        <option value="rejetee"    {{ request('statut') == 'rejetee'    ? 'selected' : '' }}>Rejetée</option>
                    </select>
                </div>

                <div class="filter-field">
                    <input type="date" name="date_debut" value="{{ request('date_debut') }}">
                </div>

                <div class="filter-field">
                    <input type="date" name="date_fin" value="{{ request('date_fin') }}">
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                        </svg>
                        Filtrer
                    </button>
                    <a href="{{ route('activites.index') }}" class="btn btn-ghost" title="Réinitialiser">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                </div>

            </div>
        </form>
    </div>

    {{-- Tableau --}}
    <div class="table-card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Enseignant</th>
                    <th>Cours</th>
                    <th>Type</th>
                    <th>Heures</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activites as $activite)
                <tr>
                    <td data-label="Date">
                        <span class="cell-date">
                            {{ $activite->date_activite->format('d/m/Y') }}
                        </span>
                    </td>

                    <td data-label="Enseignant">
                        <span class="cell-enseignant">{{ $activite->enseignant->nom_complet }}</span>
                    </td>

                    <td data-label="Cours">
                        <div class="cell-cours-main">{{ $activite->cours?->intitule }}</div>
                        <div class="cell-cours-sub">
                            {{ $activite->nb_sequences }} séquence(s)
                            &mdash; {{ $activite->complexite }}
                        </div>
                    </td>

                    <td data-label="Type">
                        @if($activite->type_action === 'creation')
                            <span class="badge badge-creation">Création</span>
                        @else
                            <span class="badge badge-maj">Mise à jour</span>
                        @endif
                    </td>

                    <td data-label="Heures">
                        <span class="cell-heures">{{ $activite->heures_calculees }}h</span>
                    </td>

                    <td data-label="Statut">
                        @php
                            $statutClass = match($activite->statut) {
                                'validee'    => 'badge-validee',
                                'rejetee'    => 'badge-rejetee',
                                default      => 'badge-attente',
                            };
                            $statutLabel = match($activite->statut) {
                                'validee'    => 'Validée',
                                'rejetee'    => 'Rejetée',
                                default      => 'En attente',
                            };
                        @endphp
                        <span class="badge {{ $statutClass }}">{{ $statutLabel }}</span>
                    </td>

                    <td data-label="Actions">
                        <div class="cell-actions">

                            {{-- Voir --}}
                            <a href="{{ route('activites.show', $activite) }}"
                               class="btn btn-sm btn-icon btn-outline-success" title="Voir">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" style="width:14px;height:14px">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>

                            @role('admin|secretaire')
                            @if($activite->statut === 'en_attente')

                            {{-- Valider --}}
                            <form method="POST" action="{{ route('activites.valider', $activite) }}"
                                  style="display:contents">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-icon btn-success" title="Valider">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" style="width:14px;height:14px">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 13l4 4L19 7"/>
                                    </svg>
                                </button>
                            </form>

                            {{-- Rejeter --}}
                            <form method="POST" action="{{ route('activites.rejeter', $activite) }}"
                                  style="display:contents">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-icon btn-danger" title="Rejeter">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" style="width:14px;height:14px">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </form>

                            @endif
                            @endrole

                            @if($activite->statut === 'en_attente')
                            {{-- Supprimer --}}
                            <form method="POST" action="{{ route('activites.destroy', $activite) }}"
                                  style="display:contents"
                                  onsubmit="return confirm('Supprimer cette activité ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" title="Supprimer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" style="width:14px;height:14px">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0a1 1 0 011-1h4a1 1 0 011 1H8z"/>
                                    </svg>
                                </button>
                            </form>
                            @endif

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding:0">
                        <div class="empty-state">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p>Aucune activité enregistrée</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($activites->hasPages())
        <div class="table-footer">
            <span class="pagination-info">
                Affichage de {{ $activites->firstItem() }}
                à {{ $activites->lastItem() }}
                sur {{ $activites->total() }} résultats
            </span>
            <div class="pagination-wrapper">
                {{ $activites->withQueryString()->links() }}
            </div>
        </div>
        @endif
    </div>{{-- /table-card --}}

</x-app-layout>