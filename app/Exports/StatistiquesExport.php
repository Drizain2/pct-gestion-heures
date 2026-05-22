<?php

namespace App\Exports;

use App\Models\Activite;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StatistiquesExport implements WithMultipleSheets
{
    public function __construct(private ?string $debut, private ?string $fin) {}

    public function sheets(): array
    {
        return [
            new StatistiquesEnseignantsSheet($this->debut, $this->fin),
            new StatistiquesCoursSheet($this->debut, $this->fin),
            new StatistiquesComplexiteSheet($this->debut, $this->fin),
        ];
    }
}

class StatistiquesEnseignantsSheet implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles, WithTitle
{
    public function __construct(private ?string $debut, private ?string $fin) {}

    public function title(): string
    {
        return 'Résumé par enseignant';
    }

    public function collection()
    {
        return Activite::with('enseignant')
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
            ->values();
    }

    public function headings(): array
    {
        return ['Nom', 'Prénom', 'Grade', 'Statut', 'Département', 'Nb activités', 'H. Création', 'H. Mise à jour', 'Total heures'];
    }

    public function map($row): array
    {
        return [$row->nom, $row->prenom, $row->grade, $row->statut, $row->departement, $row->nb_activites, $row->heures_creation, $row->heures_maj, $row->total_heures];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1B5E20']]],
        ];
    }
}

class StatistiquesCoursSheet implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles, WithTitle
{
    public function __construct(private ?string $debut, private ?string $fin) {}

    public function title(): string
    {
        return 'Heures par cours';
    }

    public function collection()
    {
        return Activite::with('cours')
            ->where('statut', 'validee')
            ->when($this->debut, fn ($q) => $q->whereDate('date_activite', '>=', $this->debut))
            ->when($this->fin, fn ($q) => $q->whereDate('date_activite', '<=', $this->fin))
            ->get()
            ->groupBy('cours_id')
            ->map(function ($activites) {
                $cours = $activites->first()->cours;

                return (object) [
                    'intitule' => $cours->intitule,
                    'filiere' => $cours->filiere,
                    'niveau' => $cours->niveau,
                    'nb_activites' => $activites->count(),
                    'heures_creation' => $activites->where('type_action', 'creation')->sum('heures_calculees'),
                    'heures_maj' => $activites->where('type_action', 'mise_a_jour')->sum('heures_calculees'),
                    'total_heures' => $activites->sum('heures_calculees'),
                ];
            })
            ->values();
    }

    public function headings(): array
    {
        return ['Cours', 'Filière', 'Niveau', 'Nb activités', 'H. Création', 'H. Mise à jour', 'Total heures'];
    }

    public function map($row): array
    {
        return [$row->intitule, $row->filiere, $row->niveau, $row->nb_activites, $row->heures_creation, $row->heures_maj, $row->total_heures];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF0D47A1']]],
        ];
    }
}

class StatistiquesComplexiteSheet implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles, WithTitle
{
    public function __construct(private ?string $debut, private ?string $fin) {}

    public function title(): string
    {
        return 'Répartition par complexité';
    }

    public function collection()
    {
        $labels = ['niveau_1' => 'Niveau 1 — Contenus simples', 'niveau_2' => 'Niveau 2 — Avec activités interactives', 'niveau_3' => 'Niveau 3 — Serious games / Haute qualité'];

        return Activite::where('statut', 'validee')
            ->when($this->debut, fn ($q) => $q->whereDate('date_activite', '>=', $this->debut))
            ->when($this->fin, fn ($q) => $q->whereDate('date_activite', '<=', $this->fin))
            ->get()
            ->groupBy('complexite')
            ->map(function ($activites, $niveau) use ($labels) {
                return (object) [
                    'niveau' => $labels[$niveau] ?? $niveau,
                    'nb_activites' => $activites->count(),
                    'heures_creation' => $activites->where('type_action', 'creation')->sum('heures_calculees'),
                    'heures_maj' => $activites->where('type_action', 'mise_a_jour')->sum('heures_calculees'),
                    'total_heures' => $activites->sum('heures_calculees'),
                ];
            })
            ->values();
    }

    public function headings(): array
    {
        return ['Niveau de complexité', 'Nb activités', 'H. Création', 'H. Mise à jour', 'Total heures'];
    }

    public function map($row): array
    {
        return [$row->niveau, $row->nb_activites, $row->heures_creation, $row->heures_maj, $row->total_heures];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFE65100']]],
        ];
    }
}
