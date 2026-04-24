<!-- resources/views/pdf/fiche_enseignant.blade.php -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <style>
        * {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        body {
            margin: 20px;
            color: #333;
        }

        .header {
            background: #2E7D32;
            color: #fff;
            padding: 15px 20px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
        }

        .header p {
            margin: 4px 0 0;
            opacity: 0.85;
            font-size: 11px;
        }

        .info-block {
            background: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 12px 15px;
            margin-bottom: 15px;
        }

        .info-grid {
            width: 100%;
        }

        .info-grid td {
            padding: 4px 8px;
        }

        .info-grid .label {
            color: #666;
            width: 40%;
        }

        .info-grid .value {
            font-weight: bold;
        }

        table.activites {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.activites th {
            background: #2E7D32;
            color: #fff;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }

        table.activites td {
            padding: 6px 8px;
            border-bottom: 1px solid #eee;
            font-size: 11px;
        }

        table.activites tr:nth-child(even) td {
            background: #f5f5f5;
        }

        .total-row td {
            background: #FFF9C4 !important;
            font-weight: bold;
            border-top: 2px solid #FFC107;
        }

        .badge-creation {
            color: #2E7D32;
            font-weight: bold;
        }

        .badge-maj {
            color: #1565C0;
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            color: #999;
            font-size: 10px;
            border-top: 1px solid #eee;
            padding-top: 8px;
        }

        .total-box {
            background: linear-gradient(135deg, #E65100, #FF6F00);
            color: #fff;
            padding: 12px 20px;
            border-radius: 6px;
            text-align: center;
            margin: 15px 0;
        }

        .total-box .number {
            font-size: 28px;
            font-weight: bold;
        }

        .total-box .label {
            font-size: 12px;
            opacity: 0.9;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>UVCI — Fiche individuelle enseignant</h1>
        <p>Université Virtuelle de Côte d'Ivoire — Générée le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>

    <!-- Infos enseignant -->
    <div class="info-block">
        <table class="info-grid">
            <tr>
                <td class="label">Nom complet</td>
                <td class="value">{{ $enseignant->nom_complet }}</td>
                <td class="label">Grade</td>
                <td class="value">{{ $enseignant->grade }}</td>
            </tr>
            <tr>
                <td class="label">Statut</td>
                <td class="value">{{ $enseignant->statut }}</td>
                <td class="label">Département</td>
                <td class="value">{{ $enseignant->departement }}</td>
            </tr>
            <tr>
                <td class="label">Email</td>
                <td class="value">{{ $enseignant->email }}</td>
                <td class="label">Taux horaire</td>
                <td class="value">{{ number_format($enseignant->taux_horaire, 0, ',', ' ') }} FCFA</td>
            </tr>
            @if ($debut || $fin)
                <tr>
                    <td class="label">Période</td>
                    <td class="value" colspan="3">
                        {{ $debut ? 'Du ' . \Carbon\Carbon::parse($debut)->format('d/m/Y') : '' }}
                        {{ $fin ? ' au ' . \Carbon\Carbon::parse($fin)->format('d/m/Y') : '' }}
                    </td>
                </tr>
            @endif
        </table>
    </div>

    <!-- Total heures -->
    <div class="total-box">
        <div class="number">{{ $volume['total'] }}h</div>
        <div class="label">
            Total heures validées
            ({{ $volume['creation'] }}h création + {{ $volume['mise_a_jour'] }}h mise à jour)
        </div>
    </div>


    <!-- Heures complémentaires -->
    @if ($volume['heures_complementaires'] > 0)
        <div class="info-block" style="border-left: 4px solid #F5A623;">
            <div class="info-grid" style="display: flex; justify-content: space-between;">
                <span class="label w-25">Heures normales</span>
                <span class="value w-25">{{ $volume['heures_normales'] }}h
                    (seuil : {{ $volume['seuil'] }}h)</span>
                <span class="label w-25">Heures complémentaires</span>
                <span class="value w-25" style="color:#E65100; font-size:14px;">
                    +{{ $volume['heures_complementaires'] }}h
                </span>
            </div>
            {{-- <table class="info-grid">
                <tr>
                    <td class="label w-25">Heures normales</td>
                    <td class="value w-25">{{ $volume['heures_normales'] }}h
                        (seuil : {{ $volume['seuil'] }}h)</td>
                    <td class="label w-25">Heures complémentaires</td>
                    <td class="value w-25" style="color:#E65100; font-size:14px;">
                        +{{ $volume['heures_complementaires'] }}h
                    </td>
                </tr>
            </table> --}}
        </div>
    @endif

    <!-- Montant à payer -->
    @php $montant = $volume['total'] * $enseignant->taux_horaire; @endphp
    <div class="info-block" style="border-left: 4px solid #2E7D32;">
        <strong>Montant à payer :</strong>
        {{ $volume['total'] }}h × {{ number_format($enseignant->taux_horaire, 0, ',', ' ') }} FCFA
        = <strong style="color:#E65100; font-size:14px;">
            {{ number_format($montant, 0, ',', ' ') }} FCFA
        </strong>
    </div>

    <!-- Tableau des activités -->
    <table class="activites">
        <thead>
            <tr>
                <th>Date</th>
                <th>Cours</th>
                <th>Nbr de Séquences</th>
                <th>Complexité</th>
                <th>Action</th>
                <th>Heures</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activites as $activite)
                <tr>
                    <td>{{ $activite->date_activite->format('d/m/Y') }}</td>
                    <td>{{ $activite->cours->intitule }}</td>
                    <td>{{ $activite->nb_sequences }}</td>
                    {{-- <td>{{ $activite->type_ressource }}</td> --}}
                    <td>{{ $activite->complexite }}</td>
                    <td class="{{ $activite->type_action === 'creation' ? 'badge-creation' : 'badge-maj' }}">
                        {{ $activite->type_action_label }}
                    </td>
                    <td><strong>{{ $activite->heures_calculees }}h</strong></td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="6" style="text-align:right;">TOTAL</td>
                <td>{{ $volume['total'] }}h</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        UVCI — Document généré automatiquement — {{ now()->format('d/m/Y à H:i') }}
    </div>
</body>

</html>
