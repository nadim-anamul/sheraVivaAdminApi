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

    /**
     * Trigger AI synthesis across QuestionBank records.
     */
    public function runSynthesis(GeminiAiService $gemini, ?string $examType = null): void
    {
        $this->isSynthesizing = true;
        $target = ($examType && $examType !== 'All') ? $examType : null;
        $targetLabel = $target ?: 'All Exam Categories';

        $this->statusMessage = "Analyzing Question Bank data & compiling AI Exam Knowledge Matrices for {$targetLabel}...";

        try {
            $result = $gemini->synthesizeExamKnowledge($target);
            $this->statusMessage = $result['message'] ?? 'Synthesis completed!';
        } catch (\Exception $e) {
            $this->statusMessage = 'Synthesis failed: '.$e->getMessage();
        } finally {
            $this->isSynthesizing = false;
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
