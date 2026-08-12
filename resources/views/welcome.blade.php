@extends('layouts.app')

@section('title', 'Shera Viva | Ultimate Government Job Mock Viva & AI Portal')

@section('content')
<!-- Hero Section -->
<section class="pt-32 pb-20 relative overflow-hidden">
    <div class="max-w-[1200px] mx-auto px-6 w-full grid grid-cols-1 lg:grid-cols-[1.1fr_0.9fr] gap-12 lg:gap-16 items-center">
        <!-- Hero Content Left -->
        <div class="text-left">
            <h1 class="font-display text-4xl lg:text-5xl font-extrabold leading-tight text-white mb-5 tracking-tight">
                <span>Ace Your Oral Board with</span> <br>
                <span class="bg-gradient-to-r from-primary-emerald to-accent-blue bg-clip-text text-transparent">AI-Simulated Board Vivas</span>
            </h1>
            <p class="text-text-muted text-base lg:text-lg mb-9 max-w-[540px]">
                Prepare for BCS, Bangladesh Bank AD, and Primary Teacher oral exams. Practice with our real-time voice simulator or schedule live mock interviews with board experts.
            </p>
            <div class="flex items-center gap-4 mb-12 flex-wrap">
                <a href="/login" class="btn-primary py-3 px-6 text-sm lg:text-base">
                    <i class="fa-solid fa-play"></i> Start AI Practice
                </a>
                <a href="#experts" class="btn-secondary py-3 px-6 text-sm lg:text-base">
                    <i class="fa-solid fa-user-tie"></i> Book Board Panelist
                </a>
            </div>
            
            <div class="flex items-center gap-10 border-t border-white/5 pt-7">
                <div>
                    <h3 class="font-display text-2xl lg:text-3xl font-bold text-white mb-0.5">25k+</h3>
                    <p class="text-xs text-text-muted mb-0 uppercase tracking-wider">Mock Sessions</p>
                </div>
                <div>
                    <h3 class="font-display text-2xl lg:text-3xl font-bold text-white mb-0.5">94.8%</h3>
                    <p class="text-xs text-text-muted mb-0 uppercase tracking-wider">Candidate Success</p>
                </div>
                <div>
                    <h3 class="font-display text-2xl lg:text-3xl font-bold text-white mb-0.5">40+</h3>
                    <p class="text-xs text-text-muted mb-0 uppercase tracking-wider">Board Panelists</p>
                </div>
            </div>
        </div>

        <!-- AI Simulator Right Card -->
        <div class="bg-bg-card border border-border-glow rounded-3xl p-6 backdrop-blur-md shadow-2xl relative overflow-hidden border-t-2 border-t-primary-emerald/40">
            <div class="flex items-center justify-between border-b border-white/5 pb-4 mb-5">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-full bg-primary-emerald text-white flex items-center justify-center text-xs font-bold font-display">SV</div>
                    <div>
                        <h4 class="text-xs font-bold text-white leading-tight">Board Chairman</h4>
                        <p class="text-[10px] text-text-muted">AI Board Evaluation Panel</p>
                    </div>
                </div>
                <div class="bg-primary-emerald/10 text-primary-emerald px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wide flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 bg-primary-emerald rounded-full animate-pulse-custom"></span> Live Engine
                </div>
            </div>

            <!-- Chat simulator box -->
            <div class="h-[200px] overflow-y-auto flex flex-col gap-4 pr-1 mb-5" id="sim-chat-box">
                <div class="chat-bubble bot">
                    আসসালামু আলাইকুম। Shera Viva AI বোর্ডে আপনাকে স্বাগত। আপনার নিজের সম্পর্কে সংক্ষেপে বলুন এবং আপনার ১ম ক্যাডার চয়েস অ্যাডমিনিস্ট্রেশন কেন, তা ব্যাখ্যা করুন।
                </div>
            </div>

            <!-- Interactive visualizer and input area -->
            <div class="flex items-center gap-3 bg-black/20 border border-white/5 rounded-xl p-2 px-3.5">
                <input id="sim-user-input" type="text" class="flex-1 bg-transparent border-none text-white text-xs lg:text-sm outline-none placeholder:text-text-muted" placeholder="Type response in Bangla or English...">
                
                <div id="audio-vis" class="hidden items-center gap-[3px] h-5">
                    <div class="w-0.5 bg-primary-emerald rounded-[1px] animate-bounce-bar" style="height: 12px; animation-delay: 0.1s;"></div>
                    <div class="w-0.5 bg-primary-emerald rounded-[1px] animate-bounce-bar" style="height: 18px; animation-delay: 0.3s;"></div>
                    <div class="w-0.5 bg-primary-emerald rounded-[1px] animate-bounce-bar" style="height: 8px; animation-delay: 0.2s;"></div>
                    <div class="w-0.5 bg-primary-emerald rounded-[1px] animate-bounce-bar" style="height: 14px; animation-delay: 0.4s;"></div>
                </div>

                <button id="sim-send-btn" class="w-8 h-8 bg-primary-emerald hover:bg-emerald-600 text-white border-none rounded-lg cursor-pointer flex items-center justify-center text-xs transition-colors duration-200">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>

            <!-- Scorecard Overlay Summary -->
            <div id="scorecard-overlay" class="scorecard-overlay">
                <div class="w-20 h-20 rounded-full border-4 border-primary-emerald flex flex-col items-center justify-center mb-4 shadow-lg shadow-primary-emerald/15">
                    <span class="font-display text-2xl lg:text-3xl font-extrabold text-white leading-none" id="score-val">00</span>
                    <span class="text-[9px] text-text-muted uppercase tracking-wider mt-0.5">Score</span>
                </div>
                <h4 class="text-white text-sm font-bold mb-4 uppercase tracking-wide">Evaluation Card</h4>
                
                <div class="flex gap-4 w-full mb-5">
                    <div class="flex-1 bg-white/3 border border-white/5 rounded-lg p-2.5 text-center">
                        <h5 class="text-[10px] text-text-muted mb-1 uppercase tracking-wide">Filler Words</h5>
                        <p id="filler-val" class="text-base font-bold text-accent-orange">0</p>
                    </div>
                    <div class="flex-1 bg-white/3 border border-white/5 rounded-lg p-2.5 text-center">
                        <h5 class="text-[10px] text-text-muted mb-1 uppercase tracking-wide">Expression</h5>
                        <p id="tone-val" class="text-xs font-bold text-white leading-tight">Formal</p>
                    </div>
                </div>
                
                <p class="text-xs text-center text-text-muted mb-6 leading-relaxed">
                    Great start! Practice mock boards to correct pronounciation, minimize filler terms, and view structured Board recommendations.
                </p>

                <button onclick="resetSimulator()" class="btn-primary text-xs py-2 px-4 rounded-full">
                    Restart Simulator <i class="fa-solid fa-rotate-left"></i>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-20 border-t border-white/5 bg-bg-obsidian">
    <div class="max-w-[1200px] mx-auto px-6 w-full">
        <div class="text-center mb-14">
            <h2 class="font-display text-3xl lg:text-4xl font-extrabold text-white mb-4">Core System Features</h2>
            <p class="text-text-muted text-sm lg:text-base max-w-[600px] mx-auto">
                Shera Viva provides an end-to-end interactive portal to prepare candidates for competitive oral boards.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-bg-card border border-border-glow rounded-2xl p-8 hover:translate-y-[-5px] hover:border-primary-emerald/30 hover:shadow-2xl hover:shadow-primary-emerald/5 transition-all duration-300">
                <div class="w-12 h-12 bg-primary-glow text-primary-emerald rounded-xl flex items-center justify-center text-xl mb-6">
                    <i class="fa-solid fa-robot"></i>
                </div>
                <h3 class="font-display text-lg font-bold text-white mb-3">AI Simulated Boards</h3>
                <p class="text-sm text-text-muted leading-relaxed">
                    Practice speech simulation answering board questions generated dynamically using Gemini 3.5 Flash, complete with instant scoring.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-bg-card border border-border-glow rounded-2xl p-8 hover:translate-y-[-5px] hover:border-primary-emerald/30 hover:shadow-2xl hover:shadow-primary-emerald/5 transition-all duration-300">
                <div class="w-12 h-12 bg-primary-glow text-primary-emerald rounded-xl flex items-center justify-center text-xl mb-6">
                    <i class="fa-solid fa-video"></i>
                </div>
                <h3 class="font-display text-lg font-bold text-white mb-3">Live WebRTC Rooms</h3>
                <p class="text-sm text-text-muted leading-relaxed">
                    Join video-conferencing rooms signed with secure token access using our LiveKit WebRTC SDK, providing browser-to-browser mock boards.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-bg-card border border-border-glow rounded-2xl p-8 hover:translate-y-[-5px] hover:border-primary-emerald/30 hover:shadow-2xl hover:shadow-primary-emerald/5 transition-all duration-300">
                <div class="w-12 h-12 bg-primary-glow text-primary-emerald rounded-xl flex items-center justify-center text-xl mb-6">
                    <i class="fa-solid fa-book-open-reader"></i>
                </div>
                <h3 class="font-display text-lg font-bold text-white mb-3">Questions & Rules Library</h3>
                <p class="text-sm text-text-muted leading-relaxed">
                    Browse through real-life Bangladesh BCS and Bank oral board transcripts, examiner guidelines, advice notes, and board etiquette.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Expert Panel Section -->
