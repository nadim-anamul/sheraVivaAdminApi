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

    protected static ?string $title = 'Gemini AI - 10 to 20 Min Multi-Choice Cadre Viva Simulator';

    protected string $view = 'filament.pages.ai-simulator';

    public string $examType = 'BCS';

    public string $position = 'BCS Administration Cadre';

    public string $choice1 = 'BCS Administration Cadre';

    public string $choice2 = 'BCS Foreign Affairs Cadre';

    public string $choice3 = 'BCS Police Cadre';

    public string $choice4 = 'BCS Audit & Accounts Cadre';

    public string $choice5 = 'BCS Taxation Cadre';

    public string $choice6 = 'BCS Customs & Excise Cadre';

    public string $choice7 = 'BCS Ansar & VDP Cadre';

    public string $candidateCv = 'Subject: Political Science, University: Dhaka University. Home District: Barisal. Achievements: Debate Champion.';

    public array $transcriptHistory = [];

    public string $currentQuestion = '';

    public string $candidateAnswer = '';

    public ?array $currentEvaluation = null;

    public ?array $finalEvaluation = null;

    public string $statusMessage = '';

    public bool $isSessionActive = false;

    public bool $isConcluded = false;

    public int $questionCount = 0;

    public int $minQuestions = 8;

    public int $maxQuestions = 20;

    public array $expectedKeyPoints = [];

    public function mount(): void
    {
        $this->setDefaultChoicesForCategory($this->examType);
    }

    public function updatedExamType($val): void
    {
        $this->setDefaultChoicesForCategory($val);
    }

    public function setDefaultChoicesForCategory(string $category): void
    {
        match (strtoupper($category)) {
            'BANK' => $this->setBankDefaults(),
            'PRIMARY' => $this->setPrimaryDefaults(),
            'OTHER' => $this->setOtherDefaults(),
            default => $this->setBcsDefaults(),
        };
    }

    protected function setBcsDefaults(): void
    {
        $this->position = 'BCS Administration Cadre';
        $this->choice1 = 'BCS Administration Cadre';
        $this->choice2 = 'BCS Foreign Affairs Cadre';
        $this->choice3 = 'BCS Police Cadre';
        $this->choice4 = 'BCS Audit & Accounts Cadre';
        $this->choice5 = 'BCS Taxation Cadre';
        $this->choice6 = 'BCS Customs & Excise Cadre';
        $this->choice7 = 'BCS Ansar & VDP Cadre';
        $this->candidateCv = 'Subject: Political Science, University: Dhaka University. Home District: Barisal. Target: BCS Admin/Foreign/Police.';
    }

    protected function setBankDefaults(): void
    {
        $this->position = 'Assistant Director (AD) - Bangladesh Bank';
        $this->choice1 = 'Assistant Director (AD) - Bangladesh Bank';
        $this->choice2 = 'Senior Officer - Sonali Bank PLC';
        $this->choice3 = 'Senior Officer - Agrani Bank PLC';
        $this->choice4 = 'Officer - Janata Bank PLC';
        $this->choice5 = 'Senior Officer - Rupali Bank PLC';
        $this->choice6 = 'Officer - Bangladesh Krishi Bank';
        $this->choice7 = 'Officer - BASIC Bank Limited';
        $this->candidateCv = 'Subject: Accounting / Finance & Banking, University: Dhaka University. Home District: Barisal. Target: BB AD & State Banks.';
    }

    protected function setPrimaryDefaults(): void
    {
        $this->position = 'Primary Assistant Teacher (Barisal Sadar)';
        $this->choice1 = 'Barisal Sadar Upazila Primary School';
        $this->choice2 = 'Bakerganj Upazila Primary School';
        $this->choice3 = 'Babuganj Upazila Primary School';
        $this->choice4 = 'Wazirpur Upazila Primary School';
        $this->choice5 = 'Gournadi Upazila Primary School';
        $this->choice6 = 'Muladi Upazila Primary School';
        $this->choice7 = 'Mehendiganj Upazila Primary School';
        $this->candidateCv = 'Subject: B.Ed / General Honors, University: Barisal University. Home District: Barisal. Target: Primary Teacher.';
    }

    protected function setOtherDefaults(): void
    {
        $this->position = 'Assistant Director - Anti-Corruption Commission (ACC)';
        $this->choice1 = 'Assistant Director - ACC';
        $this->choice2 = 'Field Officer - National Security Intelligence (NSI)';
        $this->choice3 = 'Sub-Inspector - Bangladesh Police';
        $this->choice4 = 'Auditor - Comptroller & Auditor General (CAG)';
        $this->choice5 = 'Customs Inspector - National Board of Revenue (NBR)';
        $this->choice6 = 'Assistant Superintendent - Jail';
        $this->choice7 = 'Assistant Postmaster - Postal Department';
        $this->candidateCv = 'Subject: Law / Criminology, University: Dhaka University. Home District: Barisal. Target: ACC / NSI AD.';
    }

    /**
     * Get candidate dynamic cadre preferences list.
     */
    protected function getCadreChoices(): array
    {
        $choices = [];
        if (!empty(trim($this->choice1))) {
            $choices['1st Choice'] = $this->choice1;
        }
        if (!empty(trim($this->choice2))) {
            $choices['2nd Choice'] = $this->choice2;
        }
        if (!empty(trim($this->choice3))) {
            $choices['3rd Choice'] = $this->choice3;
        }
        if (!empty(trim($this->choice4))) {
            $choices['4th Choice'] = $this->choice4;
        }
        if (!empty(trim($this->choice5))) {
            $choices['5th Choice'] = $this->choice5;
        }
        if (!empty(trim($this->choice6))) {
            $choices['6th Choice'] = $this->choice6;
        }
        if (!empty(trim($this->choice7))) {
            $choices['7th Choice'] = $this->choice7;
        }

        return $choices;
    }

    /**
     * Start the AI mock session and generate Question #1.
     */
    public function startSession(GeminiAiService $gemini): void
    {
        $this->validate([
            'examType' => 'required|string',
            'choice1' => 'required|string',
            'candidateCv' => 'required|string|min:10',
        ]);

        $this->position = $this->choice1;
        $this->statusMessage = 'Assembling 10-20 min BPSC Board and loading candidate preference choices (1 to 7)...';
        $this->transcriptHistory = [];
        $this->currentEvaluation = null;
        $this->finalEvaluation = null;
        $this->candidateAnswer = '';
        $this->questionCount = 1;
        $this->isConcluded = false;

        try {
            $response = $gemini->generateVivaQuestion(
                "{$this->examType} Cadre Preference Choice Viva Board",
                [],
                $this->examType,
                $this->position,
                $this->candidateCv,
                1,
                $this->getCadreChoices()
            );

            if (!empty($response)) {
                $this->currentQuestion = $response['question'] ?? 'Introduce yourself, your academic background, and explain why Admin is your 1st choice.';
                $this->expectedKeyPoints = $response['expected_key_points'] ?? [];

                $this->transcriptHistory[] = [
                    'speaker' => $response['speaker'] ?? 'Chairman',
                    'text' => $this->currentQuestion,
                ];

                $this->isSessionActive = true;
                $this->statusMessage = 'Question 1 (10-20 Min Board Session: 8 to 20 questions)';
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

        $this->statusMessage = 'AI Board is evaluating your response and probing cadre suitability...';

        try {
            // 1. Evaluate single answer
            $eval = $gemini->evaluateAnswer(
                $this->currentQuestion,
                $this->candidateAnswer,
                "{$this->examType} - {$this->position}"
            );

            $this->currentEvaluation = $eval;

            // Format feedback, recommendations & model answer strings
            $fbStr = is_array($eval['feedback'] ?? null) ? implode(' ', $eval['feedback']) : ($eval['feedback'] ?? '');
            $modelAnsStr = is_array($eval['model_answer'] ?? null) ? implode(' ', $eval['model_answer']) : ($eval['model_answer'] ?? '');
            $recStr = is_array($eval['recommendations'] ?? null) ? implode(' ', $eval['recommendations']) : ($eval['recommendations'] ?? '');

            // Store detailed Q&A & evaluation turn object into transcript history
            $this->transcriptHistory[] = [
                'turn' => $this->questionCount,
                'speaker' => 'Board Chairman',
                'question' => $this->currentQuestion,
                'expected_key_points' => $this->expectedKeyPoints,
                'candidate_answer' => $this->candidateAnswer,
                'score' => $eval['score'] ?? 75,
                'fluency_rating' => $eval['fluency_rating'] ?? 'Good',
                'knowledge_rating' => $eval['knowledge_rating'] ?? 'Good',
                'fillers_detected' => $eval['fillers_detected'] ?? 0,
                'feedback' => $fbStr,
                'recommendations' => $recStr,
                'model_answer' => $modelAnsStr,
            ];

            // 3. Check hard cap limit (20 questions)
            if ($this->questionCount >= $this->maxQuestions) {
                $this->concludeSession($gemini);

                return;
            }

            // 4. Query AI Board for next turn or adaptive conclusion (if >= 8 questions)
            $nextCount = $this->questionCount + 1;
            $response = $gemini->generateVivaQuestion(
                "{$this->examType} Cadre Preference Choice Viva Board",
                $this->transcriptHistory,
                $this->examType,
                $this->position,
                $this->candidateCv,
                $nextCount,
                $this->getCadreChoices()
            );

            if (!empty($response)) {
                $isBoardConcluded = ($response['is_concluded'] ?? false) && ($nextCount > $this->minQuestions);

                if ($isBoardConcluded) {
                    $this->transcriptHistory[] = [
                        'speaker' => $response['speaker'] ?? 'Chairman',
                        'text' => $response['question'] ?? 'Thank you candidate. The board has concluded your viva session.',
                    ];
                    $this->concludeSession($gemini);
                } else {
                    $this->questionCount = $nextCount;
                    $this->currentQuestion = $response['question'] ?? 'What are your primary goals in this service?';
                    $this->expectedKeyPoints = $response['expected_key_points'] ?? [];

                    $this->candidateAnswer = '';
                    $this->statusMessage = "Question {$this->questionCount} of 20 (Board evaluating Cadre Choices 1 to 7...)";
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
        $this->statusMessage = 'Compiling 10-20 min Board Evaluation and assigning Cadre Placement Recommendation...';

        try {
            $finalReport = $gemini->evaluateFullSessionTranscript(
                $this->transcriptHistory,
                $this->examType,
                $this->position,
                $this->candidateCv,
                $this->getCadreChoices()
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
                'overall_score' => $finalReport['overall_score'] ?? 80,
                'verdict' => $finalReport['verdict'] ?? 'Recommended',
                'score_breakdown' => $finalReport['score_breakdown'] ?? [],
                'board_feedback' => $finalReport['board_feedback'] ?? null,
                'recommendations' => $finalReport['recommendations'] ?? null,
                'transcript' => $this->transcriptHistory,
                'completed_at' => now(),
            ]);

            $score = $finalReport['overall_score'] ?? 80;
            $verdict = $finalReport['verdict'] ?? 'Recommended';
            $this->statusMessage = "VIVA CONCLUDED ({$this->questionCount} Questions Asked)! Final Board Verdict: {$verdict} ({$score}/100). Record saved on Dashboard!";
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
