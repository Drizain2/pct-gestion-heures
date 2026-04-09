<!-- resources/views/auth/login.blade.php -->
<x-guest-layout>
    <x-slot name="title">Connexion</x-slot>

    <h5 class="text-center fw-600 mb-4" style="color:#333;">
        Connexion à votre espace
    </h5>

    @if($errors->any())
        <div class="alert alert-danger py-2" style="border-left:4px solid #E65100; font-size:0.85rem;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Adresse email</label>
            <div class="input-group">
                <span class="input-group-text" style="border-radius:10px 0 0 10px; border-color:#e0e0e0;">
                    <i class="bi bi-envelope" style="color:#2E7D32;"></i>
                </span>
                <input type="email" name="email" class="form-control"
                       style="border-radius:0 10px 10px 0;"
                       value="{{ old('email') }}"
                       placeholder="votre@email.com" required autofocus>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Mot de passe</label>
            <div class="input-group">
                <span class="input-group-text" style="border-radius:10px 0 0 10px; border-color:#e0e0e0;">
                    <i class="bi bi-lock" style="color:#2E7D32;"></i>
                </span>
                <input type="password" name="password" class="form-control"
                       style="border-radius:0 10px 10px 0;"
                       placeholder="••••••••" required>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember" style="font-size:0.85rem;">
                    Se souvenir de moi
                </label>
            </div>
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   style="font-size:0.85rem; color:#E65100; text-decoration:none;">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        <button type="submit" class="btn-login">
            <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
        </button>
    </form>
</x-guest-layout>