<x-filament-panels::page>
    <div class="bg-gray-900/80 border border-white/10 rounded-2xl p-6 shadow-xl space-y-4 backdrop-blur-md">
        <h3 class="text-base font-bold text-white flex items-center gap-2">
            <i class="fa-solid fa-file-signature text-emerald-400"></i> Your Mock Board Session Transcripts & Analytical Scorecards
        </h3>

        @if(count($sessions) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs text-gray-300">
                    <thead>
                        <tr class="border-b border-white/10 text-gray-400 font-bold uppercase text-[10px] tracking-wider">
                            <th class="py-3 px-4">Exam Category</th>
                            <th class="py-3 px-4">Cadre Placement Verdict</th>
                            <th class="py-3 px-4">Total Questions</th>
                            <th class="py-3 px-4">Overall Score</th>
                            <th class="py-3 px-4">Date</th>
                            <th class="py-3 px-4">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($sessions as $session)
                            <tr class="hover:bg-white/5 transition">
                                <td class="py-3.5 px-4 font-bold text-white">{{ $session->exam_type }} Board</td>
                                <td class="py-3.5 px-4 font-semibold text-emerald-300">{{ $session->recommended_cadre ?? 'Under Evaluation' }}</td>
                                <td class="py-3.5 px-4 font-bold text-gray-300">{{ $session->total_questions }} Questions</td>
                                <td class="py-3.5 px-4 font-extrabold text-emerald-400">{{ $session->overall_score }} / 100</td>
                                <td class="py-3.5 px-4 text-gray-400">{{ $session->created_at->format('d M Y, h:i A') }}</td>
                                <td class="py-3.5 px-4">
                                    <a href="/viva/sessions/{{ $session->id }}" target="_blank" class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 hover:bg-emerald-500/20 font-bold px-3 py-1.5 rounded-lg transition inline-flex items-center gap-1">
                                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i> View Detailed Board Report
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-10 text-gray-400 text-xs">
                <p>No completed viva sessions found in your history.</p>
            </div>
        @endif
    </div>
</x-filament-panels::page>
