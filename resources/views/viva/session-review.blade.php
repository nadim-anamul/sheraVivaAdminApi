<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $sessionLog->exam_type }} Viva Performance Review - SheraViva</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-gray-50 text-gray-800 font-sans min-h-screen">

    <!-- Top Navigation Bar -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-emerald-600 transition">
                    <i class="fa-solid fa-arrow-left text-lg"></i>
                </a>
                <h1 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-award text-emerald-600"></i>
                    <span>{{ $sessionLog->exam_type }} Viva Session Review</span>
                </h1>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('viva.practice') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs px-4 py-2 rounded-lg transition shadow-sm">
                    <i class="fa-solid fa-play mr-1"></i> Start New Viva Session
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-8 space-y-8">

        <!-- Header Scorecard Banner -->
        <div class="bg-gradient-to-r from-emerald-900 via-emerald-800 to-indigo-950 text-white p-8 rounded-2xl shadow-xl relative overflow-hidden">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative z-10">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                        <i class="fa-solid fa-certificate text-emerald-400"></i> {{ $sessionLog->exam_type }} Board Assessment
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold">{{ $sessionLog->verdict }}</h2>
                    <p class="text-emerald-100 text-sm">
                        Candidate: <strong>{{ $sessionLog->candidate_name }}</strong> | Target Position: <strong>{{ $sessionLog->position }}</strong>
                    </p>
                </div>

                <div class="w-24 h-24 rounded-full bg-white text-emerald-950 flex flex-col items-center justify-center shadow-2xl flex-shrink-0">
                    <span class="text-3xl font-black leading-none">{{ $sessionLog->overall_score }}</span>
                    <span class="text-xs font-bold text-gray-500 mt-1">/ 100</span>
                </div>
            </div>

            <!-- Score Breakdown -->
            @if(!empty($sessionLog->score_breakdown))
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-6 pt-6 border-t border-white/15">
                    <div class="bg-white/10 p-3 rounded-xl">
                        <div class="text-xs text-emerald-200 uppercase font-semibold">Academic Depth</div>
                        <div class="text-lg font-bold mt-0.5">{{ $sessionLog->score_breakdown['academic_subject_knowledge'] ?? 24 }} / 30</div>
                    </div>
                    <div class="bg-white/10 p-3 rounded-xl">
                        <div class="text-xs text-emerald-200 uppercase font-semibold">Laws & Policy</div>
                        <div class="text-lg font-bold mt-0.5">{{ $sessionLog->score_breakdown['legal_policy_constitution'] ?? 25 }} / 30</div>
                    </div>
                    <div class="bg-white/10 p-3 rounded-xl">
                        <div class="text-xs text-emerald-200 uppercase font-semibold">Cadre Aptitude</div>
                        <div class="text-lg font-bold mt-0.5">{{ $sessionLog->score_breakdown['cadre_personality_aptitude'] ?? 20 }} / 25</div>
                    </div>
                    <div class="bg-white/10 p-3 rounded-xl">
                        <div class="text-xs text-emerald-200 uppercase font-semibold">Stress Handling</div>
                        <div class="text-lg font-bold mt-0.5">{{ $sessionLog->score_breakdown['communication_stress_handling'] ?? 11 }} / 15</div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Executive Board Feedback -->
        @if($sessionLog->board_feedback)
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-3">
                <h3 class="text-sm font-bold text-emerald-700 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-user-tie"></i> Chairman Executive Board Rationale
                </h3>
                <p class="text-gray-700 text-sm leading-relaxed">{{ $sessionLog->board_feedback }}</p>
                @if($sessionLog->recommendations)
                    <div class="pt-3 border-t border-gray-100">
                        <div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Strategic Recommendations:</div>
                        <p class="text-gray-600 text-sm whitespace-pre-line">{{ $sessionLog->recommendations }}</p>
                    </div>
                @endif
            </div>
        @endif

        <!-- Q&A & Model Answer Review List -->
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-emerald-600"></i> Turn-by-Turn Q&A & Model Answer Review
                </h3>
                <span class="text-xs font-semibold text-gray-500 bg-gray-200 px-3 py-1 rounded-full">
                    {{ count($sessionLog->transcript ?? []) }} Questions Evaluated
                </span>
            </div>

            @if(!empty($sessionLog->transcript))
                @foreach($sessionLog->transcript as $index => $item)
                    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm space-y-4 hover:border-emerald-300 transition">
                        
                        <!-- Question Header -->
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                            <div class="flex items-center gap-2">
                                <span class="bg-emerald-600 text-white text-xs font-extrabold px-3 py-1 rounded-full">
                                    Question #{{ $item['turn'] ?? ($index + 1) }}
                                </span>
                                <span class="text-xs font-semibold text-gray-500">{{ $item['speaker'] ?? 'Board Chairman' }}</span>
                            </div>
                            @if(isset($item['score']))
                                <span class="text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1 rounded-lg">
                                    Turn Score: {{ $item['score'] }} / 100
                                </span>
                            @endif
                        </div>

                        <!-- Question Statement -->
                        <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl space-y-1">
                            <span class="text-xs font-bold text-blue-700 uppercase tracking-wider">Board Question:</span>
                            <p class="text-blue-950 font-semibold text-base">{{ $item['question'] ?? ($item['text'] ?? 'N/A') }}</p>
                        </div>

                        <!-- Expected Key Points -->
                        @if(!empty($item['expected_key_points']))
                            <div class="flex items-center gap-2 flex-wrap text-xs">
                                <span class="font-bold text-gray-500">Expected Key Concepts:</span>
                                @foreach($item['expected_key_points'] as $pt)
                                    <span class="bg-gray-100 text-gray-700 px-2.5 py-1 rounded-md font-medium">{{ $pt }}</span>
                                @endforeach
                            </div>
                        @endif

                        <!-- Candidate Answer -->
                        <div>
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Your Response:</span>
                            <div class="mt-1 bg-gray-50 border border-gray-200 p-4 rounded-xl text-sm text-gray-800 leading-relaxed">
                                {{ $item['candidate_answer'] ?? ($item['text'] ?? 'No answer recorded.') }}
                            </div>
                        </div>

                        <!-- Feedback -->
                        @if(!empty($item['feedback']))
                            <div class="text-xs text-gray-600 bg-amber-50/50 border border-amber-200/60 p-3 rounded-lg">
                                <strong><i class="fa-solid fa-comment-dots text-amber-600"></i> AI Board Feedback:</strong> {{ $item['feedback'] }}
                            </div>
                        @endif

                        <!-- Recommended 100/100 Model Answer -->
                        @if(!empty($item['model_answer']))
                            <div class="bg-emerald-50 border border-emerald-300 p-4 rounded-xl space-y-2">
                                <span class="text-xs font-black text-emerald-800 uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="fa-solid fa-star text-amber-500"></i> Recommended Model Answer (100/100 Response)
                                </span>
                                <p class="text-emerald-950 text-sm leading-relaxed font-medium">
                                    {{ $item['model_answer'] }}
                                </p>
                            </div>
                        @endif

                    </div>
                @endforeach
            @endif
        </div>

    </main>

</body>
</html>
