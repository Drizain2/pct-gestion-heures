<?php

namespace App\Exports;

use App\Models\Enseignant;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PaiementsExport implements FromCollection,WithHeadings,WithMapping,WithStyles,WithTitle,ShouldAutoSize
{
    public function __construct(private ?string $debut = null, private ?string $fin = null) {}

    public function collection()
    {
        return Enseignant::select('enseignants.*', DB::raw('COALESCE(SUM(activites.heures_calculees),0) as total_heures'))
            ->leftJoin('activites', function ($join) {
                $join->on('enseignants.id', '=', 'activites.enseignant_id')
                    ->where('activites.statut', 'validee')
                    ->when($this->debut, fn ($q) => $q->whereDate('activites.date_activite', '>=', $this->debut))
                    ->when($this->fin, fn ($q) => $q->whereDate('activites.date_activite', '<=', $this->fin));
            })
            ->groupBy('enseignants.id')
            ->having('total_heures', '>', 0)
            ->orderBy('enseignants.nom')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nom',
            'Prénom',
            'Grade',
            'Statut',
            'Département',
            'Taux horaire (FCFA)',
            'Total heures',
            'Montant à payer (FCFA)',
        ];
    }

    public function map($enseignant): array
    {
        $montant = $enseignant->total_heures * $enseignant->taux_horaire;

        return [
            $enseignant->nom,
            $enseignant->prenom,
            $enseignant->grade,
            $enseignant->statut,
            $enseignant->departement,
            number_format($enseignant->taux_horaire, 0, ',', ' '),
            $enseignant->total_heures,
            number_format($montant, 0, ',', ' '),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // En-tete en vert
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => '1B5E20']],
            ],
        ];
    }

    public function title(): string
    {
        return 'Etat des paiements';
    }
}
