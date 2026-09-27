<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'সেরা ভাইভা | বিসিএস ও ব্যাংক মক ভাইভা এবং এআই পোর্টাল')</title>
    
    <!-- SEO Optimization Meta Tags -->
    <meta name="description" content="সেরা ভাইভা হলো বাংলাদেশের বিসিএস, ব্যাংক ও সরকারি চাকরি ভাইভা প্রস্তুতির নির্ভরযোগ্য অনলাইন প্ল্যাটফর্ম।">
    <meta name="keywords" content="সেরা ভাইভা, মক ভাইভা, বিসিএস ভাইভা, ব্যাংক ভাইভা, সরকারি চাকরি প্রস্তুতি, এআই ভাইভা">
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Open Graph (OG) Social Sharing -->
    <meta property="og:site_name" content="Shera Viva">
    <meta property="og:title" content="@yield('title', 'সেরা ভাইভা | বিসিএস ও ব্যাংক মক ভাইভা এবং এআই পোর্টাল')">
    <meta property="og:description" content="বাস্তবসম্মত এআই সেশন এবং অভিজ্ঞ বিশেষজ্ঞদের সাথে লাইভ ভাইভা দিয়ে আপনার প্রস্তুতি যাচাই করুন।">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('favicon.svg') }}">
    
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

    <!-- Header Navigation Bar -->
    <header id="header" class="sticky top-0 z-50 bg-bg-obsidian/85 backdrop-blur-md border-b border-white/5 py-3.5 transition-all duration-300">
        <div class="max-w-[1200px] mx-auto px-6 w-full flex items-center justify-between">
            <a href="/" class="font-display font-extrabold text-2xl text-white flex items-center gap-2 no-underline hover:opacity-90">
                <i class="fa-solid fa-graduation-cap text-primary-emerald"></i> Shera <span class="bg-gradient-to-r from-primary-emerald to-emerald-300 bg-clip-text text-transparent">Viva</span>
            </a>
            
            <div class="flex items-center gap-3 lg:hidden">
                <!-- Theme toggle button for mobile -->
                <button id="theme-toggle-mobile" class="flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-lg border border-slate-300 bg-slate-100 text-slate-800" aria-label="Toggle Theme">
                    <i class="fa-solid fa-sun text-amber-500"></i>
                </button>

                <!-- Mobile Toggler Button -->
                <button id="mobile-menu-toggle" class="text-text-muted hover:text-white focus:outline-none transition-colors p-1" aria-label="Toggle menu">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
            
            <!-- Nav Links -->
            <nav id="navbar-links" class="hidden lg:flex items-center gap-6 absolute lg:static top-[73px] left-0 w-full lg:w-auto bg-bg-obsidian lg:bg-transparent border-b lg:border-none border-white/5 p-6 lg:p-0 flex-col lg:flex-row items-stretch lg:items-center">
                <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }} text-text-muted hover:text-white transition-colors font-medium text-sm no-underline py-2 lg:py-0">হোম</a>
                
                <!-- Quick Feature Action Buttons in Top Bar (Req #6) -->
                <a href="/viva/practice" class="btn-primary py-1.5 px-3 text-xs flex items-center gap-1.5 no-underline {{ request()->is('viva/practice*') ? 'ring-2 ring-emerald-400 shadow-lg' : '' }}">
                    <i class="fa-solid fa-robot"></i> এআই প্র্যাকটিস
                </a>
                <a href="/live-vivas" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs py-1.5 px-3 rounded-lg flex items-center gap-1.5 no-underline transition {{ request()->is('live-vivas*') ? 'ring-2 ring-indigo-400 shadow-lg' : '' }}">
                    <i class="fa-solid fa-video"></i> লাইভ ভাইভা
                </a>

                <a href="/library" class="nav-link {{ request()->is('library*') ? 'active' : '' }} text-text-muted hover:text-white transition-colors font-medium text-sm no-underline py-2 lg:py-0">প্রশ্ন ও স্টাডি লাইব্রেরি</a>
                <a href="/job-updates" class="nav-link {{ request()->is('job-updates*') ? 'active' : '' }} text-text-muted hover:text-white transition-colors font-medium text-sm no-underline py-2 lg:py-0">ক্যারিয়ার আপডেটস</a>
                <a href="/guidelines" class="nav-link {{ request()->is('guidelines*') ? 'active' : '' }} text-text-muted hover:text-white transition-colors font-medium text-sm no-underline py-2 lg:py-0">গাইডলাইন</a>
                
                @auth
                    <a href="/dashboard" class="nav-link {{ request()->is('dashboard*') || request()->is('candidate*') ? 'active' : '' }} text-text-muted hover:text-white transition-colors font-medium text-sm no-underline py-2 lg:py-0">ড্যাশবোর্ড</a>
                    <form action="/logout" method="POST" class="inline py-2 lg:py-0">
                        @csrf
                        <button type="submit" class="btn-secondary w-full lg:w-auto py-1.5 px-3.5 text-xs">
                            <i class="fa-solid fa-right-from-bracket"></i> লগআউট
                        </button>
                    </form>
                @else
                    <div class="flex flex-col lg:flex-row gap-2.5 mt-4 lg:mt-0 items-stretch lg:items-center">
                        <a href="/login" class="px-3.5 py-1.5 text-xs font-bold rounded-lg border border-slate-300 bg-slate-100 text-slate-800 hover:bg-slate-200 transition text-center no-underline">লগইন</a>
                        <a href="/register" class="btn-primary py-1.5 px-3.5 text-xs text-center justify-center">নিবন্ধন</a>
                    </div>
                @endauth

                <!-- Day/Night Mode Theme Switcher (Req #1 & #9) -->
                <button id="theme-toggle" class="hidden lg:flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-lg border transition-all cursor-pointer bg-slate-100 border-slate-300 text-slate-800 hover:bg-slate-200" aria-label="Toggle Theme">
                    <i id="theme-icon" class="fa-solid fa-sun text-amber-500"></i>
                    <span id="theme-text">ডে মোড</span>
                </button>
            </nav>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer (Cleaned up per Req #10) -->
    <footer class="border-t border-white/5 py-10 bg-black/10 mt-auto text-xs">
        <div class="max-w-[1200px] mx-auto px-6 w-full flex flex-col md:flex-row items-center justify-between gap-6">
            <a href="/" class="font-display font-extrabold text-xl text-white no-underline">
                Shera <span class="text-primary-emerald">Viva</span>
            </a>
            
            <p class="text-text-muted text-center md:text-left">&copy; ২০২৬ সেরা ভাইভা মক পোর্টাল। সর্বস্বত্ব সংরক্ষিত।</p>

            <div class="flex items-center gap-5">
                <a href="/privacy-policy" class="text-text-muted hover:text-white no-underline transition-colors">গোপনীয়তা নীতি</a>
                <a href="/terms-of-service" class="text-text-muted hover:text-white no-underline transition-colors">ব্যবহারের শর্তাবলী</a>
                <a href="/admin" class="text-text-muted hover:text-white no-underline transition-colors">এডমিন প্যানেল</a>
            </div>
        </div>
    </footer>

    <!-- Mobile menu & Theme toggle scripts -->
    <script>
        // Apply saved theme early before render
        (function() {
            const savedTheme = localStorage.getItem('shera_viva_theme') || 'light';
            if (savedTheme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                document.body?.setAttribute('data-theme', 'dark');
            } else {
                document.documentElement.removeAttribute('data-theme');
                document.body?.removeAttribute('data-theme');
            }
        })();

        document.addEventListener('DOMContentLoaded', function () {
            // Theme toggle elements
            const themeBtn = document.getElementById('theme-toggle');
            const themeBtnMobile = document.getElementById('theme-toggle-mobile');
            const themeIcon = document.getElementById('theme-icon');
            const themeText = document.getElementById('theme-text');

            function updateThemeUI(theme) {
                if (theme === 'dark') {
                    document.documentElement.setAttribute('data-theme', 'dark');
                    document.body.setAttribute('data-theme', 'dark');
                    if (themeIcon) themeIcon.className = 'fa-solid fa-moon text-indigo-400';
                    if (themeText) themeText.innerText = 'নাইট মোড';
                } else {
                    document.documentElement.removeAttribute('data-theme');
                    document.body.removeAttribute('data-theme');
                    if (themeIcon) themeIcon.className = 'fa-solid fa-sun text-amber-500';
                    if (themeText) themeText.innerText = 'ডে মোড';
                }
            }

            const currentTheme = localStorage.getItem('shera_viva_theme') || 'light';
            updateThemeUI(currentTheme);

            function toggleTheme() {
                const isDark = document.body.getAttribute('data-theme') === 'dark';
                const newTheme = isDark ? 'light' : 'dark';
                localStorage.setItem('shera_viva_theme', newTheme);
                updateThemeUI(newTheme);
            }

            if (themeBtn) themeBtn.addEventListener('click', toggleTheme);
            if (themeBtnMobile) themeBtnMobile.addEventListener('click', toggleTheme);

            // Mobile menu toggle
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
