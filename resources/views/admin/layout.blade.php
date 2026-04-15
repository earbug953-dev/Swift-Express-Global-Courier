<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swift Express — Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1B4FD8;
            --primary-dark: #1440b8;
            --primary-light: #EEF3FF;
            --accent: #F97316;
            --success: #16A34A;
            --danger: #DC2626;
            --warning: #D97706;
            --sidebar-w: 250px;
            --topbar-h: 60px;
            --bg: #F1F5F9;
            --card: #ffffff;
            --border: #E2E8F0;
            --text: #1E293B;
            --muted: #64748B;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: 13.5px;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-w);
            height: 100vh;
            background: #0F172A;
            position: fixed;
            left: 0; top: 0;
            display: flex;
            flex-direction: column;
            z-index: 200;
            transition: transform 0.3s;
        }

        .sidebar-logo {
            padding: 20px 20px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .sidebar-logo .brand {
            font-size: 15px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.3px;
            line-height: 1.2;
        }
        .sidebar-logo .brand span { color: #60A5FA; }
        .sidebar-logo .sub {
            font-size: 10px;
            color: #94A3B8;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 2px;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 12px 0;
        }
        .nav-section-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #475569;
            padding: 10px 20px 6px;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 20px;
            color: #94A3B8;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: all 0.15s;
        }
        .sidebar-link i { width: 18px; text-align: center; font-size: 13px; }
        .sidebar-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.05);
        }
        .sidebar-link.active {
            color: #fff;
            background: rgba(96,165,250,0.12);
            border-left-color: #60A5FA;
        }
        .sidebar-link .badge-pill {
            margin-left: auto;
            background: var(--accent);
            color: #fff;
            font-size: 10px;
            padding: 2px 7px;
            border-radius: 20px;
            font-weight: 700;
        }

        .sidebar-footer {
            padding: 14px 20px;
            border-top: 1px solid rgba(255,255,255,0.07);
        }
        .sidebar-footer a {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #64748B;
            text-decoration: none;
            font-size: 12.5px;
        }
        .sidebar-footer a:hover { color: #fff; }

        /* ── MAIN AREA ── */
        .main-wrap {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── TOPBAR ── */
        .topbar {
            height: var(--topbar-h);
            background: var(--card);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .topbar .page-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text);
            flex: 1;
        }
        .topbar .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .topbar-icon {
            width: 34px; height: 34px;
            border-radius: 8px;
            border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            color: var(--muted);
            cursor: pointer;
            font-size: 13px;
            transition: all 0.15s;
        }
        .topbar-icon:hover { background: var(--bg); color: var(--primary); }
        .avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        /* ── CONTENT ── */
        .content-area {
            flex: 1;
            padding: 24px;
        }

        /* ── ALERTS ── */
        .alert-toast {
            position: fixed;
            top: 70px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
        }

        /* ── MOBILE TOGGLE ── */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 18px;
            color: var(--text);
            margin-right: 8px;
        }

        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrap { margin-left: 0; }
            .mobile-toggle { display: flex; align-items: center; }
            .overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 199;
            }
            .overlay.show { display: block; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <div class="brand">Swift<span>Express</span></div>
        <div class="sub">Admin Panel</div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-gauge-high"></i> Dashboard
        </a>

        <div class="nav-section-label">Shipments</div>
        <a href="{{ route('admin.shipments') }}" class="sidebar-link {{ request()->routeIs('admin.shipments') ? 'active' : '' }}">
            <i class="fas fa-box"></i> All Shipments
        </a>
        <a href="{{ route('admin.shipments.create') }}" class="sidebar-link {{ request()->routeIs('admin.shipments.create') ? 'active' : '' }}">
            <i class="fas fa-plus-circle"></i> New Shipment
        </a>

        <div class="nav-section-label">System</div>
        <a href="/" class="sidebar-link" target="_blank">
            <i class="fas fa-globe"></i> View Website
        </a>
    </nav>

    <div class="sidebar-footer">
        <a href="#"><i class="fas fa-right-from-bracket"></i> Logout</a>
    </div>
</aside>

<div class="overlay" id="overlay" onclick="closeSidebar()"></div>

<!-- MAIN WRAPPER -->
<div class="main-wrap">

    <!-- TOPBAR -->
    <header class="topbar">
        <button class="mobile-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <div class="page-title">@yield('page-title', 'Dashboard')</div>
        <div class="topbar-right">
            <div class="topbar-icon"><i class="fas fa-bell"></i></div>
            <div class="avatar">A</div>
        </div>
    </header>

    <!-- CONTENT -->
    <main class="content-area">

        @if(session('success'))
        <div class="alert-toast">
            <div class="alert alert-success alert-dismissible d-flex align-items-center shadow" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="alert-toast">
            <div class="alert alert-danger alert-dismissible d-flex align-items-center shadow" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        </div>
        @endif

        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('overlay').classList.toggle('show');
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('overlay').classList.remove('show');
}
// Auto-dismiss toast
setTimeout(() => {
    document.querySelectorAll('.alert-toast .alert').forEach(a => {
        let bsAlert = bootstrap.Alert.getOrCreateInstance(a);
        bsAlert.close();
    });
}, 4000);
</script>
@stack('scripts')
</body>
</html>
