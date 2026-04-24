<!-- resources/views/ressources/create.blade.php -->
<x-app-layout>
    <x-slot name="title">Nouvelle Ressource</x-slot>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-plus-circle-fill me-2"></i>
                    Ajouter une ressource — {{ $sequence->titre }}
                </div>
                <div class="card-body p-4">
                    <form method="POST"
                          action="{{ route('cours.sequences.ressources.store', [$cour, $sequence]) }}">
                        @csrf
                        @include('ressources._form')
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('cours.sequences.index', $cour) }}"
                               class="btn btn-outline-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>