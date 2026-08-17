<x-filament-panels::page>
    <!-- Load FontAwesome stylesheet inside Filament Admin view -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .synth-card {
            background: #ffffff;
            border: 1px solid #E5E7EB;
            border-radius: 16px;
            padding: 20px 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }

        .dark .synth-card {
            background: #111827;
            border-color: #1F2937;
            box-shadow: none;
        }

        .synth-card:hover {
            border-color: #10B981;
        }

        .btn-emerald {
            background: linear-gradient(135deg, #059669 0%, #10B981 100%);
            color: #ffffff;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
            transition: all 0.2s ease;
        }

        .btn-emerald:hover:not(:disabled) {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.35);
        }

        .btn-emerald:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .btn-outline {
            background: rgba(16, 185, 129, 0.08);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #059669;
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }

        .dark .btn-outline {
            color: #34D399;
            border-color: rgba(16, 185, 129, 0.4);
        }

        .btn-outline:hover:not(:disabled) {
            background: rgba(16, 185, 129, 0.18);
        }

        .btn-outline:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .progress-bar-bg {
            width: 100%;
            height: 8px;
            background: #E5E7EB;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 8px;
        }

        .dark .progress-bar-bg {
            background: #374151;
        }

        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #10B981 0%, #059669 100%);
            transition: width 0.3s ease;
        }
    </style>

    <div 
        x-data="{
            isBatchRunning: false,
            currentCategory: '',
            currentIndex: 0,
            totalCategories: 0,
            progressPercent: 0,

            async runBatchSynthesis(targetExam = null, onlyNewRecords = true) {
                if (this.isBatchRunning) return;
                this.isBatchRunning = true;
                this.currentIndex = 0;
                this.progressPercent = 0;

                const queue = await $wire.startBatchSynthesis(targetExam, onlyNewRecords);
                this.totalCategories = queue ? queue.length : 0;

                if (!queue || queue.length === 0) {
                    this.isBatchRunning = false;
                    return;
                }

                for (let i = 0; i < queue.length; i++) {
                    this.currentCategory = queue[i].label || ('Micro-Batch ' + (i + 1));
                    this.currentIndex = i + 1;
                    this.progressPercent = Math.round((this.currentIndex / queue.length) * 100);

                    await $wire.processMicroBatchStep(i);
                }

                this.isBatchRunning = false;
            }
        }"
        style="display: flex; flex-direction: column; gap: 24px;"
    >
        
        <!-- Header Hero Banner -->
        <div style="background: linear-gradient(135deg, #064E3B 0%, #065F46 50%, #1E3A8A 100%); padding: 28px; border-radius: 16px; color: #ffffff; box-shadow: 0 10px 25px rgba(6, 95, 70, 0.2);">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                <div style="display: flex; align-items: center; gap: 16px; flex: 1; min-width: 280px;">
                    <div style="width: 52px; height: 52px; min-width: 52px; flex-shrink: 0; border-radius: 14px; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center;">
                        <svg style="width: 28px; height: 28px; color: #ffffff;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M3 9h2m-2 6h2m14-6h2m-2 6h2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <h2 style="font-size: 22px; font-weight: 800; line-height: 1.2; color: #ffffff;">
                            AI Viva Board Knowledge Synthesizer
                        </h2>
                        <p style="font-size: 14px; opacity: 0.9; margin-top: 4px; line-height: 1.4; color: #ffffff;">
                            Pre-compiles authentic board questions & interrogation patterns from Question Banks into compact AI Knowledge Cards. Saves <strong>80% input tokens</strong> & improves candidate question precision!
                        </p>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <!-- Default Action: Incremental Synthesis (Only New Records) -->
                    <button 
                        @click="runBatchSynthesis(null, true)" 
                        :disabled="isBatchRunning"
                        type="button" 
                        class="btn-emerald"
                    >
                        <template x-if="!isBatchRunning">
                            <span style="display: inline-flex; align-items: center; gap: 8px;">
                                <svg style="width: 18px; height: 18px; color: #ffffff;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                Synthesize New & Updated Records
                            </span>
                        </template>
                        <template x-if="isBatchRunning">
                            <span style="display: inline-flex; align-items: center; gap: 8px;">
                                <i class="fa-solid fa-spinner fa-spin"></i> Compiling <span x-text="currentCategory"></span>... (<span x-text="currentIndex"></span>/<span x-text="totalCategories"></span>)
                            </span>
                        </template>
                    </button>

                    <!-- Force Full Re-Synthesis Action -->
                    <button 
                        @click="runBatchSynthesis(null, false)" 
                        :disabled="isBatchRunning"
                        type="button" 
                        style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.3); color: #ffffff; padding: 12px 18px; border-radius: 10px; font-weight: 700; font-size: 13px; cursor: pointer;"
                    >
                        <i class="fa-solid fa-rotate"></i> Re-Synthesize All
                    </button>
                </div>
            </div>

            <!-- Active Batch Synthesis Progress -->
            <template x-if="isBatchRunning">
                <div style="margin-top: 20px; background: rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.15); padding: 16px; border-radius: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 13px; font-weight: 700;">
                        <span style="display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-spinner fa-spin text-emerald-400"></i>
                            Synthesizing: <span x-text="currentCategory" style="color: #34D399;"></span>
                        </span>
                        <span x-text="progressPercent + '%'"></span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" :style="'width: ' + progressPercent + '%'"></div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Summary Metric Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
            <!-- Card 1 -->
            <div class="synth-card" style="display: flex; align-items: center; gap: 16px; min-height: 90px;">
                <div style="width: 48px; height: 48px; min-width: 48px; flex-shrink: 0; border-radius: 12px; background: rgba(16, 185, 129, 0.12); color: #10B981; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 24px; height: 24px; color: #10B981;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <div style="flex: 1; min-width: 0; display: flex; flex-direction: column; justify-content: center;">
                    <span style="font-size: 11px; font-weight: 700; color: #9CA3AF; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 2px;">Synthesized Knowledge Cards</span>
                    <span style="font-size: 20px; font-weight: 800; color: #ffffff; display: block; line-height: 1.2;" class="dark:text-white">{{ $totalCards }} Cards</span>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="synth-card" style="display: flex; align-items: center; gap: 16px; min-height: 90px;">
                <div style="width: 48px; height: 48px; min-width: 48px; flex-shrink: 0; border-radius: 12px; background: rgba(59, 130, 246, 0.12); color: #3B82F6; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 24px; height: 24px; color: #3B82F6;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div style="flex: 1; min-width: 0; display: flex; flex-direction: column; justify-content: center;">
                    <span style="font-size: 11px; font-weight: 700; color: #9CA3AF; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 2px;">Indexed Question Bank Items</span>
                    <span style="font-size: 20px; font-weight: 800; color: #ffffff; display: block; line-height: 1.2;" class="dark:text-white">{{ $totalQuestionBankRecords }} Items</span>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="synth-card" style="display: flex; align-items: center; gap: 16px; min-height: 90px;">
                <div style="width: 48px; height: 48px; min-width: 48px; flex-shrink: 0; border-radius: 12px; background: rgba(245, 158, 11, 0.12); color: #F59E0B; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 24px; height: 24px; color: #F59E0B;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div style="flex: 1; min-width: 0; display: flex; flex-direction: column; justify-content: center;">
                    <span style="font-size: 11px; font-weight: 700; color: #9CA3AF; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 2px;">Last Synthesis Run</span>
                    <span style="font-size: 15px; font-weight: 800; color: #ffffff; display: block; line-height: 1.2;" class="dark:text-white">
                        {{ $lastSynthesisDate ? \Carbon\Carbon::parse($lastSynthesisDate)->diffForHumans() : 'Not Synthesized Yet' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Status Message Banner -->
        @if($statusMessage && !$isSynthesizing)
            <div style="background: #ECFDF5; border: 1px solid #10B981; color: #047857; padding: 16px 20px; border-radius: 12px; font-weight: 600; font-size: 14px; display: flex; align-items: center; gap: 12px;" class="dark:bg-emerald-950/40 dark:border-emerald-500 dark:text-emerald-300">
                <i class="fa-solid fa-circle-check" style="font-size: 18px;"></i>
                <span>{{ $statusMessage }}</span>
            </div>
        @endif

        <!-- Filter & Action Controls -->
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; background: #F9FAFB; padding: 16px; border-radius: 12px; border: 1px solid #E5E7EB;" class="dark:bg-gray-900/70 dark:border-gray-800">
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <span style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #6B7280; letter-spacing: 0.03em;">Quick Synthesis Actions:</span>
                <button @click="runBatchSynthesis('BCS', true)" :disabled="isBatchRunning" class="btn-outline"><i class="fa-solid fa-gavel"></i> Synthesize BCS</button>
                <button @click="runBatchSynthesis('Bank', true)" :disabled="isBatchRunning" class="btn-outline"><i class="fa-solid fa-building-columns"></i> Synthesize Bank</button>
                <button @click="runBatchSynthesis('Primary', true)" :disabled="isBatchRunning" class="btn-outline"><i class="fa-solid fa-school"></i> Synthesize Primary</button>
            </div>

            <div style="display: flex; align-items: center; gap: 10px;">
                <label style="font-size: 13px; font-weight: 700; color: #6B7280;">Filter Matrix View:</label>
                <select 
                    wire:model.live="selectedExamType" 
                    style="padding: 8px 14px; border-radius: 8px; border: 1px solid #D1D5DB; font-size: 13px; font-weight: 600;" 
                    class="dark:bg-gray-800 dark:border-gray-700 dark:text-white bg-white text-gray-900 outline-none"
                >
                    <option value="All">All Exam Types</option>
                    <option value="BCS">BCS Viva Matrix</option>
                    <option value="Bank">Bank AD / Officer Matrix</option>
                    <option value="Primary">Primary Teacher Matrix</option>
                </select>
            </div>
        </div>

        <!-- Synthesized Cards Grid -->
        @if($cards->isEmpty())
            <div class="synth-card" style="text-align: center; padding: 48px;">
                <i class="fa-solid fa-brain" style="font-size: 48px; color: #D1D5DB; margin-bottom: 12px;"></i>
                <h3 style="font-size: 18px; font-weight: 700; color: #374151;" class="dark:text-white">No AI Knowledge Cards Generated Yet</h3>
                <p style="font-size: 14px; color: #6B7280; margin-top: 4px; max-width: 500px; margin-left: auto; margin-right: auto;">
                    Click the <strong>"Synthesize All Exam Matrices"</strong> button above to scan your Question Bank records and extract authentic board question pools.
                </p>
            </div>
        @else
            <div style="display: flex; flex-direction: column; gap: 20px;">
                @foreach($cards as $card)
                    <div class="synth-card">
                        <!-- Card Header -->
                        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 16px; border-bottom: 1px solid #F3F4F6; padding-bottom: 14px;" class="dark:border-gray-800">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                @php
                                    $badgeBg = match(strtoupper($card->exam_type)) {
                                        'BCS' => 'background: linear-gradient(135deg, #059669 0%, #10B981 100%);',
                                        'BANK' => 'background: linear-gradient(135deg, #1E3A8A 0%, #3B82F6 100%);',
                                        'PRIMARY' => 'background: linear-gradient(135deg, #991B1B 0%, #F43F5E 100%);',
                                        default => 'background: linear-gradient(135deg, #D97706 0%, #F59E0B 100%);'
                                    };
                                @endphp
                                <span style="{{ $badgeBg }} color: #fff; font-size: 11px; font-weight: 800; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;">
                                    {{ $card->exam_type }}
                                </span>
                                <h3 style="font-size: 18px; font-weight: 800; color: #111827;" class="dark:text-white">
                                    {{ $card->title }}
                                </h3>
                            </div>

                            <div style="display: flex; align-items: center; gap: 12px; font-size: 12px; color: #6B7280;">
                                <span><i class="fa-solid fa-database" style="color: #10B981;"></i> {{ $card->source_items_count }} Source Records Indexed</span>
                                <span>•</span>
                                <span><i class="fa-solid fa-clock"></i> Updated {{ $card->last_synthesized_at ? $card->last_synthesized_at->diffForHumans() : 'N/A' }}</span>
                            </div>
                        </div>

                        <!-- Interrogation Persona Summary -->
                        @if($card->chairman_style)
                            <div style="background: rgba(59, 130, 246, 0.05); border-left: 4px solid #3B82F6; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 13px; color: #1E40AF;" class="dark:bg-blue-950/30 dark:text-blue-200">
                                <strong><i class="fa-solid fa-user-tie"></i> Board Chairman Persona & Interrogation Style:</strong>
                                <span style="margin-left: 6px;">{{ $card->chairman_style }}</span>
                            </div>
                        @endif

                        <!-- Core Topics Chips -->
                        @if(!empty($card->core_topics))
                            <div style="margin-bottom: 16px;">
                                <div style="font-size: 12px; font-weight: 700; color: #6B7280; text-transform: uppercase; margin-bottom: 6px;">Mandatory Core Topics Covered:</div>
                                <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                                    @foreach($card->core_topics as $topic)
                                        <span style="background: #F3F4F6; border: 1px solid #E5E7EB; color: #374151; font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 6px;" class="dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">
                                            <i class="fa-solid fa-check" style="color: #10B981; font-size: 10px;"></i> {{ $topic }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Top High-Frequency Board Questions -->
                        @if(!empty($card->top_questions))
                            <div>
                                <div style="font-size: 12px; font-weight: 700; color: #6B7280; text-transform: uppercase; margin-bottom: 8px;">High-Frequency Board Questions Pool:</div>
                                <div style="display: flex; flex-direction: column; gap: 8px;">
                                    @foreach($card->top_questions as $idx => $q)
                                        <div style="background: #F9FAFB; border: 1px solid #E5E7EB; padding: 12px 16px; border-radius: 8px;" class="dark:bg-gray-800/60 dark:border-gray-700/60">
                                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 4px;">
                                                <span style="font-size: 11px; font-weight: 700; color: #10B981; text-transform: uppercase; background: rgba(16, 185, 129, 0.1); padding: 2px 8px; border-radius: 4px;">
                                                    Topic: {{ $q['topic'] ?? 'Board Question' }}
                                                </span>
                                                <span style="font-size: 11px; color: #9CA3AF;">Question #{{ $idx + 1 }}</span>
                                            </div>
                                            <div style="font-size: 14px; font-weight: 700; color: #111827; margin-bottom: 4px;" class="dark:text-white">
                                                {{ $q['question'] ?? '' }}
                                            </div>
                                            @if(!empty($q['expected_key_points']))
                                                <div style="font-size: 12px; color: #6B7280;">
                                                    <strong>Expected Points:</strong> {{ implode(', ', $q['expected_key_points']) }}
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>
        @endif

    </div>
</x-filament-panels::page>
