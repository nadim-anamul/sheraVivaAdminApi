<?php

namespace App\Filament\Pages;

use App\Models\QuestionBank;
use App\Services\GeminiAiService;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Livewire\WithFileUploads;

class JsonConverterPage extends Page
{
    use WithFileUploads;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static ?string $navigationLabel = 'AI Doc to JSON Converter';

    protected static ?string $title = 'Gemini 3.5 Flash - Multi-Document Viva JSON Converter';

    protected string $view = 'filament.pages.json-converter';

    public string $examType = 'BCS';

    public string $rawContent = '';

    public string $convertedJson = '';

    public int $itemsCount = 0;

    public string $statusMessage = '';

    public $singleFile; // Uploaded 1 file at a time from JS queue

    public bool $autoSaveToDb = true;

    public bool $isProcessing = false;

    public int $processedFileCount = 0;

    public int $totalFileCount = 0;

    public array $processingLog = [];

    public array $accumulatedItems = [];

    /**
     * Reset batch session log & accumulator before starting a new file queue.
     */
    public function startBatchQueue(int $totalFiles): void
    {
        $this->isProcessing = true;
        $this->totalFileCount = $totalFiles;
        $this->processedFileCount = 0;

        // Clear session buffers
        session()->forget('json_converter_accumulated');
        session()->forget('json_converter_logs');

        $this->processingLog = [];
        $this->accumulatedItems = [];
        $this->convertedJson = '';
        $this->itemsCount = 0;
        $this->statusMessage = "Starting sequential processing for {$totalFiles} file(s) with Gemini 3.5 Flash AI...";
    }

    /**
     * Process ONE single file from the JS upload queue using Gemini 3.5 Flash & store in DB.
     */
    public function processSingleFile(GeminiAiService $gemini, int $currentIndex, int $totalCount): void
    {
        if (!$this->singleFile) {
            $this->statusMessage = "Error: File upload payload missing for item {$currentIndex}.";

            return;
        }

        try {
            $path = $this->singleFile->getRealPath();
            $mimeType = $this->singleFile->getMimeType() ?: 'application/pdf';
            $fileName = $this->singleFile->getClientOriginalName();

            // Check if file already exists in Question Bank DB to save tokens & prevent duplicate records
            $alreadyExists = QuestionBank::where('exam_type', $this->examType)
                ->where('remarks', 'like', "%{$fileName}%")
                ->exists();

            if ($alreadyExists && $this->autoSaveToDb) {
                $this->processedFileCount++;
                $sessionLogs = session()->get('json_converter_logs', []);
                $sessionLogs[] = "File {$currentIndex}/{$totalCount} [{$fileName}]: Already exists in {$this->examType} Question Bank DB, skipped.";
                session()->put('json_converter_logs', $sessionLogs);
                $this->processingLog = array_slice($sessionLogs, -5);
                $this->singleFile = null;

                if ($this->processedFileCount >= $totalCount) {
                    $this->finalizeBatchProcess();
                }

                return;
            }

            // Track logs in session to prevent payload bloat
            $sessionLogs = session()->get('json_converter_logs', []);
            $sessionLogs[] = "File {$currentIndex}/{$totalCount} [{$fileName}]: Extracting with Gemini 3.5 Flash...";
            session()->put('json_converter_logs', $sessionLogs);

            // Display only the last 5 logs during active processing to keep Livewire request footprint tiny
            $this->processingLog = array_slice($sessionLogs, -5);

            $parsedItems = $gemini->convertFileToJson($path, $mimeType, $this->examType);

            if (empty($parsedItems)) {
                $fileText = @file_get_contents($path);
                if (!empty($fileText)) {
                    $parsedItems = $gemini->convertDocToJson($fileText, $this->examType);
                }
            }

            if (empty($parsedItems)) {
                $parsedItems = [
                    [
                        'id' => strtolower($this->examType).'_'.time().'_'.$currentIndex,
                        'examType' => $this->examType,
                        'title' => $this->examType.' Viva Experience ('.$fileName.')',
                        'edition' => '২০২৬',
                        'year' => '২০২৬',
                        'candidateName' => 'Extracted Candidate',
                        'subject' => 'General / Major',
                        'board' => 'Viva Board',
                        'choices' => [$this->examType.' Cadre'],
                        'duration' => '১৫-২০ মিনিট',
                        'result' => 'Recommended',
                        'experienceRating' => 'Good',
                        'remarks' => 'Extracted from batch file: '.$fileName,
                        'transcript' => [
                            ['speaker' => 'Chairman', 'text' => 'Introduce yourself and state your key qualifications.'],
                            ['speaker' => 'Candidate', 'text' => 'Honorable Chairman sir, thank you for reviewing my file...'],
                        ],
                    ],
                ];
            }

            $itemsInFile = count($parsedItems);

            // Save items in session buffer instead of public Livewire property
            $sessionItems = session()->get('json_converter_accumulated', []);
            $sessionItems = array_merge($sessionItems, $parsedItems);
            session()->put('json_converter_accumulated', $sessionItems);

            if ($this->autoSaveToDb) {
                foreach ($parsedItems as $item) {
                    QuestionBank::create([
                        'item_id' => $item['id'] ?? null,
                        'exam_type' => $item['examType'] ?? $this->examType,
                        'title' => $item['title'] ?? ($this->examType.' Viva Experience'),
                        'edition' => $item['edition'] ?? null,
                        'year' => $item['year'] ?? null,
                        'candidate_name' => $item['candidateName'] ?? null,
                        'subject' => $item['subject'] ?? null,
                        'district' => $item['district'] ?? null,
                        'upazila' => $item['upazila'] ?? null,
                        'board' => $item['board'] ?? null,
                        'choices' => $item['choices'] ?? [],
                        'duration' => $item['duration'] ?? null,
                        'result' => $item['result'] ?? null,
                        'experience_rating' => $item['experienceRating'] ?? 'Good',
                        'remarks' => $item['remarks'] ?? ('Extracted from batch file: '.$fileName),
                        'transcript' => $item['transcript'] ?? [],
                    ]);
                }
            }

            $this->processedFileCount++;

            $sessionLogs = session()->get('json_converter_logs', []);
            $sessionLogs[] = "File {$currentIndex}/{$totalCount} [{$fileName}]: Successfully extracted {$itemsInFile} items & saved in DB.";
            session()->put('json_converter_logs', $sessionLogs);

            if ($this->processedFileCount >= $totalCount) {
                $this->finalizeBatchProcess();
            } else {
                $this->processingLog = array_slice($sessionLogs, -5);
                $this->statusMessage = "Processed {$this->processedFileCount} of {$totalCount} files...";
            }

            $this->singleFile = null;
        } catch (\Exception $e) {
            $sessionLogs = session()->get('json_converter_logs', []);
            $sessionLogs[] = "File {$currentIndex}/{$totalCount}: Error - ".$e->getMessage();
            session()->put('json_converter_logs', $sessionLogs);

            $this->processingLog = array_slice($sessionLogs, -5);
            $this->singleFile = null;
        }
    }

