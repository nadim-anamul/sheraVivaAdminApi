<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Shera Viva | Mock Viva Portal')</title>
    
    <!-- Premium Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-obsidian: #090D1A;
            --bg-card: rgba(17, 24, 39, 0.7);
            --border-glow: rgba(255, 255, 255, 0.08);
            --primary-emerald: #10B981;
            --primary-glow: rgba(16, 185, 129, 0.15);
            --text-main: #F3F4F6;
            --text-muted: #9CA3AF;
            --accent-blue: #3B82F6;
            --accent-orange: #F59E0B;
            --font-sans: 'Inter', 'Hind Siliguri', sans-serif;
            --font-display: 'Outfit', 'Hind Siliguri', sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-obsidian);
            color: var(--text-main);
            font-family: var(--font-sans);
            overflow-x: hidden;
            line-height: 1.6;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(16, 185, 129, 0.08) 0%, transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.06) 0%, transparent 40%);
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Utility Scrollbars */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--bg-obsidian);
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-emerald);
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            width: 100%;
        }

        /* Glassmorphic Header */
        header {
            background: rgba(9, 13, 26, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-glow);
            padding: 16px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 24px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .logo span {
            color: var(--primary-emerald);
            background: linear-gradient(135deg, var(--primary-emerald), #6EE7B7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 28px;
        }

        .nav-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: color 0.2s ease;
        }

        .nav-links a:hover {
            color: var(--text-main);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-emerald), #059669);
            color: #fff !important;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .btn-secondary {
            background: transparent;
            color: var(--text-main) !important;
            border: 1px solid var(--border-glow);
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.15);
        }

        /* Main Content */
        main {
            flex: 1;
            padding: 40px 0;
        }

        /* Footer */
        footer {
            border-top: 1px solid var(--border-glow);
            padding: 24px 0;
            text-align: center;
            color: var(--text-muted);
            font-size: 13px;
            margin-top: auto;
        }

        /* Form Styles */
        .auth-card {
            background: var(--bg-card);
            border: 1px solid var(--border-glow);
            border-radius: 20px;
            padding: 40px;
            max-width: 480px;
            width: 100%;
            margin: 40px auto;
            backdrop-filter: blur(10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .auth-card h2 {
            font-family: var(--font-display);
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 8px;
            color: #fff;
            text-align: center;
        }

        .auth-card p.subtitle {
            color: var(--text-muted);
            text-align: center;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-main);
        }

        .form-group input {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid var(--border-glow);
            border-radius: 8px;
            padding: 12px 16px;
            color: #fff;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            border-color: var(--primary-emerald);
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.2);
        }

        .text-error {
            color: #EF4444;
            font-size: 12px;
            margin-top: 4px;
        }

        .auth-footer {
            margin-top: 24px;
            text-align: center;
            font-size: 13px;
            color: var(--text-muted);
        }

        .auth-footer a {
            color: var(--primary-emerald);
            text-decoration: none;
            font-weight: 600;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }
        
        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #F87171;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
        }
    </style>
    @yield('styles')
</head>
<body>

    <header>
        <div class="container nav-wrapper">
            <a href="/" class="logo">
                <i class="fa-solid fa-graduation-cap"></i> Shera <span>Viva</span>
            </a>
            
            <nav class="nav-links">
                <a href="/">Home</a>
                @auth
                    <a href="/dashboard">Dashboard</a>
                    <a href="/viva/practice" style="color: var(--primary-emerald); font-weight: 700;"><i class="fa-solid fa-robot"></i> Practice AI Viva</a>
                    <a href="/library">Question Library</a>
                    <a href="/job-updates">Job Updates</a>
                    <a href="/guidelines">Viva Guidelines</a>
                    <form action="/logout" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-secondary" style="padding: 6px 14px; font-size: 12px;">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </button>
                    </form>
                @else
                    <a href="/library">Question Library</a>
                    <a href="/job-updates">Job Updates</a>
                    <a href="/guidelines">Viva Guidelines</a>
                    <a href="/login" class="btn-secondary">Log in</a>
                    <a href="/register" class="btn-primary">Get Started</a>
                @endauth
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer>
        <div class="container">
            &copy; 2026 Shera Viva. All Rights Reserved. Prepare with confidence.
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
