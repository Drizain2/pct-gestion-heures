<x-app-layout>
    <x-slot name="title">Nouvel Enseignant</x-slot>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('enseignants._form', [
                    'enseignant' => null, // Pas d'enseignant existant pour la création
                ])
            </div>
        </div>
    </div>
</x-app-layout>
