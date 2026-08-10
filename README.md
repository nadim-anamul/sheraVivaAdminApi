# Shera Viva - Mock Viva & AI Portal API

Shera Viva is a state-of-the-art mock interview and job preparation backend. It leverages secure WebRTC video conferencing, automated job crawler systems, and dynamic AI-simulated speech evaluations to help candidates in Bangladesh ace civil service (BPSC), central banking (Bangladesh Bank), and primary teaching oral examinations.

---

## 🌟 Core Features

- **Live WebRTC Video Meetings (LiveKit)**: Custom integrated WebRTC meeting rooms utilizing the LiveKit Server & Web client SDK. Eliminates third-party dependencies (like Jitsi) to ensure secure, low-latency, and authenticated connections.
- **Google Meet-style Meeting Codes**: Automatic generation of unique random codes (e.g., `vva-abcd-xyz`) for booked time slots. Examiners and candidates can join directly from their respective dashboards or by typing the code.
- **Filament Admin & Examiner Dashboards**: Dedicated admin dashboard for system managers and a custom "My Booked Vivas" portal for examiners to evaluate candidates post-interview.
- **Automated Government Job Crawlers**: Rip-scrapers that crawl BPSC exams notices and Bangladesh Bank career portals in real-time, fetching new circular notices and result PDFs.
- **AI-Powered Government Job Finder**: A custom Filament Page tool using Google Search Grounding to find live Bangladeshi government job circulars, complete with inline edits, manual PDF uploads, automatic PDF localizers/downloaders, and duplicate-entry protections.
- **AI Speech Analytics Engine**: Fully integrated simulation engine evaluating speaking confidence, vocabulary quality, filler word usage (e.g. "basically", "um"), and providing custom recommendations.

---

## 📁 Project Structure

```
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       └── CrawlJobsCommand.php         # BPSC & Bangladesh Bank Job Notice scrapers
│   ├── Filament/
│   │   ├── Resources/                       # Main Admin Filament Resources (Users, Jobs, Bookings)
│   │   └── Examiner/                        # Custom Examiner Dashboard Panel
│   │       ├── Resources/                   # Bookings list and Evaluation form
│   │       └── Widgets/                     # "My Scheduled Mock Vivas" dashboard table
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php           # API Token Authentication (Mobile login/register)
│   │   │   ├── VivaApiController.php        # Mobile endpoints (stats, slots, history)
│   │   │   ├── JobUpdateApiController.php   # Job notice lists API
│   │   │   └── MeetingController.php        # Web Meeting Portal controller (join, generate JWT)
│   │   └── Middleware/
│   │       └── EnsureUserIsExaminer.php     # Safeguards examiner dashboard access
│   └── Models/
│       ├── Interviewer.php                  # Examiner profile model
│       ├── AvailabilityBlock.php            # Grouped availability (e.g. 4 PM - 6 PM)
│       ├── Slot.php                         # Sliced time slot (e.g. 20-min individual blocks)
│       └── Booking.php                      # Paid candidate booking & meeting info
├── database/
│   ├── migrations/                          # Database schemas
│   └── seeders/
│       └── DatabaseSeeder.php               # High-profile seed data for testing
├── resources/
│   └── views/
│       ├── candidate/
│       │   └── dashboard.blade.php          # Candidate portal with countdowns & join buttons
│       ├── layouts/
│       │   └── app.blade.php                # Global dark-theme layout
│       ├── viva/
│       │   ├── join.blade.php               # Meeting code entry screen
│       │   └── meeting.blade.php            # Standalone LiveKit WebRTC client interface
│       └── welcome.blade.php                # Premium landing page & interactive AI simulator
├── routes/
│   ├── api.php                              # Mobile app endpoints
│   └── web.php                              # Web application routes
└── config/                                  # Configurations (app, database, services)
```

---

## ⚙️ Core System Algorithms

### 1. Automatic Time Slot Slicing
When an interviewer declares an availability block (e.g., from `16:00` to `18:00` with `slot_duration_minutes` set to `20`), the `AvailabilityBlock` model triggers a lifecycle event to slice the block into available individual slots:
$$\text{Number of Slots} = \lfloor \frac{\text{End Time} - \text{Start Time}}{\text{Duration}} \rfloor$$
- **Implementation**: Handled inside `AvailabilityBlock::booted()` via the Eloquent `created` event. It parses the times robustly using `Carbon::parse()` and inserts individual `Slot` records dynamically.