<section id="experts" class="py-20 bg-white/[0.01] border-t border-white/5">
    <div class="max-w-[1200px] mx-auto px-6 w-full">
        <div class="text-center mb-14">
            <h2 class="font-display text-3xl lg:text-4xl font-extrabold text-white mb-4">Board Panel Experts</h2>
            <p class="text-text-muted text-sm lg:text-base max-w-[600px] mx-auto">
                Book slots with seasoned examiners, retired civil servants, and bankers to simulate real board panels.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($interviewers as $interviewer)
                <div class="bg-bg-card border border-border-glow rounded-2xl overflow-hidden hover:translate-y-[-5px] hover:border-accent-blue/30 transition-all duration-300 flex flex-col flex-1">
                    <div class="p-7 flex-1">
                        <div class="flex items-center gap-4 mb-5">
                            <img class="w-16 h-16 rounded-full object-cover border border-white/5" src="{{ $interviewer->avatar_url ?? 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=256&h=256&q=80' }}" alt="Examiner">
                            <div>
                                <h3 class="text-lg font-bold text-white mb-1">{{ $interviewer->name }}</h3>
                                <p class="text-xs text-primary-emerald font-semibold">{{ $interviewer->designation }}</p>
                            </div>
                        </div>
                        <p class="text-xs lg:text-sm text-text-muted leading-relaxed mb-6">{{ $interviewer->bio }}</p>
                        
                        <div class="flex items-center justify-between border-t border-white/5 pt-5">
                            <div class="text-left">
                                <h4 class="font-display text-lg font-bold text-white">BDT {{ $interviewer->base_price }}</h4>
                                <span class="text-[10px] text-text-muted">per 20-min session</span>
                            </div>
                            <div class="bg-accent-blue/10 text-accent-blue px-2.5 py-1 rounded-md text-[10px] font-semibold flex items-center gap-1.5 shrink-0">
                                <i class="fa-solid fa-calendar-check text-[10px]"></i> {{ $interviewer->slots_count }} Slots Available
                            </div>
                        </div>
                    </div>
                    <a href="/admin/bookings/create" class="bg-white/3 border-t border-white/5 text-center py-4 text-text-main font-semibold text-xs no-underline hover:bg-primary-emerald hover:text-white transition-colors duration-200 block">
                        Book Live Session <i class="fa-solid fa-arrow-right-long text-[10px] ml-1.5"></i>
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center text-text-muted py-10 bg-bg-card border border-dashed border-border-glow rounded-2xl">
                    No active board interviewers currently seeded. Visit Filament panel to add interviewers.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Scraped Jobs Portal -->
