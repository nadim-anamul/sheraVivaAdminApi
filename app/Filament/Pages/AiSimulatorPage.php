<?php

namespace App\Filament\Pages;

use App\Services\GeminiAiService;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class AiSimulatorPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCommandLine;

    protected static ?string $navigationLabel = 'AI Viva Simulator';

    protected static ?string $title = 'Gemini 3.5 Flash - AI Mock Viva Simulator';

    protected string $view = 'filament.pages.ai-simulator';

    public string $examType = 'BCS';

    public string $position = 'Administration Cadre';

    public string $candidateCv = 'Subject: Political Science, University: Dhaka University. Choice 1: Admin, Choice 2: Police. Born in Barisal.';

    public array $transcriptHistory = [];

    public string $currentQuestion = '';

    public string $candidateAnswer = '';

    public ?array $currentEvaluation = null;

    public string $statusMessage = '';

    public bool $isSessionActive = false;

    public array $expectedKeyPoints = [];

    /**
     * Start the AI mock session and generate the first question using RAG.
     */
    public function startSession(GeminiAiService $gemini): void
    {
        $this->validate([
            'examType' => 'required|string',
            'position' => 'required|string',
            'candidateCv' => 'required|string|min:10',
        ]);

        $this->statusMessage = 'Querying past transcripts and preparing AI board setup...';
        $this->transcriptHistory = [];
        $this->currentEvaluation = null;
        $this->candidateAnswer = '';

        try {
            $response = $gemini->generateVivaQuestion(
                "{$this->examType} {$this->position} Mock Viva Board",
                [],
                $this->examType,
                $this->position,
                $this->candidateCv
            );

            if (!empty($response)) {
                $this->currentQuestion = $response['question'] ?? 'Introduce yourself and state your choices.';
                $this->expectedKeyPoints = $response['expected_key_points'] ?? [];

                $this->transcriptHistory[] = [
                    'speaker' => $response['speaker'] ?? 'Chairman',
                    'text' => $this->currentQuestion,
                ];

                $this->isSessionActive = true;
                $this->statusMessage = 'Mock interview session started!';
            } else {
                $this->statusMessage = 'Failed to generate first question. Verify your API key.';
            }
        } catch (\Exception $e) {
            $this->statusMessage = 'Error starting session: '.$e->getMessage();
        }
    }

    /**
     * Submit candidate response, evaluate it, and generate the next board question.
     */
    public function submitAnswer(GeminiAiService $gemini): void
    {
        $this->validate([
            'candidateAnswer' => 'required|string|min:5',
        ]);

        $this->statusMessage = 'AI Board is evaluating your answer and planning the next question...';

        try {
            // 1. Evaluate the answer
            $eval = $gemini->evaluateAnswer(
                $this->currentQuestion,
                $this->candidateAnswer,
                "{$this->examType} - {$this->position}"
            );

            $this->currentEvaluation = $eval;

            // 2. Add candidate answer to transcript history
            $this->transcriptHistory[] = [
                'speaker' => 'Candidate',
                'text' => $this->candidateAnswer,
            ];

            // 3. Generate the next question based on history and RAG context
            $response = $gemini->generateVivaQuestion(
                "{$this->examType} {$this->position} Mock Board",
                $this->transcriptHistory,
                $this->examType,
                $this->position,
                $this->candidateCv
            );

            if (!empty($response)) {
                $this->currentQuestion = $response['question'] ?? 'Thank you. The board has concluded your viva.';
                $this->expectedKeyPoints = $response['expected_key_points'] ?? [];

                $this->transcriptHistory[] = [
                    'speaker' => $response['speaker'] ?? 'Board Member',
                    'text' => $this->currentQuestion,
                ];

                $this->candidateAnswer = '';
                $this->statusMessage = 'Next question generated!';
            } else {
                $this->isSessionActive = false;
                $this->statusMessage = 'Interview session concluded by the board.';
            }

        } catch (\Exception $e) {
            $this->statusMessage = 'Error processing turn: '.$e->getMessage();
        }
    }

    /**
     * Conclude and reset the active session.
     */
    public function resetSession(): void
    {
        $this->isSessionActive = false;
        $this->currentQuestion = '';
        $this->candidateAnswer = '';
        $this->currentEvaluation = null;
        $this->transcriptHistory = [];
        $this->statusMessage = 'Session concluded and reset.';
    }
}
