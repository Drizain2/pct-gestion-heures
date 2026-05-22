<x-app-layout>
    <x-slot name="title">Mon profil</x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-person-fill me-2"></i>Informations du profil
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-lock-fill me-2"></i>Modifier le mot de passe
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-danger">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Zone de danger
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
