<!-- resources/views/auth/forgot-password.blade.php -->
<x-guest-layout>
    <x-slot name="title">Mot de passe oublié</x-slot>

    <p class="auth-title">Réinitialisez votre mot de passe</p>

    @if (session('status'))
        <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div>{{ session('status') }}</div>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-x-circle-fill me-2"></i>
            <div>{{ $errors->first() }}</div>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold">Adresse email</label>
            <div class="position-relative">
                <i class="bi bi-envelope position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="form-control ps-5 @error('email') is-invalid @enderror" placeholder="votre@uvci.ci"
                    required autofocus>
            </div>
            @error('email')
                <div class="invalid-feedback d-block mt-1">
                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn-auth"
            style="background: var(---blue) !important; border-color: var(---blue-dark) !important; color: white; width: 100%;">
            Envoyer le lien de réinitialisation
        </button>

        <p class="mt-3 text-center">
            <a href="{{ route('login') }}" class="text-decoration-none" style="color: var(---blue);">
                Retour à la connexion
            </a>
        </p>
    </form>
</x-guest-layout>
