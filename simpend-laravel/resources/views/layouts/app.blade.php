<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | SIMPEND</title>
    <!-- Google Fonts Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: #080d16; 
            color: #e5e7eb; 
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow-x: hidden;
        }
        
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
            padding: 40px 20px; 
            flex: 1;
            width: 100%;
        }
        
        .card { 
            background: rgba(17, 24, 39, 0.7); 
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px; 
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5); 
            padding: 32px; 
            margin-bottom: 24px;
        }
        
        .nav { 
            background: rgba(17, 24, 39, 0.65); 
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            padding: 18px 24px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            position: sticky;
            top: 0;
            z-index: 1000;
            flex-wrap: wrap;
            gap: 12px;
        }
        
        .nav a { 
            color: #9ca3af; 
            text-decoration: none; 
            margin-left: 20px; 
            font-weight: 600;
            font-size: 14px;
            transition: color 0.2s, text-shadow 0.2s;
        }
        
        .nav a:hover { 
            color: #10b981; 
            text-shadow: 0 0 10px rgba(16, 185, 129, 0.3);
        }
        
        .nav .logo { 
            font-size: 22px; 
            font-weight: 800; 
            background: linear-gradient(135deg, #10b981, #84cc16);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-left: 0;
        }
        
        .btn { 
            padding: 10px 22px; 
            border-radius: 10px; 
            border: none; 
            cursor: pointer; 
            font-weight: 700; 
            text-decoration: none; 
            display: inline-block; 
            font-size: 14px;
            transition: all 0.25s ease;
        }
        
        .btn-primary { 
            background: linear-gradient(135deg, #059669, #10b981); 
            color: white; 
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.35);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.5);
            background: linear-gradient(135deg, #047857, #059669);
        }
        
        .btn-success { 
            background: linear-gradient(135deg, #0891b2, #14b8a6); 
            color: white; 
            box-shadow: 0 4px 15px rgba(20, 184, 166, 0.35);
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(20, 184, 166, 0.5);
        }
        
        .btn-danger { 
            background: linear-gradient(135deg, #e11d48, #f43f5e); 
            color: white; 
            box-shadow: 0 4px 15px rgba(244, 63, 94, 0.35);
        }
        
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(244, 63, 94, 0.5);
        }
        
        .btn-outline { 
            background: transparent; 
            border: 1px solid rgba(255, 255, 255, 0.15); 
            color: #d1d5db; 
        }
        
        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            border-color: rgba(255, 255, 255, 0.3);
        }
        
        .form-group { 
            margin-bottom: 20px; 
        }
        
        .form-group label { 
            display: block; 
            margin-bottom: 8px; 
            font-weight: 700; 
            font-size: 13px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .form-group input, .form-group select, .form-group textarea { 
            width: 100%; 
            padding: 12px; 
            background: rgba(17, 24, 39, 0.5); 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            border-radius: 10px; 
            font-size: 14px; 
            color: white;
            transition: all 0.2s;
            font-family: inherit;
        }
        
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none;
            border-color: #10b981;
            background: rgba(17, 24, 39, 0.8);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
        }
        
        .table-wrap {
            overflow-x: auto;
        }
        
        .table { 
            width: 100%; 
            border-collapse: separate; 
            border-spacing: 0;
            margin-top: 16px;
            min-width: 800px;
        }
        
        .table th {
            background: rgba(31, 41, 55, 0.4);
            padding: 16px; 
            text-align: left; 
            font-weight: 700;
            font-size: 13px;
            color: #9ca3af;
            text-transform: uppercase;
            border-bottom: 2px solid rgba(255, 255, 255, 0.08);
        }
        
        .table td { 
            padding: 16px; 
            border-bottom: 1px solid rgba(255, 255, 255, 0.06); 
            color: #e5e7eb;
            font-size: 14px;
        }
        
        .table tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }
        
        .badge { 
            padding: 6px 12px; 
            border-radius: 9999px; 
            font-size: 11px; 
            font-weight: 700; 
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: inline-block;
        }
        
        .badge-pending { 
            background: rgba(245, 158, 11, 0.15); 
            color: #fbbf24; 
            border: 1px solid rgba(245, 158, 11, 0.3);
        }
        
        .badge-disetujui { 
            background: rgba(16, 185, 129, 0.15); 
            color: #34d399; 
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        
        .badge-ditolak { 
            background: rgba(239, 68, 68, 0.15); 
            color: #f87171; 
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        
        .alert { 
            padding: 14px 20px; 
            border-radius: 12px; 
            margin-bottom: 24px; 
            font-size: 14px;
            font-weight: 500;
            border: 1px solid transparent;
        }
        
        .alert-success { 
            background: rgba(16, 185, 129, 0.15); 
            color: #34d399; 
            border-color: rgba(16, 185, 129, 0.25);
        }
        
        .alert-error { 
            background: rgba(239, 68, 68, 0.15); 
            color: #f87171; 
            border-color: rgba(239, 68, 68, 0.25);
        }
        
        .grid-4 { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); 
            gap: 20px; 
            margin-bottom: 24px; 
        }
        
        .stat-card { 
            background: rgba(17, 24, 39, 0.7); 
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 24px; 
            border-radius: 16px; 
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5); 
        }
        
        .stat-card h3 { 
            font-size: 28px; 
            font-weight: 800; 
            margin: 8px 0; 
        }
        
        .footer { 
            text-align: center; 
            padding: 32px; 
            color: #4b5563; 
            margin-top: auto; 
            font-size: 14px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            background: rgba(11, 15, 25, 0.5);
        }

        a {
            color: #10b981;
            text-decoration: none;
            transition: color 0.2s;
        }

        a:hover {
            color: #34d399;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .nav { padding: 14px 16px; }
            .nav a { margin-left: 12px; }
            .container { padding: 24px 16px; }
            .card { padding: 24px; }
            .grid-4 { grid-template-columns: 1fr; }
        }

        @media (max-width: 640px) {
            .nav { flex-direction: column; align-items: flex-start; }
            .nav > div { width: 100%; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 8px; }
            .nav a { margin-left: 0; }
            .nav .logo { margin-bottom: 8px; }
        }
    </style>
