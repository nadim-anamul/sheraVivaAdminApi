<?php

namespace App\Filament\Pages;

use App\Models\VivaSessionLog;
use App\Services\GeminiAiService;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class AiSimulatorPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCommandLine;

    protected static ?string $navigationLabel = 'AI Viva Simulator';

    protected static ?string $title = 'Gemini AI - Adaptive Viva Board Simulator';

    protected string $view = 'filament.pages.ai-simulator';

    public string $examType = 'BCS';

    public string $position = 'Administration Cadre';

    public string $candidateCv = 'Subject: Political Science, University: Dhaka University. Choice 1: Admin, Choice 2: Police. Born in Barisal.';

    public array $transcriptHistory = [];

    public string $currentQuestion = '';

    public string $candidateAnswer = '';

    public ?array $currentEvaluation = null;

    public ?array $finalEvaluation = null;

    public string $statusMessage = '';

    public bool $isSessionActive = false;

    public bool $isConcluded = false;

    public int $questionCount = 0;

    public int $minQuestions = 5;

    public int $maxQuestions = 15;

    public array $expectedKeyPoints = [];

    /**
     * Start the AI mock session and generate Question #1.
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
        $this->finalEvaluation = null;
        $this->candidateAnswer = '';
        $this->questionCount = 1;
        $this->isConcluded = false;

        try {
            $response = $gemini->generateVivaQuestion(
                "{$this->examType} {$this->position} Mock Viva Board",
                [],
                $this->examType,
                $this->position,
                $this->candidateCv,
                1
            );

            if (!empty($response)) {
                $this->currentQuestion = $response['question'] ?? 'Introduce yourself and state your key choices.';
                $this->expectedKeyPoints = $response['expected_key_points'] ?? [];

                $this->transcriptHistory[] = [
                    'speaker' => $response['speaker'] ?? 'Chairman',
                    'text' => $this->currentQuestion,
                ];

                $this->isSessionActive = true;
                $this->statusMessage = 'Question 1 (Adaptive Board Session: 5 to 15 questions)';
            } else {
                $this->statusMessage = 'Failed to generate first question. Verify your API key.';
            }
        } catch (\Exception $e) {
            $this->statusMessage = 'Error starting session: '.$e->getMessage();
        }
    }

    /**
     * Submit candidate response, evaluate turn, and adaptively advance or conclude.
     */
    public function submitAnswer(GeminiAiService $gemini): void
    {
        $this->validate([
            'candidateAnswer' => 'required|string|min:5',
        ]);

        $this->statusMessage = 'AI Board is evaluating your response...';

        try {
            // 1. Evaluate single answer
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

            // 3. Check hard cap limit (15 questions)
            if ($this->questionCount >= $this->maxQuestions) {
                $this->concludeSession($gemini);

                return;
            }

            // 4. Query AI Board for next turn or adaptive conclusion (if >= 5 questions)
            $nextCount = $this->questionCount + 1;
            $response = $gemini->generateVivaQuestion(
                "{$this->examType} {$this->position} Mock Board",
                $this->transcriptHistory,
                $this->examType,
                $this->position,
                $this->candidateCv,
                $nextCount
            );

            if (!empty($response)) {
                $isBoardConcluded = ($response['is_concluded'] ?? false) && ($nextCount > $this->minQuestions);

                if ($isBoardConcluded) {
                    $this->transcriptHistory[] = [
                        'speaker' => $response['speaker'] ?? 'Chairman',
                        'text' => $response['question'] ?? 'Thank you. The board has concluded your viva.',
                    ];
                    $this->concludeSession($gemini);
                } else {
                    $this->questionCount = $nextCount;
                    $this->currentQuestion = $response['question'] ?? 'What are your primary goals in this service?';
                    $this->expectedKeyPoints = $response['expected_key_points'] ?? [];

                    $this->transcriptHistory[] = [
                        'speaker' => $response['speaker'] ?? 'Board Member',
                        'text' => $this->currentQuestion,
                    ];

                    $this->candidateAnswer = '';
                    $this->statusMessage = "Question {$this->questionCount} of 15 (Board evaluating live suitability...)";
                }
            } else {
                $this->concludeSession($gemini);
            }
        } catch (\Exception $e) {
            $this->statusMessage = 'Error processing turn: '.$e->getMessage();
        }
    }

    /**
     * Conclude session, perform overall evaluation out of 100, and save to DB.
     */
    public function concludeSession(GeminiAiService $gemini): void
    {
        $this->statusMessage = 'Calculating final board marks and compiling overall evaluation report...';

        try {
            $finalReport = $gemini->evaluateFullSessionTranscript(
                $this->transcriptHistory,
                $this->examType,
                $this->position,
                $this->candidateCv
            );

            $this->finalEvaluation = $finalReport;
            $this->isConcluded = true;
            $this->isSessionActive = false;

            // Save completed session into DB
            VivaSessionLog::create([
                'user_id' => auth()->id(),
                'candidate_name' => auth()->user()?->name ?? 'Candidate',
                'exam_type' => $this->examType,
                'position' => $this->position,
                'candidate_cv' => $this->candidateCv,
                'total_questions' => $this->questionCount,
                'overall_score' => $finalReport['overall_score'] ?? 75,
                'verdict' => $finalReport['verdict'] ?? 'Recommended',
                'score_breakdown' => $finalReport['score_breakdown'] ?? [],
                'board_feedback' => $finalReport['board_feedback'] ?? null,
                'recommendations' => $finalReport['recommendations'] ?? null,
                'transcript' => $this->transcriptHistory,
                'completed_at' => now(),
            ]);

            $score = $finalReport['overall_score'] ?? 75;
            $verdict = $finalReport['verdict'] ?? 'Recommended';
            $this->statusMessage = "VIVA CONCLUDED ({$this->questionCount} Questions Asked)! Final Board Marks: {$score}/100 ({$verdict}). Record saved in Dashboard!";
        } catch (\Exception $e) {
            $this->statusMessage = 'Error concluding session: '.$e->getMessage();
        }
    }

    /**
     * Reset the active session.
     */
    public function resetSession(): void
    {
        $this->isSessionActive = false;
        $this->isConcluded = false;
        $this->currentQuestion = '';
        $this->candidateAnswer = '';
        $this->currentEvaluation = null;
        $this->finalEvaluation = null;
        $this->transcriptHistory = [];
        $this->questionCount = 0;
        $this->statusMessage = 'Session reset. Ready for a new viva.';
    }
}
