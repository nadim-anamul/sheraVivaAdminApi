<?php

namespace Database\Seeders;

use App\Models\AvailabilityBlock;
use App\Models\Interviewer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AddExpertsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Md. Shadman Akif (BCS Admin Expert)
        $akif = Interviewer::updateOrCreate(
            ['email' => 'shadman.akif@seraviva.com'],
            [
                'name' => 'Md. Shadman Akif',
                'phone' => '+8801886399786',
                'designation' => 'Assistant Commissioner (Land) & Executive Magistrate | 40th BCS (Administration)',
                'bio' => '40th BCS (Administration) Cadre Officer. B.Sc. in Chemical Engineering from BUET, CSCM®. Upazila Land Office, Mohammadpur, Magura. Expert in BCS Administration viva board preparation, cadre choices, and executive administration.',
                'base_price' => 500,
                'avatar_url' => '/images/interviewers/shadman_akif.jpg',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'shadman.akif@seraviva.com'],
            [
                'name' => 'Md. Shadman Akif',
                'password' => bcrypt('password'),
            ]
        );

        AvailabilityBlock::create([
            'interviewer_id' => $akif->id,
            'date' => Carbon::tomorrow()->format('Y-m-d'),
            'start_time' => '15:00',
            'end_time' => '17:00',
            'slot_duration_minutes' => 20,
        ]);

        // 2. Md. Omar (Corporate & Banking Expert)
        $omar = Interviewer::updateOrCreate(
            ['email' => 'md.omar@seraviva.com'],
            [
                'name' => 'Md. Omar',
                'phone' => '+8801711998877',
                'designation' => 'Senior Officer, Eastern Bank Ltd | MBA (IBA, DU)',
                'bio' => 'Senior Officer at Eastern Bank Ltd. MBA from IBA, Dhaka University & B.Sc. in Biochemistry from Dhaka University. Specialist in corporate banking interviews, bank officer recruitment boards, and aptitude coaching.',
                'base_price' => 500,
                'avatar_url' => '/images/interviewers/md_omar.jpg',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'md.omar@seraviva.com'],
            [
                'name' => 'Md. Omar',
                'password' => bcrypt('password'),
            ]
        );

        AvailabilityBlock::create([
            'interviewer_id' => $omar->id,
            'date' => Carbon::tomorrow()->format('Y-m-d'),
            'start_time' => '18:00',
            'end_time' => '20:00',
            'slot_duration_minutes' => 20,
        ]);
    }
}
