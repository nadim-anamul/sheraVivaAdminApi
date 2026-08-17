<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Human Live Vivas & Google Meet - SheraViva</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-gray-50 text-gray-800 font-sans min-h-screen">

    <!-- Header Navigation -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-emerald-600 transition">
                    <i class="fa-solid fa-arrow-left text-lg"></i>
                </a>
                <h1 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-video text-indigo-600"></i>
                    <span>Human Expert Live Vivas</span>
                </h1>
            </div>
            
            <a href="{{ route('candidate.packages') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs px-4 py-2 rounded-xl transition flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Book Live Board Session
            </a>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-8 space-y-8">

        <!-- Banner Header -->
        <div class="bg-gradient-to-r from-indigo-950 via-indigo-900 to-purple-950 text-white p-8 rounded-2xl shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="space-y-2">
                <span class="bg-white/20 text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full">1-on-1 Board Practice</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold">Live Expert Interviews & Video Recordings</h2>
                <p class="text-indigo-100 text-sm max-w-xl">
                    Attend scheduled live Google Meet board sessions with former BPSC members and banking experts. Re-watch recorded videos and review official scorecards anytime!
                </p>
            </div>
        </div>

        <!-- Scheduled & Past Live Vivas List -->
        <div class="space-y-6">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-calendar-check text-indigo-600"></i> Your 1-on-1 Live Viva Sessions
            </h3>

            @if($liveVivas->count() > 0)
                <div class="space-y-4">
                    @foreach($liveVivas as $viva)
                        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm space-y-4 hover:border-indigo-300 transition">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-gray-100 pb-4">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="bg-indigo-100 text-indigo-800 text-xs font-black px-3 py-1 rounded-full uppercase">
                                            {{ $viva->exam_type }} Board
                                        </span>
                                        <span class="text-xs font-semibold text-gray-500">
                                            Target: {{ $viva->target_position ?? 'General Board' }}
                                        </span>
                                    </div>
                                    <h4 class="text-base font-bold text-gray-900 mt-1">
                                        Examiner: {{ $viva->interviewer?->name ?? 'Assigned BPSC Board Expert' }}
                                    </h4>
                                    <p class="text-xs text-gray-500">
                                        {{ $viva->interviewer?->designation ?? 'Senior Civil Service Expert' }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-3">
                                    @if($viva->status === 'scheduled' && !empty($viva->google_meet_url))
                                        <a href="{{ $viva->google_meet_url }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition flex items-center gap-2 shadow-md animate-pulse">
                                            <i class="fa-video"></i> Join Google Meet Session
                                        </a>
                                    @elseif($viva->status === 'completed')
                                        <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full">
                                            <i class="fa-solid fa-check"></i> Completed
                                        </span>
                                    @else
                                        <span class="bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full">
                                            <i class="fa-solid fa-clock"></i> {{ ucfirst(str_replace('_', ' ', $viva->status)) }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                                <div class="bg-gray-50 p-3 rounded-xl">
                                    <span class="text-gray-500 font-bold uppercase">Scheduled Time:</span>
                                    <div class="font-black text-gray-900 text-sm mt-0.5">
                                        {{ $viva->scheduled_at ? $viva->scheduled_at->format('d M Y, h:i A') : 'Awaiting Schedule' }}
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-3 rounded-xl">
                                    <span class="text-gray-500 font-bold uppercase">Google Meet Link:</span>
                                    <div class="font-bold text-indigo-700 truncate mt-0.5">
                                        @if($viva->google_meet_url)
                                            <a href="{{ $viva->google_meet_url }}" target="_blank" class="underline">{{ $viva->google_meet_url }}</a>
                                        @else
                                            <span class="text-gray-400 font-normal">Will be generated by Admin</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-3 rounded-xl">
                                    <span class="text-gray-500 font-bold uppercase">Video Recording URL:</span>
                                    <div class="font-bold text-purple-700 truncate mt-0.5">
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
                                <div class="bg-indigo-50/70 border border-indigo-200 p-4 rounded-xl space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs font-bold text-indigo-900 uppercase tracking-wider">Official Examiner Board Rating</span>
                                        <span class="text-lg font-black text-indigo-900 bg-white px-3 py-0.5 rounded-lg border border-indigo-200">
                                            {{ $viva->overall_score }} / 100
                                        </span>
                                    </div>
                                    @if($viva->board_feedback)
                                        <p class="text-xs text-indigo-950 leading-relaxed font-medium">
                                            <strong>Board Feedback:</strong> {{ $viva->board_feedback }}
                                        </p>
                                    @endif
                                    @if($viva->recommendations)
                                        <p class="text-xs text-indigo-900 leading-relaxed">
                                            <strong>Recommendations:</strong> {{ $viva->recommendations }}
                                        </p>
                                    @endif
                                </div>
                            @endif

                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white border border-gray-200 rounded-2xl p-12 text-center text-gray-500 space-y-3">
                    <i class="fa-solid fa-video-slash text-4xl text-gray-300"></i>
                    <h4 class="text-base font-bold text-gray-800">No Human Live Viva Sessions Booked Yet</h4>
                    <p class="text-xs max-w-md mx-auto">
                        Book a 1-on-1 live mock board interview with former BPSC & Bank examiners. We will generate a Google Meet link and provide a recorded video URL after your session!
                    </p>
                    <a href="{{ route('candidate.packages') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition">
                        <i class="fa-solid fa-cart-plus"></i> Book Live Board Viva
                    </a>
                </div>
            @endif
        </div>

    </main>

</body>
</html>
