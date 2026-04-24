<?php

namespace App\Exports;

use App\Models\Activite;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HeuresExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles, WithTitle
{
    public function __construct(private ?string $debut = null, private ?string $fin = null) {}

    public function collection()
    {
        return Activite::where('statut', 'validee')
            ->with(['enseignant', 'cours'])
            ->when($this->debut, fn ($q) => $q->whereDate('date_activite', '>=', $this->debut))
            ->when($this->fin, fn ($q) => $q->whereDate('date_activite', '<=', $this->fin))
            ->orderBy('date_activite')
            ->get();
    }

    public function headings() : array
    {
        return [
            'Date',
            'Enseignant',
            'Grade',
            'Département',
            'Cours',
            'Nombre de Sequence',
            'Complexité',
            'Type action',
            'Heures calculées',
        ];
    }

    public function map($activite): array
    {
        return [
            $activite->date_activite->format('d/m/Y'),
            $activite->enseignant->nom,
            $activite->enseignant->grade,
            $activite->enseignant->departement,
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
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => '2E7D32']],
            ],
        ];

    }

    public function title(): string
    {
        return 'Heures validées';
    }
}
