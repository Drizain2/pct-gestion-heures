<!-- resources/views/auth/reset-password.blade.php -->
<x-guest-layout>
    <x-slot name="title">Réinitialisation du mot de passe</x-slot>

    <p class="auth-title">Choisissez un nouveau mot de passe</p>

    @if ($errors->any())
        <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-x-circle-fill me-2"></i>
            <div>{{ $errors->first() }}</div>
        </div>
    @endif

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-3">
            <label class="form-label fw-semibold">Adresse email</label>
            <div class="position-relative">
                <i class="bi bi-envelope position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
                <input type="email" name="email" value="{{ old('email', $request->email) }}"
                    class="form-control ps-5 @error('email') is-invalid @enderror" placeholder="votre@uvci.ci"
                    required autofocus>
            </div>
            @error('email')
                <div class="invalid-feedback d-block mt-1">
                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Nouveau mot de passe</label>
            <div class="position-relative">
                <i class="bi bi-lock position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
                <input type="password" name="password"
                    class="form-control ps-5 @error('password') is-invalid @enderror" placeholder="••••••••"
                    required>
            </div>
            @error('password')
                <div class="invalid-feedback d-block mt-1">
                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Confirmer le mot de passe</label>
            <div class="position-relative">
                <i class="bi bi-lock position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
                <input type="password" name="password_confirmation"
                    class="form-control ps-5 @error('password_confirmation') is-invalid @enderror"
                    placeholder="••••••••" required>
            </div>
            @error('password_confirmation')
                <div class="invalid-feedback d-block mt-1">
                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn-auth"
            style="background: var(---blue) !important; border-color: var(---blue-dark) !important; color: white; width: 100%;">
            Réinitialiser mon mot de passe
        </button>

        <p class="mt-3 text-center">
            <a href="{{ route('login') }}" class="text-decoration-none" style="color: var(---blue);">
                Retour à la connexion
            </a>
        </p>
    </form>
</x-guest-layout>
