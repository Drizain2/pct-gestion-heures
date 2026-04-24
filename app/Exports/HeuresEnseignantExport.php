<?php

namespace App\Exports;

use App\Models\Activite;
use App\Models\Enseignant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HeuresEnseignantExport implements FromCollection, ShouldAutoSize, WithEvents, WithHeadings, WithMapping, WithStyles, WithTitle
{
    private float $totalHeures = 0;

    public function __construct(private ?string $debut, private ?string $fin, private Enseignant $enseignant) {}

    public function collection()
    {
        $activites = Activite::where('enseignant_id', $this->enseignant->id)
            ->where('statut', 'validee')
            ->with(['cours'])
            ->when($this->debut, fn ($q) => $q->whereDate('date_activite', '>=', $this->debut))
            ->when($this->fin, fn ($q) => $q->whereDate('date_activite', '<=', $this->fin))
            ->orderBy('date_activite')
            ->get();

        $this->totalHeures = $activites->sum('heures_calculees');

        return $activites;
    }

    public function headings(): array
    {
        return [
            'Date', 'Cours', 'Nombre de Sequence', 'Complexité', 'Type action', 'Heures',
        ];
    }

    public function map($activite): array
    {
        return [
            $activite->date_activite->format('d/m/Y'),
            $activite->cours->intitule,
            $activite->nb_sequences,
            $activite->complexite,
            $activite->type_action_label,
            $activite->heures_calculees,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // En-tete en vert
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'E65100']],
            ],
        ];
    }

    public function title(): string
    {
        return $this->enseignant->nom_complet;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $lastRow = $event->sheet->getHighestRow() + 1;

                // ligne total
                $event->sheet->setCellValue("A{$lastRow}", 'TOTAL');
                $event->sheet->setCellValue("G{$lastRow}", $this->totalHeures.'h');
                $event->sheet->getStyle("A{$lastRow}:G{$lastRow}")->applyFromArray([
                    'font' => ['bold' => true], ['fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFF9C4']]],
                ]);
            },
        ];
    }
}
