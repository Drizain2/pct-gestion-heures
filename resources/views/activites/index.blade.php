<x-app-layout>
    <x-slot name="title">Activités pédagogiques</x-slot>

@push('styles')
<style>
    :root {
        --primary:       #2563eb;
        --primary-light: #eff6ff;
        --primary-dark:  #1d4ed8;
        --surface:       #ffffff;
        --surface-alt:   #f8fafc;
        --border:        #e2e8f0;
        --text:          #0f172a;
        --text-muted:    #64748b;
        --success:       #059669;
        --success-light: #ecfdf5;
        --success-border:#6ee7b7;
        --warning:       #d97706;
        --warning-light: #fffbeb;
        --warning-border:#fcd34d;
        --error:         #dc2626;
        --error-light:   #fef2f2;
        --error-border:  #fca5a5;
        --radius:        8px;
        --shadow:        0 1px 3px rgba(0,0,0,.08);
        --shadow-md:     0 4px 12px rgba(0,0,0,.1);
    }

    *, *::before, *::after { box-sizing: border-box; }

    body {
        background: #f1f5f9;
        color: var(--text);
        font-family: 'Instrument Sans', 'Segoe UI', sans-serif;
        font-size: 14px;
        line-height: 1.5;
    }

    /* ── Page ── */
    .page-wrapper { padding: 32px 24px; max-width: 1200px; margin: 0 auto; }

    /* ── Page header ── */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 24px;
    }

    .page-header-left { display: flex; align-items: center; gap: 12px; }

    .page-header-icon {
        width: 40px; height: 40px;
        background: var(--primary-light);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .page-header-icon svg { width: 20px; height: 20px; color: var(--primary); }

    .page-title { font-size: 18px; font-weight: 700; margin: 0 0 1px; color: var(--text); }
    .page-subtitle { font-size: 12px; color: var(--text-muted); margin: 0; }

    /* ── Btn ── */
    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 16px;
        border-radius: var(--radius);
        font-size: 13px; font-weight: 500; font-family: inherit;
        cursor: pointer; border: 1px solid transparent;
        text-decoration: none;
        transition: all .15s;
        white-space: nowrap;
    }

    .btn svg { width: 15px; height: 15px; flex-shrink: 0; }

    .btn-primary { background: var(--primary); color: #fff; box-shadow: 0 1px 3px rgba(37,99,235,.3); }
    .btn-primary:hover { background: var(--primary-dark); color: #fff; }

    .btn-ghost { background: transparent; border-color: var(--border); color: var(--text-muted); }
    .btn-ghost:hover { background: var(--border); color: var(--text); }

    .btn-sm { padding: 6px 10px; font-size: 12px; }
    .btn-icon { padding: 6px 8px; }

    .btn-outline-success { background: transparent; border-color: var(--success-border); color: var(--success); }
    .btn-outline-success:hover { background: var(--success-light); }

    .btn-success { background: var(--success); color: #fff; border-color: var(--success); }
    .btn-success:hover { background: #047857; }

    .btn-danger { background: var(--error); color: #fff; border-color: var(--error); }
    .btn-danger:hover { background: #b91c1c; }

    .btn-outline-danger { background: transparent; border-color: var(--error-border); color: var(--error); }
    .btn-outline-danger:hover { background: var(--error-light); }

    /* ── Filter card ── */
    .filter-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        box-shadow: var(--shadow);
        padding: 16px 20px;
        margin-bottom: 20px;
    }

    .filter-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: flex-end;
    }

    .filter-grid .filter-field { flex: 1; min-width: 160px; }
    .filter-grid .filter-actions { display: flex; gap: 8px; flex-shrink: 0; }

    .filter-field select,
    .filter-field input[type="date"] {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        background: var(--surface);
        color: var(--text);
        font-size: 13px;
        font-family: inherit;
        appearance: none; -webkit-appearance: none;
        transition: border-color .15s, box-shadow .15s;
    }

    .filter-field select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%2394a3b8' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        padding-right: 30px;
    }

    .filter-field select:focus,
    .filter-field input[type="date"]:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37,99,235,.1);
    }

    /* ── Table card ── */
    .table-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }

    /* ── Table ── */
    .data-table { width: 100%; border-collapse: collapse; }

    .data-table thead tr {
        background: #f8fafc;
        border-bottom: 1px solid var(--border);
    }

    .data-table thead th {
        padding: 11px 16px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--text-muted);
        white-space: nowrap;
        text-align: left;
    }

    .data-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background .1s;
    }

    .data-table tbody tr:last-child { border-bottom: none; }
    .data-table tbody tr:hover { background: #fafcff; }

    .data-table td {
        padding: 13px 16px;
        font-size: 13px;
        color: var(--text);
        vertical-align: middle;
    }

    /* ── Cell helpers ── */
    .cell-date { white-space: nowrap; color: var(--text-muted); font-size: 12px; }

    .cell-enseignant { font-weight: 600; }

    .cell-cours-main { font-weight: 500; margin-bottom: 2px; }
    .cell-cours-sub  { font-size: 11px; color: var(--text-muted); }

    .cell-heures {
        font-size: 15px;
        font-weight: 700;
        color: #ea580c;
        white-space: nowrap;
    }

    .cell-actions { display: flex; gap: 6px; align-items: center; }

    /* ── Badges ── */
    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-creation  { background: var(--success-light); color: var(--success); border: 1px solid var(--success-border); }
    .badge-maj       { background: var(--primary-light); color: var(--primary); border: 1px solid #bfdbfe; }
    .badge-attente   { background: var(--warning-light); color: var(--warning); border: 1px solid var(--warning-border); }
    .badge-validee   { background: var(--success-light); color: var(--success); border: 1px solid var(--success-border); }
    .badge-rejetee   { background: var(--error-light);   color: var(--error);   border: 1px solid var(--error-border); }

    /* ── Empty state ── */
    .empty-state {
        padding: 60px 20px;
        text-align: center;
        color: var(--text-muted);
    }

    .empty-state svg { width: 40px; height: 40px; margin-bottom: 12px; opacity: .4; }
    .empty-state p { margin: 0; font-size: 14px; }

    /* ── Pagination ── */
    .table-footer {
        padding: 14px 20px;
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        background: var(--surface-alt);
    }

    .pagination-info { font-size: 12px; color: var(--text-muted); }

    /* Override Laravel pagination links */
    .pagination-wrapper nav { display: flex; align-items: center; }

    .pagination-wrapper nav > div:first-child { display: none; } /* hide "Showing X to Y" from Laravel */

    .pagination-wrapper [aria-label="Pagination Navigation"] {
        display: flex; align-items: center; gap: 4px;
    }

    .pagination-wrapper span[aria-current="page"] > span,
    .pagination-wrapper a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        padding: 0 10px;
        border-radius: var(--radius);
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        border: 1px solid transparent;
        transition: all .15s;
        color: var(--text-muted);
    }

    .pagination-wrapper a:hover {
        background: var(--primary-light);
        color: var(--primary);
        border-color: #bfdbfe;
    }

    .pagination-wrapper span[aria-current="page"] > span {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
        font-weight: 600;
    }

    /* Disabled prev/next */
    .pagination-wrapper span > span[aria-disabled="true"],
    .pagination-wrapper span:not([aria-current]) > span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        padding: 0 10px;
        border-radius: var(--radius);
        font-size: 13px;
        color: #cbd5e1;
        border: 1px solid var(--border);
        background: var(--surface-alt);
        cursor: not-allowed;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .page-wrapper { padding: 20px 16px; }
        .filter-grid .filter-field { min-width: 140px; }

        .data-table thead { display: none; }

        .data-table tbody tr {
            display: block;
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
        }

        .data-table td {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            padding: 4px 0;
            font-size: 13px;
        }

        .data-table td::before {
            content: attr(data-label);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--text-muted);
            min-width: 90px;
            padding-top: 1px;
            flex-shrink: 0;
        }

        .table-footer { flex-direction: column; align-items: flex-start; }
    }
</style>
@endpush

<div class="page-wrapper">

    {{-- En-tête --}}
    <div class="page-header">
        <div class="page-header-left">
            <div class="page-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h1 class="page-title">Activités pédagogiques</h1>
                <p class="page-subtitle">{{ $activites->total() }} activité(s) enregistrée(s)</p>
            </div>
        </div>
        <a href="{{ route('activites.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
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
</div>{{-- /page-wrapper --}}

</x-app-layout>