<section id="jobs" class="py-20 border-t border-white/5 bg-bg-obsidian">
    <div class="max-w-[1200px] mx-auto px-6 w-full">
        <div class="text-center mb-10">
            <h2 class="font-display text-3xl lg:text-4xl font-extrabold text-white mb-4">Government Careers Updates</h2>
            <p class="text-text-muted text-sm lg:text-base max-w-[600px] mx-auto mb-10">
                Real-time scraped Government job notices, board recommendations lists, and BCS circular summaries.
            </p>
            
            <div class="max-w-[500px] mx-auto relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-text-muted text-sm"></i>
                <input id="job-search-input" onkeyup="filterJobs()" type="text" class="w-full bg-[#111827]/50 border border-border-glow rounded-xl py-3.5 pl-11 pr-4 text-white text-sm outline-none transition-all focus:border-primary-emerald focus:shadow-[0_0_15px_rgba(16,185,129,0.1)]" placeholder="Search organization, job title...">
            </div>
        </div>

        <!-- Job portal split columns -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Left: Job Circulars -->
            <div>
                <h3 class="font-display text-lg lg:text-xl font-bold text-white mb-6 flex items-center gap-2.5">
                    <span class="w-2 h-2 rounded-full bg-primary-emerald"></span> Latest Circular Notices
                </h3>
                
                <div class="flex flex-col gap-4">
                    @foreach($circulars as $circ)
                        <div class="bg-bg-card border border-border-glow rounded-xl p-5 hover:border-white/15 hover:bg-[#111827]/90 transition-all duration-200 flex items-start justify-between gap-5 search-target">
                            <div class="flex-1 text-left">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="bg-white/5 text-text-muted py-0.5 px-2 rounded text-[10px] font-semibold job-badge">{{ $circ->organization }}</span>
                                    <span class="bg-accent-blue/15 text-accent-blue py-0.5 px-2 rounded text-[10px] font-bold uppercase tracking-wider">Circular</span>
                                </div>
                                <h4 class="text-sm font-bold text-white leading-snug mb-3 job-title">{{ $circ->title }}</h4>
                                <div class="flex items-center gap-4 text-[11px] text-text-muted">
                                    <span><i class="fa-solid fa-calendar-day mr-1"></i> Published: {{ $circ->published_date?->format('M d, Y') }}</span>
                                </div>
                            </div>
                            <button onclick='openJobModal({!! json_encode($circ) !!})' class="w-10 h-10 bg-white/3 border border-border-glow rounded-xl flex items-center justify-center text-text-muted hover:bg-primary-emerald hover:border-primary-emerald hover:text-white transition-all duration-200 cursor-pointer">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right: Results -->
            <div>
                <h3 class="font-display text-lg lg:text-xl font-bold text-white mb-6 flex items-center gap-2.5">
                    <span class="w-2 h-2 rounded-full bg-accent-blue"></span> Recommendation Results
                </h3>
                
                <div class="flex flex-col gap-4">
                    @foreach($results as $res)
                        <div class="bg-bg-card border border-border-glow rounded-xl p-5 hover:border-white/15 hover:bg-[#111827]/90 transition-all duration-200 flex items-start justify-between gap-5 search-target">
                            <div class="flex-1 text-left">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="bg-white/5 text-text-muted py-0.5 px-2 rounded text-[10px] font-semibold job-badge">{{ $res->organization }}</span>
                                    <span class="bg-primary-emerald/15 text-primary-emerald py-0.5 px-2 rounded text-[10px] font-bold uppercase tracking-wider">Result</span>
                                </div>
                                <h4 class="text-sm font-bold text-white leading-snug mb-3 job-title">{{ $res->title }}</h4>
                                <div class="flex items-center gap-4 text-[11px] text-text-muted">
                                    <span><i class="fa-solid fa-calendar-day mr-1"></i> Published: {{ $res->published_date?->format('M d, Y') }}</span>
                                </div>
                            </div>
                            <button onclick='openJobModal({!! json_encode($res) !!})' class="w-10 h-10 bg-white/3 border border-border-glow rounded-xl flex items-center justify-center text-text-muted hover:bg-accent-blue hover:border-accent-blue hover:text-white transition-all duration-200 cursor-pointer">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mobile App Showcase Section -->
