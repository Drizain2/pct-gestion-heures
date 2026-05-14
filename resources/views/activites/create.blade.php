<x-app-layout title="Nouvelle activité">

@push('styles')
<style>
    :root {
        --primary: #2563eb;
        --primary-light: #eff6ff;
        --primary-dark: #1d4ed8;
        --surface: #ffffff;
        --surface-alt: #f8fafc;
        --border: #e2e8f0;
        --text: #0f172a;
        --text-muted: #64748b;
        --success: #059669;
        --success-light: #ecfdf5;
        --error: #dc2626;
        --error-light: #fef2f2;
        --radius: 8px;
        --shadow-md: 0 4px 12px rgba(0,0,0,.1);
    }

    .page-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding: 40px 16px;
        background: #f1f5f9;
    }

    .form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        box-shadow: var(--shadow-md);
        width: 100%;
        max-width: 720px;
        overflow: hidden;
    }

    .form-header {
        padding: 28px 32px 24px;
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; gap: 14px;
    }

    .form-header-icon {
        width: 40px; height: 40px;
        background: var(--primary-light); border-radius: 10px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }

    .form-header-icon svg { width: 20px; height: 20px; color: var(--primary); }
    .form-header h1 { font-size: 18px; font-weight: 600; margin: 0 0 2px; }
    .form-header p  { font-size: 13px; color: var(--text-muted); margin: 0; }

    .form-body { padding: 28px 32px; display: flex; flex-direction: column; gap: 22px; }

    .form-row { display: grid; gap: 18px; }
    .form-row.cols-2 { grid-template-columns: 1fr 1fr; }

    @media (max-width: 560px) {
        .form-row.cols-2 { grid-template-columns: 1fr; }
        .form-header, .form-body, .form-footer { padding: 20px; }
    }

    .field { display: flex; flex-direction: column; gap: 5px; }

    .field label {
        font-size: 13px; font-weight: 500; color: var(--text);
        display: flex; align-items: center; gap: 4px;
    }

    .field label .required { color: var(--error); font-size: 11px; }

    .field select,
    .field input[type="number"],
    .field textarea {
        width: 100%; padding: 9px 12px;
        border: 1px solid var(--border); border-radius: var(--radius);
        background: var(--surface); color: var(--text);
        font-size: 14px; font-family: inherit;
        transition: border-color .15s, box-shadow .15s;
        appearance: none; -webkit-appearance: none;
    }

    .field select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%2394a3b8' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 12px center; padding-right: 34px;
    }

    .field select:focus,
    .field input[type="number"]:focus,
    .field textarea:focus {
        outline: none; border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37,99,235,.12);
    }

    .field select.is-invalid,
    .field input.is-invalid,
    .field textarea.is-invalid { border-color: var(--error); background: var(--error-light); }

    .field select.is-valid,
    .field input.is-valid { border-color: var(--success); }

    .field-error { font-size: 12px; color: var(--error); display: flex; align-items: center; gap: 4px; }
    .field-hint  { font-size: 12px; color: var(--text-muted); }

    .sequences-row { display: flex; gap: 8px; align-items: stretch; }
    .sequences-row input { flex: 1; min-width: 0; }

    .btn-max {
        padding: 9px 14px;
        background: var(--surface-alt); border: 1px solid var(--border);
        border-radius: var(--radius);
        font-size: 12px; font-weight: 600; color: var(--text-muted);
        cursor: pointer; white-space: nowrap;
        transition: all .15s; text-transform: uppercase; letter-spacing: .04em;
    }

    .btn-max:hover { background: var(--primary-light); border-color: var(--primary); color: var(--primary); }

    .radio-group-label { font-size: 13px; font-weight: 500; color: var(--text); margin-bottom: 6px; }
    .radio-pills { display: flex; flex-wrap: wrap; gap: 8px; }
    .radio-pill input[type="radio"] { display: none; }

    .radio-pill label {
        display: flex; align-items: center; gap: 6px;
        padding: 7px 14px; border: 1px solid var(--border); border-radius: 20px;
        cursor: pointer; font-size: 13px; font-weight: 500;
        color: var(--text-muted); background: var(--surface-alt);
        transition: all .15s; user-select: none;
    }

    .radio-pill label:hover { border-color: var(--primary); color: var(--primary); background: var(--primary-light); }

    .radio-pill input[type="radio"]:checked + label {
        background: var(--primary); border-color: var(--primary);
        color: #fff; box-shadow: 0 2px 8px rgba(37,99,235,.25);
    }

    .divider { height: 1px; background: var(--border); margin: 2px 0; }

    .calcul-banner {
        border-radius: var(--radius); padding: 14px 16px;
        display: flex; align-items: center; gap: 12px;
        font-size: 14px; transition: all .25s ease;
    }

    .calcul-banner.pending { background: var(--surface-alt); border: 1px dashed var(--border); color: var(--text-muted); }
    .calcul-banner.ready   { background: var(--success-light); border: 1px solid #6ee7b7; color: var(--success); }

    .calcul-banner .banner-icon {
        width: 32px; height: 32px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }

    .calcul-banner.pending .banner-icon { background: #f1f5f9; }
    .calcul-banner.ready   .banner-icon { background: #d1fae5; }
    .calcul-banner .banner-icon svg { width: 16px; height: 16px; }
    .calcul-banner .banner-text strong { display: block; font-size: 15px; font-weight: 700; }
    .calcul-banner .banner-text span   { font-size: 12px; opacity: .75; }

    .form-footer {
        padding: 20px 32px; border-top: 1px solid var(--border);
        display: flex; align-items: center; justify-content: flex-end; gap: 10px;
        background: var(--surface-alt);
    }

    .btn {
        padding: 9px 20px; border-radius: var(--radius);
        font-size: 14px; font-weight: 500; font-family: inherit;
        cursor: pointer; border: 1px solid transparent;
        transition: all .15s; display: inline-flex; align-items: center; gap: 6px;
    }

    .btn-ghost { background: transparent; border-color: var(--border); color: var(--text-muted); }
    .btn-ghost:hover { background: var(--border); color: var(--text); }
    .btn-primary { background: var(--primary); color: #fff; box-shadow: 0 1px 3px rgba(37,99,235,.3); }
    .btn-primary:hover { background: var(--primary-dark); }
    .btn-primary:disabled { opacity: .5; cursor: not-allowed; }

    textarea { resize: vertical; min-height: 88px; }
    select option[value=""] { color: var(--text-muted); }
</style>
@endpush

<div class="page-wrapper">
    <div class="form-card">

        {{-- Header --}}
        <div class="form-header">
            <div class="form-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <h1>Nouvelle activité</h1>
                <p>Renseignez les informations pour calculer la charge horaire</p>
            </div>
        </div>

        {{-- Formulaire --}}
        <form action="{{ route('activites.store') }}" method="POST" id="activiteForm" novalidate>
            @csrf

            <div class="form-body">

                {{-- Enseignant + Cours --}}
                <div class="form-row cols-2">

                    <div class="field">
                        <label for="enseignant_id">Enseignant <span class="required">*</span></label>
                        <select name="enseignant_id" id="enseignant_id"
                                class="{{ $errors->has('enseignant_id') ? 'is-invalid' : '' }}" required>
                            <option value="">— Sélectionner —</option>
                            @foreach($enseignants as $e)
                                <option value="{{ $e->id }}"
                                    {{ old('enseignant_id', $enseignantSelectionne) == $e->id ? 'selected' : '' }}>
                                    {{ $e->nom }} {{ $e->prenom }}
                                </option>
                            @endforeach
                        </select>
                        @error('enseignant_id')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="cours_id">Cours concerné <span class="required">*</span></label>
                        <select name="cours_id" id="cours_id"
                                class="{{ $errors->has('cours_id') ? 'is-invalid' : '' }}" required>
                            <option value="">— Sélectionner —</option>
                            @foreach($cours as $c)
                                <option value="{{ $c->id }}"
                                        data-max-seq="{{ $c->sequences->count() }}"
                                        {{ old('cours_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->intitule }}
                                </option>
                            @endforeach
                        </select>
                        @error('cours_id')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                                {{-- Date de l'activité --}}
                <div class="field">
                    <label for="date_activite">Date de l'activité <span class="required">*</span></label>
                    <input type="date" name="date_activite" id="date_activite"
                           value="{{ old('date_activite', date('Y-m-d')) }}"
                           class="{{ $errors->has('date_activite') ? 'is-invalid' : '' }}"
                           style="padding:9px 12px;border:1px solid var(--border);border-radius:var(--radius);font-size:14px;font-family:inherit;background:var(--surface);color:var(--text);width:100%;transition:border-color .15s,box-shadow .15s"
                           required>
                    @error('date_activite')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Nombre de séquences --}}
                <div class="field">
                    <label for="nb_sequences">Nombre de séquences <span class="required">*</span></label>
                    <div class="sequences-row">
                        <input type="number" name="nb_sequences" id="nb_sequences"
                               min="1" step="1" placeholder="ex : 4"
                               value="{{ old('nb_sequences') }}"
                               class="{{ $errors->has('nb_sequences') ? 'is-invalid' : '' }}" required>
                        <button type="button" class="btn-max" id="btnMax"
                                title="Appliquer le nombre total de séquences du cours">
                            Max
                        </button>
                    </div>
                    <span class="field-hint" id="seqHint">Sélectionnez d'abord un cours pour activer le bouton Max</span>
                    @error('nb_sequences')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="divider"></div>

                {{-- Type d'activité + Niveau de complexité --}}
                <div class="form-row cols-2">

                    <div>
                        <div class="radio-group-label">
                            Type d'activité <span style="color:var(--error);font-size:11px">*</span>
                        </div>
                        <div class="radio-pills" role="group">
                            @foreach(['creation' => 'Création', 'mise_a_jour' => 'Mise à jour'] as $val => $libelle)
                                <div class="radio-pill">
                                    <input type="radio" name="type_action" id="type_{{ $val }}"
                                           value="{{ $val }}"
                                           {{ old('type_action') === $val ? 'checked' : '' }} required>
                                    <label for="type_{{ $val }}">{{ $libelle }}</label>
                                </div>
                            @endforeach
                        </div>
                        @error('type_action')
                            <span class="field-error" style="margin-top:6px">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <div class="radio-group-label">
                            Niveau de complexité <span style="color:var(--error);font-size:11px">*</span>
                        </div>
                        <div class="radio-pills" role="group">
                            @for($n = 1; $n <= 3; $n++)
                                <div class="radio-pill">
                                    <input type="radio" name="complexite" id="niveau_{{ $n }}"
                                           value="{{ 'niveau_'.$n }}"
                                           {{ old('complexite') == 'niveau_'.$n ? 'checked' : '' }} required>
                                    <label for="niveau_{{ $n }}">Niveau {{ $n }}</label>
                                </div>
                            @endfor
                        </div>
                        @error('complexite')
                            <span class="field-error" style="margin-top:6px">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="divider"></div>

                {{-- Bannière calcul horaire --}}
                <div class="calcul-banner pending" id="calculBanner">
                    <div class="banner-icon">
                        <svg id="iconPending" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="#94a3b8">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <svg id="iconReady" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="#059669" style="display:none">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="banner-text">
                        <strong id="calculResult">—</strong>
                        <span id="calculDetail">Remplissez tous les champs requis pour voir le calcul</span>
                    </div>
                </div>

                {{-- Commentaire --}}
                <div class="field">
                    <label for="commentaire">Commentaire</label>
                    <textarea name="commentaire" id="commentaire"
                              placeholder="Remarques, précisions…">{{ old('commentaire') }}</textarea>
                </div>

            </div>{{-- /form-body --}}

            {{-- Footer boutons --}}
            <div class="form-footer">
                <a href="{{ route('activites.index') }}" class="btn btn-ghost">Annuler</a>
                <button type="submit" class="btn btn-primary">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Enregistrer
                </button>
            </div>

        {{-- Charge horaire calculée (envoyée au back) --}}
        <input type="hidden" name="heures_calculees" id="heures_calculees" value="{{ old('heures_calculees', 0) }}">

        </form>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const coefficients = @json($coefficients);

    const coursSelect  = document.getElementById('cours_id');
    const nbSeqInput   = document.getElementById('nb_sequences');
    const btnMax       = document.getElementById('btnMax');
    const seqHint      = document.getElementById('seqHint');
    const banner       = document.getElementById('calculBanner');
    const bannerResult = document.getElementById('calculResult');
    const bannerDetail = document.getElementById('calculDetail');
    const iconPending  = document.getElementById('iconPending');
    const iconReady    = document.getElementById('iconReady');

    /* Bouton Max */
    coursSelect.addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];
        const max = opt.dataset.maxSeq;
        if (max && parseInt(max) > 0) {
            seqHint.textContent = `Ce cours comporte ${max} séquence(s) au total`;
            btnMax.dataset.max  = max;
        } else {
            seqHint.textContent = "Sélectionnez d'abord un cours pour activer le bouton Max";
            delete btnMax.dataset.max;
        }
        recalculate();
    });

    btnMax.addEventListener('click', function () {
        if (this.dataset.max) {
            nbSeqInput.value = this.dataset.max;
            nbSeqInput.dispatchEvent(new Event('input'));
        }
    });

    const getRadio = name => {
        const el = document.querySelector(`input[name="${name}"]:checked`);
        return el ? el.value : null;
    };

    function recalculate () {
        const enseignant = document.getElementById('enseignant_id').value;
        const cours      = coursSelect.value;
        const nb         = parseInt(nbSeqInput.value);
        const type       = getRadio('type_action');
        const niveau     = getRadio('complexite');

        const dateVal = document.getElementById('date_activite').value;
        if (!enseignant || !cours || !dateVal || !(nb > 0) || !type || !niveau) {
            setPending('Remplissez tous les champs requis pour voir le calcul');
            return;
        }

        const maxSeq = btnMax.dataset.max ? parseInt(btnMax.dataset.max) : null;
        if (maxSeq !== null && nb > maxSeq) {
            nbSeqInput.classList.add('is-invalid');
            setPending(`Le nombre de séquences ne peut pas dépasser ${maxSeq}`);
            return;
        } else {
            nbSeqInput.classList.remove('is-invalid');
        }

        const coef = coefficients?.[niveau]?.[type] ?? null;

        if (coef == null) {
            setPending('Coefficient introuvable pour cette combinaison');
            return;
        }

        const total = (coef * nb).toFixed(2);
        setReady(
            `${total} h — Charge horaire calculée`,
            `Coefficient ${coef} × ${nb} séquence(s) = ${total} h`,
            total
        );
    }

    function setPending (msg) {
        banner.className          = 'calcul-banner pending';
        bannerResult.textContent  = '—';
        bannerDetail.textContent  = msg;
        iconPending.style.display = '';
        iconReady.style.display   = 'none';
        document.getElementById('heures_calculees').value = 0;
    }

    function setReady (titre, detail, valeur) {
        banner.className          = 'calcul-banner ready';
        bannerResult.textContent  = titre;
        bannerDetail.textContent  = detail;
        iconPending.style.display = 'none';
        iconReady.style.display   = '';
        document.getElementById('heures_calculees').value = valeur;
    }

    /* Écouteurs */
    document.getElementById('enseignant_id').addEventListener('change', function() {
    let enseignantId = this.value;
    let coursSelect = document.getElementById('cours_id');
    
    coursSelect.innerHTML = '<option value="">Chargement...</option>';
    
    if(enseignantId) {
        fetch('/api/enseignants/' + enseignantId + '/cours')
            .then(response => response.json())
            .then(data => {
                coursSelect.innerHTML = '<option value="">— Sélectionner —</option>';
                if(data.length > 0) {
                    data.forEach(cours => {
                        coursSelect.innerHTML += <option value="${cours.id}">${cours.libelle}</option>;
                    });
                } else {
                    coursSelect.innerHTML = '<option value="">Aucun cours pour cet enseignant</option>';
                }
            })
            .catch(() => {
                coursSelect.innerHTML = '<option value="">Erreur de chargement</option>';
            });
    } else {
        coursSelect.innerHTML = '<option value="">— Sélectionner —</option>';
    }
    
    recalculate();
});

document.getElementById('date_activite').addEventListener('change', recalculate);
nbSeqInput.addEventListener('input', recalculate);
document.querySelectorAll('input[name="type_action"]').forEach(r => r.addEventListener('change', recalculate));
document.querySelectorAll('input[name="complexite"]').forEach(r => r.addEventListener('change', recalculate));        .forEach(r => r.addEventListener('change', recalculate));

    /* Validation submit */
    document.getElementById('activiteForm').addEventListener('submit', function (e) {
        let valid = true;

        ['enseignant_id', 'cours_id', 'date_activite'].forEach(id => {
            const el = document.getElementById(id);
            el.classList.toggle('is-invalid', !el.value);
            el.classList.toggle('is-valid',   !!el.value);
            if (!el.value) valid = false;
        });

        const nb    = parseInt(nbSeqInput.value);
        const maxNb = btnMax.dataset.max ? parseInt(btnMax.dataset.max) : null;
        const nbOk  = nb > 0 && (maxNb === null || nb <= maxNb);
        nbSeqInput.classList.toggle('is-invalid', !nbOk);
        nbSeqInput.classList.toggle('is-valid',    nbOk);
        if (!nbOk) valid = false;

        if (!getRadio('type_action'))      valid = false;
        if (!getRadio('complexite')) valid = false;

        if (parseFloat(document.getElementById('heures_calculees').value) <= 0) {
            valid = false;
            banner.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        if (!valid) {
            e.preventDefault();
            const first = document.querySelector('.is-invalid');
            if (first) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    /* Init (old() après erreur Laravel) */
    recalculate();
})();
</script>
@endpush

</x-app-layout>