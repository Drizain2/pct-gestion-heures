<x-app-layout>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('enseignants._form', [
                    'enseignant' => $enseignant,
                ])
            </div>
        </div>
    </div>
</x-app-layout>