<section id="app" class="py-20 border-t border-white/5 bg-gradient-to-b from-transparent to-primary-emerald/[0.02]">
    <div class="max-w-[1200px] mx-auto px-6 grid grid-cols-1 lg:grid-cols-[0.95fr_1.05fr] gap-16 items-center">
        <!-- Mockup Left -->
        <div class="relative flex justify-center order-2 lg:order-1">
            <div class="w-[280px] h-[560px] bg-black border-8 border-slate-800 rounded-[36px] shadow-2xl p-2.5 relative overflow-hidden">
                <div class="w-[120px] height-[18px] bg-slate-800 absolute top-0 left-1/2 -translate-x-1/2 rounded-b-xl z-10"></div>
                <div class="bg-bg-obsidian w-full h-full rounded-[24px] overflow-hidden flex flex-col border border-white/5 p-4 relative text-left">
                    <div class="flex items-center justify-between mb-5 pt-2">
                        <h5 class="text-xs font-bold text-white">Shera Viva</h5>
                        <i class="fa-solid fa-circle text-primary-emerald text-[6px] animate-pulse"></i>
                    </div>
                    <div class="bg-white/3 border border-border-glow rounded-xl p-3.5 mb-3 text-left">
                        <h6 class="text-[9px] text-text-muted mb-1 uppercase tracking-wider">Average AI Score</h6>
                        <p class="text-sm font-bold text-white mb-0">87%</p>
                    </div>
                    <div class="grid grid-cols-2 gap-2 mb-3">
                        <div class="bg-white/3 border border-border-glow rounded-xl p-2.5 text-left">
                            <h6 class="text-[8px] text-text-muted mb-0.5 uppercase tracking-wider">Mocks Practiced</h6>
                            <p class="text-xs font-bold text-white leading-none">12 Sessions</p>
                        </div>
                        <div class="bg-white/3 border border-border-glow rounded-xl p-2.5 text-left">
                            <h6 class="text-[8px] text-text-muted mb-0.5 uppercase tracking-wider">Upcoming Board</h6>
                            <p class="text-xs font-bold text-accent-blue leading-none">Today 4 PM</p>
                        </div>
                    </div>
                    <div class="bg-primary-emerald/10 border border-primary-emerald/20 rounded-xl p-3 text-[10px] text-primary-emerald text-center font-bold mt-auto">
                        <i class="fa-solid fa-microphone"></i> Active Room Channel
                    </div>
                </div>
            </div>
            
            <!-- QR code float badge -->
            <div class="absolute bottom-[-30px] right-0 lg:right-10 bg-bg-card border border-border-glow rounded-2xl p-4 flex flex-col items-center gap-2.5 shadow-2xl transition-transform duration-200 hover:scale-105 select-none">
                <div class="w-24 h-24 bg-white rounded-lg flex items-center justify-center text-black text-5xl">
                    <i class="fa-solid fa-qrcode"></i>
                </div>
                <span class="text-[9px] font-bold text-text-muted uppercase tracking-wider">Scan APK Code</span>
            </div>
        </div>

        <!-- Showcase content Right -->
        <div class="text-left order-1 lg:order-2">
            <h2 class="font-display text-3xl lg:text-4xl font-extrabold text-white mb-4">Practice Anywhere with our Mobile App</h2>
            <p class="text-text-muted text-sm lg:text-base mb-7">
                Download the Shera Viva Android app to configure push notification alerts, record audio diagnostics, manage slot bookings, and access oral guidelines on the go.
            </p>
            
            <div class="flex flex-col gap-4 mb-9">
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 bg-primary-glow text-primary-emerald rounded-full flex items-center justify-center text-[10px] mt-1 shrink-0">
                        <i class="fa-solid fa-bell"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-white mb-0.5">Instant Push Updates</h4>
                        <p class="text-xs text-text-muted">Get notifications directly when board panelists release evaluation reports.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 bg-primary-glow text-primary-emerald rounded-full flex items-center justify-center text-[10px] mt-1 shrink-0">
                        <i class="fa-solid fa-volume-high"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-white mb-0.5">Audio Response Logging</h4>
                        <p class="text-xs text-text-muted">Record and track audio transcripts for seamless AI speech evaluations.</p>
                    </div>
                </div>
            </div>

            <a href="#" class="btn-primary py-3 px-6 text-sm bg-slate-800 hover:bg-slate-700 border border-white/5 shadow-none inline-flex">
                <i class="fa-brands fa-google-play"></i> Download APK Installer
            </a>
        </div>
    </div>
