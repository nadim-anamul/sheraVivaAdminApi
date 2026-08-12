<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VivaAdvice;
use App\Models\VivaRule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VivaAdviceRuleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Setup API Key mock header protection bypass
        config(['services.shera_viva.api_key' => 'sv_secure_test_key']);
    }

    /**
     * Test getAdvice endpoint filters correctly.
     */
    public function test_advice_endpoint_returns_filtered_results(): void
    {
        // Seed database
        VivaAdvice::create([
            'title' => 'General Tip',
            'category' => 'general',
            'tips' => ['Eat breakfast'],
            'is_active' => true,
        ]);

        VivaAdvice::create([
            'title' => 'BCS Specific Tip',
            'category' => 'bcs',
            'tips' => ['Study Cadre choice details'],
            'is_active' => true,
        ]);

        VivaAdvice::create([
            'title' => 'Bank Specific Tip',
            'category' => 'bank',
            'tips' => ['Study Monetary Policy'],
            'is_active' => true,
        ]);

        // Request all
        $response = $this->withHeaders(['X-Api-Key' => 'sv_secure_test_key'])
            ->getJson('/api/viva/advice');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json('data'));

        // Request BCS filtered (should return general AND bcs)
        $responseFiltered = $this->withHeaders(['X-Api-Key' => 'sv_secure_test_key'])
            ->getJson('/api/viva/advice?category=bcs');

        $responseFiltered->assertStatus(200);
        $data = $responseFiltered->json('data');
        $this->assertCount(2, $data);

        $titles = collect($data)->pluck('title')->all();
        $this->assertContains('General Tip', $titles);
        $this->assertContains('BCS Specific Tip', $titles);
        $this->assertNotContains('Bank Specific Tip', $titles);
    }

    /**
     * Test getRules endpoint filters correctly.
     */
    public function test_rules_endpoint_returns_filtered_results(): void
    {
        // Seed rules
        VivaRule::create([
            'title' => 'Do Rule General',
            'category' => 'do',
            'rules' => ['Smile'],
            'is_active' => true,
        ]);

        VivaRule::create([
            'title' => 'BCS Rule',
            'category' => 'bcs_do',
            'rules' => ['Polite entrance'],
            'is_active' => true,
        ]);

        VivaRule::create([
            'title' => 'Bank Rule',
            'category' => 'bank_do',
            'rules' => ['Suit up'],
            'is_active' => true,
        ]);

        // Request all
        $response = $this->withHeaders(['X-Api-Key' => 'sv_secure_test_key'])
            ->getJson('/api/viva/rules');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json('data'));

        // Request BCS filtered (should return bcs_do, do, general, but not bank_do)
        $responseFiltered = $this->withHeaders(['X-Api-Key' => 'sv_secure_test_key'])
            ->getJson('/api/viva/rules?category=bcs');

        $responseFiltered->assertStatus(200);
        $data = $responseFiltered->json('data');
        $this->assertCount(2, $data);

        $titles = collect($data)->pluck('title')->all();
        $this->assertContains('Do Rule General', $titles);
        $this->assertContains('BCS Rule', $titles);
        $this->assertNotContains('Bank Rule', $titles);
    }

    /**
     * Test guidelines page is accessible to authenticated candidates.
     */
    public function test_guidelines_page_is_accessible_to_authenticated_candidates(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@seraviva.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        $response = $this->get('/guidelines');
        $response->assertStatus(200);
    }
}
