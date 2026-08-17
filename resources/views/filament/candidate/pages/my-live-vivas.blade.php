<x-filament-panels::page>
    <div class="space-y-6">

        <!-- Banner Header -->
        <div class="bg-gradient-to-r from-indigo-950 via-purple-900 to-indigo-950 border border-indigo-500/20 text-white p-6 sm:p-8 rounded-2xl shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="space-y-2">
                <span class="bg-indigo-500/20 text-indigo-300 text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full border border-indigo-500/30">1-on-1 Board Practice</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold">Live Expert Interviews & Video Recordings</h2>
                <p class="text-gray-300 text-sm max-w-xl">
                    Attend scheduled live Google Meet board sessions with former BPSC members and banking experts. Re-watch recorded videos and review official scorecards anytime!
                </p>
            </div>
            <a href="{{ route('filament.candidate.pages.my-packages-page') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-2 shadow-md">
                <i class="fa-solid fa-plus"></i> Book Live Board Session
            </a>
        </div>

        <!-- Scheduled & Past Live Vivas List -->
        <div class="space-y-4">
            <h3 class="text-base font-bold text-white flex items-center gap-2">
                <i class="fa-solid fa-calendar-check text-indigo-400"></i> Your 1-on-1 Live Viva Sessions
            </h3>

            @if(count($liveVivas) > 0)
                <div class="space-y-4">
                    @foreach($liveVivas as $viva)
                        <div class="bg-gray-900/80 border border-white/10 rounded-2xl p-6 shadow-xl space-y-4 backdrop-blur-md hover:border-indigo-500/40 transition">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-white/10 pb-4">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="bg-indigo-500/20 text-indigo-300 text-xs font-black px-3 py-1 rounded-full border border-indigo-500/30 uppercase">
                                            {{ $viva->exam_type }} Board
                                        </span>
                                        <span class="text-xs font-semibold text-gray-400">
                                            Target: {{ $viva->target_position ?? 'General Board' }}
                                        </span>
                                    </div>
                                    <h4 class="text-base font-bold text-white mt-1">
                                        Examiner: {{ $viva->interviewer?->name ?? 'Assigned BPSC Board Expert' }}
                                    </h4>
                                    <p class="text-xs text-gray-400">
                                        {{ $viva->interviewer?->designation ?? 'Senior Civil Service Expert' }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-3">
                                    @if($viva->status === 'scheduled' && !empty($viva->google_meet_url))
                                        <a href="{{ $viva->google_meet_url }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition flex items-center gap-2 shadow-md animate-pulse">
                                            <i class="fa-video"></i> Join Google Meet Session
                                        </a>
                                    @elseif($viva->status === 'completed')
                                        <span class="bg-emerald-500/20 text-emerald-300 text-xs font-bold px-3 py-1 rounded-full border border-emerald-500/30">
                                            <i class="fa-solid fa-check"></i> Completed
                                        </span>
                                    @else
                                        <span class="bg-amber-500/20 text-amber-300 text-xs font-bold px-3 py-1 rounded-full border border-amber-500/30">
                                            <i class="fa-solid fa-clock"></i> {{ ucfirst(str_replace('_', ' ', $viva->status)) }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                                <div class="bg-white/5 p-3 rounded-xl border border-white/10">
                                    <span class="text-gray-400 font-bold uppercase text-[10px]">Scheduled Time:</span>
                                    <div class="font-black text-white text-sm mt-0.5">
                                        {{ $viva->scheduled_at ? $viva->scheduled_at->format('d M Y, h:i A') : 'Awaiting Schedule' }}
                                    </div>
                                </div>

                                <div class="bg-white/5 p-3 rounded-xl border border-white/10">
                                    <span class="text-gray-400 font-bold uppercase text-[10px]">Google Meet Link:</span>
                                    <div class="font-bold text-indigo-300 truncate mt-0.5">
                                        @if($viva->google_meet_url)
                                            <a href="{{ $viva->google_meet_url }}" target="_blank" class="underline">{{ $viva->google_meet_url }}</a>
                                        @else
                                            <span class="text-gray-400 font-normal">Will be generated by Admin</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="bg-white/5 p-3 rounded-xl border border-white/10">
                                    <span class="text-gray-400 font-bold uppercase text-[10px]">Video Recording URL:</span>
                                    <div class="font-bold text-purple-300 truncate mt-0.5">
                                        @if($viva->recording_url)
                                            <a href="{{ $viva->recording_url }}" target="_blank" class="underline flex items-center gap-1">
                                                <i class="fa-solid fa-film"></i> Watch Recording
                                            </a>
                                        @else
                                            <span class="text-gray-400 font-normal">Available post-interview</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($viva->overall_score !== null)
                                <div class="bg-indigo-950/40 border border-indigo-500/30 p-4 rounded-xl space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs font-bold text-indigo-300 uppercase tracking-wider">Official Examiner Board Rating</span>
                                        <span class="text-base font-black text-indigo-200 bg-indigo-900/60 px-3 py-0.5 rounded-lg border border-indigo-500/40">
                                            {{ $viva->overall_score }} / 100
                                        </span>
                                    </div>
                                    @if($viva->board_feedback)
                                        <p class="text-xs text-gray-200 leading-relaxed font-medium">
                                            <strong>Board Feedback:</strong> {{ $viva->board_feedback }}
                                        </p>
                                    @endif
                                    @if($viva->recommendations)
                                        <p class="text-xs text-indigo-300 leading-relaxed">
                                            <strong>Recommendations:</strong> {{ $viva->recommendations }}
                                        </p>
                                    @endif
                                </div>
                            @endif

                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-900/80 border border-white/10 rounded-2xl p-12 text-center text-gray-400 space-y-3 backdrop-blur-md">
                    <i class="fa-solid fa-video-slash text-4xl text-gray-600"></i>
                    <h4 class="text-base font-bold text-white">No Human Live Viva Sessions Booked Yet</h4>
                    <p class="text-xs max-w-md mx-auto text-gray-400">
                        Book a 1-on-1 live mock board interview with former BPSC & Bank examiners. We will generate a Google Meet link and provide a recorded video URL after your session!
                    </p>
                    <a href="{{ route('filament.candidate.pages.my-packages-page') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition shadow-md">
                        <i class="fa-solid fa-cart-plus"></i> Book Live Board Viva
                    </a>
                </div>
            @endif
        </div>

    </div>
</x-filament-panels::page>
