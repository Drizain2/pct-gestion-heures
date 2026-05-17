{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UVCI — {{ $title ?? 'Gestion des Heures' }}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS UVCI -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    @stack('styles')

    <style>
        :root {
            --uvci-blue: #2563eb;
            --uvci-blue-dark: #1e40af;
            --uvci-glass: rgba(255, 255, 255, 0.9);
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        /* --- SIDEBAR FIXE --- */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, #000080 0%, #000080 100%);
            z-index: 1050;
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* --- TOPBAR --- */
        .topbar {
            height: 70px;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* --- CARDS STATISTIQUES --- */
        .stat-card-modern {
            background: #ffffff;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            height: 100%;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-card-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .stat-icon.blue {
            background: #eff6ff;
            color: #2563eb;
        }

        .stat-icon.green {
            background: #f0fdf4;
            color: #16a34a;
        }

        .stat-icon.orange {
            background: #fff7ed;
            color: #ea580c;
        }

        .stat-icon.purple {
            background: #faf5ff;
            color: #9333ea;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 500;
        }

        /* --- LAYOUT ADJUSTMENTS --- */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .page-content {
            padding: 2rem;
            flex-grow: 1;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                left: calc(-1 * var(--sidebar-width));
            }

            .sidebar.is-open {
                left: 0;
            }

            .main-wrapper {
                margin-left: 0;
            }

            .sidebar-overlay.is-open {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1040;
            }
        }

        /* --- PROFIL TOPBAR --- */
        .topbar-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .topbar-avatar {
            width: 32px;
            height: 32px;
            background: var(--uvci-blue);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .nav-link {
            transition: all 0.2s;
        }

        .nav-link:hover {
            color: white !important;
            background: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body>

    {{-- Overlay sidebar mobile --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="app-wrapper">


        {{-- ══════════════════════════════════════════════════════
        SIDEBAR
        ══════════════════════════════════════════════════════ --}}
        <aside class="sidebar" id="sidebar">

            {{-- Logo --}}
            <a href="
                @role('admin'){{ route('admin.dashboard') }}
                @elserole('secretaire'){{ route('secretaire.dashboard') }}
                @elserole('enseignant'){{ route('enseignant.dashboard') }}
                @endrole
            " class="sidebar-brand text-decoration-none">
                <div class="sidebar-brand-icon">
                    <i class="bi bi-mortarboard-fill text-white fs-3"></i>
                </div>
                <div class="sidebar-brand-text">
                    <h4 class="text-white mb-0 fw-bold">UVCI</h4>
                    <span class="text-white-50 small">Gestion des Heures</span>
                </div>
            </a>

            {{-- Navigation --}}
            <nav class="sidebar-nav">

                {{-- ── SECTION PRINCIPALE ────────────────────── --}}
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

                {{-- ── SECTION GESTION (Admin + Secrétaire) ──── --}}
                @role('admin|secretaire')
                <div class="sidebar-section-label">Gestion</div>

                <a href="{{ route('enseignants.index') }}"
                    class="nav-item {{ request()->routeIs('enseignants.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Enseignants</span>
                </a>

                <a href="{{ route('cours.index') }}"
                    class="nav-item {{ request()->routeIs('cours.*') ? 'active' : '' }}">
                    <i class="bi bi-book-fill"></i>
                    <span>Cours</span>
                </a>
                @endrole

                {{-- ── ACTIVITÉS (Tous les rôles) ────────────── --}}
                @role('admin|secretaire|enseignant')
                @php
                    $nbEnAttente = \App\Models\Activite::where('statut', 'en_attente')
                        ->when(
                            auth()->user()->hasRole('enseignant'),
                            fn($q) => $q->where('enseignant_id', auth()->user()->enseignant?->id)
                        )
                        ->count();
                @endphp

                <a href="{{ route('activites.index') }}"
                    class="nav-item {{ request()->routeIs('activites.*') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i>
                    <span>Activités</span>
                    @if($nbEnAttente > 0)
                        <span class="nav-badge">{{ $nbEnAttente }}</span>
                    @endif
                </a>
                @endrole

                {{-- ── RÉCAPITULATIFS (Enseignant) ───────────── --}}
                @role('enseignant')
                @if(auth()->user()->enseignant)
                    <a href="{{ route('activites.recapitulatif', auth()->user()->enseignant) }}"
                        class="nav-item {{ request()->routeIs('activites.recapitulatif') ? 'active' : '' }}">
                        <i class="bi bi-person-lines-fill"></i>
                        <span>Mon récapitulatif</span>
                    </a>
                @endif
                @endrole

                {{-- ── RÉCAPITULATIFS (Admin + Secrétaire) ───── --}}
                @role('admin|secretaire')
                <a href="{{ route('exports.index') }}"
                    class="nav-item {{ request()->routeIs('exports.index') && !request()->has('view') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph-fill"></i>
                    <span>Récapitulatifs</span>
                </a>
                @endrole

                {{-- ── EXPORTS (Admin + Secrétaire) ─────────── --}}

                {{-- ── ADMINISTRATION (Admin uniquement) ─────── --}}
                @role('admin')
                <div class="sidebar-section-label">Administration</div>

                <a href="{{ route('admin.users.index') }}"
                    class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-shield-lock-fill"></i>
                    <span>Utilisateurs</span>
                </a>

                <a href="{{ route('admin.parametres.index') }}"
                    class="nav-item {{ request()->routeIs('admin.parametres.*') ? 'active' : '' }}">
                    <i class="bi bi-gear-fill"></i>
                    <span>Paramètres</span>
                </a>

                <a href="{{ route('admin.annees.index') }}"
                    class="nav-item {{ request()->routeIs('admin.annees.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-fill"></i>
                    <span>Années académiques</span>
                </a>
                @endrole

            </nav>

            {{-- ── PROFIL + DÉCONNEXION ───────────────────────── --}}
            <div class="sidebar-footer">
                @auth
                    <div class="sidebar-user">
                        <div class="sidebar-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="sidebar-user-info">
                            <div class="sidebar-user-name">
                                {{ Str::limit(auth()->user()->name, 20) }}
                            </div>
                            <div class="sidebar-user-role">
                                {{ ucfirst(auth()->user()->getRoleNames()->first() ?? 'Utilisateur') }}
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="px-3 pb-3">
                        @csrf
                        <button type="submit"
                            class="btn btn-outline-danger btn-sm w-100 py-2 d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Déconnexion</span>
                        </button>
                    </form>
                @endauth
            </div>
        </aside>

        {{-- ══════════════════════════════════════════════════════
        MAIN WRAPPER
        ══════════════════════════════════════════════════════ --}}
        <div class="main-wrapper">

            {{-- ── TOPBAR ─────────────────────────────────────── --}}
            <header class="topbar">
                <div class="topbar-left">
                    {{-- Toggle mobile --}}
                    <button class="btn btn-light d-lg-none me-3" id="sidebarToggle">
                        <i class="bi bi-list fs-5"></i>
                    </button>

                    {{-- Fil d'ariane / Titre --}}
                    <div>
                        <h5 class="topbar-title mb-0 fw-bold">{{ $title ?? 'Tableau de bord' }}</h5>
                    </div>
                </div>

                <div class="topbar-right">
                    {{-- Notification activités en attente --}}
                    @role('admin|secretaire')
                    @php
                        $notifCount = \App\Models\Activite::where('statut', 'en_attente')->count();
                    @endphp
                    <a href="{{ route('activites.index', ['statut' => 'en_attente']) }}"
                        class="topbar-notif text-decoration-none" title="{{ $notifCount }} activité(s) en attente">
                        <i class="bi bi-bell"></i>
                        @if($notifCount > 0)
                            <span class="topbar-notif-dot"></span>
                        @endif
                    </a>
                    @endrole

                    {{-- Profil utilisateur --}}
                    @auth
                        <div class="topbar-user ms-3">
                            <div class="topbar-avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="d-none d-md-block">
                                <div class="topbar-user-name fw-bold small">
                                    {{ Str::limit(auth()->user()->name, 18) }}
                                </div>
                                <div class="topbar-user-role text-muted" style="font-size: 0.7rem;">
                                    {{ ucfirst(auth()->user()->getRoleNames()->first() ?? 'Utilisateur') }}
                                </div>
                            </div>
                        </div>
                    @endauth
                </div>
            </header>

            {{-- ── CONTENU PRINCIPAL ──────────────────────────── --}}
            <main class="page-content">

                {{-- HEADER DASHBOARD (Uniquement sur l'index admin) --}}
                @if(request()->routeIs('admin.dashboard'))
                    <div class="dashboard-header mb-5">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <h2 class="fw-bold text-dark mb-1">Bienvenue, Administrateur 👋</h2>
                                <p class="text-muted mb-0">Gérez et supervisez les heures d'enseignement de l'ensemble du
                                    corps professoral de l'UVCI pour l'année universitaire 2025–2026.</p>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-12 col-sm-6 col-xl-3">
                                <div class="stat-card-modern">
                                    <div class="stat-icon blue"><i class="bi bi-people-fill"></i></div>
                                    <div>
                                        <div class="stat-value">{{ $stats['enseignants'] ?? 0 }}</div>
                                        <div class="stat-label">Enseignants</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-xl-3">
                                <div class="stat-card-modern">
                                    <div class="stat-icon green"><i class="bi bi-book-fill"></i></div>
                                    <div>
                                        <div class="stat-value">{{ $stats['cours'] ?? 0 }}</div>
                                        <div class="stat-label">Cours actifs</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-xl-3">
                                <div class="stat-card-modern">
                                    <div class="stat-icon orange"><i class="bi bi-clock-fill"></i></div>
                                    <div>
                                        <div class="stat-value">{{ $heuresMois ?? 0 }}h</div>
                                        <div class="stat-label">Heures ce mois</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-xl-3">
                                <div class="stat-card-modern">
                                    <div class="stat-icon purple"><i class="bi bi-collection-fill"></i></div>
                                    <div>
                                        <div class="stat-value">{{ $stats['ressources'] ?? 0 }}</div>
                                        <div class="stat-label">Ressources</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4 border-0 shadow-sm"
                        role="alert">
                        <i class="bi bi-check-circle-fill"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4 border-0 shadow-sm"
                        role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Contenu Variable --}}
                {{ $slot }}

            </main>

        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // --- LOGIQUE DE LA SIDEBAR ---
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const sidebarToggle = document.getElementById('sidebarToggle');

        function openSidebar() {
            sidebar?.classList.add('is-open');
            overlay?.classList.add('is-open');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar?.classList.remove('is-open');
            overlay?.classList.remove('is-open');
            document.body.style.overflow = '';
        }

        sidebarToggle?.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar?.classList.contains('is-open') ? closeSidebar() : openSidebar();
        });

        overlay?.addEventListener('click', closeSidebar);

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeSidebar();
        });

        // ── Auto-fermeture des alertes après 5s ───────────────────
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-8px)';
                setTimeout(() => alert.remove(), 600);
            }, 5000);
        });
    </script>

    @stack('scripts')

</body>

</html>