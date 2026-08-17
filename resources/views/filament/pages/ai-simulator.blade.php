<x-filament-panels::page>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .simulator-layout {
            display: grid;
            grid-template-columns: 360px 1fr;
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

        .final-score-card {
            background: linear-gradient(135deg, #064E3B 0%, #065F46 50%, #1E3A8A 100%);
            color: #ffffff;
            padding: 28px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(6, 95, 70, 0.2);
        }
    </style>

    <div class="simulator-layout">
        
        <!-- Sidebar Configuration Card -->
        <div class="converter-card" style="display: flex; flex-direction: column; gap: 14px; background: #ffffff; border: 1px solid #E5E7EB; border-radius: 16px; padding: 20px;" class="dark:bg-gray-900 dark:border-gray-800">
            <h3 style="font-size: 16px; font-weight: 800; color: #10B981; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-user-gear"></i> BPSC Candidate Setup
            </h3>

            <div>
                <label style="display: block; font-size: 12px; font-weight: 700; color: #4B5563; margin-bottom: 3px;" class="dark:text-gray-300">Exam Category</label>
                <select wire:model="examType" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #D1D5DB; background: #F9FAFB; color: #111827; font-size: 12px;" class="dark:bg-gray-800 dark:border-gray-700 dark:text-white" :disabled="isSessionActive">
                    <option value="BCS">BCS (Civil Service)</option>
                    <option value="Bank">Bank AD / Senior Officer</option>
                    <option value="Primary">Primary Assistant Teacher</option>
                </select>
            </div>

            <!-- Choices 1 to 7 Inputs -->
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <div>
                    <label style="display: block; font-size: 11px; font-weight: 700; color: #10B981;" class="dark:text-emerald-400">1st Preference Choice</label>
                    <input type="text" wire:model="choice1" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #D1D5DB; background: #F9FAFB; color: #111827; font-size: 12px;" class="dark:bg-gray-800 dark:border-gray-700 dark:text-white" placeholder="e.g. BCS Administration Cadre" :disabled="isSessionActive" />
                </div>

                <div>
                    <label style="display: block; font-size: 11px; font-weight: 700; color: #3B82F6;" class="dark:text-blue-400">2nd Preference Choice</label>
                    <input type="text" wire:model="choice2" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #D1D5DB; background: #F9FAFB; color: #111827; font-size: 12px;" class="dark:bg-gray-800 dark:border-gray-700 dark:text-white" placeholder="e.g. BCS Foreign Affairs Cadre" :disabled="isSessionActive" />
                </div>

                <div>
                    <label style="display: block; font-size: 11px; font-weight: 700; color: #6B7280;" class="dark:text-gray-400">3rd Choice</label>
                    <input type="text" wire:model="choice3" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #D1D5DB; background: #F9FAFB; color: #111827; font-size: 12px;" class="dark:bg-gray-800 dark:border-gray-700 dark:text-white" placeholder="e.g. BCS Police Cadre" :disabled="isSessionActive" />
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                    <div>
                        <label style="display: block; font-size: 10px; font-weight: 700; color: #6B7280;">4th Choice</label>
                        <input type="text" wire:model="choice4" style="width: 100%; padding: 5px 8px; border-radius: 6px; border: 1px solid #D1D5DB; background: #F9FAFB; color: #111827; font-size: 11px;" class="dark:bg-gray-800 dark:border-gray-700 dark:text-white" placeholder="Audit & Accounts" :disabled="isSessionActive" />
                    </div>
                    <div>
                        <label style="display: block; font-size: 10px; font-weight: 700; color: #6B7280;">5th Choice</label>
                        <input type="text" wire:model="choice5" style="width: 100%; padding: 5px 8px; border-radius: 6px; border: 1px solid #D1D5DB; background: #F9FAFB; color: #111827; font-size: 11px;" class="dark:bg-gray-800 dark:border-gray-700 dark:text-white" placeholder="Taxation Cadre" :disabled="isSessionActive" />
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                    <div>
                        <label style="display: block; font-size: 10px; font-weight: 700; color: #6B7280;">6th Choice</label>
                        <input type="text" wire:model="choice6" style="width: 100%; padding: 5px 8px; border-radius: 6px; border: 1px solid #D1D5DB; background: #F9FAFB; color: #111827; font-size: 11px;" class="dark:bg-gray-800 dark:border-gray-700 dark:text-white" placeholder="Customs Cadre" :disabled="isSessionActive" />
                    </div>
                    <div>
                        <label style="display: block; font-size: 10px; font-weight: 700; color: #6B7280;">7th Choice</label>
                        <input type="text" wire:model="choice7" style="width: 100%; padding: 5px 8px; border-radius: 6px; border: 1px solid #D1D5DB; background: #F9FAFB; color: #111827; font-size: 11px;" class="dark:bg-gray-800 dark:border-gray-700 dark:text-white" placeholder="Ansar Cadre" :disabled="isSessionActive" />
                    </div>
                </div>
            </div>

            <div>
                <label style="display: block; font-size: 11px; font-weight: 700; color: #4B5563; margin-bottom: 3px;" class="dark:text-gray-300">Candidate CV / Context</label>
                <textarea wire:model="candidateCv" rows="3" style="width: 100%; padding: 6px 10px; border-radius: 6px; border: 1px solid #D1D5DB; background: #F9FAFB; color: #111827; font-size: 11px;" class="dark:bg-gray-800 dark:border-gray-700 dark:text-white" placeholder="Subject, University, Home District..." :disabled="isSessionActive"></textarea>
            </div>

            <div style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.2); padding: 8px 10px; border-radius: 6px; font-size: 11px; color: #047857;" class="dark:text-emerald-400">
                <i class="fa-solid fa-clock"></i> <strong>10–20 Min Board Simulation:</strong> Minimum 8 questions, Maximum 20 questions adaptively.
            </div>

            @if(!$isSessionActive && !$isConcluded)
                <button wire:click="startSession" wire:loading.attr="disabled" class="btn-emerald" style="background: linear-gradient(135deg, #059669 0%, #10B981 100%); color: white; padding: 10px; border-radius: 8px; font-weight: 700; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%;">
                    <span wire:loading.remove wire:target="startSession">
                        <i class="fa-solid fa-circle-play"></i> Start 10-20 Min Mock Viva
                    </span>
                    <span wire:loading wire:target="startSession" style="display: none;">
                        <i class="fa-solid fa-spinner fa-spin"></i> Preparing Board...
                    </span>
                </button>
            @elseif($isSessionActive)
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    @if($questionCount >= 8)
                        <button wire:click="concludeSession" wire:loading.attr="disabled" style="background: #3B82F6; color: white; padding: 10px; border-radius: 8px; font-weight: 700; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%;">
                            <span wire:loading.remove wire:target="concludeSession">
                                <i class="fa-solid fa-flag-checkered"></i> Conclude & Get Preference Fit
                            </span>
                            <span wire:loading wire:target="concludeSession" style="display: none;">
                                <i class="fa-solid fa-spinner fa-spin"></i> Evaluating Placement...
                            </span>
                        </button>
                    @endif
                    
                    <button wire:click="resetSession" style="background: #EF4444; color: white; padding: 10px; border-radius: 8px; font-weight: 700; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%;">
                        <i class="fa-solid fa-rotate-left"></i> Reset Session
                    </button>
                </div>
            @else
                <button wire:click="resetSession" style="background: linear-gradient(135deg, #059669 0%, #10B981 100%); color: white; padding: 10px; border-radius: 8px; font-weight: 700; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%;">
                    <i class="fa-solid fa-plus"></i> Start New Viva Session
                </button>
            @endif

            @if($statusMessage)
                <div style="font-size: 11px; font-weight: 600; color: #4B5563; padding: 8px; border-radius: 6px; background: #F3F4F6;" class="dark:bg-gray-800 dark:text-gray-300">
                    <i class="fa-solid fa-circle-info" style="color: #10B981;"></i> {{ $statusMessage }}
                </div>
            @endif
        </div>

        <!-- Right Side: Active Chat Timeline & AI Scorecard -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <!-- Final Evaluation Summary Scorecard (when session is concluded) -->
            @if($isConcluded && $finalEvaluation)
                <div class="final-score-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.2); padding-bottom: 16px;">
                        <div>
                            <span style="font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; opacity: 0.85;">Final Board Cadre Verdict</span>
                            <h2 style="font-size: 24px; font-weight: 800; margin-top: 2px;">{{ $finalEvaluation['verdict'] ?? 'Recommended' }}</h2>
                        </div>

                        <div style="width: 90px; height: 90px; border-radius: 50%; background: #ffffff; color: #065F46; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(0,0,0,0.2);">
                            <span style="font-size: 26px; font-weight: 900; line-height: 1;">{{ $finalEvaluation['overall_score'] ?? 80 }}</span>
                            <span style="font-size: 11px; font-weight: 700; color: #6B7280;">/ 100</span>
                        </div>
                    </div>

                    <!-- Cadre Choice Suitability Ratings across all submitted preferences (1 to 7) -->
                    @if(!empty($finalEvaluation['cadre_suitability_ratings']))
                        <div style="margin-bottom: 20px;">
                            <h4 style="font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; opacity: 0.9; margin-bottom: 8px;">
                                <i class="fa-solid fa-list-ol"></i> Cadre Preference Suitability Ranking:
                            </h4>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px;">
                                @if(is_array($finalEvaluation['cadre_suitability_ratings']))
                                    @foreach($finalEvaluation['cadre_suitability_ratings'] as $idx => $item)
                                        @if(is_array($item))
                                            <div style="background: rgba(255,255,255,0.12); padding: 10px 12px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.15);">
                                                <div style="font-size: 10px; opacity: 0.85; font-weight: 700; text-transform: uppercase;">{{ $item['choice'] ?? ('Choice '.($idx+1)) }}</div>
                                                <div style="font-size: 18px; font-weight: 900; margin-top: 2px; color: #34D399;">
                                                    {{ $item['fit_percent'] ?? 80 }}% Fit
                                                </div>
                                                <div style="font-size: 11px; opacity: 0.9; margin-top: 2px;" class="truncate">{{ $item['cadre'] ?? '' }}</div>
                                            </div>
                                        @elseif(is_numeric($item))
                                            <div style="background: rgba(255,255,255,0.12); padding: 10px 12px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.15);">
                                                <div style="font-size: 10px; opacity: 0.85; font-weight: 700; text-transform: uppercase;">{{ str_replace('_', ' ', $idx) }}</div>
                                                <div style="font-size: 18px; font-weight: 900; margin-top: 2px; color: #34D399;">
                                                    {{ $item }}% Fit
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Category Score Breakdown -->
                    @if(!empty($finalEvaluation['score_breakdown']))
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 10px; margin-bottom: 20px;">
                            <div style="background: rgba(255,255,255,0.08); padding: 10px 12px; border-radius: 8px;">
                                <div style="font-size: 10px; opacity: 0.85; font-weight: 700; text-transform: uppercase;">Academic Knowledge</div>
                                <div style="font-size: 16px; font-weight: 800; margin-top: 2px;">{{ $finalEvaluation['score_breakdown']['academic_subject_knowledge'] ?? 24 }} / 30</div>
                            </div>
                            <div style="background: rgba(255,255,255,0.08); padding: 10px 12px; border-radius: 8px;">
                                <div style="font-size: 10px; opacity: 0.85; font-weight: 700; text-transform: uppercase;">Laws & Constitution</div>
                                <div style="font-size: 16px; font-weight: 800; margin-top: 2px;">{{ $finalEvaluation['score_breakdown']['legal_policy_constitution'] ?? 25 }} / 30</div>
                            </div>
                            <div style="background: rgba(255,255,255,0.08); padding: 10px 12px; border-radius: 8px;">
                                <div style="font-size: 10px; opacity: 0.85; font-weight: 700; text-transform: uppercase;">Cadre Personality</div>
                                <div style="font-size: 16px; font-weight: 800; margin-top: 2px;">{{ $finalEvaluation['score_breakdown']['cadre_personality_aptitude'] ?? 20 }} / 25</div>
                            </div>
                            <div style="background: rgba(255,255,255,0.08); padding: 10px 12px; border-radius: 8px;">
                                <div style="font-size: 10px; opacity: 0.85; font-weight: 700; text-transform: uppercase;">Stress Handling</div>
                                <div style="font-size: 16px; font-weight: 800; margin-top: 2px;">{{ $finalEvaluation['score_breakdown']['communication_stress_handling'] ?? 11 }} / 15</div>
                            </div>
                        </div>
                    @endif

                    <!-- Executive Board Feedback -->
                    @if(!empty($finalEvaluation['board_feedback']))
                        <div style="margin-bottom: 16px;">
                            <h4 style="font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; opacity: 0.9; margin-bottom: 4px;">
                                <i class="fa-solid fa-user-tie"></i> Chairman Board Cadre Recommendation Analysis:
                            </h4>
                            <p style="font-size: 14px; opacity: 0.95; line-height: 1.6;">
                                {{ $finalEvaluation['board_feedback'] }}
                            </p>
                        </div>
                    @endif

                    <!-- Recommendations -->
                    @if(!empty($finalEvaluation['recommendations']))
                        <div>
                            <h4 style="font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; opacity: 0.9; margin-bottom: 4px;">
                                <i class="fa-solid fa-lightbulb"></i> Strategic Viva Recommendations:
                            </h4>
                            <p style="font-size: 14px; opacity: 0.95; line-height: 1.6; white-space: pre-line;">
                                {{ $finalEvaluation['recommendations'] }}
                            </p>
                        </div>
                    @endif
                </div>
            @endif

            @if($isSessionActive)
                <!-- Live Conversation timeline -->
                <div class="chat-container">
                    <div style="font-weight: 800; font-size: 15px; border-bottom: 1px solid #E5E7EB; padding-bottom: 10px; display: flex; align-items: center; justify-content: space-between;" class="dark:border-gray-800">
                        <span style="color: #10B981;"><i class="fa-solid fa-podcast"></i> Live Board Interview Transcript</span>
                        <span style="font-size: 12px; background: rgba(16, 185, 129, 0.15); color: #047857; padding: 4px 12px; border-radius: 20px; font-weight: 800;" class="dark:text-emerald-400">
                            Question {{ $questionCount }} of 20 (Min 8 Baseline)
                        </span>
                    </div>

                    <!-- Chat Bubbles -->
                    <div style="display: flex; flex-direction: column; gap: 14px; max-height: 400px; overflow-y: auto; padding-right: 6px;">
                        @foreach($transcriptHistory as $step)
                            <div style="display: flex; flex-direction: column; gap: 4px; align-self: {{ ($step['speaker'] ?? '') === 'Candidate' ? 'flex-end' : 'flex-start' }}">
                                <span style="font-size: 11px; font-weight: 700; color: #6B7280; align-self: {{ ($step['speaker'] ?? '') === 'Candidate' ? 'flex-end' : 'flex-start' }}">
                                    {{ $step['speaker'] ?? 'Board' }}
                                </span>
                                <div class="chat-bubble {{ ($step['speaker'] ?? '') === 'Candidate' ? 'bubble-candidate' : 'bubble-board' }}">
                                    {{ $step['question'] ?? ($step['text'] ?? '') }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Expected Key Points Panel -->
                    @if(!empty($expectedKeyPoints))
                        <div style="background: #F0FDF4; border: 1px dashed #10B981; border-radius: 8px; padding: 12px 16px;" class="dark:bg-emerald-950/20">
                            <span style="font-size: 12px; font-weight: 700; color: #047857;" class="dark:text-emerald-400">
                                <i class="fa-solid fa-circle-exclamation"></i> Expected Key Concepts for 100/100 score:
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
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 12px; font-weight: 800; color: #1D4ED8; text-transform: uppercase;" class="dark:text-blue-400">Active Board Question ({{ $questionCount }}/20):</span>
                        </div>
                        <p style="font-size: 15px; font-weight: 700; color: #1E3A8A; margin-top: 4px;" class="dark:text-blue-200">{{ $currentQuestion }}</p>
                    </div>

                    <!-- Answer Input Area -->
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <textarea wire:model="candidateAnswer" rows="3" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #D1D5DB; background: #F9FAFB; color: #111827;" class="dark:bg-gray-800 dark:border-gray-700 dark:text-white" placeholder="Type candidate answer response here..."></textarea>
                        
                        <div style="display: flex; gap: 12px; justify-content: flex-end;">
                            <button wire:click="submitAnswer" wire:loading.attr="disabled" class="btn-emerald" style="background: linear-gradient(135deg, #4F46E5 0%, #3B82F6 100%); color: white; padding: 10px 24px; border-radius: 8px; font-weight: 700; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <span wire:loading.remove wire:target="submitAnswer">
                                    <i class="fa-solid fa-paper-plane"></i> Submit Answer & Next Turn
                                </span>
                                <span wire:loading wire:target="submitAnswer" style="display: none;">
                                    <i class="fa-solid fa-spinner fa-spin"></i> Evaluating Answer...
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
                                <i class="fa-solid fa-square-poll-vertical"></i> Turn Evaluation (Question {{ $questionCount }})
                            </h3>
                            <div class="score-badge">
                                <span>{{ $currentEvaluation['score'] }}</span>
                                <span style="font-size: 11px; opacity: 0.85; font-weight: 600;">/ 100</span>
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

            @elseif(!$isConcluded)
                <div style="background: #ffffff; border: 1px solid #E5E7EB; padding: 40px; border-radius: 16px; text-align: center; color: #6B7280;" class="dark:bg-gray-900 dark:border-gray-800">
                    <i class="fa-solid fa-comments" style="font-size: 48px; color: #E5E7EB; margin-bottom: 16px;"></i>
                    <h3 style="font-size: 18px; font-weight: 700; color: #1F2937;" class="dark:text-white">AI Viva Simulator Idle</h3>
                    <p style="font-size: 14px; margin-top: 4px; max-width: 420px; margin-left: auto; margin-right: auto;">
                        Set up the candidate's cadre preferences (Choices 1 to 7) on the left sidebar to start a realistic 10–20 minute board interview (8 to 20 questions).
                    </p>
                </div>
            @endif

        </div>

    </div>
</x-filament-panels::page>