</section>

<!-- Job Details Modal Overlay Markup -->
<div id="job-modal" class="modal-overlay" onclick="closeJobModal(event)">
    <div class="modal-content" onclick="event.stopPropagation()">
        <button class="modal-close" onclick="closeJobModal(event)"><i class="fa-solid fa-xmark"></i></button>
        <div class="flex gap-2 items-center">
            <span id="modal-badge" class="bg-white/5 text-text-muted py-0.5 px-2 rounded text-[10px] font-semibold">BPSC</span>
            <span id="modal-type" class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wide">Circular</span>
        </div>
        <h3 id="modal-title" class="font-display text-lg lg:text-xl font-bold text-white my-4 leading-snug">Job Title</h3>
        
        <p id="modal-description" class="text-xs lg:text-sm text-text-muted mb-5 leading-relaxed border-b border-white/5 pb-4 min-h-[40px]">Job Description Summary...</p>
        
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <div class="text-[10px] font-bold text-text-muted uppercase tracking-wider">Vacancies</div>
                <div id="modal-vacancies" class="text-sm font-semibold text-white mt-1">1026 posts</div>
            </div>
            <div>
                <div class="text-[10px] font-bold text-text-muted uppercase tracking-wider">Qualifications</div>
                <div id="modal-qualifications" class="text-sm font-semibold text-white mt-1">Graduation</div>
            </div>
            <div>
                <div class="text-[10px] font-bold text-text-muted uppercase tracking-wider">Published Date</div>
                <div id="modal-published" class="text-sm font-semibold text-white mt-1">Aug 10, 2026</div>
            </div>
            <div>
                <div class="text-[10px] font-bold text-text-muted uppercase tracking-wider">Application Deadline</div>
                <div id="modal-deadline" class="text-sm font-semibold text-accent-blue mt-1">Aug 30, 2026</div>
            </div>
        </div>
        
        <a id="modal-download-link" href="#" target="_blank" class="btn-primary w-full justify-center text-xs lg:text-sm py-2.5">
            <i class="fa-solid fa-download"></i> Download / View PDF Notice
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Live Client-side Job search filter
    function filterJobs() {
        const input = document.getElementById('job-search-input');
        const filter = input.value.toLowerCase();
        const items = document.getElementsByClassName('search-target');

        for (let i = 0; i < items.length; i++) {
            const title = items[i].getElementsByClassName('job-title')[0].innerText.toLowerCase();
            const badge = items[i].getElementsByClassName('job-badge')[0].innerText.toLowerCase();
            if (title.indexOf(filter) > -1 || badge.indexOf(filter) > -1) {
                items[i].style.display = "";
            } else {
                items[i].style.display = "none";
            }
        }
    }

    // AI Mock Simulator Interactive Script
    const simInput = document.getElementById('sim-user-input');
    const simSend = document.getElementById('sim-send-btn');
    const chatBox = document.getElementById('sim-chat-box');
    const audioVis = document.getElementById('audio-vis');
    const scorecard = document.getElementById('scorecard-overlay');

    let step = 1;

    simSend.addEventListener('click', handleSimInput);
    simInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') handleSimInput();
    });

    function handleSimInput() {
        const text = simInput.value.trim();
        if (!text) return;

        // 1. Append user response bubble
        appendBubble(text, 'user');
        simInput.value = '';
        simInput.disabled = true;

        // 2. Trigger audio visualizer for AI processing
        audioVis.classList.remove('hidden');
        audioVis.classList.add('flex');
        simSend.style.display = 'none';

        setTimeout(() => {
            // Remove visualizer
            audioVis.classList.remove('flex');
            audioVis.classList.add('hidden');
            simSend.style.display = 'flex';
            simInput.disabled = false;

            if (step === 1) {
                // Bot responds with second query
                appendBubble("চমৎকার। এবার বলুন, বাংলাদেশ ব্যাংকের সাম্প্রতিক রেপো রেট বৃদ্ধির সিদ্ধান্ত মূল্যস্ফীতি নিয়ন্ত্রণে কীভাবে অবদান রাখতে পারে?", 'bot');
                step = 2;
            } else {
                // Show AI Scorecard summary
                const score = Math.floor(Math.random() * (95 - 76) + 76);
                const fillers = Math.floor(Math.random() * 6);
                const tones = ['Excellent & Formal', 'Structured & Confident', 'Slightly Hesitant'];
                const tone = tones[Math.floor(Math.random() * tones.length)];
                
                document.getElementById('score-val').innerText = score;
                document.getElementById('filler-val').innerText = fillers;
                document.getElementById('tone-val').innerText = tone;

                scorecard.classList.add('active');
            }
        }, 2200);
    }

    function appendBubble(text, sender) {
        const bubble = document.createElement('div');
        bubble.classList.add('chat-bubble', sender);
        bubble.innerText = text;
        chatBox.appendChild(bubble);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function resetSimulator() {
        scorecard.classList.remove('active');
        chatBox.innerHTML = `
            <div class="chat-bubble bot">
                আসসালামু আলাইকুম। Shera Viva AI বোর্ডে আপনাকে স্বাগত। আপনার নিজের সম্পর্কে সংক্ষেপে বলুন এবং আপনার ১ম ক্যাডার চয়েস অ্যাডমিনিস্ট্রেশন কেন, তা ব্যাখ্যা করুন।
            </div>
        `;
        step = 1;
    }

    // Job details modal handlers
    function openJobModal(job) {
        document.getElementById('modal-badge').innerText = job.organization;
        
        const typeBadge = document.getElementById('modal-type');
        typeBadge.innerText = job.type === 'circular' ? 'Circular' : 'Result';
        typeBadge.className = job.type === 'circular' 
            ? 'px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wide bg-accent-blue/15 text-accent-blue' 
            : 'px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wide bg-primary-emerald/15 text-primary-emerald';
        
        document.getElementById('modal-title').innerText = job.title;
        document.getElementById('modal-description').innerText = job.description || 'No description summary details provided.';
        document.getElementById('modal-vacancies').innerText = job.vacancies || 'N/A';
        document.getElementById('modal-qualifications').innerText = job.qualifications || 'N/A';
        
        // Format published date
        if (job.published_date) {
            const pubDate = new Date(job.published_date);
            document.getElementById('modal-published').innerText = pubDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        } else {
            document.getElementById('modal-published').innerText = 'N/A';
        }
        
        // Format application deadline
        const deadlineEl = document.getElementById('modal-deadline');
        if (job.application_deadline) {
            const deadDate = new Date(job.application_deadline);
            deadlineEl.innerText = deadDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            deadlineEl.className = 'text-sm font-semibold text-primary-emerald mt-1';
        } else {
            deadlineEl.innerText = 'N/A';
            deadlineEl.className = 'text-sm font-semibold text-text-muted mt-1';
        }
        
        const downloadBtn = document.getElementById('modal-download-link');
        if (job.file_url) {
            downloadBtn.href = job.file_url;
            downloadBtn.style.display = 'flex';
        } else {
            downloadBtn.style.display = 'none';
        }
        
        document.getElementById('job-modal').classList.add('active');
    }

    function closeJobModal(e) {
        document.getElementById('job-modal').classList.remove('active');
    }
</script>
@endsection
