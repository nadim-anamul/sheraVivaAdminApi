<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $item->title }} - SheraViva Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800 font-sans min-h-screen">

    <!-- Header Navigation -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('candidate.library') }}" class="text-gray-500 hover:text-emerald-600 transition">
                    <i class="fa-solid fa-arrow-left text-lg"></i>
                </a>
                <h1 class="text-base font-bold text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-book-open text-emerald-600"></i>
                    <span>Question Bank Detail</span>
                </h1>
            </div>

            <a href="{{ route('viva.practice') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2 rounded-xl transition flex items-center gap-2">
                <i class="fa-solid fa-play"></i> Practice This Category
            </a>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-8 space-y-6">

        <!-- Banner Header -->
        <div class="bg-gradient-to-r from-emerald-950 via-teal-900 to-indigo-950 border border-emerald-500/20 text-white p-6 sm:p-8 rounded-2xl shadow-xl space-y-3">
            <div class="flex flex-wrap items-center gap-2">
                <span class="bg-emerald-500/20 text-emerald-300 text-xs font-black px-3 py-1 rounded-full border border-emerald-500/30 uppercase">
                    {{ $item->exam_type }} Board Experience
                </span>
                @if($item->year)
                    <span class="bg-white/10 text-gray-200 text-xs font-bold px-3 py-1 rounded-full">
                        {{ $item->year }} Edition
                    </span>
                @endif
                @if($item->result)
                    <span class="bg-emerald-400/20 text-emerald-200 text-xs font-bold px-3 py-1 rounded-full">
                        Result: {{ $item->result }}
                    </span>
                @endif
            </div>

            <h2 class="text-2xl sm:text-3xl font-extrabold text-white">{{ $item->title }}</h2>

            <div class="flex flex-wrap gap-4 text-xs text-gray-300 pt-2 border-t border-white/10">
                @if($item->candidate_name)
                    <div><i class="fa-solid fa-user text-emerald-400"></i> Candidate: <strong>{{ $item->candidate_name }}</strong></div>
                @endif
                @if($item->subject)
                    <div><i class="fa-solid fa-graduation-cap text-emerald-400"></i> Subject: <strong>{{ $item->subject }}</strong></div>
                @endif
                @if($item->district)
                    <div><i class="fa-solid fa-location-dot text-emerald-400"></i> District: <strong>{{ $item->district }}</strong></div>
                @endif
                @if($item->board)
                    <div><i class="fa-solid fa-building-columns text-emerald-400"></i> Board: <strong>{{ $item->board }}</strong></div>
                @endif
            </div>
        </div>

        <!-- Cadre Choices & Details Card -->
        @if(!empty($item->choices) && is_array($item->choices))
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm space-y-3">
                <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-emerald-600"></i> Candidate Cadre Preference Choices
                </h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($item->choices as $index => $choice)
                        <span class="bg-gray-100 border border-gray-200 text-gray-800 text-xs font-semibold px-3 py-1.5 rounded-xl">
                            <strong>{{ $index + 1 }}.</strong> {{ is_array($choice) ? implode(', ', $choice) : $choice }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Transcript Q&A Section -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
            <h3 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-comments text-emerald-600"></i> Board Questions & Turn-by-Turn Transcript
            </h3>

            @if(!empty($item->transcript) && is_array($item->transcript))
                <div class="space-y-4">
                    @foreach($item->transcript as $qa)
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 space-y-2">
                            <div class="font-bold text-emerald-800 text-xs flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[10px]">Q</span>
                                <span>{{ $qa['question'] ?? ($qa['speaker'] ?? 'Board Member') }}</span>
                            </div>
                            <div class="text-xs text-gray-800 pl-8 leading-relaxed font-medium">
                                {{ $qa['answer'] ?? ($qa['text'] ?? '') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6 text-gray-500 text-xs">
                    No transcript breakdown available for this item.
                </div>
            @endif
        </div>

    </main>

</body>
</html>
