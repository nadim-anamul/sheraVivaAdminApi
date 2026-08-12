<?php

namespace App\Filament\Pages;

use App\Models\JobUpdate;
use App\Services\GeminiAiService;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class AiJobFinderPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static ?string $navigationLabel = 'AI Job Finder';

    protected static ?string $title = 'Gemini 3.6 - AI Government Job Finder';

    protected string $view = 'filament.pages.ai-job-finder';

    public string $searchQuery = 'BPSC';

    public array $discoveredJobs = [];

    public bool $isSearching = false;

    public string $statusMessage = '';

    public array $importedIndices = [];

    /**
     * Search and discover latest govt jobs using Gemini Search Grounding.
     */
    public function searchJobs(GeminiAiService $gemini): void
    {
        $this->isSearching = true;
        $this->statusMessage = 'AI is searching live Google search indexes for recent Bangladesh govt circulars and results...';
        $this->discoveredJobs = [];
        $this->importedIndices = [];

        try {
            $jobs = $gemini->searchGovtJobs($this->searchQuery);
            if (!empty($jobs)) {
                $this->discoveredJobs = $jobs;
                $this->statusMessage = 'Successfully discovered '.count($jobs).' matches!';
            } else {
                $this->statusMessage = 'No matching government job circulars or results were found.';
            }
        } catch (\Exception $e) {
            $this->statusMessage = 'Search failed: '.$e->getMessage();
        } finally {
            $this->isSearching = false;
        }
    }

    /**
     * Update an editable field inside the local search results.
     */
    public function updateField(int $index, string $field, string $value): void
    {
        if (isset($this->discoveredJobs[$index])) {
            $this->discoveredJobs[$index][$field] = $value;
        }
    }

    /**
     * Import a single job post into the database.
     */
    public function importJob(int $index): void
    {
        if (!isset($this->discoveredJobs[$index])) {
            return;
        }

        if (in_array($index, $this->importedIndices)) {
            Notification::make()
                ->warning()
                ->title('Already Imported')
                ->body('This job circular is already imported.')
                ->send();

            return;
        }

        $job = $this->discoveredJobs[$index];

        // Basic validation of fields
        if (empty($job['title']) || empty($job['organization'])) {
            Notification::make()
                ->danger()
                ->title('Validation Error')
                ->body('Title and Organization are required to import.')
                ->send();

            return;
        }

        try {
            // Check for duplicate in DB
            $exists = JobUpdate::where('title', $job['title'])
                ->orWhere('file_url', $job['file_url'] ?? '')
                ->exists();

            if ($exists) {
                session()->flash('error', 'A job circular with this title or file link already exists in the database.');
                Notification::make()
                    ->warning()
                    ->title('Possible Duplicate')
                    ->body('A job circular with this title or file link already exists in the database.')
                    ->send();

                return;
            }

            JobUpdate::create([
                'title' => $job['title'],
                'organization' => $job['organization'],
                'type' => in_array($job['type'] ?? 'circular', ['circular', 'result']) ? ($job['type'] ?? 'circular') : 'circular',
                'published_date' => $job['published_date'] ?? now()->format('Y-m-d'),
                'file_url' => $job['file_url'] ?? 'https://bpsc.gov.bd',
                'file_size' => $job['file_size'] ?? '1.5 MB',
                'vacancies' => $job['vacancies'] ?? null,
                'qualifications' => $job['qualifications'] ?? null,
                'application_deadline' => !empty($job['application_deadline']) ? $job['application_deadline'] : null,
                'description' => $job['description'] ?? null,
            ]);

            $this->importedIndices[] = $index;

            session()->flash('success', 'Successfully imported: '.$job['title']);

            Notification::make()
                ->success()
                ->title('Circular Imported')
                ->body('Successfully imported: '.$job['title'])
                ->send();

        } catch (\Exception $e) {
            session()->flash('error', 'Import Failed: '.$e->getMessage());
            Notification::make()
                ->danger()
                ->title('Import Failed')
                ->body($e->getMessage())
                ->send();
        }
    }

    /**
     * Import all discovered jobs into the database.
     */
    public function importAll(): void
    {
        if (empty($this->discoveredJobs)) {
            return;
        }

        $importedCount = 0;

        foreach ($this->discoveredJobs as $index => $job) {
            if (in_array($index, $this->importedIndices)) {
                continue;
            }

            // Skip invalid ones
            if (empty($job['title']) || empty($job['organization'])) {
                continue;
            }

            try {
                $exists = JobUpdate::where('title', $job['title'])
                    ->orWhere('file_url', $job['file_url'] ?? '')
                    ->exists();

                if (!$exists) {
                    JobUpdate::create([
                        'title' => $job['title'],
                        'organization' => $job['organization'],
                        'type' => in_array($job['type'] ?? 'circular', ['circular', 'result']) ? ($job['type'] ?? 'circular') : 'circular',
                        'published_date' => $job['published_date'] ?? now()->format('Y-m-d'),
                        'file_url' => $job['file_url'] ?? 'https://bpsc.gov.bd',
                        'file_size' => $job['file_size'] ?? '1.5 MB',
                        'vacancies' => $job['vacancies'] ?? null,
                        'qualifications' => $job['qualifications'] ?? null,
                        'application_deadline' => !empty($job['application_deadline']) ? $job['application_deadline'] : null,
                        'description' => $job['description'] ?? null,
                    ]);
                    $this->importedIndices[] = $index;
                    $importedCount++;
                }
            } catch (\Exception $e) {
                // Fail silently for bulk imports
            }
        }

        session()->flash('success', "Bulk Import Complete: Imported {$importedCount} circulars successfully.");

        Notification::make()
            ->success()
            ->title('Bulk Import Complete')
            ->body("Imported {$importedCount} circulars successfully.")
            ->send();
    }
}
