<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UVCI — {{ $title ?? 'Gestion des Heures' }}</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --vert-primary: #2E7D32;
            --vert-light: #4CAF50;
            --orange-primary: #E65100;
            --orange-light: #FF6F00;
            --gold: #FFC107;
            --bg-sidebar: #1B5E20;
            --bg-page: #F5F5F5;
        }

        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--bg-page);
        }

        /* ─── SIDEBAR ─── */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, var(--bg-sidebar) 0%, #2E7D32 100%);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s;
        }

        .sidebar-brand {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        .sidebar-brand h4 {
            color: var(--gold);
            font-weight: 700;
            margin: 0;
            font-size: 1.1rem;
        }

        .sidebar-brand span {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.75rem;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 10px 20px;
            border-radius: 8px;
            margin: 2px 10px;
            font-size: 0.9rem;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: var(--orange-primary);
            color: #fff;
            transform: translateX(4px);
        }

        .sidebar .nav-link i {
            font-size: 1.1rem;
        }

        .sidebar-section {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 15px 20px 5px;
        }

        /* ─── MAIN CONTENT ─── */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
        }

        /* ─── TOPBAR ─── */
        .topbar {
            background: #fff;
            padding: 12px 25px;
            border-bottom: 2px solid var(--orange-light);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .topbar .page-title {
            font-weight: 600;
            color: var(--vert-primary);
            font-size: 1.1rem;
            margin: 0;
        }

        .topbar .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar .avatar {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--orange-primary), var(--gold));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 0.9rem;
        }

        /* ─── CARDS ─── */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
        }

        .card-header {
            background: linear-gradient(135deg, var(--vert-primary), var(--vert-light));
            color: #fff;
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
            padding: 14px 20px;
        }

        /* ─── BOUTONS ─── */
        .btn-primary {
            background: var(--vert-primary);
            border-color: var(--vert-primary);
        }

        .btn-primary:hover {
            background: var(--vert-light);
            border-color: var(--vert-light);
        }

        .btn-warning {
            background: var(--orange-primary);
            border-color: var(--orange-primary);
            color: #fff;
        }

        .btn-warning:hover {
            background: var(--orange-light);
            border-color: var(--orange-light);
            color: #fff;
        }

        /* ─── STAT CARDS ─── */
        .stat-card {
            border-radius: 12px;
            padding: 20px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-card.green {
            background: linear-gradient(135deg, #2E7D32, #4CAF50);
        }

        .stat-card.orange {
            background: linear-gradient(135deg, #E65100, #FF6F00);
        }

        .stat-card.gold {
            background: linear-gradient(135deg, #F57F17, #FFC107);
        }

        .stat-card.dark {
            background: linear-gradient(135deg, #1B5E20, #388E3C);
        }

        .stat-card .stat-icon {
            font-size: 2.2rem;
            opacity: 0.9;
        }

        .stat-card .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 1;
        }

        .stat-card .stat-label {
            font-size: 0.85rem;
            opacity: 0.85;
        }

        /* ─── TABLES ─── */
        .table thead th {
            background: var(--vert-primary);
            color: #fff;
            font-weight: 500;
            font-size: 0.88rem;
            border: none;
        }

        .table tbody tr:hover {
            background: rgba(76, 175, 80, 0.08);
        }

        /* ─── ALERTS ─── */
        .alert-success {
            border-left: 4px solid var(--vert-primary);
        }

        .alert-danger {
            border-left: 4px solid var(--orange-primary);
        }

        /* ─── PAGE CONTENT ─── */
        .page-content {
            padding: 25px;
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- SIDEBAR --}}
    <div class="sidebar">
        <div class="sidebar-brand">
            <h4><i class="bi bi-mortarboard-fill"></i> UVCI</h4>
            <span>Gestion des Heures</span>
        </div>

        <nav class="mt-3">
            <div class="sidebar-section">Principal</div>

            @role('admin')
            <a href=""
                class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Tableau de bord
            </a>
            @endrole

            @role('secretaire')
            <a href=""
                class="nav-link {{ request()->routeIs('secretaire.*') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Tableau de bord
            </a>
            @endrole

            @role('enseignant')
            <a href=""
                class="nav-link {{ request()->routeIs('enseignant.*') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Mon espace
            </a>
            @endrole

            <div class="sidebar-section">Gestion</div>

            @role('admin|secretaire')
            <a href="" class="nav-link {{ request()->routeIs('enseignants.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Enseignants
            </a>
            <a href="" class="nav-link {{ request()->routeIs('cours.*') ? 'active' : ''  }}">
                <i class="bi bi-book-fill"></i> Cours
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-collection-fill"></i> Ressources
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-clock-history"></i> Activités
            </a>
            @endrole

            @role('admin')
            <div class="sidebar-section">Administration</div>
            <a href="#" class="nav-link">
                <i class="bi bi-people"></i> Utilisateurs
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-gear-fill"></i> Paramètres
            </a>
            @endrole

            <div class="sidebar-section">Exports</div>
            <a href="#" class="nav-link">
                <i class="bi bi-file-earmark-pdf"></i> Rapports PDF
            </a>
            <a href="#" class="nav-link">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
        </nav>

        {{-- Logout en bas --}}
        <div style="position:absolute; bottom:0; width:100%; padding:15px;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                    <i class="bi bi-box-arrow-left"></i> Déconnexion
                </button>
            </form>
        </div>
    </div>

    {{-- MAIN --}}
    <div class="main-content">

        {{-- TOPBAR --}}
        <div class="topbar">
            <h5 class="page-title">{{ $title ?? 'Tableau de bord' }}</h5>
            <div class="user-info">
                <div class="avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <div style="font-weight:600; font-size:0.9rem;">
                        {{ auth()->user()->name }}
                    </div>
                    <div style="font-size:0.75rem; color:#888;">
                        {{ ucfirst(auth()->user()->getRoleNames()->first()) }}
                    </div>
                </div>
            </div>
        </div>

        {{-- ALERTS --}}
        <div class="px-4 pt-3">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Erreurs de validation :</strong>
                <ul class="mb-0 mt-14">
                    @foreach($errors->all() as $error)
                    <li>{{ $error  }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </ul>
            </div>
            @endif
        </div>

        {{-- PAGE CONTENT --}}
        <div class="page-content">
            {{ $slot }}
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>