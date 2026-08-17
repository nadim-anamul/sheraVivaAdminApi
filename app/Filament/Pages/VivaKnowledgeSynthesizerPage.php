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

    public array $pendingCategories = [];

    /**
     * Start the stepped category synthesis queue.
     */
    public function startBatchSynthesis(array $categories = []): void
    {
        if (empty($categories)) {
            $categories = QuestionBank::distinct()->pluck('exam_type')->toArray();
            if (empty($categories)) {
                $categories = ['BCS', 'Bank', 'Primary', 'Other'];
            }
        }

        $this->isSynthesizing = true;
        $this->pendingCategories = array_values(array_unique($categories));
        $this->totalStepCount = count($this->pendingCategories);
        $this->currentStepIndex = 0;
        $this->statusMessage = "Starting step-by-step synthesis for {$this->totalStepCount} category groups...";
    }

    /**
     * Process ONE single exam category step safely within 3-5 seconds.
     */
    public function processCategoryStep(GeminiAiService $gemini, string $examType): void
    {
        try {
            $result = $gemini->synthesizeExamKnowledge($examType);

            $this->currentStepIndex++;

            if ($this->currentStepIndex >= $this->totalStepCount) {
                $this->isSynthesizing = false;
                $this->statusMessage = "COMPLETED! Synthesized all {$this->totalStepCount} exam knowledge matrices successfully!";
            } else {
                $this->statusMessage = "Synthesized {$examType} matrix ({$this->currentStepIndex}/{$this->totalStepCount}). Processing next category...";
            }
        } catch (\Exception $e) {
            $this->currentStepIndex++;
            $this->statusMessage = "Error synthesizing {$examType}: ".$e->getMessage();
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
