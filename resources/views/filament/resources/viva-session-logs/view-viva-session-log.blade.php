<x-filament-panels::page>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .final-score-card {
            background: linear-gradient(135deg, #064E3B 0%, #065F46 50%, #1E3A8A 100%);
            color: #ffffff;
            padding: 28px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(6, 95, 70, 0.2);
            margin-bottom: 24px;
        }

        .qa-card {
            background: #ffffff;
            border: 1px solid #E5E7EB;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .dark .qa-card {
            background: #111827;
            border-color: #1F2937;
            box-shadow: none;
        }

        .model-answer-box {
            background: #ECFDF5;
            border: 1px solid #10B981;
            border-radius: 12px;
            padding: 18px;
            color: #065F46;
        }

        .dark .model-answer-box {
            background: rgba(16, 185, 129, 0.08);
            border-color: #059669;
            color: #34D399;
        }
    </style>

    <div style="display: flex; flex-direction: column; gap: 24px;">
        
        <!-- Header & Executive Scorecard -->
        <div class="final-score-card">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.2); padding-bottom: 16px;">
                <div>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                        <span style="background: rgba(255,255,255,0.2); padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 800; text-transform: uppercase;">
                            {{ $record->exam_type }}
                        </span>
                        <span style="font-size: 13px; opacity: 0.9;">Candidate: <strong>{{ $record->candidate_name }}</strong></span>
                    </div>
                    <h2 style="font-size: 24px; font-weight: 800; margin-top: 2px;">{{ $record->verdict ?? 'Recommended' }}</h2>
                    <div style="font-size: 13px; opacity: 0.85; margin-top: 2px;">Target Position: {{ $record->position }}</div>
                </div>

                <div style="width: 95px; height: 95px; border-radius: 50%; background: #ffffff; color: #065F46; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(0,0,0,0.2);">
                    <span style="font-size: 28px; font-weight: 900; line-height: 1;">{{ $record->overall_score }}</span>
                    <span style="font-size: 11px; font-weight: 700; color: #6B7280;">/ 100</span>
                </div>
            </div>

            <!-- Category Breakdown -->
            @if(!empty($record->score_breakdown))
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 10px; margin-bottom: 20px;">
                    <div style="background: rgba(255,255,255,0.1); padding: 12px; border-radius: 10px;">
                        <div style="font-size: 11px; opacity: 0.85; font-weight: 700; text-transform: uppercase;">Academic Knowledge</div>
                        <div style="font-size: 18px; font-weight: 800; margin-top: 2px;">{{ $record->score_breakdown['academic_subject_knowledge'] ?? 24 }} / 30</div>
                    </div>
                    <div style="background: rgba(255,255,255,0.1); padding: 12px; border-radius: 10px;">
                        <div style="font-size: 11px; opacity: 0.85; font-weight: 700; text-transform: uppercase;">Laws & Constitution</div>
                        <div style="font-size: 18px; font-weight: 800; margin-top: 2px;">{{ $record->score_breakdown['legal_policy_constitution'] ?? 25 }} / 30</div>
                    </div>
                    <div style="background: rgba(255,255,255,0.1); padding: 12px; border-radius: 10px;">
                        <div style="font-size: 11px; opacity: 0.85; font-weight: 700; text-transform: uppercase;">Cadre Personality</div>
                        <div style="font-size: 18px; font-weight: 800; margin-top: 2px;">{{ $record->score_breakdown['cadre_personality_aptitude'] ?? 20 }} / 25</div>
                    </div>
                    <div style="background: rgba(255,255,255,0.1); padding: 12px; border-radius: 10px;">
                        <div style="font-size: 11px; opacity: 0.85; font-weight: 700; text-transform: uppercase;">Stress Handling</div>
                        <div style="font-size: 18px; font-weight: 800; margin-top: 2px;">{{ $record->score_breakdown['communication_stress_handling'] ?? 11 }} / 15</div>
                    </div>
                </div>
            @endif

            <!-- Board Feedback & Recommendations -->
            @if($record->board_feedback)
                <div style="margin-bottom: 14px;">
                    <h4 style="font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; opacity: 0.9; margin-bottom: 4px;">
                        <i class="fa-solid fa-user-tie"></i> Chairman Executive Board Analysis:
                    </h4>
                    <p style="font-size: 14px; opacity: 0.95; line-height: 1.6;">{{ $record->board_feedback }}</p>
                </div>
            @endif

            @if($record->recommendations)
                <div>
                    <h4 style="font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; opacity: 0.9; margin-bottom: 4px;">
                        <i class="fa-solid fa-lightbulb"></i> Strategic Viva Recommendations:
                    </h4>
                    <p style="font-size: 14px; opacity: 0.95; line-height: 1.6; white-space: pre-line;">{{ $record->recommendations }}</p>
                </div>
            @endif
        </div>

        <!-- Section Title -->
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <h3 style="font-size: 18px; font-weight: 800; color: #111827; display: flex; align-items: center; gap: 10px;" class="dark:text-white">
                <i class="fa-solid fa-clipboard-list" style="color: #10B981;"></i> Complete Turn-by-Turn Question & Model Answer Review
            </h3>
            <span style="font-size: 13px; font-weight: 700; color: #6B7280;">Total {{ count($record->transcript ?? []) }} Questions Asked</span>
        </div>

        <!-- Turn-by-Turn Q&A List -->
        @if(!empty($record->transcript))
            @foreach($record->transcript as $index => $item)
                <div class="qa-card">
                    <!-- Turn Header -->
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #E5E7EB; padding-bottom: 12px;" class="dark:border-gray-800">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="background: #10B981; color: white; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 20px;">
                                Question #{{ $item['turn'] ?? ($index + 1) }}
                            </span>
                            <span style="font-size: 13px; font-weight: 700; color: #6B7280;">{{ $item['speaker'] ?? 'Board Member' }}</span>
                        </div>
                        @if(isset($item['score']))
                            <div style="font-size: 14px; font-weight: 800; color: #047857; background: rgba(16, 185, 129, 0.1); padding: 4px 12px; border-radius: 8px;" class="dark:text-emerald-400">
                                Score: {{ $item['score'] }} / 100
                            </div>
                        @endif
                    </div>

                    <!-- Question Text -->
                    <div style="background: #EFF6FF; border: 1px solid #3B82F6; padding: 14px 16px; border-radius: 10px;" class="dark:bg-blue-950/20 dark:border-blue-800">
                        <span style="font-size: 11px; font-weight: 800; color: #1D4ED8; text-transform: uppercase;" class="dark:text-blue-400">Board Question:</span>
                        <p style="font-size: 15px; font-weight: 700; color: #1E3A8A; margin-top: 2px;" class="dark:text-blue-200">
                            {{ $item['question'] ?? ($item['text'] ?? 'N/A') }}
                        </p>
                    </div>

                    <!-- Expected Key Points -->
                    @if(!empty($item['expected_key_points']))
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                            <span style="font-size: 11px; font-weight: 700; color: #6B7280;" class="dark:text-gray-400">Expected Key Concepts:</span>
                            @foreach($item['expected_key_points'] as $pt)
                                <span style="background: #F3F4F6; color: #374151; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 4px;" class="dark:bg-gray-800 dark:text-gray-300">{{ $pt }}</span>
                            @endforeach
                        </div>
                    @endif

                    <!-- Candidate Given Answer -->
                    @if(isset($item['candidate_answer']) || ($item['speaker'] ?? '') === 'Candidate')
                        <div>
                            <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: #4B5563;" class="dark:text-gray-300">Candidate Response:</span>
                            <div style="background: #F9FAFB; border: 1px solid #E5E7EB; padding: 12px 16px; border-radius: 10px; font-size: 14px; color: #1F2937; margin-top: 4px; line-height: 1.6;" class="dark:bg-gray-900 dark:border-gray-800 dark:text-gray-200">
                                {{ $item['candidate_answer'] ?? ($item['text'] ?? '') }}
                            </div>
                        </div>
                    @endif

                    <!-- Turn Feedback -->
                    @if(!empty($item['feedback']))
                        <div style="font-size: 13px; color: #4B5563; line-height: 1.5;" class="dark:text-gray-300">
                            <strong><i class="fa-solid fa-comment-dots" style="color: #3B82F6;"></i> AI Turn Feedback:</strong> {{ $item['feedback'] }}
                        </div>
                    @endif

                    <!-- Recommended Model Answer (100/100 Response) -->
                    @if(!empty($item['model_answer']))
                        <div class="model-answer-box">
                            <span style="font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.03em; display: flex; align-items: center; gap: 6px;">
                                <i class="fa-solid fa-star" style="color: #F59E0B;"></i> Recommended Model Answer (100/100 Ideal Response)
                            </span>
                            <p style="font-size: 14px; font-weight: 500; margin-top: 6px; line-height: 1.6;">
                                {{ $item['model_answer'] }}
                            </p>
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            <div style="background: #ffffff; padding: 30px; border-radius: 12px; text-align: center; color: #6B7280;">
                No turn-by-turn transcript recorded for this session.
            </div>
        @endif

    </div>
</x-filament-panels::page>
