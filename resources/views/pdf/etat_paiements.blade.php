<!-- resources/views/pdf/etat_paiements.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        * { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        body { margin: 20px; }

        .header {
            background: #1B5E20;
            color: #fff;
            padding: 15px 20px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .header h1 { margin: 0; font-size: 16px; }
        .header p  { margin: 4px 0 0; opacity: 0.85; font-size: 10px; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #1B5E20;
            color: #fff;
            padding: 8px;
            text-align: left;
        }

        td {
            padding: 6px 8px;
            border-bottom: 1px solid #eee;
        }

        tr:nth-child(even) td { background: #f5f5f5; }

        .total-row td {
            background: #FFF9C4 !important;
            font-weight: bold;
            border-top: 2px solid #FFC107;
        }

        .footer {
            margin-top: 15px;
            text-align: center;
            color: #999;
            font-size: 9px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>UVCI — État des paiements</h1>
        <p>
            @if($debut || $fin)
                Période :
                {{ $debut ? \Carbon\Carbon::parse($debut)->format('d/m/Y') : '...' }}
                au
                {{ $fin ? \Carbon\Carbon::parse($fin)->format('d/m/Y') : '...' }}
                —
            @endif
            Généré le {{ now()->format('d/m/Y à H:i') }}
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nom complet</th>
                <th>Grade</th>
                <th>Département</th>
                <th>Taux (FCFA)</th>
                <th>Heures</th>
                <th>Montant (FCFA)</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; $totalHeures = 0; @endphp
            @foreach($enseignants as $index => $item)
            @php
                $montant = $item->total_heures * $item->enseignant->taux_horaire;
                $grandTotal  += $montant;
                $totalHeures += $item->total_heures;
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $item->enseignant->nom_complet }}</strong></td>
                <td>{{ $item->enseignant->grade }}</td>
                <td>{{ $item->enseignant->departement }}</td>
                <td>{{ number_format($item->enseignant->taux_horaire, 0, ',', ' ') }}</td>
                <td>{{ $item->total_heures }}h</td>
                <td><strong>{{ number_format($montant, 0, ',', ' ') }}</strong></td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="5" style="text-align:right;">TOTAL GÉNÉRAL</td>
                <td>{{ $totalHeures }}h</td>
                <td>{{ number_format($grandTotal, 0, ',', ' ') }} FCFA</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        UVCI — Document généré automatiquement — {{ now()->format('d/m/Y à H:i') }}
    </div>
</body>
</html>