<!-- resources/views/layouts/guest.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UVCI — {{ $title ?? 'Connexion' }}</title>

    <!-- Bootstrap CSS - OBLIGATOIRE pour position-absolute, ps-5, etc -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-logo">
                <div class="auth-logo-icon" style="background: #6f42c1; color: white;">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <h3>UVCI</h3>
                <p>Université Virtuelle de Côte d'Ivoire</p>
            </div>
            {{ $slot }}
        </div>
    </div>

    @stack('scripts')
</body>
</html>