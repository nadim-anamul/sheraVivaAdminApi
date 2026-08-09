<x-filament-panels::page>
    <style>
        .simulator-layout {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 24px;
            align-items: start;
        }

        @media (max-width: 1024px) {
            .simulator-layout {
                grid-template-columns: 1fr;
            }
        }

        .chat-container {
            background: #ffffff;
            border: 1px solid #E5E7EB;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            gap: 20px;
            min-height: 500px;
        }

        .dark .chat-container {
            background: #111827;
            border-color: #1F2937;
            box-shadow: none;
        }

        .chat-bubble {
            padding: 14px 18px;
            border-radius: 12px;
            max-width: 85%;
            font-size: 14px;
            line-height: 1.6;
        }

        .bubble-board {
            background: #F3F4F6;
            color: #1F2937;
            align-self: flex-start;
            border-bottom-left-radius: 2px;
        }

        .dark .bubble-board {
            background: #1F2937;
            color: #F9FAFB;
        }

        .bubble-candidate {
            background: #10B981;
            color: #ffffff;
            align-self: flex-end;
            border-bottom-right-radius: 2px;
        }

        .evaluation-card {
            background: #ECFDF5;
            border: 1px solid #10B981;
            border-radius: 12px;
            padding: 20px;
            color: #065F46;
        }

        .dark .evaluation-card {
            background: rgba(16, 185, 129, 0.05);
            border-color: #059669;
            color: #34D399;
        }

        .score-badge {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #10B981;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 800;
            line-height: 1.1;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        .score-badge-max {
            font-size: 11px;
            opacity: 0.85;
            font-weight: 600;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin {
            animation: spin 1s linear infinite;
        }
    </style>

    <div class="simulator-layout">
        
        <!-- Sidebar Configuration Card -->
        <div class="converter-card" style="display: flex; flex-direction: column; gap: 20px; background: #ffffff; border: 1px solid #E5E7EB; border-radius: 16px; padding: 24px;" class="dark:bg-gray-900 dark:border-gray-800">
            <h3 style="font-size: 16px; font-weight: 800; color: #10B981; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-gears"></i> Candidate & Board Setup
            </h3>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #4B5563; margin-bottom: 6px;" class="dark:text-gray-300">Exam Type</label>
                <select wire:model="examType" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #D1D5DB; background: #F9FAFB; color: #111827;" class="dark:bg-gray-800 dark:border-gray-700 dark:text-white" :disabled="isSessionActive">
                    <option value="BCS">BCS (Civil Service)</option>
                    <option value="Bank">Bank AD / Officer</option>
                    <option value="Primary">Primary Assistant Teacher</option>
                </select>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #4B5563; margin-bottom: 6px;" class="dark:text-gray-300">Target Position / Cadre</label>
                <input type="text" wire:model="position" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #D1D5DB; background: #F9FAFB; color: #111827;" class="dark:bg-gray-800 dark:border-gray-700 dark:text-white" placeholder="e.g. Administration Cadre" :disabled="isSessionActive" />
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #4B5563; margin-bottom: 6px;" class="dark:text-gray-300">Candidate Bio / CV Context</label>
                <textarea wire:model="candidateCv" rows="5" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #D1D5DB; background: #F9FAFB; color: #111827; font-size: 13px;" class="dark:bg-gray-800 dark:border-gray-700 dark:text-white" placeholder="Enter target subject, background, district..." :disabled="isSessionActive"></textarea>
            </div>

            @if(!$isSessionActive)
                <button wire:click="startSession" wire:loading.attr="disabled" class="btn-emerald" style="background: linear-gradient(135deg, #059669 0%, #10B981 100%); color: white; padding: 12px; border-radius: 8px; font-weight: 700; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%;">
                    <span wire:loading.remove wire:target="startSession">
                        <i class="fa-solid fa-circle-play"></i> Start Mock Viva Session
                    </span>
                    <span wire:loading wire:target="startSession" style="display: none;">
                        <svg class="animate-spin" style="display: inline-block; vertical-align: middle; width: 20px; height: 20px; color: white; margin-right: 8px;" fill="none" viewBox="0 0 24 24">
                            <circle style="opacity: 0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path style="opacity: 0.75;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Preparing Board...
                    </span>
                </button>
            @else
                <button wire:click="resetSession" style="background: #EF4444; color: white; padding: 12px; border-radius: 8px; font-weight: 700; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%;">
                    <i class="fa-solid fa-circle-stop"></i> End Session & Reset
                </button>
            @endif

            @if($statusMessage)
                <div style="font-size: 13px; font-weight: 600; color: #4B5563; padding: 8px 12px; border-radius: 6px; background: #F3F4F6;" class="dark:bg-gray-800 dark:text-gray-300">
                    <i class="fa-solid fa-info-circle" style="color: #10B981;"></i> {{ $statusMessage }}
                </div>
            @endif
        </div>

        <!-- Right Side: Active Chat Timeline & AI Scorecard -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            @if($isSessionActive)
                <!-- Live Conversation timeline -->
                <div class="chat-container">
                    <div style="font-weight: 800; font-size: 15px; border-bottom: 1px solid #E5E7EB; padding-bottom: 10px; display: flex; align-items: center; justify-content: space-between;" class="dark:border-gray-800">
                        <span style="color: #10B981;"><i class="fa-solid fa-podcast"></i> Live Board Interview Transcript</span>
                        <span style="font-size: 11px; background: rgba(16, 185, 129, 0.1); padding: 3px 8px; border-radius: 20px;">Active Session</span>
                    </div>

                    <!-- Chat Bubbles -->
                    <div style="display: flex; flex-direction: column; gap: 14px; max-height: 400px; overflow-y: auto; padding-right: 6px;">
                        @foreach($transcriptHistory as $step)
                            <div style="display: flex; flex-direction: column; gap: 4px; align-self: {{ $step['speaker'] === 'Candidate' ? 'flex-end' : 'flex-start' }}">
                                <span style="font-size: 11px; font-weight: 700; color: #6B7280; align-self: {{ $step['speaker'] === 'Candidate' ? 'flex-end' : 'flex-start' }}">
                                    {{ $step['speaker'] }}
                                </span>
                                <div class="chat-bubble {{ $step['speaker'] === 'Candidate' ? 'bubble-candidate' : 'bubble-board' }}">
                                    {{ $step['text'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Expected Key Points Panel -->
                    @if(!empty($expectedKeyPoints))
                        <div style="background: #F0FDF4; border: 1px dashed #10B981; border-radius: 8px; padding: 12px 16px;" class="dark:bg-emerald-950/20">
                            <span style="font-size: 12px; font-weight: 700; color: #047857;" class="dark:text-emerald-400">
                                <i class="fa-solid fa-circle-exclamation"></i> Expected Key Points for 100/100 score:
                            </span>
                            <div style="font-size: 13px; display: flex; flex-wrap: wrap; gap: 8px; margin-top: 6px;">
                                @foreach($expectedKeyPoints as $point)
                                    <span style="background: rgba(16, 185, 129, 0.15); color: #047857; padding: 2px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;" class="dark:text-emerald-300">{{ $point }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Active Board Question Statement -->
                    <div style="background: #EFF6FF; border: 1px solid #3B82F6; padding: 16px; border-radius: 10px;" class="dark:bg-blue-950/20 dark:border-blue-800">
                        <span style="font-size: 12px; font-weight: 800; color: #1D4ED8; text-transform: uppercase;" class="dark:text-blue-400">Active Board Question:</span>
                        <p style="font-size: 15px; font-weight: 700; color: #1E3A8A; margin-top: 4px;" class="dark:text-blue-200">{{ $currentQuestion }}</p>
                    </div>

                    <!-- Answer Input Area -->
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <textarea wire:model="candidateAnswer" rows="3" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #D1D5DB; background: #F9FAFB; color: #111827;" class="dark:bg-gray-800 dark:border-gray-700 dark:text-white" placeholder="Type candidate answer response here..."></textarea>
                        
                        <div style="display: flex; gap: 12px; justify-content: flex-end;">
                            <button wire:click="submitAnswer" wire:loading.attr="disabled" class="btn-emerald" style="background: linear-gradient(135deg, #4F46E5 0%, #3B82F6 100%); color: white; padding: 10px 24px; border-radius: 8px; font-weight: 700; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <span wire:loading.remove wire:target="submitAnswer">
                                    <i class="fa-solid fa-paper-plane"></i> Submit Answer & Get Next Question
                                </span>
                                <span wire:loading wire:target="submitAnswer" style="display: none;">
                                    <svg class="animate-spin" style="display: inline-block; vertical-align: middle; width: 20px; height: 20px; color: white; margin-right: 8px;" fill="none" viewBox="0 0 24 24">
                                        <circle style="opacity: 0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path style="opacity: 0.75;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Evaluating...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- AI Scorecard Details -->
                @if($currentEvaluation)
                    <div class="evaluation-card" style="display: flex; flex-direction: column; gap: 16px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(16, 185, 129, 0.2); padding-bottom: 12px;">
                            <h3 style="font-size: 17px; font-weight: 800;">
                                <i class="fa-solid fa-square-poll-vertical"></i> AI Performance Scorecard (Last Turn)
                            </h3>
                            <div class="score-badge">
                                <span>{{ $currentEvaluation['score'] }}</span>
                                <span class="score-badge-max">/ 100</span>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                            <div>
                                <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #6B7280;" class="dark:text-gray-400">Fluency Rating</span>
                                <div style="font-size: 15px; font-weight: 800; color: #047857;" class="dark:text-emerald-400">{{ $currentEvaluation['fluency_rating'] }}</div>
                            </div>
                            <div>
                                <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #6B7280;" class="dark:text-gray-400">Knowledge Rating</span>
                                <div style="font-size: 15px; font-weight: 800; color: #047857;" class="dark:text-emerald-400">{{ $currentEvaluation['knowledge_rating'] }}</div>
                            </div>
                            <div>
                                <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #6B7280;" class="dark:text-gray-400">Speech Filler Words</span>
                                <div style="font-size: 15px; font-weight: 800; color: #B45309;">{{ $currentEvaluation['fillers_detected'] }} hesitations detected</div>
                            </div>
                        </div>

                        <div>
                            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #6B7280;" class="dark:text-gray-400">Constructive Feedback</span>
                            <p style="font-size: 14px; margin-top: 4px; line-height: 1.6;">
                                @if(is_array($currentEvaluation['feedback'] ?? ''))
                                    {{ implode(' ', $currentEvaluation['feedback']) }}
                                @else
                                    {{ $currentEvaluation['feedback'] ?? '' }}
                                @endif
                            </p>
                        </div>

                        <div>
                            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #6B7280;" class="dark:text-gray-400">Recommendations</span>
                            <p style="font-size: 14px; margin-top: 4px; white-space: pre-wrap; line-height: 1.6;">
                                @if(is_array($currentEvaluation['recommendations'] ?? ''))
                                    @foreach($currentEvaluation['recommendations'] as $rec)
                                        • {{ $rec }}
                                    @endforeach
                                @else
                                    {{ $currentEvaluation['recommendations'] ?? '' }}
                                @endif
                            </p>
                        </div>

                        <div style="background: #ffffff; border: 1px solid #10B981; padding: 16px; border-radius: 8px;" class="dark:bg-gray-900 dark:border-gray-800">
                            <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: #047857;" class="dark:text-emerald-400">Model Answer (100/100 response)</span>
                            <p style="font-size: 14px; margin-top: 6px; color: #1F2937; line-height: 1.6;" class="dark:text-gray-300">
                                @if(is_array($currentEvaluation['model_answer'] ?? ''))
                                    {{ implode(' ', $currentEvaluation['model_answer']) }}
                                @else
                                    {{ $currentEvaluation['model_answer'] ?? '' }}
                                @endif
                            </p>
                        </div>
                    </div>
                @endif

            @else
                <div style="background: #ffffff; border: 1px solid #E5E7EB; padding: 40px; border-radius: 16px; text-align: center; color: #6B7280;" class="dark:bg-gray-900 dark:border-gray-800">
                    <i class="fa-solid fa-comments" style="font-size: 48px; color: #E5E7EB; margin-bottom: 16px;"></i>
                    <h3 style="font-size: 18px; font-weight: 700; color: #1F2937;" class="dark:text-white">AI Viva Simulator Idle</h3>
                    <p style="font-size: 14px; margin-top: 4px; max-width: 400px; margin-left: auto; margin-right: auto;">
                        Set up the candidate's target exam type, position, and profile on the left sidebar to start a simulated mock interview.
                    </p>
                </div>
            @endif

        </div>

    </div>
</x-filament-panels::page>
