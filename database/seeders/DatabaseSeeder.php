<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\VivaCategory;
use App\Models\JobUpdate;
use App\Models\Interviewer;
use App\Models\AvailabilityBlock;
use App\Models\Slot;
use App\Models\Booking;
use App\Models\MockSession;
use App\Models\SessionEvaluation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed System Admin User for Filament Dashboard login
        $admin = User::create([
            'name' => 'Admin Manager',
            'email' => 'admin@seraviva.com',
            'password' => Hash::make('password'),
        ]);

        // 2. Seed a Default Candidate User for Mobile App testing
        $candidate = User::create([
            'name' => 'Nadim Chowdhury',
            'email' => 'candidate@seraviva.com',
            'password' => Hash::make('password'),
        ]);

        // 3. Seed Viva Category configurations
        $categories = [
            [
                'slug' => 'administration',
                'title' => 'BCS Administration Board',
                'subtitle' => 'Assistant Commissioner & Executive Magistrate',
                'icon_name' => 'gavel_rounded',
                'color_hex' => '#0F766E', // Deep Teal
                'is_active' => true,
            ],
            [
                'slug' => 'police',
                'title' => 'BCS Police Board',
                'subtitle' => 'Assistant Superintendent of Police (ASP)',
                'icon_name' => 'local_police_rounded',
                'color_hex' => '#1E3A8A', // Royal Blue
                'is_active' => true,
            ],
            [
                'slug' => 'foreign_affairs',
                'title' => 'BCS Foreign Affairs Board',
                'subtitle' => 'Foreign Affairs Cadre (Assistant Secretary)',
                'icon_name' => 'public_rounded',
                'color_hex' => '#0369A1', // Sky Blue
                'is_active' => true,
            ],
            [
                'slug' => 'bank_ad',
                'title' => 'Bangladesh Bank AD Board',
                'subtitle' => 'Assistant Director (Central Banking)',
                'icon_name' => 'account_balance_rounded',
                'color_hex' => '#D97706', // Warm Orange
                'is_active' => true,
            ],
            [
                'slug' => 'primary_teacher',
                'title' => 'Primary Teacher Board',
                'subtitle' => 'Primary Assistant School Teacher',
                'icon_name' => 'school_rounded',
                'color_hex' => '#BE123C', // Deep Rose
                'is_active' => true,
            ],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[$cat['slug']] = VivaCategory::create($cat);
        }

        // 4. Seed Job Updates (Circulars & Results)
        $jobUpdates = [
            // Circulars
            [
                'type' => 'circular',
                'title' => '47th BCS Preliminary Examination Circular 2026',
                'organization' => 'BPSC',
                'file_url' => 'https://bpsc.gov.bd/sites/default/files/47bcs_prelim.pdf',
                'file_size' => '2.4 MB',
                'published_date' => '2026-05-10',
            ],
            [
                'type' => 'circular',
                'title' => 'Bangladesh Bank Assistant Director Recruitment 2026',
                'organization' => 'Bangladesh Bank',
                'file_url' => 'https://erecruitment.bb.org.bd/career/bb_ad_2026.pdf',
                'file_size' => '1.8 MB',
                'published_date' => '2026-05-18',
            ],
            [
                'type' => 'circular',
                'title' => 'Primary Assistant School Teacher Recruitment Circular (3rd Phase)',
                'organization' => 'DPE',
                'file_url' => 'https://dpe.gov.bd/sites/default/files/primary_phase3.pdf',
                'file_size' => '1.2 MB',
                'published_date' => '2026-05-22',
            ],
            // Results
            [
                'type' => 'result',
                'title' => '46th BCS Written Examination Result Published',
                'organization' => 'BPSC',
                'file_url' => 'https://bpsc.gov.bd/sites/default/files/46bcs_written_res.pdf',
                'file_size' => '3.5 MB',
                'published_date' => '2026-05-05',
            ],
            [
                'type' => 'result',
                'title' => 'Bangladesh Bank Officer (General) Final Recommendation List',
                'organization' => 'Bangladesh Bank',
                'file_url' => 'https://erecruitment.bb.org.bd/career/bb_officer_final_rec.pdf',
                'file_size' => '2.1 MB',
                'published_date' => '2026-05-12',
            ],
            [
                'type' => 'result',
                'title' => 'Primary Teacher Recruitment 2025 (2nd Phase) Final Selection Result',
                'organization' => 'DPE',
                'file_url' => 'https://dpe.gov.bd/sites/default/files/primary_phase2_final.pdf',
                'file_size' => '1.5 MB',
                'published_date' => '2026-05-20',
            ],
        ];

        foreach ($jobUpdates as $job) {
            JobUpdate::create($job);
        }

        // 5. Seed Interviewers
        $interviewers = [
            [
                'name' => 'Dr. Mahbubur Rahman',
                'email' => 'mahbub@seraviva.com',
                'phone' => '+8801711223344',
                'designation' => 'Former Member, BPSC & Joint Secretary',
                'bio' => 'Over 15 years of experience presiding over BCS viva boards. Expert in administrative law, government machinery, and BCS cadre choices.',
                'base_price' => 500,
                'avatar_url' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=256&h=256&q=80',
                'is_active' => true,
            ],
            [
                'name' => 'Ms. Fatema Yasmin',
                'email' => 'fatema@seraviva.com',
                'phone' => '+8801811223344',
                'designation' => 'Former General Manager, Bangladesh Bank',
                'bio' => 'Expert in central banking operations, monetary policy, and bank recruitment board standards. Assessed over 1,000 banking officers.',
                'base_price' => 600,
                'avatar_url' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=256&h=256&q=80',
                'is_active' => true,
            ],
            [
                'name' => 'Barrister Asif Kamal',
                'email' => 'asif@seraviva.com',
                'phone' => '+8801911223344',
                'designation' => 'Advocate, Supreme Court of Bangladesh',
                'bio' => 'Specializes in constitution, civil and criminal procedures, and judicial exams. Coaches candidates for the Bar Council and BJS oral exams.',
                'base_price' => 700,
                'avatar_url' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=256&h=256&q=80',
                'is_active' => true,
            ],
        ];

        $interviewerModels = [];
        foreach ($interviewers as $int) {
            $interviewerModels[] = Interviewer::create($int);
        }

        // 6. Seed Availability Blocks (This automatically triggers Slot generation in model events!)
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        $blocks = [
            // Dr. Mahbubur Rahman: Today 4 PM to 6 PM (6 slots, 20 mins each)
            [
                'interviewer_id' => $interviewerModels[0]->id,
                'date' => $today->format('Y-m-d'),
                'start_time' => '16:00',
                'end_time' => '18:00',
                'slot_duration_minutes' => 20,
            ],
            // Ms. Fatema Yasmin: Tomorrow 10 AM to 12 PM (4 slots, 30 mins each)
            [
                'interviewer_id' => $interviewerModels[1]->id,
                'date' => $tomorrow->format('Y-m-d'),
                'start_time' => '10:00',
                'end_time' => '12:00',
                'slot_duration_minutes' => 30,
            ],
            // Barrister Asif Kamal: Tomorrow 6 PM to 7:40 PM (5 slots, 20 mins each)
            [
                'interviewer_id' => $interviewerModels[2]->id,
                'date' => $tomorrow->format('Y-m-d'),
                'start_time' => '18:00',
                'end_time' => '19:40',
                'slot_duration_minutes' => 20,
            ],
        ];

        foreach ($blocks as $block) {
            AvailabilityBlock::create($block);
        }

        // 7. Seed candidate Mock Sessions with simulated AI evaluations
        $vivaHistory = [
            [
                'category' => 'administration',
                'date' => $today->copy()->subDays(6),
                'score' => 84,
                'fillers' => 5,
                'transcript' => [
                    ['speaker' => 'Interviewer', 'text' => 'Introduce yourself, and tell us why you chose administration as your first choice.'],
                    ['speaker' => 'Candidate', 'text' => 'Thank you, sir. I am Nadim. I studied public administration. I believe administration allows direct contact with citizens to deliver public welfare.'],
                    ['speaker' => 'Interviewer', 'text' => 'What is the role of an Executive Magistrate in conducting mobile courts?'],
                    ['speaker' => 'Candidate', 'text' => 'Basically, under the Mobile Court Act 2009, executive magistrates can take cognizance of offenses committed in their presence and issue judicial sentences on the spot within the limits of law.'],
                ],
                'feedback' => 'Highly promising BCS Admin attempt. Your speech delivery was clear, and you showed excellent mastery of the Mobile Court Act 2009. Continue to focus on crisp CADRE choice arguments.',
                'recs' => "1. Decrease filler word 'basically' when transitioning between points.\n2. Work on introducing direct articles of the Constitution of Bangladesh relating to public administration."
            ],
            [
                'category' => 'bank_ad',
                'date' => $today->copy()->subDays(3),
                'score' => 90,
                'fillers' => 2,
                'transcript' => [
                    ['speaker' => 'Interviewer', 'text' => 'What is your understanding of the primary objectives of monetary policy?'],
                    ['speaker' => 'Candidate', 'text' => 'Monetary policy maintains price stability, controls inflation, and channels credit flow towards productive sectors to sustain GDP growth.'],
                    ['speaker' => 'Interviewer', 'text' => 'How does a rise in central bank repo rate impact market inflation?'],
                    ['speaker' => 'Candidate', 'text' => 'A rise in repo rate makes borrowing more expensive for commercial banks. This increases interest rates for retail customers, reducing consumer demand and curtailing inflation.'],
                ],
                'feedback' => 'Spectacular AD Board simulation! You maintained excellent control over banking concepts and showed perfect articulation. Minimal filler words used.',
                'recs' => "1. Keep practicing macroeconomic indicator updates (GDP, current inflation rates).\n2. Expand on foreign reserve management strategies when asked about balance of payments."
            ],
        ];

        foreach ($vivaHistory as $history) {
            $session = MockSession::create([
                'user_id' => $candidate->id,
                'viva_category_id' => $categoryModels[$history['category']]->id,
                'transcript' => $history['transcript'],
                'viva_date' => $history['date'],
            ]);

            SessionEvaluation::create([
                'mock_session_id' => $session->id,
                'score' => $history['score'],
                'filler_words_count' => $history['fillers'],
                'feedback' => $history['feedback'],
                'recommendations' => $history['recs'],
            ]);
        }

        // 8. Seed a Paid Active Booking (e.g. Booking Dr. Mahbubur Rahman's first slot today)
        $firstSlot = Slot::where('interviewer_id', $interviewerModels[0]->id)->first();
        if ($firstSlot) {
            $firstSlot->update(['status' => 'booked']);

            Booking::create([
                'slot_id' => $firstSlot->id,
                'candidate_id' => $candidate->id,
                'interviewer_id' => $interviewerModels[0]->id,
                'amount_paid' => $interviewerModels[0]->base_price,
                'payment_status' => 'success',
                'payment_trx_id' => 'TRX_SEED_BKASH_99',
                'livekit_room_name' => 'viva_room_' . uniqid(),
                'grade_score' => null, // Upcoming session, not graded yet!
                'feedback_remarks' => null,
            ]);
        }
    }
}
