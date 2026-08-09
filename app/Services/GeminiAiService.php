<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiAiService
{
    protected string $apiKey;
    protected string $model;
    protected string $conversationModel;
    protected string $evaluationModel;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key', env('GEMINI_API_KEY', ''));
        $this->model = config('services.gemini.model', env('GEMINI_MODEL', 'gemini-2.5-flash'));
        $this->conversationModel = config('services.gemini.model_conversation', 'gemini-3.6-flash');
        $this->evaluationModel = config('services.gemini.model_evaluation', 'gemini-3.6-pro');
        $this->baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/';
    }

    /**
     * Convert uploaded PDF/Doc/Text file directly into structured viva question bank JSON using Gemini 3.5 Flash.
     */
    public function convertFileToJson(string $filePath, string $mimeType = 'application/pdf', string $examType = 'BCS'): array
    {
        // For DOCX files, extract text locally first as Gemini does not natively support DOCX base64 OLE archives
        if ($mimeType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || 
            str_ends_with(strtolower($filePath), '.docx') || 
            str_ends_with(strtolower($filePath), '.doc')) {
            
            $text = $this->extractTextFromDocx($filePath);
            if (!empty($text)) {
                return $this->convertDocToJson($text, $examType);
            }
        }

        $fileBytes = file_get_contents($filePath);
        if (!$fileBytes) {
            return [];
        }

        $base64Data = base64_encode($fileBytes);

        $prompt = <<<PROMPT
You are an expert Bangladeshi Job Viva (BCS, Bank, Primary Teacher, etc.) content digitizer and AI assistant.
Extract and convert the contents of the attached file into a clean, structured JSON array matching our Question Bank schema.

Target Exam Type: {$examType}

Each item in the JSON array MUST follow this exact JSON schema:
[
  {
    "id": "unique_string_id",
    "examType": "{$examType}",
    "title": "Clear descriptive title in Bangla or English",
    "edition": "e.g. ৪৬তম or N/A",
    "year": "e.g. ২০২৬",
    "candidateName": "Name or বেনামী",
    "subject": "Candidate major/subject",
    "district": "District name if available",
    "upazila": "Upazila name if available",
    "board": "Board chairman or board description",
    "choices": ["Cadre/Job Choice 1", "Choice 2"],
    "duration": "e.g. ১৫-২০ মিনিট",
    "result": "e.g. সুপারিশপ্রাপ্ত or N/A",
    "experienceRating": "Good or Excellent or Average",
    "remarks": "Summary notes or remarks",
    "transcript": [
      {
        "speaker": "Exactly one of: Chairman, Board Member 1, Board Member 2, Candidate, External Examiner",
        "text": "Detailed question or response statement"
      }
    ]
  }
]

Classify speakers strictly (e.g. map board questions or chairman comments to 'Chairman' or 'Board Member 1'/'Board Member 2', and candidate answers to 'Candidate').
Do not omit any Q&A pairs from the document. Format all transcript conversations neatly.
PROMPT;

        return $this->callGeminiJsonWithFile($prompt, $base64Data, $mimeType, $this->conversationModel);
    }

    /**
     * Convert raw document/PDF text into structured viva question bank JSON.
     */
    public function convertDocToJson(string $rawText, string $examType = 'BCS'): array
    {
        $prompt = <<<PROMPT
You are an expert Bangladeshi Job Viva (BCS, Bank, Primary Teacher, etc.) content digitizer and AI assistant.
Extract and convert the following raw document/text content into a clean, structured JSON array matching our Question Bank schema.

Target Exam Type: {$examType}

Each item in the JSON array MUST follow this exact JSON schema:
[
  {
    "id": "unique_string_id",
    "examType": "{$examType}",
    "title": "Clear descriptive title in Bangla or English",
    "edition": "e.g. ৪৬তম or N/A",
    "year": "e.g. ২০২৬",
    "candidateName": "Name or বেনামী",
    "subject": "Candidate major/subject",
    "district": "District name if available",
    "upazila": "Upazila name if available",
    "board": "Board chairman or board description",
    "choices": ["Cadre/Job Choice 1", "Choice 2"],
    "duration": "e.g. ১৫-২০ মিনিট",
    "result": "e.g. সুপারিশপ্রাপ্ত or N/A",
    "experienceRating": "Good or Excellent or Average",
    "remarks": "Summary notes or remarks",
    "transcript": [
      {
        "speaker": "Exactly one of: Chairman, Board Member 1, Board Member 2, Candidate, External Examiner",
        "text": "Detailed question or response statement"
      }
    ]
  }
]

Classify speakers strictly (e.g. map board questions or chairman comments to 'Chairman' or 'Board Member 1'/'Board Member 2', and candidate answers to 'Candidate').
Do not omit any Q&A pairs from the document. Format all transcript conversations neatly.

Document Content:
{$rawText}
PROMPT;

        return $this->callGeminiJson($prompt, $this->conversationModel);
    }

    /**
     * Generate dynamic AI viva question based on category and transcript history.
     * Incorporates RAG (Retrieval Augmented Generation) context from past real transcripts.
     */
    public function generateVivaQuestion(
        string $categoryTitle, 
        array $transcriptHistory = [], 
        string $examType = 'BCS', 
        string $position = 'General', 
        string $candidateCv = ''
    ): array {
        $historyText = '';
        foreach ($transcriptHistory as $item) {
            $speaker = $item['speaker'] ?? 'User';
            $text = $item['text'] ?? '';
            $historyText .= "{$speaker}: {$text}\n";
        }

        // Fetch up to 3 relevant past viva transcripts from DB matching the exam type and position/subject (RAG)
        $relevantExperiences = \App\Models\QuestionBank::where('exam_type', $examType)
            ->where(function ($query) use ($position, $candidateCv) {
                if (!empty($position)) {
                    $query->orWhere('title', 'like', "%{$position}%")
                          ->orWhere('subject', 'like', "%{$position}%");
                }
                if (!empty($candidateCv)) {
                    $query->orWhere('subject', 'like', "%{$candidateCv}%");
                }
            })
            ->limit(3)
            ->get();

        $realExamplesContext = "";
        if ($relevantExperiences->isNotEmpty()) {
            $realExamplesContext = "Here is context from REAL past board viva transcripts matching this exam/position:\n";
            foreach ($relevantExperiences as $index => $exp) {
                $realExamplesContext .= "Example " . ($index + 1) . " (" . $exp->title . "):\n";
                if (is_array($exp->transcript)) {
                    foreach (array_slice($exp->transcript, 0, 4) as $exStep) {
                        $speaker = $exStep['speaker'] ?? 'Interviewer';
                        $text = $exStep['text'] ?? '';
                        $realExamplesContext .= "  - {$speaker}: {$text}\n";
                    }
                }
                $realExamplesContext .= "\n";
            }
        }

        $prompt = <<<PROMPT
You are a highly distinguished Bangladeshi Viva Board Chairman for '{$categoryTitle}'.
Target Position: {$position}
Exam Type: {$examType}
Candidate Profile/CV: {$candidateCv}

Your goal is to conduct a highly realistic, professional, and rigorous job interview (in Bangla/English mixed naturally as done in real BPSC/Bank/Primary boards).

{$realExamplesContext}

Previous Conversation History:
{$historyText}

Based on the candidate's CV/bio, target position, real past board examples, and the ongoing conversation history, generate the NEXT viva board question for the candidate. Focus on testing their technical/academic knowledge, situational judgement, general awareness, and critically, their knowledge of recent national/international events, contemporary policy reforms, and current affairs in Bangladesh.

Return a structured JSON object:
{
  "question_no": number of question in session,
  "speaker": "Chairman" or "Board Member 1" or "Board Member 2",
  "question": "The question string in Bangla/English",
  "context_hint": "Brief background hint on why this question is being asked",
  "expected_key_points": ["Key concept 1", "Key concept 2"]
}
PROMPT;

        return $this->callGeminiJson($prompt, $this->conversationModel);
    }

    /**
     * Evaluate candidate viva answer using Gemini AI.
     */
    public function evaluateAnswer(string $question, string $candidateAnswer, string $categoryTitle): array
    {
        $prompt = <<<PROMPT
You are an expert evaluator for Bangladeshi Job Viva Examinations (BPSC, Bangladesh Bank AD, Primary Teacher).
Evaluate the candidate's answer to the board question below.

Category: {$categoryTitle}
Board Question: {$question}
Candidate's Answer: {$candidateAnswer}

Return a structured JSON object with full evaluation details:
{
  "score": number between 0 and 100,
  "fluency_rating": "Excellent" or "Good" or "Needs Improvement",
  "knowledge_rating": "High" or "Moderate" or "Basic",
  "fillers_detected": estimated count of hesitations/fillers,
  "feedback": "Comprehensive constructive evaluation in Bangla/English focusing on tone, precision, and depth",
  "recommendations": "Bullet points on how to improve this answer in real viva board",
  "model_answer": "An exemplary 100/100 response to this specific question"
}
PROMPT;

        $response = $this->callGeminiJson($prompt, $this->evaluationModel);

        if (empty($response)) {
            // Fallback response if API key is not configured or fails
            return [
                'score' => 82,
                'fluency_rating' => 'Good',
                'knowledge_rating' => 'Moderate',
                'fillers_detected' => 2,
                'feedback' => "Good effort! Your response addressed the core topic for {$categoryTitle}. Try to reference relevant legal/economic frameworks more directly.",
                'recommendations' => "1. Maintain strong eye contact and clear pacing.\n2. Support your statements with official statistics where applicable.",
                'model_answer' => "Sir, under the relevant regulations, we should prioritize national interest and administrative efficiency while ensuring full adherence to constitutional mandates."
            ];
        }

        return $response;
    }

    /**
     * Evaluate the entire conversation transcript of a mock session using Gemini AI.
     */
    public function evaluateSessionTranscript(array $transcript, string $categoryTitle): array
    {
        $conversationText = '';
        foreach ($transcript as $step) {
            $speaker = $step['speaker'] ?? 'Unknown';
            $text = $step['text'] ?? '';
            $conversationText .= "{$speaker}: {$text}\n";
        }

        $prompt = <<<PROMPT
You are a highly distinguished board evaluator for Bangladeshi Job Viva Examinations.
Analyze the complete interview transcript below and evaluate the candidate's performance.

Viva Category: {$categoryTitle}

Complete Interview Transcript:
{$conversationText}

Provide an overall assessment of the candidate's performance across the entire session.
Return a structured JSON object with these fields:
{
  "score": number between 0 and 100,
  "filler_words_count": estimated total count of hesitation/filler words used by the candidate (e.g. 'um', 'uh', 'আসলে', 'মানে'),
  "feedback": "Comprehensive constructive performance review focusing on fluency, domain knowledge, situational presence, and presentation tone.",
  "recommendations": "Actionable, numbered list of recommendations on what to improve for a real board viva"
}
PROMPT;

        $response = $this->callGeminiJson($prompt, $this->evaluationModel);

        if (empty($response)) {
            // Fallback response if API fails
            return [
                'score' => 80,
                'filler_words_count' => 4,
                'feedback' => 'Good overall performance. The candidate showed moderate understanding of the topics.',
                'recommendations' => '1. Practice speaking with fewer pauses.\n2. Work on technical definitions.',
            ];
        }

        return $response;
    }

    /**
     * Helper to send generateContent API request to Google Gemini API with JSON output mode.
     */
    protected function callGeminiJson(string $prompt, ?string $customModel = null): array
    {
        if (empty($this->apiKey) || $this->apiKey === 'YOUR_GEMINI_API_KEY') {
            Log::warning('Gemini API key is not set. Using fallback logic.');
            return [];
        }

        $primaryModel = $customModel ?? $this->model;

        // List of models to try in order (starts with configured model, falls back to best stable models)
        $modelsToTry = array_unique([
            $primaryModel, 
            'gemini-3.6-pro',
            'gemini-3.6-flash',
            'gemini-3.5-pro',
            'gemini-3.5-flash',
            'gemini-2.5-pro', 
            'gemini-2.5-flash', 
            'gemini-1.5-pro', 
            'gemini-1.5-flash', 
            'gemini-2.0-flash'
        ]);

        foreach ($modelsToTry as $modelName) {
            $url = $this->baseUrl . $modelName . ':generateContent?key=' . $this->apiKey;

            try {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->timeout(30)->post($url, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'responseMimeType' => 'application/json',
                        'temperature' => 0.4,
                    ]
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
                    $parsed = json_decode($text, true);
                    if (is_array($parsed)) {
                        return $parsed;
                    }
                } else {
                    Log::error("Gemini API call failed with model {$modelName}: " . $response->body());
                }
            } catch (\Exception $e) {
                Log::error("Gemini API Exception with model {$modelName}: " . $e->getMessage());
            }
        }

        return [];
    }

    /**
     * Helper to send inline file base64 data + prompt request to Google Gemini API.
     */
    protected function callGeminiJsonWithFile(string $prompt, string $base64Data, string $mimeType, ?string $customModel = null): array
    {
        if (empty($this->apiKey) || $this->apiKey === 'YOUR_GEMINI_API_KEY') {
            Log::warning('Gemini API key is not set. Using fallback logic for file upload.');
            return [];
        }

        $primaryModel = $customModel ?? $this->model;

        $modelsToTry = array_unique([
            $primaryModel, 
            'gemini-3.6-pro',
            'gemini-3.6-flash',
            'gemini-3.5-pro',
            'gemini-3.5-flash',
            'gemini-2.5-pro', 
            'gemini-2.5-flash', 
            'gemini-1.5-pro', 
            'gemini-1.5-flash', 
            'gemini-2.0-flash'
        ]);

        foreach ($modelsToTry as $modelName) {
            $url = $this->baseUrl . $modelName . ':generateContent?key=' . $this->apiKey;

            try {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->timeout(45)->post($url, [
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'inlineData' => [
                                        'mimeType' => $mimeType,
                                        'data' => $base64Data,
                                    ]
                                ],
                                [
                                    'text' => $prompt
                                ]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'responseMimeType' => 'application/json',
                        'temperature' => 0.4,
                    ]
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
                    $parsed = json_decode($text, true);
                    if (is_array($parsed)) {
                        return $parsed;
                    }
                } else {
                    Log::error("Gemini API file call failed with model {$modelName}: " . $response->body());
                }
            } catch (\Exception $e) {
                Log::error("Gemini API file Exception with model {$modelName}: " . $e->getMessage());
            }
        }

        return [];
    }

    /**
     * Helper to extract clean text from a DOCX file using ZipArchive.
     */
    public function extractTextFromDocx(string $filePath): ?string
    {
        $zip = new \ZipArchive();
        if ($zip->open($filePath) === true) {
            if (($index = $zip->locateName('word/document.xml')) !== false) {
                $data = $zip->getFromIndex($index);
                $zip->close();

                // Format paragraph endings and table rows as newlines to preserve spacing
                $cleanXml = str_replace(['</w:p>', '</w:tr>', '</w:tab>'], "\n", $data);
                
                // Strip w:t tags and keep only actual text content
                $text = strip_tags($cleanXml);
                
                // Decode HTML/XML entity values if any
                return html_entity_decode(trim($text), ENT_QUOTES, 'UTF-8');
            }
            $zip->close();
        }
        return null;
    }
}
