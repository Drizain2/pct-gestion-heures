<!-- resources/views/exports/index.blade.php -->
<x-app-layout>
    <x-slot name="title">Exports & Rapports</x-slot>

    <div class="mb-4">
        <h4 class="fw-bold mb-0" style="color:#2E7D32;">
            <i class="bi bi-download me-2"></i>Exports & Rapports
        </h4>
        <small class="text-muted">Générez vos documents PDF et Excel</small>
    </div>

    <!-- Filtre période global -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-calendar-range me-2"></i>Période (optionnelle)
        </div>
        <div class="card-body py-3">
            <form id="filterForm" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label mb-1 small">Date début</label>
                    <input type="date" id="debut" class="form-control"
                           value="{{ request('debut') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label mb-1 small">Date fin</label>
                    <input type="date" id="fin" class="form-control"
                           value="{{ request('fin') }}">
                </div>
                <div class="col-md-3">
                    <small class="text-muted d-block">
                        <i class="bi bi-info-circle me-1"></i>
                        Laissez vide pour toute la période
                    </small>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">

        <!-- Exports globaux -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-globe me-2"></i>Exports globaux
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">

                        <div class="d-flex align-items-center justify-content-between
                                    p-3 rounded" style="background:#f0fdf4;">
                            <div>
                                <i class="bi bi-file-earmark-pdf"
                                   style="color:#E65100; font-size:1.4rem;"></i>
                                <span class="ms-2 fw-500">État des paiements</span>
                                <small class="text-muted d-block ms-4">
                                    Tous les enseignants avec montants
                                </small>
                            </div>
                            <a href="#" onclick="exporterAvecPeriode('{{ route('exports.paiements.pdf') }}')"
                               class="btn btn-sm btn-danger">
                                <i class="bi bi-file-pdf me-1"></i>PDF
                            </a>
                        </div>

                        <div class="d-flex align-items-center justify-content-between
                                    p-3 rounded" style="background:#f0fdf4;">
                            <div>
                                <i class="bi bi-file-earmark-excel"
                                   style="color:#2E7D32; font-size:1.4rem;"></i>
                                <span class="ms-2 fw-500">État global des heures</span>
                                <small class="text-muted d-block ms-4">
                                    Toutes les activités validées
                                </small>
                            </div>
                            <a href="#" onclick="exporterAvecPeriode('{{ route('exports.heures.global.excel') }}')"
                               class="btn btn-sm btn-success">
                                <i class="bi bi-file-excel me-1"></i>Excel
                            </a>
                        </div>

                        <div class="d-flex align-items-center justify-content-between
                                    p-3 rounded" style="background:#f0fdf4;">
                            <div>
                                <i class="bi bi-file-earmark-excel"
                                   style="color:#2E7D32; font-size:1.4rem;"></i>
                                <span class="ms-2 fw-500">Paiements Excel</span>
                                <small class="text-muted d-block ms-4">
                                    Tableau des montants à payer
                                </small>
                            </div>
                            <a href="#" onclick="exporterAvecPeriode('{{ route('exports.paiements.excel') }}')"
                               class="btn btn-sm btn-success">
                                <i class="bi bi-file-excel me-1"></i>Excel
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Exports par enseignant -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-person-lines-fill me-2"></i>
                    Fiche individuelle enseignant
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Sélectionner un enseignant</label>
                        <select id="enseignant_select" class="form-select">
                            <option value="">-- Choisir un enseignant --</option>
                            @foreach($enseignants as $enseignant)
                                <option value="{{ $enseignant->id }}"
                                        data-pdf="{{ route('exports.fiche.pdf', $enseignant) }}"
                                        data-excel="{{ route('exports.heures.enseignant.excel', $enseignant) }}">
                                    {{ $enseignant->nom_complet }}
                                    — {{ $enseignant->grade }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex gap-2" id="btnExportEnseignant" style="display:none;">
                        <button onclick="exporterEnseignant('pdf')"
                                class="btn btn-danger flex-fill" disabled id="btnPdfEnseignant">
                            <i class="bi bi-file-pdf me-1"></i>Fiche PDF
                        </button>
                        <button onclick="exporterEnseignant('excel')"
                                class="btn btn-success flex-fill" disabled id="btnExcelEnseignant">
                            <i class="bi bi-file-excel me-1"></i>Heures Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        // Active les boutons quand un enseignant est sélectionné
        document.getElementById('enseignant_select').addEventListener('change', function() {
            const btnPdf   = document.getElementById('btnPdfEnseignant');
            const btnExcel = document.getElementById('btnExcelEnseignant');
            const hasValue = this.value !== '';
            console.log(btnPdf);
            btnPdf.disabled   = !hasValue;
            btnExcel.disabled = !hasValue;
        });

        // Export enseignant avec période
        function exporterEnseignant(type) {
            const select = document.getElementById('enseignant_select');
            const option = select.options[select.selectedIndex];
            const debut  = document.getElementById('debut').value;
            const fin    = document.getElementById('fin').value;

            const baseUrl = type === 'pdf'
                ? option.dataset.pdf
                : option.dataset.excel;

            const params = new URLSearchParams();
            if (debut) params.append('debut', debut);
            if (fin)   params.append('fin', fin);

            window.location.href = baseUrl + (params.toString() ? '?' + params.toString() : '');
        }

        // Export global avec période
        function exporterAvecPeriode(baseUrl) {
            const debut  = document.getElementById('debut').value;
            const fin    = document.getElementById('fin').value;

            const params = new URLSearchParams();
            if (debut) params.append('debut', debut);
            if (fin)   params.append('fin', fin);

            window.location.href = baseUrl + (params.toString() ? '?' + params.toString() : '');
        }
    </script>
    @endpush
</x-app-layout>