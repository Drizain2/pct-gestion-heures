<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UVCI — {{ $title ?? 'Gestion des Heures' }}</title>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap 5 (grid + utilitaires uniquement) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS UVCI -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body>

<!-- Overlay sidebar (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="app-wrapper">

    <!-- ══ SIDEBAR ══════════════════════════════════════════ -->
    <aside class="sidebar" id="sidebar">

        <!-- Logo -->
        <a href="#" class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <div class="sidebar-brand-text">
                <h4>UVCI</h4>
                <span>Gestion des Heures</span>
            </div>
        </a>

        <!-- Navigation -->
        <nav class="sidebar-nav">

            <div class="sidebar-section-label">Principal</div>

            @role('admin')
            <a href="{{ route('admin.dashboard') }}"
               class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Tableau de bord</span>
            </a>
            @endrole

            @role('secretaire')
            <a href="{{ route('secretaire.dashboard') }}"
               class="nav-item {{ request()->routeIs('secretaire.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Tableau de bord</span>
            </a>
            @endrole

            @role('enseignant')
            <a href="{{ route('enseignant.dashboard') }}"
               class="nav-item {{ request()->routeIs('enseignant.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Mon espace</span>
            </a>
            @endrole

            @role('admin|secretaire')
            <div class="sidebar-section-label">Gestion</div>

            {{-- <a href="{{ route('enseignants.index') }}"
               class="nav-item {{ request()->routeIs('enseignants.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>Enseignants</span>
            </a> --}}

            {{-- <a href="{{ route('cours.index') }}"
               class="nav-item {{ request()->routeIs('cours.*') ? 'active' : '' }}">
                <i class="bi bi-book-fill"></i>
                <span>Cours</span>
            </a> --}}
            @endrole

            @role('admin|secretaire|enseignant')
            {{-- <a href="{{ route('activites.index') }}"
               class="nav-item {{ request()->routeIs('activites.*') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>Activités</span>
                @php
                    $enAttente = \App\Models\Activite::where('statut','en_attente')
                        ->when(auth()->user()->hasRole('enseignant'),
                            fn($q) => $q->where('enseignant_id', auth()->user()->enseignant?->id))
                        ->count();
                @endphp
                @if($enAttente > 0)
                    <span class="nav-badge">{{ $enAttente }}</span>
                @endif
            </a> --}}
            @endrole

            @role('admin|secretaire')
            <div class="sidebar-section-label">Exports</div>

            {{-- <a href="{{ route('exports.index') }}"
               class="nav-item {{ request()->routeIs('exports.*') ? 'active' : '' }}">
                <i class="bi bi-download"></i>
                <span>Exports & Rapports</span>
            </a> --}}
            @endrole

            @role('admin')
            <div class="sidebar-section-label">Administration</div>

            {{-- <a href="{{ route('admin.users.index') }}"
               class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-shield-lock-fill"></i>
                <span>Utilisateurs</span>
            </a>

            <a href="{{ route('admin.parametres.index') }}"
               class="nav-item {{ request()->routeIs('admin.parametres.*') ? 'active' : '' }}">
                <i class="bi bi-gear-fill"></i>
                <span>Paramètres</span>
            </a> --}}
            @endrole

        </nav>

        <!-- Profil + Déconnexion -->
        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                    <div class="sidebar-user-role">
                        {{ ucfirst(auth()->user()->getRoleNames()->first()) }}
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-left"></i>
                    Déconnexion
                </button>
            </form>
        </div>

    </aside>

    <!-- ══ MAIN ═════════════════════════════════════════════ -->
    <div class="main-wrapper">

        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <!-- Toggle mobile -->
                <button class="sidebar-toggle" id="sidebarToggle" type="button">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <h5 class="topbar-title">{{ $title ?? 'Tableau de bord' }}</h5>
            </div>
            <div class="topbar-right">
                <!-- Notifications -->
                {{-- <a href="{{ route('activites.index', ['statut' => 'en_attente']) }}"
                   class="topbar-notif" title="Activités en attente">
                    <i class="bi bi-bell"></i>
                    @if(isset($enAttente) && $enAttente > 0)
                        <span class="topbar-notif-dot"></span>
                    @endif
                </a> --}}
                <!-- Profil -->
                <div class="topbar-user">
                    <div class="topbar-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="d-none d-md-block">
                        <div class="topbar-user-name">{{ auth()->user()->name }}</div>
                        <div class="topbar-user-role">
                            {{ ucfirst(auth()->user()->getRoleNames()->first()) }}
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Contenu principal -->
        <main class="page-content">

            <!-- Flash messages -->
            @if(session('success'))
                <div class="alert alert-success fade-in-up">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger fade-in-up">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger fade-in-up">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div>
                        <strong>Erreurs de validation :</strong>
                        <ul class="mb-0 mt-1" style="padding-left:16px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{ $slot }}

        </main>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // ── Toggle sidebar mobile ──────────────────────────────
    const sidebar        = document.getElementById('sidebar');
    const overlay        = document.getElementById('sidebarOverlay');
    const toggleBtn      = document.getElementById('sidebarToggle');

    function openSidebar() {
        sidebar.classList.add('is-open');
        overlay.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('is-open');
        overlay.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    toggleBtn?.addEventListener('click', () => {
        sidebar.classList.contains('is-open') ? closeSidebar() : openSidebar();
    });

    overlay?.addEventListener('click', closeSidebar);

    // Fermer avec Échap
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeSidebar();
    });

    // Auto-fermer les alertes après 5s
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        });
    }, 5000);
</script>

@stack('scripts')

</body>
</html>