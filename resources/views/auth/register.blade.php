<!-- resources/views/auth/register.blade.php -->
<x-guest-layout>
    <x-slot name="title">Inscription</x-slot>

    <p class="auth-title">Créez votre compte</p>

    @if($errors->any())
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle-fill"></i>
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-x-circle-fill me-2"></i>
                <div></div>
            </div>
        @endif

        <div class="mb-3">
            <div class="mb-3">
                <label class="form-label fw-semibold">Nom et prénom</label>
                <div class="position-relative">
                    <i class="bi bi-person position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="form-control ps-5 @error('name') is-invalid @enderror" placeholder="Votre nom et prénom"
                        required autofocus>
                </div>
                @error('name')
                    <div class="invalid-feedback d-block mt-1">
                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Adresse email</label>
                <div class="position-relative">
                    <i
                        class="bi bi-envelope position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
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


            <div class="mb-4">
                <label class="form-label fw-semibold">Mot de passe</label>
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember"> Se souvenir de moi
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-auth"
                style="background: var(---blue) !important; border-color: var(---blue-dark) !important; color: white; width: 100%;">
                <i class="bi bi-box-arrow-in-right"></i>
                S'inscrire
            </button>
            <p class="mt-3 text-center">
                Vous avez déjà un compte ?
                <a href="{{ route('login') }}" class="text-decoration-none" style="color: var(---blue);">
                    Se connecter
                </a>
            </p>
    </form>
</x-guest-layout>