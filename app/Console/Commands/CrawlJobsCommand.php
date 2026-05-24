<?php

namespace App\Console\Commands;

use App\Models\JobUpdate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;
use Carbon\Carbon;
use Exception;

class CrawlJobsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:crawl-jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawls BPSC and Bangladesh Bank recruitment pages for new circulars and results';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting job search crawlers...');

        // 1. Scrape BPSC
        try {
            $this->crawlBpsc();
        } catch (Exception $e) {
            $this->error('BPSC Scraper error: ' . $e->getMessage());
            Log::error('BPSC Scraper failed: ' . $e->getMessage());
        }

        // 2. Scrape Bangladesh Bank
        try {
            $this->crawlBangladeshBank();
        } catch (Exception $e) {
            $this->error('Bangladesh Bank Scraper error: ' . $e->getMessage());
            Log::error('Bangladesh Bank Scraper failed: ' . $e->getMessage());
        }

        $this->info('Job search crawlers execution completed.');
    }

    /**
     * Crawls BPSC Exams Page
     */
    private function crawlBpsc()
    {
        $this->info('Crawling BPSC exams portal...');
        $url = 'https://bpsc.gov.bd/pages/psc-exams?page=1&page_size=10';

        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
        ])->get($url);

        if (!$response->successful()) {
            $this->error('Failed to fetch BPSC page. Status: ' . $response->status());
            return;
        }

        $html = $response->body();
        $crawler = new Crawler($html);

        // Target the rows inside noticeTable tbody
        $rows = $crawler->filter('table#noticeTable tbody tr');

        if ($rows->count() === 0) {
            $this->warn('No notice rows found on BPSC page. Table layout may have changed.');
            return;
        }

        $newCount = 0;

        $rows->each(function (Crawler $row) use (&$newCount) {
            // Check if it's the filter row (which contains inputs and has toggle-hidden class)
            if (str_contains($row->attr('class') ?? '', 'toggle-hidden')) {
                return;
            }

            try {
                $titleCell = $row->filter('td[data-column="title"]');
                $pdfCell = $row->filter('td[data-column="pdf"] a');
                $typeCell = $row->filter('td[data-column="exam_type"]');
                $dateCell = $row->filter('td[data-column="publish_date"]');

                if ($titleCell->count() === 0 || $pdfCell->count() === 0) {
                    return;
                }

                $title = trim($titleCell->text());
                $fileUrl = trim($pdfCell->attr('href'));
                
                // Parse date
                $rawDate = $dateCell->count() > 0 ? trim($dateCell->text()) : '';
                $publishedDate = $this->parseDate($rawDate);

                // Determine circular vs result type
                $type = 'circular';
                $resultKeywords = ['ফলাফল', 'মনোনয়ন', 'সুপারিশ', 'মনোনীত', 'মনোনয়নসাময়িক', 'ফলাফলসংক্রান্ত', 'Result', 'Waitlist', 'Waiting', 'মেধা'];
                foreach ($resultKeywords as $keyword) {
                    if (str_contains($title, $keyword)) {
                        $type = 'result';
                        break;
                    }
                }

                // Check for duplicates
                $exists = JobUpdate::where('title', $title)
                    ->orWhere('file_url', $fileUrl)
                    ->exists();

                if (!$exists) {
                    JobUpdate::create([
                        'type' => $type,
                        'title' => $title,
                        'organization' => 'BPSC',
                        'file_url' => $fileUrl,
                        'file_size' => '1.5 MB', // Standard placeholder
                        'published_date' => $publishedDate,
                    ]);
                    $newCount++;
                    $this->info("Imported BPSC item: $title");
                }
            } catch (Exception $ex) {
                $this->error('Error parsing row: ' . $ex->getMessage());
            }
        });

        $this->info("BPSC scraping finished. Imported $newCount new records.");
    }

    /**
     * Crawls Bangladesh Bank E-recruitment Job Opportunities Page
     */
    private function crawlBangladeshBank()
    {
        $this->info('Crawling Bangladesh Bank e-recruitment portal...');
        $url = 'https://erecruitment.bb.org.bd/career/jobopportunity.php';

        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
        ])->get($url);

        if (!$response->successful()) {
            $this->error('Failed to connect to Bangladesh Bank portal. Status: ' . $response->status());
            return;
        }

        $html = $response->body();

        // Check if blocked by CAPTCHA / WAF shield
        if (str_contains($html, 'What code is in the image?') || str_contains($html, 'id="ans"') || str_contains($html, 'bottle')) {
            $this->warn('Bangladesh Bank e-recruitment portal has requested CAPTCHA solving. Crawling paused.');
            $this->line('Safe Fallback: Filament Admin panel supports full manual entries. Automated system skipped successfully.');
            Log::warning('Bangladesh Bank Scraper blocked by CAPTCHA request. Skipping automated crawl for this run.');
            return;
        }

        $crawler = new Crawler($html);
        
        // Target all table rows
        $rows = $crawler->filter('table tr');

        if ($rows->count() === 0) {
            $this->warn('No table rows found on Bangladesh Bank e-recruitment page.');
            return;
        }

        $newCount = 0;

        $rows->each(function (Crawler $row) use (&$newCount) {
            // Find links ending with or containing .pdf
            $pdfLink = $row->filter('a[href*=".pdf"]');
            if ($pdfLink->count() === 0) {
                return;
            }

            $cells = $row->filter('td');
            // Table should have at least 5 columns
            if ($cells->count() < 5) {
                return;
            }

            try {
                $title = trim($cells->eq(1)->text()); // Column 2: Post Name
                $bankName = trim($cells->eq(2)->text()); // Column 3: Name of Bank
                $fileUrl = trim($pdfLink->attr('href'));

                // Resolve relative links to absolute URLs
                if (!str_starts_with($fileUrl, 'http')) {
                    $fileUrl = 'https://erecruitment.bb.org.bd' . (str_starts_with($fileUrl, '/') ? '' : '/') . $fileUrl;
                }

                // Parse Date from Column 5 (index 4)
                $rawDate = trim($cells->eq(4)->text());
                $publishedDate = $this->parseDate($rawDate);

                // Duplicate check
                $exists = JobUpdate::where('title', $title)
                    ->orWhere('file_url', $fileUrl)
                    ->exists();

                if (!$exists) {
                    JobUpdate::create([
                        'type' => 'circular',
                        'title' => $title,
                        'organization' => $bankName ?: 'Bangladesh Bank',
                        'file_url' => $fileUrl,
                        'file_size' => '1.8 MB', // Standard placeholder
                        'published_date' => $publishedDate,
                    ]);
                    $newCount++;
                    $this->info("Imported Bangladesh Bank circular: $title");
                }
            } catch (Exception $ex) {
                $this->error('Error parsing Bangladesh Bank row: ' . $ex->getMessage());
            }
        });

        $this->info("Bangladesh Bank scraping finished. Imported $newCount new records.");
    }

    /**
     * Translates Bengali digits to English digits
     */
    private function translateBengaliDigits(string $bengaliString): string
    {
        $bengaliDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return str_replace($bengaliDigits, $englishDigits, $bengaliString);
    }

    /**
     * Parses the publication date string cleanly
     */
    private function parseDate(string $dateStr): string
    {
        $translated = $this->translateBengaliDigits($dateStr);
        $translated = trim(preg_replace('/\s+/', '', $translated));

        try {
            // Format XXIII-XX-XXXX is parsed into Carbon standard
            return Carbon::createFromFormat('d-m-Y', $translated)->format('Y-m-d');
        } catch (Exception $e) {
            try {
                return Carbon::parse($translated)->format('Y-m-d');
            } catch (Exception $ex) {
                return now()->format('Y-m-d');
            }
        }
    }
}
