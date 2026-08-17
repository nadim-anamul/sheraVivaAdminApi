<?php

namespace App\Filament\Pages;

use App\Models\ExamKnowledgeBank;
use App\Models\QuestionBank;
use App\Services\GeminiAiService;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class VivaKnowledgeSynthesizerPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCpuChip;

    protected static ?string $navigationLabel = 'AI Knowledge Synthesizer';

    protected static ?string $title = 'Gemini AI - Exam Viva Knowledge Synthesizer';

    protected string $view = 'filament.pages.viva-knowledge-synthesizer';

    public string $selectedExamType = 'All';

    public string $statusMessage = '';

    public bool $isSynthesizing = false;

    public int $currentStepIndex = 0;

    public int $totalStepCount = 0;

    public int $pendingBatchesCount = 0;

    /**
     * Start the micro-batch queue synthesis.
     */
    public function startBatchSynthesis(GeminiAiService $gemini, ?string $examType = null, bool $onlyNewRecords = true): array
    {
        $this->isSynthesizing = true;
        $batches = $gemini->getSynthesisBatches($examType, $onlyNewRecords);

        session()->put('viva_synth_pending_batches', $batches);
        $this->pendingBatchesCount = count($batches);
        $this->totalStepCount = count($batches);
        $this->currentStepIndex = 0;

        if ($this->totalStepCount === 0) {
            $this->isSynthesizing = false;
            $this->statusMessage = $onlyNewRecords
                ? 'All Question Bank records are up to date! No new un-synthesized items found.'
                : 'No Question Bank records found to synthesize.';

            return [];
        }

        $this->statusMessage = "Starting synthesis across {$this->totalStepCount} micro-batches...";

        // Return minimal batch metadata array (labels only) to frontend to avoid payload bloat
        return array_map(function ($b) {
            return ['label' => $b['label'] ?? 'Micro-Batch'];
        }, $batches);
    }

    /**
     * Process ONE single micro-batch step safely from session memory.
     */
    public function processMicroBatchStep(GeminiAiService $gemini, int $batchIndex): void
    {
        $batches = session('viva_synth_pending_batches', []);

        if (!isset($batches[$batchIndex])) {
            return;
        }

        $batch = $batches[$batchIndex];

        try {
            $gemini->synthesizeMicroBatch($batch);
            $this->currentStepIndex++;

            if ($this->currentStepIndex >= $this->totalStepCount) {
                $this->isSynthesizing = false;
                $this->statusMessage = "COMPLETED! Synthesized all {$this->totalStepCount} micro-batches successfully!";
                session()->forget('viva_synth_pending_batches');
            } else {
                $this->statusMessage = "Synthesized {$batch['label']} ({$this->currentStepIndex}/{$this->totalStepCount}). Processing next batch...";
            }
        } catch (\Exception $e) {
            $this->currentStepIndex++;
            $this->statusMessage = "Error synthesizing {$batch['label']}: ".$e->getMessage();
            if ($this->currentStepIndex >= $this->totalStepCount) {
                $this->isSynthesizing = false;
                session()->forget('viva_synth_pending_batches');
            }
        }
    }

    /**
     * Get overview stats for the page header.
     */
    public function getViewData(): array
    {
        return [
            'totalCards' => ExamKnowledgeBank::count(),
            'totalQuestionBankRecords' => QuestionBank::count(),
            'lastSynthesisDate' => ExamKnowledgeBank::max('last_synthesized_at'),
            'cards' => ExamKnowledgeBank::when($this->selectedExamType !== 'All', function ($q) {
                $q->where('exam_type', $this->selectedExamType);
            })->latest('last_synthesized_at')->get(),
        ];
    }
}