### 2. Google Meet-style Meeting Code Generation
To avoid exposing database IDs and internal room details, a unique meeting code is generated for each booking.
- **Pattern**: `vva-xxxx-xxx` (e.g. `vva-hunn-4ak`).
- **Implementation**: Generated on the `Booking::creating` lifecycle event:
  ```php
  $booking->meeting_code = 'vva-' . strtolower(Str::random(4)) . '-' . strtolower(Str::random(3));
  ```

### 3. LiveKit Secure JWT Token Generation
To prevent unauthorized users from eavesdropping on active vivas, LiveKit requires video rooms to be authenticated with JSON Web Tokens (JWT) signed by our server's `LIVEKIT_API_SECRET`.
- **Flow**:
  1. Retrieve `booking_id` or `meeting_code` parameter.
  2. Authenticate standard Laravel Session or Sanctum Token request.
  3. Validate if the user is the assigned candidate or the interviewer.
  4. Build Video Grant permissions (Examiner gets elevated `RoomAdmin` grant; Candidate gets standard publish grants).
  5. Generate JWT token using `Agence104\LiveKit\AccessToken` and return.

### 4. Double-Booking Prevention
We enforce atomic locking of time slots to prevent race conditions during booking.
- **Flow**:
  ```
   Candidate Selects Slot
             │
             ▼
   Begin Database Transaction
             │
             ▼
   Check if Slot `status == 'available'`
             │
   ┌─────────┴─────────┐
   ▼                   ▼
[Yes]                 [No]
   │                   │
   ▼                   ▼
Update Status       Aborts with
to 'booked'        HTTP 422 Error
   │
   ▼
Create Booking
   │
   ▼
Commit Transaction
  ```

---

## 🚀 Getting Started

### Prerequisites
- PHP >= 8.2 with PDO, OpenSSL, and standard extensions.
- MySQL or SQLite database.
- Node.js & NPM (for frontend asset building).
- LiveKit Server running locally or in staging (default: `http://localhost:7880`).

### 📖 API Reference
For mobile clients or frontend integrations, see the complete [API Documentation Guidelines](file:///home/nadim/braincraft/sheraVivaAdminApi/API_DOCUMENTATION.md).

### Installation
1. Clone the project repository and copy the environment file:
   ```bash
   cp .env.example .env
   ```
2. Open `.env` and fill in your database credentials and LiveKit keys:
   ```env
   DB_CONNECTION=mysql
   DB_DATABASE=shera_viva
   DB_PASSWORD=yourpassword

   LIVEKIT_URL=http://localhost:7880
   LIVEKIT_API_KEY=devkey
   LIVEKIT_API_SECRET=secret_key_must_be_at_least_32_chars_long
   ```
3. Install dependencies:
   ```bash
   composer install
   npm install
   ```
4. Rebuild the database schemas and seed high-profile development data:
   ```bash
   php artisan migrate:fresh --seed
   ```
5. Run the dev servers:
   ```bash
   npm run dev
   ```

---

## 👥 Authentication & Roles

| Role | Email | Password | Access Location |
| :--- | :--- | :--- | :--- |
| **System Admin** | `admin@seraviva.com` | `password` | `/admin` |
| **Examiner** | `mahbub@seraviva.com` | `password` | `/examiner` |
| **Candidate** | `candidate@seraviva.com` | `password` | `/login` -> `/dashboard` |

---

## 🛠️ How to Extend

### 1. Adding a New Viva Category
Simply add a new array configuration in the `DatabaseSeeder.php` categories seeder block:
```php
[
    'slug' => 'judicial',
    'title' => 'Bangladesh Judicial Service Board',
    'subtitle' => 'Assistant Judge (BJS Exams)',
    'icon_name' => 'balance_rounded',
    'color_hex' => '#4F46E5',
    'is_active' => true,
]
```
Run `php artisan db:seed` to register.

### 2. Building a Custom Scraper Engine
To add another recruitment agency (e.g. Ntrca, Civil Aviation) to the crawler command:
1. Open `app/Console/Commands/CrawlJobsCommand.php`.
2. Add a new crawler method (e.g. `crawlNtrca()`).
3. Query the target page using `Http::get()`, parse HTML notice tables using `Symfony\Component\DomCrawler\Crawler`, and run duplication checks against `JobUpdate`.
4. Register the crawl method in the `handle()` method.

---

## ☁️ Deployment
For detailed instructions on deploying the APIs and Admin Panel to Hostinger Shared Hosting via Git, check out the [Hostinger Deployment Guide](file:///home/nadim/braincraft/sheraVivaAdminApi/HOSTINGER_DEPLOYMENT.md).
