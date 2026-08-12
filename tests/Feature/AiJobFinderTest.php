<?php

namespace Tests\Feature;

use App\Filament\Pages\AiJobFinderPage;
use App\Models\User;
use App\Services\GeminiAiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class AiJobFinderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Http::fake([
            '*' => Http::response('Fake PDF content', 200),
        ]);
    }

    /**
     * Test searchGovtJobs method on GeminiAiService fallback.
     */
    public function test_gemini_service_returns_fallback_jobs_when_api_key_is_empty(): void
    {
        $service = new GeminiAiService;
        $results = $service->searchGovtJobs('BPSC');

        $this->assertIsArray($results);
        $this->assertGreaterThan(0, count($results));
        $this->assertEquals('BPSC', $results[0]['organization']);
    }

    /**
     * Test page is accessible to authenticated administrators.
     */
    public function test_page_is_accessible_to_admins(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@seraviva.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($admin);

        $response = $this->get(AiJobFinderPage::getUrl());
        $response->assertStatus(200);
    }

    /**
     * Test Livewire search functionality and dynamic database import action.
     */
    public function test_livewire_can_search_and_import_job(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@seraviva.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($admin);

        $mockJobs = [
            [
                'title' => 'Test Circular 2026',
                'organization' => 'BPSC Test',
                'type' => 'circular',
                'published_date' => '2026-08-10',
                'file_url' => 'https://bpsc.gov.bd/test.pdf',
                'file_size' => '1.2 MB',
                'vacancies' => '৫০ টি পদ',
                'qualifications' => 'স্নাতক',
                'application_deadline' => '2026-08-30',
                'description' => 'টেস্ট বিজ্ঞপ্তি বিবরণী',
            ],
        ];

        // Instantiate livewire component
        $component = Livewire::test(AiJobFinderPage::class);

        // Populate mock job results
        $component->set('discoveredJobs', $mockJobs);

        // Import the job update at index 0
        $component->call('importJob', 0);

        // Verify it exists in database
        $this->assertDatabaseHas('job_updates', [
            'title' => 'Test Circular 2026',
            'organization' => 'BPSC Test',
            'type' => 'circular',
            'vacancies' => '৫০ টি পদ',
            'qualifications' => 'স্নাতক',
            'application_deadline' => '2026-08-30',
            'description' => 'টেস্ট বিজ্ঞপ্তি বিবরণী',
        ]);

        // Verify it was marked as imported in state
        $component->assertSet('importedIndices', [0]);
    }
}
