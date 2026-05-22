<?php

namespace App\Exports;

use App\Models\Activite;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HeuresGlobalExport implements WithMultipleSheets
{
    public function __construct(private ?string $debut = null, private ?string $fin = null) {}

    public function sheets(): array
    {
        return [
            new HeuresGlobalDetailSheet($this->debut, $this->fin),
            new HeuresGlobalRecapSheet($this->debut, $this->fin),
        ];
    }
}

/**
 * Feuille 1 — Détail chronologique de toutes les activités validées
 */
class HeuresGlobalDetailSheet implements FromCollection, ShouldAutoSize, WithEvents, WithHeadings, WithMapping, WithStyles, WithTitle
{
    private float $totalHeures = 0;

    public function __construct(private ?string $debut, private ?string $fin) {}

    public function title(): string
    {
        return 'Détail des activités';
    }

    public function collection()
    {
        $activites = Activite::with(['enseignant', 'cours'])
            ->where('statut', 'validee')
            ->when($this->debut, fn ($q) => $q->whereDate('date_activite', '>=', $this->debut))
            ->when($this->fin, fn ($q) => $q->whereDate('date_activite', '<=', $this->fin))
            ->orderBy('date_activite')
            ->orderBy('enseignant_id')
            ->get();

        $this->totalHeures = $activites->sum('heures_calculees');

        return $activites;
    }

    public function headings(): array
    {
        return [
            'Date',
            'Enseignant',
            'Grade',
            'Cours',
            'Filière',
            'Nb séquences',
            'Complexité',
            'Type action',
            'Heures calculées',
        ];
    }

    public function map($activite): array
    {
        return [
            $activite->date_activite->format('d/m/Y'),
            $activite->enseignant->nom_complet,
            $activite->enseignant->grade,
            $activite->cours->intitule,
            $activite->cours->filiere,
            $activite->nb_sequences,
            match ($activite->complexite) {
                'niveau_1' => 'Niveau 1',
                'niveau_2' => 'Niveau 2',
                'niveau_3' => 'Niveau 3',
                default => $activite->complexite,
            },
            $activite->type_action_label,
            $activite->heures_calculees,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF003B7A']],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $lastRow = $event->sheet->getHighestRow() + 1;

                $event->sheet->setCellValue("A{$lastRow}", 'TOTAL');
                $event->sheet->setCellValue("I{$lastRow}", $this->totalHeures.'h');
                $event->sheet->getStyle("A{$lastRow}:I{$lastRow}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E3F2FD']],
                ]);
            },
        ];
    }
}

/**
 * Feuille 2 — Récapitulatif des heures par enseignant
 */
class HeuresGlobalRecapSheet implements FromCollection, ShouldAutoSize, WithEvents, WithHeadings, WithMapping, WithStyles, WithTitle
{
    private float $grandTotal = 0;

    public function __construct(private ?string $debut, private ?string $fin) {}

    public function title(): string
    {
        return 'Récapitulatif par enseignant';
    }

    public function collection()
    {
        $rows = Activite::with('enseignant')
            ->where('statut', 'validee')
            ->when($this->debut, fn ($q) => $q->whereDate('date_activite', '>=', $this->debut))
            ->when($this->fin, fn ($q) => $q->whereDate('date_activite', '<=', $this->fin))
            ->get()
            ->groupBy('enseignant_id')
            ->map(function ($activites) {
                $enseignant = $activites->first()->enseignant;

                return (object) [
                    'nom' => $enseignant->nom,
                    'prenom' => $enseignant->prenom,
                    'grade' => $enseignant->grade,
                    'statut' => $enseignant->statut,
                    'departement' => $enseignant->departement,
                    'nb_activites' => $activites->count(),
                    'heures_creation' => $activites->where('type_action', 'creation')->sum('heures_calculees'),
                    'heures_maj' => $activites->where('type_action', 'mise_a_jour')->sum('heures_calculees'),
                    'total_heures' => $activites->sum('heures_calculees'),
                ];
            })
            ->sortBy('nom')
            ->values();

        $this->grandTotal = $rows->sum('total_heures');

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Nom',
            'Prénom',
            'Grade',
            'Statut',
            'Département',
            'Nb activités',
            'H. Création',
            'H. Mise à jour',
            'Total heures',
        ];
    }

    public function map($row): array
    {
        return [
            $row->nom,
            $row->prenom,
            $row->grade,
            $row->statut,
            $row->departement,
            $row->nb_activites,
            $row->heures_creation,
            $row->heures_maj,
            $row->total_heures,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF003B7A']],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $lastRow = $event->sheet->getHighestRow() + 1;

                $event->sheet->setCellValue("A{$lastRow}", 'TOTAL GÉNÉRAL');
                $event->sheet->setCellValue("I{$lastRow}", $this->grandTotal.'h');
                $event->sheet->getStyle("A{$lastRow}:I{$lastRow}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E3F2FD']],
                ]);
            },
        ];
    }
}
