<!-- resources/views/cours/edit.blade.php -->
<x-app-layout>
    <x-slot name="title">Modifier le cours</x-slot>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-pencil-fill me-2"></i>Modifier — {{ $cour->intitule }}
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('cours.update', $cour) }}">
                        @csrf @method('PUT')
                        @include('cours._form')
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('cours.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-lg me-1"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>