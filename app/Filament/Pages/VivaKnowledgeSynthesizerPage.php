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

    public array $pendingBatches = [];

    /**
     * Start the micro-batch queue synthesis.
     */
    public function startBatchSynthesis(GeminiAiService $gemini, ?string $examType = null): void
    {
        $this->isSynthesizing = true;
        $this->pendingBatches = $gemini->getSynthesisBatches($examType);
        $this->totalStepCount = count($this->pendingBatches);
        $this->currentStepIndex = 0;

        if ($this->totalStepCount === 0) {
            $this->isSynthesizing = false;
            $this->statusMessage = 'No Question Bank records found to synthesize.';

            return;
        }

        $this->statusMessage = "Starting synthesis across {$this->totalStepCount} micro-batches...";
    }

    /**
     * Process ONE single micro-batch step safely within ~2.5 seconds.
     */
    public function processMicroBatchStep(GeminiAiService $gemini, int $batchIndex): void
    {
        if (!isset($this->pendingBatches[$batchIndex])) {
            return;
        }

        $batch = $this->pendingBatches[$batchIndex];

        try {
            $gemini->synthesizeMicroBatch($batch);
            $this->currentStepIndex++;

            if ($this->currentStepIndex >= $this->totalStepCount) {
                $this->isSynthesizing = false;
                $this->statusMessage = "COMPLETED! Synthesized all {$this->totalStepCount} micro-batches successfully!";
            } else {
                $this->statusMessage = "Synthesized {$batch['label']} ({$this->currentStepIndex}/{$this->totalStepCount}). Processing next batch...";
            }
        } catch (\Exception $e) {
            $this->currentStepIndex++;
            $this->statusMessage = "Error synthesizing {$batch['label']}: ".$e->getMessage();
            if ($this->currentStepIndex >= $this->totalStepCount) {
                $this->isSynthesizing = false;
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
