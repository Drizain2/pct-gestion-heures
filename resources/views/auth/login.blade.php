<!-- resources/views/auth/login.blade.php -->
<x-guest-layout>
    <x-slot name="title">Connexion</x-slot>

    <p class="auth-title">Connectez-vous à votre espace</p>

    @if($errors->any())
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle-fill"></i>
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Adresse email</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-envelope"></i>
                </span>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email') }}"
                       placeholder="votre@uvci.ci" required autofocus>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Mot de passe</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-lock"></i>
                </span>
                <input type="password" name="password" class="form-control"
                       placeholder="••••••••" required>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox"
                       name="remember" id="remember">
                <label class="form-check-label" for="remember"
                       style="font-size:0.85rem;">
                    Se souvenir de moi
                </label>
            </div>
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   style="font-size:0.82rem; color:var(--uvci-blue);">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        <button type="submit" class="btn-auth">
            <i class="bi bi-box-arrow-in-right"></i>
            Se connecter
        </button>
    </form>
</x-guest-layout>