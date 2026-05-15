{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UVCI — {{ $title ?? 'Gestion des Heures' }}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
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

        .stat-icon.blue { background: #eff6ff; color: #2563eb; }
        .stat-icon.green { background: #f0fdf4; color: #16a34a; }
        .stat-icon.orange { background: #fff7ed; color: #ea580c; }
        .stat-icon.purple { background: #faf5ff; color: #9333ea; }

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
                background: rgba(0,0,0,0.5);
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
            background: rgba(255,255,255,0.1);
        }
    </style>
</head>
<body>

{{-- Overlay sidebar mobile --}}
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="app-wrapper">

    {{-- SIDEBAR --}}
    <aside class="sidebar" id="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand text-decoration-none p-4 d-flex align-items-center gap-2">
            <i class="bi bi-mortarboard-fill text-white fs-3"></i>
            <div class="text-white">
                <h4 class="mb-0 fw-bold">UVCI</h4>
                <small class="text-white-50">Gestion des Heures</small>
            </div>
        </a>

        <nav class="sidebar-nav px-3 mt-3">
            <div class="text-white-50 small text-uppercase fw-bold mb-2 ps-3" style="font-size: 0.7rem; letter-spacing: 1px;">Menu Principal</div>
            
            @role('admin')
            <a href="{{ route('admin.dashboard') }}" class="nav-link p-3 d-flex align-items-center gap-3 text-white-50 text-decoration-none {{ request()->routeIs('admin.dashboard') ? 'active bg-primary text-white rounded-3 shadow-sm' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Tableau de bord</span>
            </a>
            @endrole

            <a href="{{ route('enseignants.index') }}" class="nav-link p-3 d-flex align-items-center gap-3 text-white-50 text-decoration-none {{ request()->routeIs('enseignants.*') ? 'active bg-primary text-white rounded-3 shadow-sm' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>Enseignants</span>
            </a>

            <a href="{{ route('cours.index') }}" class="nav-link p-3 d-flex align-items-center gap-3 text-white-50 text-decoration-none {{ request()->routeIs('cours.*') ? 'active bg-primary text-white rounded-3 shadow-sm' : '' }}">
                <i class="bi bi-book-fill"></i>
                <span>Cours</span>
            </a>
            
            <a href="{{ route('activites.index') }}" class="nav-link p-3 d-flex align-items-center gap-3 text-white-50 text-decoration-none {{ request()->routeIs('activites.*') ? 'active bg-primary text-white rounded-3 shadow-sm' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>Activités</span>
            </a>

            @role('admin')
            <div class="text-white-50 small text-uppercase fw-bold mt-4 mb-2 ps-3" style="font-size: 0.7rem; letter-spacing: 1px;">Administration</div>
            <a href="{{ route('admin.users.index') }}" class="nav-link p-3 d-flex align-items-center gap-3 text-white-50 text-decoration-none {{ request()->routeIs('admin.users.*') ? 'active bg-primary text-white rounded-3 shadow-sm' : '' }}">
                <i class="bi bi-shield-lock-fill"></i>
                <span>Utilisateurs</span>
            </a>
            <a href="{{ route('admin.parametres.index') }}" class="nav-link p-3 d-flex align-items-center gap-3 text-white-50 text-decoration-none {{ request()->routeIs('admin.parametres.*') ? 'active bg-primary text-white rounded-3 shadow-sm' : '' }}">
                <i class="bi bi-gear-fill"></i>
                <span>Paramètres</span>
            </a>
            @endrole
        </nav>

        <div class="sidebar-footer mt-auto p-3 border-top border-secondary">
            @auth
            <div class="d-flex align-items-center gap-3 p-2 mb-2">
                <div class="topbar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="overflow-hidden">
                    <div class="text-white fw-bold text-truncate small">{{ auth()->user()->name }}</div>
                    <div class="text-white-50" style="font-size: 0.7rem;">{{ ucfirst(auth()->user()->getRoleNames()->first() ?? 'User') }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm w-100 py-2">
                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                </button>
            </form>
            @endauth
        </div>
    </aside>

    {{-- MAIN --}}
    <div class="main-wrapper">
        
        {{-- TOPBAR --}}
        <header class="topbar">
            <div class="d-flex align-items-center w-100">
                <button class="btn btn-light d-lg-none me-3" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item small text-muted">UVCI</li>
                        <li class="breadcrumb-item active fw-bold text-dark small">{{ $title ?? 'Tableau de bord' }}</li>
                    </ol>
                </nav>

                <div class="topbar-right ms-auto">
                    {{-- Notifications --}}
                    @role('admin|secretaire')
                    @php $notifCount = \App\Models\Activite::where('statut','en_attente')->count(); @endphp
                    <a href="{{ route('activites.index', ['statut' => 'en_attente']) }}" class="btn btn-light position-relative p-0 d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px;" title="Activités en attente">
                        <i class="bi bi-bell"></i>
                        @if($notifCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white" style="font-size: 0.6rem;">
                                {{ $notifCount }}
                            </span>
                        @endif
                    </a>
                    @endrole

                    {{-- Profil --}}
                    @auth
                    <div class="topbar-user">
                        <div class="topbar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        <div class="d-none d-md-block">
                            <div class="topbar-user-name fw-bold" style="font-size: 0.85rem;">{{ Str::limit(auth()->user()->name, 12) }}</div>
                            <div class="topbar-user-role small text-muted" style="font-size: 0.7rem;">{{ ucfirst(auth()->user()->getRoleNames()->first() ?? 'User') }}</div>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>
        </header>

        {{-- CONTENU --}}
        <main class="page-content">
            
            {{-- HEADER DASHBOARD (Uniquement sur l'index admin) --}}
            @if(request()->routeIs('admin.dashboard'))
            <div class="dashboard-header mb-5">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h2 class="fw-bold text-dark mb-1">Bienvenue, Administrateur 👋</h2>
                        <p class="text-muted mb-0">Gérez et supervisez les heures d'enseignement de l'ensemble du corps professoral de l'UVCI pour l'année universitaire 2025–2026.</p>
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
                <div class="alert alert-success d-flex align-items-center gap-2 mb-4 border-0 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger d-flex align-items-center gap-2 mb-4 border-0 shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            {{-- Contenu Variable --}}
            {{ $slot }}

        </main>
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Sidebar Toggle
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    toggleBtn?.addEventListener('click', () => {
        sidebar.classList.toggle('is-open');
        overlay.classList.toggle('is-open');
    });

    overlay?.addEventListener('click', () => {
        sidebar.classList.remove('is-open');
        overlay.classList.remove('is-open');
    });
</script>

@stack('scripts')

</body>
</html>