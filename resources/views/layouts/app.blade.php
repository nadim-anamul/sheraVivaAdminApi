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
    <header id="header" class="sticky top-0 z-50 bg-white/90 dark:bg-[#090D1A]/90 backdrop-blur-md border-b border-slate-200/80 dark:border-white/10 transition-all duration-300">
        <div class="max-w-[1320px] mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
            
            <!-- Brand Logo -->
            <a href="/" class="font-display font-black text-xl sm:text-2xl flex items-center gap-2.5 no-underline shrink-0 group">
                <div class="w-9 h-9 rounded-xl bg-emerald-500/10 dark:bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center group-hover:scale-105 transition-transform">
                    <i class="fa-solid fa-graduation-cap text-emerald-500 text-lg"></i>
                </div>
                <div class="flex items-center tracking-tight">
                    <span class="logo-text-shera font-extrabold text-slate-900 dark:text-white">Shera</span>
                    <span class="bg-gradient-to-r from-emerald-500 via-teal-400 to-cyan-400 bg-clip-text text-transparent font-black ml-1">Viva</span>
                </div>
            </a>

            <!-- Desktop Nav Links (Center) -->
            <nav class="hidden lg:flex items-center gap-1 xl:gap-1.5">
                <a href="/" class="nav-item-link {{ request()->is('/') ? 'active' : '' }}">
                    <i class="fa-solid fa-house text-xs opacity-75"></i>
                    <span>হোম</span>
                </a>
                
                <a href="/viva/practice" class="nav-item-badge emerald {{ request()->is('viva/practice*') ? 'active' : '' }}">
                    <i class="fa-solid fa-robot text-xs"></i>
                    <span>এআই প্র্যাকটিস</span>
                </a>
                
                <a href="/live-vivas" class="nav-item-badge indigo {{ request()->is('live-vivas*') ? 'active' : '' }}">
                    <i class="fa-solid fa-video text-xs"></i>
                    <span>লাইভ এক্সপার্ট ভাইভা</span>
                </a>

                <a href="/library" class="nav-item-link {{ request()->is('library*') ? 'active' : '' }}">
                    <i class="fa-solid fa-book-open text-xs opacity-75"></i>
                    <span>প্রশ্ন ও স্টাডি লাইব্রেরি</span>
                </a>

                <a href="/job-updates" class="nav-item-link {{ request()->is('job-updates*') ? 'active' : '' }}">
                    <i class="fa-solid fa-briefcase text-xs opacity-75"></i>
                    <span>ক্যারিয়ার আপডেটস</span>
                </a>

                <a href="/guidelines" class="nav-item-link {{ request()->is('guidelines*') ? 'active' : '' }}">
                    <i class="fa-solid fa-compass text-xs opacity-75"></i>
                    <span>গাইডলাইন</span>
                </a>
            </nav>

            <!-- Desktop Actions (Right: Auth & Theme Toggle) -->
            <div class="hidden lg:flex items-center gap-2.5 shrink-0">
                @auth
                    <a href="/dashboard" class="nav-item-link {{ request()->is('dashboard*') || request()->is('candidate*') ? 'active' : '' }}">
                        <i class="fa-solid fa-gauge text-xs"></i>
                        <span>ড্যাশবোর্ড</span>
                    </a>
                    <form action="/logout" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="nav-btn-outline cursor-pointer">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>লগআউট</span>
                        </button>
                    </form>
                @else
                    <a href="/login" class="nav-btn-outline no-underline">
                        লগইন
                    </a>
                    <a href="/register" class="px-3.5 py-1.5 text-xs font-bold rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white hover:opacity-95 shadow-sm shadow-emerald-500/20 transition no-underline hover:scale-[1.02]">
                        নিবন্ধন
                    </a>
                @endauth

                <!-- Theme Toggle Desktop -->
                <button id="theme-toggle" class="nav-theme-btn" aria-label="Toggle Theme">
                    <i id="theme-icon" class="fa-solid fa-sun text-amber-500"></i>
                    <span id="theme-text">ডে মোড</span>
                </button>
            </div>

            <!-- Mobile Bar Right (Theme Toggle & Menu Drawer Button) -->
            <div class="flex items-center gap-2 lg:hidden">
                <button id="theme-toggle-mobile" class="nav-theme-btn !px-2.5" aria-label="Toggle Theme">
                    <i class="fa-solid fa-sun text-amber-500"></i>
                </button>

                <button id="mobile-menu-toggle" class="p-2 rounded-xl text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-white/10 focus:outline-none transition-colors" aria-label="Toggle menu">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Drawer Dropdown -->
        <div id="navbar-links" class="hidden lg:hidden border-t border-slate-200 dark:border-white/10 bg-white/95 dark:bg-[#090D1A]/95 backdrop-blur-xl px-4 py-5 shadow-2xl transition-all duration-300">
            <div class="flex flex-col gap-2">
                <a href="/" class="mobile-nav-link {{ request()->is('/') ? 'active' : '' }}">
                    <span class="flex items-center gap-2.5">
                        <i class="fa-solid fa-house text-emerald-500"></i>
                        <span>হোম</span>
                    </span>
                    <i class="fa-solid fa-chevron-right text-xs opacity-40"></i>
                </a>

                <a href="/viva/practice" class="mobile-nav-link {{ request()->is('viva/practice*') ? 'active' : '' }}">
                    <span class="flex items-center gap-2.5">
                        <i class="fa-solid fa-robot text-emerald-500"></i>
                        <span>এআই প্র্যাকটিস</span>
                    </span>
                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">এআই</span>
                </a>

                <a href="/live-vivas" class="mobile-nav-link {{ request()->is('live-vivas*') ? 'active' : '' }}">
                    <span class="flex items-center gap-2.5">
                        <i class="fa-solid fa-video text-indigo-500"></i>
                        <span>লাইভ এক্সপার্ট ভাইভা ও ফিডব্যাক</span>
                    </span>
                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20">লাইভ</span>
                </a>

                <a href="/library" class="mobile-nav-link {{ request()->is('library*') ? 'active' : '' }}">
                    <span class="flex items-center gap-2.5">
                        <i class="fa-solid fa-book-open text-amber-500"></i>
                        <span>প্রশ্ন ও স্টাডি লাইব্রেরি</span>
                    </span>
                    <i class="fa-solid fa-chevron-right text-xs opacity-40"></i>
                </a>

                <a href="/job-updates" class="mobile-nav-link {{ request()->is('job-updates*') ? 'active' : '' }}">
                    <span class="flex items-center gap-2.5">
                        <i class="fa-solid fa-briefcase text-blue-500"></i>
                        <span>ক্যারিয়ার আপডেটস</span>
                    </span>
                    <i class="fa-solid fa-chevron-right text-xs opacity-40"></i>
                </a>

                <a href="/guidelines" class="mobile-nav-link {{ request()->is('guidelines*') ? 'active' : '' }}">
                    <span class="flex items-center gap-2.5">
                        <i class="fa-solid fa-compass text-teal-500"></i>
                        <span>গাইডলাইন</span>
                    </span>
                    <i class="fa-solid fa-chevron-right text-xs opacity-40"></i>
                </a>

                <div class="pt-3 mt-2 border-t border-slate-200 dark:border-white/10 flex flex-col gap-2.5">
                    @auth
                        <a href="/dashboard" class="mobile-nav-link {{ request()->is('dashboard*') || request()->is('candidate*') ? 'active' : '' }}">
                            <span class="flex items-center gap-2.5">
                                <i class="fa-solid fa-gauge text-indigo-500"></i>
                                <span>ক্যান্ডিডেট ড্যাশবোর্ড</span>
                            </span>
                        </a>
                        <form action="/logout" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="w-full py-2.5 px-4 rounded-xl font-bold text-xs bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 text-slate-700 dark:text-slate-200 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span>লগআউট</span>
                            </button>
                        </form>
                    @else
                        <div class="grid grid-cols-2 gap-2.5">
                            <a href="/login" class="py-2.5 text-center text-xs font-bold rounded-xl border border-slate-300 dark:border-white/10 text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-white/5 no-underline">
                                লগইন
                            </a>
                            <a href="/register" class="py-2.5 text-center text-xs font-bold rounded-xl bg-emerald-600 text-white shadow-md no-underline">
                                নিবন্ধন
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
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
                document.documentElement.classList.add('dark');
                document.body?.classList.add('dark');
            } else {
                document.documentElement.removeAttribute('data-theme');
                document.body?.removeAttribute('data-theme');
                document.documentElement.classList.remove('dark');
                document.body?.classList.remove('dark');
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
                    document.documentElement.classList.add('dark');
                    document.body.classList.add('dark');
                    if (themeIcon) themeIcon.className = 'fa-solid fa-moon text-indigo-400';
                    if (themeText) themeText.innerText = 'নাইট মোড';
                } else {
                    document.documentElement.removeAttribute('data-theme');
                    document.body.removeAttribute('data-theme');
                    document.documentElement.classList.remove('dark');
                    document.body.classList.remove('dark');
                    if (themeIcon) themeIcon.className = 'fa-solid fa-sun text-amber-500';
                    if (themeText) themeText.innerText = 'ডে মোড';
                }
            }

            const currentTheme = localStorage.getItem('shera_viva_theme') || 'light';
            updateThemeUI(currentTheme);

            function toggleTheme() {
                const isDark = document.body.getAttribute('data-theme') === 'dark' || document.body.classList.contains('dark');
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
