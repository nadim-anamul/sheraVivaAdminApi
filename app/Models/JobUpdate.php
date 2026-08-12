<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class JobUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'organization',
        'file_url',
        'file_size',
        'published_date',
        'vacancies',
        'qualifications',
        'application_deadline',
        'description',
    ];

    protected $casts = [
        'published_date' => 'date',
        'application_deadline' => 'date',
    ];

    /**
     * Set up Eloquent lifecycle hooks to automatically download and localize PDF circulars.
     */
    protected static function booted()
    {
        static::creating(function (JobUpdate $jobUpdate) {
            $jobUpdate->downloadAndLocalizeFile();
        });

        static::updating(function (JobUpdate $jobUpdate) {
            if ($jobUpdate->isDirty('file_url')) {
                $jobUpdate->downloadAndLocalizeFile();
            }
        });
    }

    /**
     * Downloads the remote PDF circular file and saves it in the local public storage.
     */
    public function downloadAndLocalizeFile(): void
    {
        $url = $this->file_url;

        // Skip if empty, already localized, or relative
        if (empty($url) || !str_starts_with($url, 'http') || str_contains($url, '/storage/')) {
            return;
        }

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            ])->timeout(20)->get($url);

            if ($response->successful()) {
                $content = $response->body();
                $size = strlen($content);

                // Verify the downloaded file starts with PDF magic bytes to prevent saving HTML index pages
                if (!str_starts_with($content, '%PDF')) {
                    Log::info('Remote URL is not a direct PDF file. Keeping original link: '.$url);

                    return;
                }

                // Ensure directory path is present in storage
                $dir = storage_path('app/public/circulars');
                if (!file_exists($dir)) {
                    mkdir($dir, 0755, true);
                }

                // Create a clean filename replacing non-alphanumeric/bengali with underscores
                $cleanTitle = preg_replace('/[^a-zA-Z0-9\x{0980}-\x{09FF}]+/u', '_', $this->title);
                $cleanTitle = trim($cleanTitle, '_');
                // Use mb_substr to safely slice multibyte Bengali characters without breaking UTF-8 byte sequences
                $filename = mb_substr($cleanTitle, 0, 80).'_'.time().'.pdf';
                $filePath = $dir.'/'.$filename;

                file_put_contents($filePath, $content);

                // Map database URL to public asset path
                $this->file_url = asset('storage/circulars/'.$filename);

                // Compute real file size
                $sizeInMb = round($size / (1024 * 1024), 2);
                $this->file_size = $sizeInMb > 0.01 ? $sizeInMb.' MB' : '0.1 MB';
            }
        } catch (\Exception $e) {
            Log::warning("Failed to localize PDF circular file from {$url}: ".$e->getMessage());
            // Fall back cleanly to original link
        }
    }
}