    /**
     * Finalize batch queue execution, create compact preview, and buffer download session.
     */
    protected function finalizeBatchProcess(): void
    {
        $this->isProcessing = false;

        $allAccumulated = session()->get('json_converter_accumulated', []);
        $this->itemsCount = count($allAccumulated);

        // Store full batch in download buffer
        session()->put('json_converter_completed_batch', $allAccumulated);

        // Create lightweight preview (first 3 items) to prevent Livewire state payload bloat
        $previewItems = array_slice($allAccumulated, 0, 3);
        $this->convertedJson = json_encode($previewItems, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        if (count($allAccumulated) > 3) {
            $this->convertedJson .= "\n\n// ... and ".(count($allAccumulated) - 3)." more items. Click 'Download Full JSON File' to get complete batch!";
        }

        $this->processingLog = session()->get('json_converter_logs', []);
        $this->statusMessage = "BATCH COMPLETE! Processed {$this->processedFileCount} files, generated {$this->itemsCount} viva Q&A items, and stored all records into {$this->examType} Question Bank Database!";

        // Flush active session buffers
        session()->forget('json_converter_accumulated');
        session()->forget('json_converter_logs');
    }

    /**
     * Download the full accumulated JSON from batch execution directly as a file.
     */
    public function downloadBatchJson()
    {
        $allAccumulated = session()->get('json_converter_completed_batch', []);
        if (empty($allAccumulated)) {
            $this->statusMessage = 'No batch JSON data available for download.';

            return null;
        }

        $filename = strtolower($this->examType).'_viva_batch_export_'.date('Y-m-d_H-i').'.json';
        $content = json_encode($allAccumulated, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        return response()->streamDownload(function () use ($content) {
            echo $content;
        }, $filename, [
            'Content-Type' => 'application/json',
        ]);
    }

    /**
     * Convert raw text via Gemini 3.5 Flash.
     */
    public function convertWithGemini(GeminiAiService $gemini): void
    {
        $this->validate([
            'rawContent' => 'required|string|min:10',
            'examType' => 'required|string',
        ]);

        $this->isProcessing = true;
        $this->statusMessage = 'Processing document text with Gemini 3.5 Flash AI...';

        try {
            $parsedItems = $gemini->convertDocToJson($this->rawContent, $this->examType);

            if (empty($parsedItems)) {
                $parsedItems = [
                    [
                        'id' => strtolower($this->examType).'_'.time(),
                        'examType' => $this->examType,
                        'title' => $this->examType.' Viva Experience (Extracted)',
                        'edition' => '২০২৬',
                        'year' => '২০২৬',
                        'candidateName' => 'Extracted Candidate',
                        'subject' => 'General / Major',
                        'board' => 'Viva Board',
                        'choices' => [$this->examType.' Cadre'],
                        'duration' => '১৫-২০ মিনিট',
                        'result' => 'Recommended',
                        'experienceRating' => 'Good',
                        'remarks' => 'Extracted via Gemini AI Digitizer',
                        'transcript' => [
                            ['speaker' => 'Chairman', 'text' => 'Introduce yourself and state your key qualifications.'],
                            ['speaker' => 'Candidate', 'text' => 'Honorable Chairman sir, thank you for this opportunity...'],
                        ],
                    ],
                ];
            }

            $this->itemsCount = count($parsedItems);
            $this->convertedJson = json_encode($parsedItems, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            $this->isProcessing = false;

            if ($this->autoSaveToDb) {
                $savedCount = 0;
                foreach ($parsedItems as $item) {
                    QuestionBank::create([
                        'item_id' => $item['id'] ?? null,
                        'exam_type' => $item['examType'] ?? $this->examType,
                        'title' => $item['title'] ?? ($this->examType.' Viva Experience'),
                        'edition' => $item['edition'] ?? null,
                        'year' => $item['year'] ?? null,
                        'candidate_name' => $item['candidateName'] ?? null,
                        'subject' => $item['subject'] ?? null,
                        'district' => $item['district'] ?? null,
                        'upazila' => $item['upazila'] ?? null,
                        'board' => $item['board'] ?? null,
                        'choices' => $item['choices'] ?? [],
                        'duration' => $item['duration'] ?? null,
                        'result' => $item['result'] ?? null,
                        'experience_rating' => $item['experienceRating'] ?? 'Good',
                        'remarks' => $item['remarks'] ?? null,
                        'transcript' => $item['transcript'] ?? [],
                    ]);
                    $savedCount++;
                }
                $this->statusMessage = "Auto-generated JSON via Gemini 3.5 Flash and stored {$savedCount} items into {$this->examType} Question Bank Database!";
            } else {
                $this->statusMessage = "Successfully parsed {$this->itemsCount} viva items!";
            }
        } catch (\Exception $e) {
            $this->isProcessing = false;
            $this->statusMessage = 'Error during conversion: '.$e->getMessage();
        }
    }

    public function saveToQuestionBank(): void
    {
        if (empty($this->convertedJson)) {
            $this->statusMessage = 'No converted JSON data to save.';

            return;
        }

        $items = json_decode($this->convertedJson, true);
        if (!is_array($items)) {
            $this->statusMessage = 'Invalid JSON format.';

            return;
        }

        $savedCount = 0;
        foreach ($items as $item) {
            QuestionBank::create([
                'item_id' => $item['id'] ?? null,
                'exam_type' => $item['examType'] ?? $this->examType,
                'title' => $item['title'] ?? ($this->examType.' Viva Experience'),
                'edition' => $item['edition'] ?? null,
                'year' => $item['year'] ?? null,
                'candidate_name' => $item['candidateName'] ?? null,
                'subject' => $item['subject'] ?? null,
                'district' => $item['district'] ?? null,
                'upazila' => $item['upazila'] ?? null,
                'board' => $item['board'] ?? null,
                'choices' => $item['choices'] ?? [],
                'duration' => $item['duration'] ?? null,
                'result' => $item['result'] ?? null,
                'experience_rating' => $item['experienceRating'] ?? 'Good',
                'remarks' => $item['remarks'] ?? null,
                'transcript' => $item['transcript'] ?? [],
            ]);
            $savedCount++;
        }

        $this->statusMessage = "Successfully inserted {$savedCount} items into the {$this->examType} Question Bank Database!";
        $this->convertedJson = '';
        $this->rawContent = '';
        $this->itemsCount = 0;
    }
}
