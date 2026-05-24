<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Interviewer;
use App\Models\AvailabilityBlock;
use App\Models\Slot;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VivaBookingTokenTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that creating an availability block automatically generates individual time slots.
     */
    public function test_creating_availability_block_generates_slots_automatically(): void
    {
        $interviewer = Interviewer::create([
            'name' => 'Dr. Mahbubur Rahman',
            'email' => 'mahbub@example.com',
            'designation' => 'PSC Board Member',
            'base_price' => 500,
        ]);

        // Create a 2-hour availability block (4 PM to 6 PM) with 20 minute slices
        $block = AvailabilityBlock::create([
            'interviewer_id' => $interviewer->id,
            'date' => '2026-06-15',
            'start_time' => '16:00:00',
            'end_time' => '18:00:00',
            'slot_duration_minutes' => 20,
        ]);

        // Assert 6 slots are generated
        $this->assertEquals(6, Slot::count());

        $firstSlot = Slot::orderBy('start_time', 'asc')->first();
        $this->assertEquals('16:00:00', $firstSlot->start_time);
        $this->assertEquals('16:20:00', $firstSlot->end_time);

        $lastSlot = Slot::orderBy('start_time', 'desc')->first();
        $this->assertEquals('17:40:00', $lastSlot->start_time);
        $this->assertEquals('18:00:00', $lastSlot->end_time);
    }

    /**
     * Test unauthenticated access is blocked.
     */
    public function test_unauthenticated_request_is_blocked(): void
    {
        $response = $this->postJson('/api/viva/get-token', ['booking_id' => 1]);

        $response->assertStatus(401);
    }

    /**
     * Test returns 404 if booking not found.
     */
    public function test_returns_404_if_booking_not_found(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/viva/get-token', ['booking_id' => 999]);

        $response->assertStatus(404)
            ->assertJson([
                'status' => 'error',
                'message' => 'Viva booking not found.'
            ]);
    }

    /**
     * Test returns 400 if payment is pending or failed.
     */
    public function test_returns_400_if_payment_not_completed(): void
    {
        $user = User::factory()->create();

        $interviewer = Interviewer::create([
            'name' => 'Dr. Mahbubur Rahman',
            'email' => 'mahbub@example.com',
            'base_price' => 500,
        ]);

        $block = AvailabilityBlock::create([
            'interviewer_id' => $interviewer->id,
            'date' => '2026-06-15',
            'start_time' => '16:00:00',
            'end_time' => '18:00:00',
            'slot_duration_minutes' => 20,
        ]);

        $slot = Slot::first();

        $booking = Booking::create([
            'slot_id' => $slot->id,
            'candidate_id' => $user->id,
            'interviewer_id' => $interviewer->id,
            'amount_paid' => 500.00,
            'payment_status' => 'pending', // Pending payment
            'livekit_room_name' => 'viva_room_test_123',
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/viva/get-token', ['booking_id' => $booking->id]);

        $response->assertStatus(400)
            ->assertJson([
                'status' => 'error',
                'message' => 'Payment has not been completed for this viva slot.'
            ]);
    }

    /**
     * Test returns 200 with LiveKit connection token for Candidate user role.
     */
    public function test_returns_200_with_token_for_candidate(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe'
        ]);

        $interviewer = Interviewer::create([
            'name' => 'Dr. Mahbubur Rahman',
            'email' => 'mahbub@example.com',
            'base_price' => 500,
        ]);

        $block = AvailabilityBlock::create([
            'interviewer_id' => $interviewer->id,
            'date' => '2026-06-15',
            'start_time' => '16:00:00',
            'end_time' => '18:00:00',
            'slot_duration_minutes' => 20,
        ]);

        $slot = Slot::first();

        $booking = Booking::create([
            'slot_id' => $slot->id,
            'candidate_id' => $user->id,
            'interviewer_id' => $interviewer->id,
            'amount_paid' => 500.00,
            'payment_status' => 'success', // Successful booking!
            'livekit_room_name' => 'viva_room_test_candidate',
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/viva/get-token', ['booking_id' => $booking->id]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'booking_id',
                    'room_name',
                    'livekit_url',
                    'token',
                    'role',
                    'interviewer' => [
                        'name',
                        'designation',
                    ],
                    'candidate' => [
                        'name',
                    ],
                    'start_time',
                    'end_time',
                ]
            ]);

        $data = $response->json('data');
        $this->assertEquals('candidate', $data['role']);
        $this->assertEquals('viva_room_test_candidate', $data['room_name']);
        $this->assertNotEmpty($data['token']);
    }

    /**
     * Test returns 200 with LiveKit connection token for Examiner user role.
     */
    public function test_returns_200_with_token_for_examiner(): void
    {
        // Interviewer logs in using User model with same email
        $examinerUser = User::factory()->create([
            'email' => 'mahbub@example.com',
            'name' => 'Mahbub Rahman'
        ]);

        $candidateUser = User::factory()->create([
            'name' => 'John Doe'
        ]);

        $interviewer = Interviewer::create([
            'name' => 'Dr. Mahbubur Rahman',
            'email' => 'mahbub@example.com',
            'base_price' => 500,
        ]);

        $block = AvailabilityBlock::create([
            'interviewer_id' => $interviewer->id,
            'date' => '2026-06-15',
            'start_time' => '16:00:00',
            'end_time' => '18:00:00',
            'slot_duration_minutes' => 20,
        ]);

        $slot = Slot::first();

        $booking = Booking::create([
            'slot_id' => $slot->id,
            'candidate_id' => $candidateUser->id,
            'interviewer_id' => $interviewer->id,
            'amount_paid' => 500.00,
            'payment_status' => 'success',
            'livekit_room_name' => 'viva_room_test_examiner',
        ]);

        $response = $this->actingAs($examinerUser, 'sanctum')
            ->postJson('/api/viva/get-token', ['booking_id' => $booking->id]);

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertEquals('examiner', $data['role']);
        $this->assertEquals('viva_room_test_examiner', $data['room_name']);
        $this->assertNotEmpty($data['token']);
    }
}
