<x-filament-panels::page>
    <style>
        .synth-card {
            background: #ffffff;
            border: 1px solid #E5E7EB;
            border-radius: 16px;
            padding: 24px;
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

        .btn-emerald:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.35);
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

        .btn-outline:hover {
            background: rgba(16, 185, 129, 0.18);
        }
    </style>

    <div style="display: flex; flex-direction: column; gap: 24px;">
        
        <!-- Header Hero Banner -->
        <div style="background: linear-gradient(135deg, #064E3B 0%, #065F46 50%, #1E3A8A 100%); padding: 28px; border-radius: 16px; color: #ffffff; box-shadow: 0 10px 25px rgba(6, 95, 70, 0.2);">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="width: 50px; height: 50px; border-radius: 14px; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; font-size: 24px;">
                        <i class="fa-solid fa-microchip"></i>
                    </div>
                    <div>
                        <h2 style="font-size: 22px; font-weight: 800; line-height: 1.2;">
                            AI Viva Board Knowledge Synthesizer
                        </h2>
                        <p style="font-size: 14px; opacity: 0.9; margin-top: 4px;">
                            Pre-compiles authentic board questions & interrogation patterns from Question Banks into compact AI Knowledge Cards. Saves <strong>80% input tokens</strong> & improves candidate question precision!
                        </p>
                    </div>
                </div>

                <button 
                    wire:click="runSynthesis('All')" 
                    wire:loading.attr="disabled"
                    type="button" 
                    class="btn-emerald"
                >
                    <span wire:loading.remove wire:target="runSynthesis">
                        <i class="fa-solid fa-wand-magic-sparkles"></i> Synthesize All Exam Matrices
                    </span>
                    <span wire:loading wire:target="runSynthesis" style="display: inline-flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-spinner fa-spin"></i> Compiling Board Intelligence...
                    </span>
                </button>
            </div>
        </div>

        <!-- Summary Metric Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px;">
            <div class="synth-card" style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(16, 185, 129, 0.1); color: #10B981; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div>
                    <div style="font-size: 12px; font-weight: 700; color: #6B7280; text-transform: uppercase;">Synthesized Knowledge Cards</div>
                    <div style="font-size: 24px; font-weight: 800; color: #111827;" class="dark:text-white">{{ $totalCards }} Cards</div>
                </div>
            </div>

            <div class="synth-card" style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(59, 130, 246, 0.1); color: #3B82F6; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div>
                    <div style="font-size: 12px; font-weight: 700; color: #6B7280; text-transform: uppercase;">Indexed Question Bank Items</div>
                    <div style="font-size: 24px; font-weight: 800; color: #111827;" class="dark:text-white">{{ $totalQuestionBankRecords }} Items</div>
                </div>
            </div>

            <div class="synth-card" style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(245, 158, 11, 0.1); color: #F59E0B; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div>
                    <div style="font-size: 12px; font-weight: 700; color: #6B7280; text-transform: uppercase;">Last Synthesis Run</div>
                    <div style="font-size: 14px; font-weight: 700; color: #111827;" class="dark:text-white">
                        {{ $lastSynthesisDate ? \Carbon\Carbon::parse($lastSynthesisDate)->diffForHumans() : 'Not Synthesized Yet' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Message Banner -->
        @if($statusMessage)
            <div style="background: #ECFDF5; border: 1px solid #10B981; color: #047857; padding: 16px 20px; border-radius: 12px; font-weight: 600; font-size: 14px; display: flex; align-items: center; gap: 12px;" class="dark:bg-emerald-950/40 dark:border-emerald-500 dark:text-emerald-300">
                <i class="fa-solid fa-circle-info" style="font-size: 18px;"></i>
                <span>{{ $statusMessage }}</span>
            </div>
        @endif

        <!-- Filter & Action Controls -->
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; background: rgba(0,0,0,0.02); padding: 12px; border-radius: 12px; border: 1px solid rgba(0,0,0,0.05);" class="dark:bg-gray-900/50 dark:border-gray-800">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 13px; font-weight: 700; text-transform: uppercase; color: #6B7280;">Quick Synthesis Actions:</span>
                <button wire:click="runSynthesis('BCS')" class="btn-outline"><i class="fa-solid fa-gavel"></i> Synthesize BCS</button>
                <button wire:click="runSynthesis('Bank')" class="btn-outline"><i class="fa-solid fa-building-columns"></i> Synthesize Bank</button>
                <button wire:click="runSynthesis('Primary')" class="btn-outline"><i class="fa-solid fa-school"></i> Synthesize Primary</button>
            </div>

            <div style="display: flex; align-items: center; gap: 8px;">
                <label style="font-size: 13px; font-weight: 700; color: #6B7280;">Filter Matrix View:</label>
                <select wire:model.live="selectedExamType" style="padding: 8px 14px; border-radius: 8px; border: 1px solid #D1D5DB; background: #fff; font-size: 13px; font-weight: 600;" class="dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                    <option value="All">All Exam Types</option>
                    <option value="BCS">BCS Viva Matrix</option>
                    <option value="Bank">Bank AD / Officer Matrix</option>
                    <option value="Primary">Primary Teacher Matrix</option>
                </select>
            </div>
        </div>

        <!-- Synthesized Cards Grid -->
        @if($cards->isEmpty())
            <div class="synth-card" style="text-align: center; padding: 40px;">
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
                                <span style="background: linear-gradient(135deg, #059669 0%, #10B981 100%); color: #fff; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;">
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
