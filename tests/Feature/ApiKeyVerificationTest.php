<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VivaCategory;
use App\Services\GeminiAiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApiKeyVerificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that accessing endpoints without API Key returns 401.
     */
    public function test_api_endpoints_reject_requests_without_key(): void
    {
        // Remove the default X-Api-Key header set in parent TestCase setup
        $this->flushHeaders();

        $response = $this->getJson('/api/viva/categories');

        $response->assertStatus(401)
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized: Invalid or missing API Key.',
            ]);
    }

    /**
     * Test that accessing endpoints with incorrect API Key returns 401.
     */
    public function test_api_endpoints_reject_requests_with_invalid_key(): void
    {
        $this->flushHeaders();

        $response = $this->withHeader('X-Api-Key', 'wrong_key_123')
            ->getJson('/api/viva/categories');

        $response->assertStatus(401)
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized: Invalid or missing API Key.',
            ]);
    }

    /**
     * Test that accessing endpoints with correct API Key returns 200.
     */
    public function test_api_endpoints_allow_requests_with_valid_key(): void
    {
        $this->flushHeaders();

        // Seed Category to avoid 200 response being empty and assure it runs correctly
        VivaCategory::create([
            'title' => 'BCS Admin',
            'slug' => 'bcs-admin',
            'subtitle' => 'BCS Administration',
            'icon_name' => 'briefcase',
            'color_hex' => '#000000',
            'description' => 'BCS Administration Cadre',
        ]);

        $response = $this->withHeader('X-Api-Key', config('services.shera_viva.api_key'))
            ->getJson('/api/viva/categories');

        $response->assertStatus(200);
    }

    /**
     * Test that an admin user is dynamically created or updated on login attempts matching env config.
     */
    public function test_admin_user_credentials_sync_on_login_attempt(): void
    {
        $adminEmail = 'dynamic-env-admin@seraviva.com';
        $adminPassword = 'new-secure-password';

        // Configure mock dynamic services config
        config(['services.admin.email' => $adminEmail]);
        config(['services.admin.password' => $adminPassword]);

        // Assure no user exists with this email in the database currently
        $this->assertDatabaseMissing('users', ['email' => $adminEmail]);

        // Attempt login via Laravel Auth
        $authAttempt = Auth::attempt([
            'email' => $adminEmail,
            'password' => $adminPassword,
        ]);

        // Assert attempt succeeds because the Attempting event listener created the user dynamically
        $this->assertTrue($authAttempt);
        $this->assertDatabaseHas('users', ['email' => $adminEmail]);

        // Verify the password in database is correctly hashed
        $user = User::where('email', $adminEmail)->first();
        $this->assertTrue(Hash::check($adminPassword, $user->password));
    }

    /**
     * Test that docx text extraction parses XML correctly.
     */
    public function test_docx_text_extraction_parses_xml_correctly(): void
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'test_docx_').'.docx';

        $zip = new \ZipArchive;
        if ($zip->open($tempFile, \ZipArchive::CREATE) === true) {
            $xmlContent = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'.
                '<w:document xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">'.
                '<w:body>'.
                '<w:p><w:r><w:t>বিসিএস ভাইভা অভিজ্ঞতা ১</w:t></w:r></w:p>'.
                '<w:p><w:r><w:t>প্রশ্ন: আপনার নাম কি?</w:t></w:r></w:p>'.
                '<w:p><w:r><w:t>উত্তর: আরিফুল ইসলাম স্যার।</w:t></w:r></w:p>'.
                '</w:body>'.
                '</w:document>';
            $zip->addFromString('word/document.xml', $xmlContent);
            $zip->close();
        }

        $service = new GeminiAiService;
        $extractedText = $service->extractTextFromDocx($tempFile);

        @unlink($tempFile);

        $this->assertNotNull($extractedText);
        $this->assertStringContainsString('বিসিএস ভাইভা অভিজ্ঞতা ১', $extractedText);
        $this->assertStringContainsString('প্রশ্ন: আপনার নাম কি?', $extractedText);
        $this->assertStringContainsString('উত্তর: আরিফুল ইসলাম স্যার।', $extractedText);
    }

    /**
     * Test generate AI question endpoint with custom profile parameters.
     */
    public function test_generate_ai_question_endpoint_with_custom_context(): void
    {
        // Mock Gemini response to bypass actual API connection during tests
        $this->mock(GeminiAiService::class, function ($mock) {
            $mock->shouldReceive('generateVivaQuestion')
                ->once()
                ->with('BCS Admin Board', [], 'BCS', 'Administration Cadre', 'Major: Economics')
                ->andReturn([
                    'question_no' => 1,
                    'speaker' => 'Chairman',
                    'question' => 'Welcome. Explain the concept of opportunity cost.',
                    'context_hint' => 'Economics background test',
                    'expected_key_points' => ['Opportunity cost definition'],
                ]);
        });

        $response = $this->withHeader('X-Api-Key', config('services.shera_viva.api_key'))
            ->postJson('/api/viva/ai/generate-question', [
                'category' => 'BCS Admin Board',
                'transcript_history' => [],
                'exam_type' => 'BCS',
                'position' => 'Administration Cadre',
                'candidate_cv' => 'Major: Economics',
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'question' => 'Welcome. Explain the concept of opportunity cost.',
                ],
            ]);
    }
}
