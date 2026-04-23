<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Perpustakaan Digital - Kelola koleksi buku dengan mudah">
    <title>@yield('title', 'Perpustakaan') – Sistem Perpustakaan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg: #0f1117;
            --bg2: #161b27;
            --bg3: #1e2535;
            --border: rgba(255,255,255,0.08);
            --text: #e2e8f0;
            --text-muted: #8892a4;
            --primary: #6366f1;
            --primary-hover: #4f52d9;
            --primary-glow: rgba(99,102,241,0.3);
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --radius: 12px;
            --shadow: 0 4px 24px rgba(0,0,0,0.4);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            min-width: 260px;
            background: var(--bg2);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-logo {
            padding: 24px 20px 20px;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-logo h1 {
            font-size: 1.25rem;
            font-weight: 800;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
        }

        .sidebar-logo p {
            font-size: 0.7rem;
            color: var(--text-muted);
            margin-top: 2px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
        }

        .nav-section-label {
            font-size: 0.65rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 8px 8px 4px;
            margin-top: 8px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
            margin-bottom: 2px;
        }

        .nav-link:hover {
            background: var(--bg3);
            color: var(--text);
        }

        .nav-link.active {
            background: var(--primary-glow);
            color: var(--primary);
            font-weight: 600;
        }

        .nav-link svg { width: 18px; height: 18px; flex-shrink: 0; }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid var(--border);
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-radius: 8px;
            background: var(--bg3);
            margin-bottom: 8px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .user-info p { font-size: 0.8rem; font-weight: 600; }
        .user-info span { font-size: 0.7rem; color: var(--text-muted); }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            padding: 8px;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--text-muted);
            border-radius: 8px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }

        .btn-logout:hover { background: rgba(239,68,68,0.1); color: var(--danger); border-color: rgba(239,68,68,0.3); }

        /* ── Main Content ── */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .topbar {
            padding: 16px 28px;
            border-bottom: 1px solid var(--border);
            background: var(--bg2);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar h2 { font-size: 1.1rem; font-weight: 700; }
        .topbar .breadcrumb { font-size: 0.8rem; color: var(--text-muted); }

        .page-content { padding: 28px; flex: 1; }

        /* ── Alert / Flash ── */
        .alert {
            padding: 12px 16px;
            border-radius: var(--radius);
            font-size: 0.875rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.3); color: #10b981; }
        .alert-error   { background: rgba(239,68,68,0.1);  border: 1px solid rgba(239,68,68,0.3);  color: #ef4444; }
        .alert-warning { background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.3); color: #f59e0b; }

        /* ── Cards ── */
        .card {
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .card-title { font-size: 0.95rem; font-weight: 700; }

        /* ── Stat Cards ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: transform 0.2s, border-color 0.2s;
        }

        .stat-card:hover { transform: translateY(-2px); border-color: var(--primary); }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .stat-icon.purple { background: rgba(99,102,241,0.15); }
        .stat-icon.green  { background: rgba(16,185,129,0.15); }
        .stat-icon.orange { background: rgba(245,158,11,0.15); }
        .stat-icon.red    { background: rgba(239,68,68,0.15); }
        .stat-icon.blue   { background: rgba(59,130,246,0.15); }

        .stat-info p { font-size: 1.6rem; font-weight: 800; line-height: 1; }
        .stat-info span { font-size: 0.75rem; color: var(--text-muted); }

        /* ── Tables ── */
        .table-wrap { overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        thead th {
            text-align: left;
            padding: 10px 14px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
        }
        tbody td {
            padding: 12px 14px;
            border-bottom: 1px solid rgba(255,255,255,0.04);
            vertical-align: middle;
        }
        tbody tr:hover { background: rgba(255,255,255,0.02); }
        tbody tr:last-child td { border-bottom: none; }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            font-family: inherit;
        }

        .btn-primary   { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-hover); box-shadow: 0 0 0 4px var(--primary-glow); }

        .btn-success   { background: rgba(16,185,129,0.15); color: var(--success); border: 1px solid rgba(16,185,129,0.3); }
        .btn-success:hover { background: rgba(16,185,129,0.25); }

        .btn-warning   { background: rgba(245,158,11,0.15); color: var(--warning); border: 1px solid rgba(245,158,11,0.3); }
        .btn-warning:hover { background: rgba(245,158,11,0.25); }

        .btn-danger    { background: rgba(239,68,68,0.15); color: var(--danger); border: 1px solid rgba(239,68,68,0.3); }
        .btn-danger:hover { background: rgba(239,68,68,0.25); }

        .btn-ghost     { background: transparent; color: var(--text-muted); border: 1px solid var(--border); }
        .btn-ghost:hover { background: var(--bg3); color: var(--text); }

        .btn-sm { padding: 5px 10px; font-size: 0.78rem; }

        /* ── Badges ── */
        .badge {
            display: inline-flex;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
        }

        .badge-pinjam  { background: rgba(245,158,11,0.15); color: var(--warning); }
        .badge-kembali { background: rgba(16,185,129,0.15); color: var(--success); }
        .badge-admin   { background: rgba(99,102,241,0.15); color: var(--primary); }
        .badge-student { background: rgba(16,185,129,0.15); color: var(--success); }

        /* ── Forms ── */
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-muted); margin-bottom: 6px; }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            background: var(--bg3);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            font-size: 0.875rem;
            font-family: inherit;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-glow); }
        .form-control::placeholder { color: var(--text-muted); }
        .form-error { font-size: 0.75rem; color: var(--danger); margin-top: 4px; }

        /* ── Pagination ── */
        .pagination { display: flex; gap: 4px; justify-content: center; margin-top: 20px; }
        .pagination a, .pagination span {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            text-decoration: none;
            color: var(--text-muted);
            border: 1px solid var(--border);
            transition: all 0.2s;
        }
        .pagination a:hover { background: var(--bg3); color: var(--text); }
        .pagination .active { background: var(--primary); color: #fff; border-color: var(--primary); }

        /* ── Book Cards (Student) ── */
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 16px;
        }

        .book-card {
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 18px;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s, border-color 0.2s;
        }

        .book-card:hover { transform: translateY(-3px); border-color: var(--primary); }

        .book-cover {
            height: 100px;
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 14px;
        }

        .book-title { font-size: 0.875rem; font-weight: 700; margin-bottom: 4px; line-height: 1.3; }
        .book-author { font-size: 0.75rem; color: var(--text-muted); margin-bottom: 8px; }
        .book-meta { display: flex; align-items: center; justify-content: space-between; margin-top: auto; }
        .stok-tag {
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 600;
        }
        .stok-ada   { background: rgba(16,185,129,0.15); color: var(--success); }
        .stok-habis { background: rgba(239,68,68,0.15);  color: var(--danger); }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .page-content { padding: 16px; }
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="layout">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <h1>📚 Perpustakaan</h1>
            <p>@yield('sidebar-role', 'Sistem Manajemen')</p>
        </div>

        <nav class="sidebar-nav">
            @yield('sidebar-nav')
        </nav>

        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="user-info">
                    <p>{{ auth()->user()->name }}</p>
                    <span>{{ ucfirst(auth()->user()->role) }}</span>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <div class="main-content">
        <div class="topbar">
            <div>
                <div class="breadcrumb">@yield('breadcrumb', 'Home')</div>
                <h2>@yield('page-title', 'Dashboard')</h2>
            </div>
            <div>@yield('topbar-actions')</div>
        </div>

        <div class="page-content">
            @if(session('success'))
                <div class="alert alert-success">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">❌ {{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-error">
                    ❌
                    <ul style="list-style:none;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>
@stack('scripts')
</body>
</html>
