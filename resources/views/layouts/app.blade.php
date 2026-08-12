<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Shera Viva | Ultimate Government Job Mock Viva & AI Portal')</title>
    
    <!-- SEO Optimization Meta Tags -->
    <meta name="description" content="Shera Viva is the ultimate government job mock interview and oral board preparation portal in Bangladesh. Practice with real-time AI simulators or book live slots.">
    <meta name="keywords" content="shera viva, mock viva, job viva, bcs viva, bank job viva, government job preparation, speech analytics, ai interview, livekit, bangladesh jobs">
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Open Graph (OG) Social Sharing -->
    <meta property="og:site_name" content="Shera Viva">
    <meta property="og:title" content="@yield('title', 'Shera Viva | Ultimate Government Job Mock Viva & AI Portal')">
    <meta property="og:description" content="Practice BCS & Bank oral boards with real-time speech analytics and instant AI scorecards. Book live face-to-face sessions with retired examiners.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('favicon.svg') }}">
    
    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="@yield('title', 'Shera Viva | Ultimate Government Job Mock Viva & AI Portal')">
    <meta name="twitter:description" content="Practice BCS & Bank oral boards with real-time speech analytics and instant AI scorecards.">
    <meta name="twitter:image" content="{{ asset('favicon.svg') }}">
    
    <!-- Relevant SVG Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    
    <!-- Premium Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Vite compiled assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @yield('styles')
    @filamentStyles
</head>
<body class="bg-bg-obsidian text-text-main font-sans min-h-screen flex flex-col antialiased">

    <!-- Glassmorphic Header -->
    <header id="header" class="sticky top-0 z-50 bg-bg-obsidian/85 backdrop-blur-md border-b border-white/5 py-4 transition-all duration-300">
        <div class="max-w-[1200px] mx-auto px-6 w-full flex items-center justify-between">
            <a href="/" class="font-display font-extrabold text-2xl text-white flex items-center gap-2 no-underline hover:opacity-90">
                <i class="fa-solid fa-graduation-cap text-primary-emerald"></i> Shera <span class="bg-gradient-to-r from-primary-emerald to-emerald-300 bg-clip-text text-transparent">Viva</span>
            </a>
            
            <!-- Mobile Toggler Button -->
            <button id="mobile-menu-toggle" class="lg:hidden text-text-muted hover:text-white focus:outline-none transition-colors p-1" aria-label="Toggle menu">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
            
            <!-- Nav Links -->
            <nav id="navbar-links" class="hidden lg:flex items-center gap-7 absolute lg:static top-[73px] left-0 w-full lg:w-auto bg-bg-obsidian lg:bg-transparent border-b lg:border-none border-white/5 p-6 lg:p-0 flex-col lg:flex-row items-stretch lg:items-center">
                <a href="/" class="text-text-muted hover:text-white transition-colors font-medium text-sm no-underline py-2 lg:py-0">Home</a>
                @auth
                    <a href="/dashboard" class="text-text-muted hover:text-white transition-colors font-medium text-sm no-underline py-2 lg:py-0">Dashboard</a>
                    <a href="/viva/practice" class="text-primary-emerald hover:text-emerald-300 transition-colors font-bold text-sm no-underline flex items-center gap-1.5 py-2 lg:py-0">
                        <i class="fa-solid fa-robot"></i> Practice AI Viva
                    </a>
                    <a href="/library" class="text-text-muted hover:text-white transition-colors font-medium text-sm no-underline py-2 lg:py-0">Question Library</a>
                    <a href="/job-updates" class="text-text-muted hover:text-white transition-colors font-medium text-sm no-underline py-2 lg:py-0">Job Updates</a>
                    <a href="/guidelines" class="text-text-muted hover:text-white transition-colors font-medium text-sm no-underline py-2 lg:py-0">Viva Guidelines</a>
                    <form action="/logout" method="POST" class="inline py-2 lg:py-0">
                        @csrf
                        <button type="submit" class="btn-secondary w-full lg:w-auto py-1.5 px-3.5 text-xs">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </button>
                    </form>
                @else
                    <a href="/library" class="text-text-muted hover:text-white transition-colors font-medium text-sm no-underline py-2 lg:py-0">Question Library</a>
                    <a href="/job-updates" class="text-text-muted hover:text-white transition-colors font-medium text-sm no-underline py-2 lg:py-0">Job Updates</a>
                    <a href="/guidelines" class="text-text-muted hover:text-white transition-colors font-medium text-sm no-underline py-2 lg:py-0">Viva Guidelines</a>
                    <div class="flex flex-col lg:flex-row gap-3 mt-4 lg:mt-0">
                        <a href="/login" class="btn-secondary w-full lg:w-auto text-center justify-center">Log in</a>
                        <a href="/register" class="btn-primary w-full lg:w-auto text-center justify-center">Get Started</a>
                    </div>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-white/5 py-12 bg-black/10 mt-auto text-xs">
        <div class="max-w-[1200px] mx-auto px-6 w-full flex flex-col md:flex-row items-center justify-between gap-6">
            <a href="/" class="font-display font-extrabold text-xl text-white no-underline">
                Shera <span class="text-primary-emerald">Viva</span>
            </a>
            
            <p class="text-text-muted text-center md:text-left">&copy; 2026 Shera Viva mock portal. All rights reserved.</p>

            <div class="flex items-center gap-5">
                <a href="/viva/practice" class="text-text-muted hover:text-white no-underline transition-colors">Practice AI</a>
                <a href="/library" class="text-text-muted hover:text-white no-underline transition-colors">Question Library</a>
                <a href="/job-updates" class="text-text-muted hover:text-white no-underline transition-colors">Job Updates</a>
                <a href="/guidelines" class="text-text-muted hover:text-white no-underline transition-colors">Guidelines</a>
                <a href="/admin" class="text-text-muted hover:text-white no-underline transition-colors">Admin Panel</a>
            </div>
        </div>
    </footer>

    <!-- Mobile menu toggle script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('mobile-menu-toggle');
            const menu = document.getElementById('navbar-links');
            
            if (toggle && menu) {
                toggle.addEventListener('click', function () {
                    menu.classList.toggle('hidden');
                    menu.classList.toggle('flex');
                    const icon = toggle.querySelector('i');
                    if (icon) {
                        icon.classList.toggle('fa-bars');
                        icon.classList.toggle('fa-xmark');
                    }
                });
            }
        });
    </script>

    @yield('scripts')
    @filamentScripts
</body>
</html>
