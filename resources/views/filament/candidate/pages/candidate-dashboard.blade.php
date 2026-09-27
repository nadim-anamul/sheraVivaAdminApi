<x-filament-panels::page>
    <div class="space-y-6">

        <!-- Banner Header -->
        <div class="bg-gradient-to-r from-emerald-800 via-teal-800 to-indigo-900 dark:from-emerald-950 dark:via-teal-900 dark:to-indigo-950 border border-emerald-500/20 text-white p-6 sm:p-8 rounded-2xl shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
            <div class="space-y-2 z-10">
                <span class="bg-emerald-500/20 text-emerald-100 text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full border border-emerald-500/30">
                    Candidate Portal Dashboard
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white">Welcome back, {{ auth()->user()?->name }}!</h2>
                <p class="text-emerald-100 dark:text-gray-300 text-sm max-w-xl">
                    Practice 10-20 min live BPSC/Bank board viva simulations, track your analytical scorecards, top up AI credits, and join scheduled 1-on-1 expert live vivas.
                </p>
            </div>
            
            <div class="flex items-center gap-3 z-10">
                <a href="/library" class="bg-white/15 hover:bg-white/25 text-white font-bold text-xs px-4 py-3 rounded-xl transition flex items-center gap-2 border border-white/20 no-underline">
                    <i class="fa-solid fa-book-bookmark"></i> প্রশ্ন ও স্টাডি লাইব্রেরি
                </a>
                <a href="{{ route('filament.candidate.pages.ai-simulator') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs px-5 py-3 rounded-xl shadow-lg transition-all transform hover:scale-[1.02] flex items-center gap-2 no-underline">
                    <i class="fa-solid fa-play"></i> Start AI Viva Simulator
                </a>
            </div>

            <!-- Background Decorative Glow -->
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        </div>

        <!-- Candidate Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <div class="bg-white dark:bg-gray-900/80 border border-slate-200 dark:border-white/10 rounded-2xl p-5 shadow-sm dark:shadow-lg flex items-center gap-4 hover:border-amber-500/30 transition">
                <div class="w-12 h-12 rounded-xl bg-amber-500/15 text-amber-500 dark:text-amber-400 border border-amber-500/20 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-coins"></i>
                </div>
                <div>
                    <div class="text-2xl font-black text-slate-900 dark:text-white">{{ $aiCredits }}</div>
                    <div class="text-[11px] font-bold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Available AI Credits</div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900/80 border border-slate-200 dark:border-white/10 rounded-2xl p-5 shadow-sm dark:shadow-lg flex items-center gap-4 hover:border-emerald-500/30 transition">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div>
                    <div class="text-2xl font-black text-slate-900 dark:text-white">{{ $totalSessions }}</div>
                    <div class="text-[11px] font-bold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Completed AI Vivas</div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900/80 border border-slate-200 dark:border-white/10 rounded-2xl p-5 shadow-sm dark:shadow-lg flex items-center gap-4 hover:border-indigo-500/30 transition">
                <div class="w-12 h-12 rounded-xl bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div>
                    <div class="text-2xl font-black text-slate-900 dark:text-white">{{ $averageScore ? $averageScore . '%' : 'N/A' }}</div>
                    <div class="text-[11px] font-bold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Average Performance</div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900/80 border border-slate-200 dark:border-white/10 rounded-2xl p-5 shadow-sm dark:shadow-lg flex items-center gap-4 hover:border-purple-500/30 transition">
                <div class="w-12 h-12 rounded-xl bg-purple-500/15 text-purple-600 dark:text-purple-400 border border-purple-500/20 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-video"></i>
                </div>
                <div>
                    <div class="text-2xl font-black text-slate-900 dark:text-white">{{ $liveBookingsCount }}</div>
                    <div class="text-[11px] font-bold text-slate-500 dark:text-gray-400 uppercase tracking-wider">1-on-1 Live Bookings</div>
                </div>
            </div>

        </div>

        <!-- Recent Mock Viva Sessions Table -->
        <div class="bg-white dark:bg-gray-900/80 border border-slate-200 dark:border-white/10 rounded-2xl p-6 shadow-sm dark:shadow-xl space-y-4">
            <div class="flex justify-between items-center">
                <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-emerald-600 dark:text-emerald-400"></i> Your Recent Mock Viva Performance History
                </h3>
                <a href="{{ route('filament.candidate.pages.my-viva-sessions-page') }}" class="text-xs font-bold text-emerald-600 dark:text-emerald-400 hover:underline flex items-center gap-1">
                    <span>View All Sessions</span> &rarr;
                </a>
            </div>

            @if(count($recentSessions) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs text-slate-600 dark:text-gray-300">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-white/10 text-slate-400 dark:text-gray-400 font-bold uppercase text-[10px] tracking-wider">
                                <th class="py-3 px-4">Board Category</th>
                                <th class="py-3 px-4">Date</th>
                                <th class="py-3 px-4">Board Score</th>
                                <th class="py-3 px-4">Filler Words</th>
                                <th class="py-3 px-4">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                            @foreach($recentSessions as $session)
                                <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition">
                                    <td class="py-3.5 px-4 font-bold text-slate-900 dark:text-white">
                                        {{ $session->vivaCategory?->title ?? 'BCS Board Viva' }}
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-500 dark:text-gray-400">{{ $session->viva_date }}</td>
                                    <td class="py-3.5 px-4 font-extrabold text-emerald-600 dark:text-emerald-400">
                                        {{ $session->evaluation?->score ?? 'N/A' }} / 100
                                    </td>
                                    <td class="py-3.5 px-4 font-bold text-amber-600 dark:text-amber-400">
                                        {{ $session->evaluation?->filler_words_count ?? 0 }} fillers
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <a href="/viva/sessions/{{ $session->id }}" target="_blank" class="bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/30 text-emerald-700 dark:text-emerald-300 hover:bg-emerald-100 dark:hover:bg-emerald-500/20 font-bold px-3 py-1.5 rounded-lg transition inline-flex items-center gap-1.5 no-underline">
                                            <i class="fa-solid fa-eye text-xs"></i> View Full Scorecard
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-10 text-slate-500 dark:text-gray-400 text-xs space-y-3">
                    <p class="text-slate-700 dark:text-gray-300 font-medium">No viva sessions taken yet. You have {{ $aiCredits }} free credit available!</p>
                    <a href="{{ route('filament.candidate.pages.ai-simulator') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-4 py-2.5 rounded-xl text-xs shadow-md transition no-underline">
                        <i class="fa-solid fa-play"></i> Start Your First Viva Now
                    </a>
                </div>
            @endif
        </div>

    </div>
</x-filament-panels::page>
