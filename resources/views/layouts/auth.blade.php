<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Perpustakaan Digital">
    <title>@yield('title', 'Login') – Perpustakaan</title>
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
            --danger: #ef4444;
            --radius: 12px;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: fixed;
            top: -40%;
            left: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 70%);
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -40%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(168,85,247,0.1) 0%, transparent 70%);
            pointer-events: none;
        }
        .auth-box {
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
            box-shadow: 0 24px 64px rgba(0,0,0,0.5);
        }
        .auth-logo {
            text-align: center;
            margin-bottom: 32px;
        }
        .auth-logo .icon {
            font-size: 2.5rem;
            display: block;
            margin-bottom: 8px;
        }
        .auth-logo h1 {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .auth-logo p { font-size: 0.85rem; color: var(--text-muted); margin-top: 4px; }

        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-muted); margin-bottom: 6px; }
        .form-control {
            width: 100%;
            padding: 11px 14px;
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

        .btn-primary {
            display: block;
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            font-family: inherit;
            transition: opacity 0.2s, transform 0.2s;
            margin-top: 8px;
        }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-primary:active { transform: none; }

        .auth-footer { text-align: center; margin-top: 20px; font-size: 0.82rem; color: var(--text-muted); }
        .auth-footer a { color: var(--primary); text-decoration: none; font-weight: 600; }
        .auth-footer a:hover { text-decoration: underline; }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0;
            color: var(--text-muted);
            font-size: 0.75rem;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .alert {
            padding: 11px 14px;
            border-radius: 8px;
            font-size: 0.82rem;
            margin-bottom: 16px;
        }
        .alert-success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.3); color: #10b981; }
        .alert-error   { background: rgba(239,68,68,0.1);  border: 1px solid rgba(239,68,68,0.3);  color: #ef4444; }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

        .remember-row { display: flex; align-items: center; justify-content: space-between; font-size: 0.8rem; }
        .remember-row label { display: flex; align-items: center; gap: 6px; cursor: pointer; color: var(--text-muted); }
        .remember-row input[type=checkbox] { accent-color: var(--primary); }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