</head>
<body>
    <!-- Background glowing decorative circles -->
    <div style="position: fixed; width: 45vw; height: 45vw; border-radius: 50%; background: radial-gradient(circle, rgba(16, 185, 129, 0.07) 0%, rgba(0,0,0,0) 70%); top: -15%; left: -15%; z-index: -1; pointer-events: none; filter: blur(60px);"></div>
    <div style="position: fixed; width: 50vw; height: 50vw; border-radius: 50%; background: radial-gradient(circle, rgba(59, 130, 246, 0.05) 0%, rgba(0,0,0,0) 70%); bottom: -20%; right: -20%; z-index: -1; pointer-events: none; filter: blur(70px);"></div>

    <nav class="nav">
        <a href="{{ Auth::check() && Auth::user()->isAdmin() ? route('admin.dashboard') : (Auth::check() ? route('pendaki.dashboard') : route('login')) }}" class="logo">⛰️ SIMPEND</a>
        <div>
            <a href="{{ route('orang-hilang.public') }}">🔍 Orang Hilang</a>
            @guest
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @else
                @if(Auth::user()->role == 'pendaki')
                <a href="{{ route('pendaki.notifications') }}" style="position: relative; margin-right: 20px;">
                    🔔 Notifikasi
                    @if(Auth::user()->unreadNotifications->count() > 0)
                        <span style="position: absolute; top: -10px; right: -12px; background: #dc2626; color: white; border-radius: 50%; padding: 2px 6px; font-size: 10px; font-weight: bold; box-shadow: 0 0 8px rgba(220, 38, 38, 0.6);">
                            {{ Auth::user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>
                @endif
                <span style="color: #e5e7eb; margin-left: 20px; font-size: 14px; font-weight: 600;">
                    👤 {{ Auth::user()->name }}
                </span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline; margin-left: 15px;">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="padding: 6px 12px; font-size: 12px;">Logout</button>
                </form>
            @endguest
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif
        @yield('content')
    </div>

    <div class="footer">© 2026 SIMPEND - Sistem Pendaftaran Pendakian. Made with 💚 for Safety Hiking.</div>
</body>
</html>
