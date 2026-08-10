# Shera Viva - Backend API Documentation

> ### 📢 Mandatory Rule for AI Agents
> Whenever you implement, add, or modify any API endpoint in this repository (in `routes/api.php` or controller handlers), you **MUST** update this `API_DOCUMENTATION.md` file immediately to reflect the changes, including parameters, headers, response schemas, and mock payloads.

---

## Global API Rules & Protections

### 1. API Key Authentication (Middleware: `VerifyApiKey`)
All `/api/...` endpoints are secured under the `api.key` middleware. Every incoming request must supply the following request header:
*   **Header Name**: `X-Api-Key`
*   **Header Value**: Matches the `SHERA_VIVA_API_KEY` defined in the environment configuration `.env` file (e.g. `sv_secure_key_123456`).
*   **Failure Behavior**: Returning `401 Unauthorized` with `{"error": "Unauthorized. Invalid API Key."}`.

### 2. User Session Authentication (Sanctum)
Endpoints requiring personal candidate history, video token generations, or interviewer bookings must be authenticated with standard Laravel Sanctum Bearer tokens:
*   **Header Name**: `Authorization`
*   **Header Value**: `Bearer <token>`

---

## 🔑 Authentication Endpoints

### Register Candidate
*   **Route**: `POST /api/auth/register`
*   **Headers**: `X-Api-Key: <key>`
*   **Body (JSON)**:
    ```json
    {
        "name": "Nadim Anamul",
        "email": "nadim@example.com",
        "password": "password123",
        "password_confirmation": "password123"
    }
    ```
*   **Response**: `201 Created`
    ```json
    {
        "status": "success",
        "token": "1|abcdef123456...",
        "user": {
            "id": 1,
            "name": "Nadim Anamul",
            "email": "nadim@example.com"
        }
    }
    ```

### Login Candidate
*   **Route**: `POST /api/auth/login`
*   **Headers**: `X-Api-Key: <key>`
*   **Body (JSON)**:
    ```json
    {
        "email": "nadim@example.com",
        "password": "password123"
    }
    ```
*   **Response**: `200 OK`
    ```json
    {
        "status": "success",
        "token": "2|hijklm789...",
        "user": {
            "id": 1,
            "name": "Nadim Anamul",
            "email": "nadim@example.com"
        }
    }
    ```

### Logout Candidate
*   **Route**: `POST /api/auth/logout`
*   **Headers**: `X-Api-Key: <key>`, `Authorization: Bearer <token>`
*   **Response**: `200 OK`
    ```json
    {
        "status": "success",
        "message": "Logged out successfully"
    }
    ```

---

## 📚 Viva Categories & Question Libraries

### Get Category Tree
*   **Route**: `GET /api/viva/categories`
*   **Headers**: `X-Api-Key: <key>`
*   **Response**: `200 OK`
    ```json
    {
        "status": "success",
        "data": [
            {
                "id": 1,
                "name": "BCS Viva",
                "slug": "bcs-viva",
                "parent_id": null
            }
        ]
    }
    ```

### Get Question Library (Experience Transcripts)
*   **Route**: `GET /api/viva/library`
*   **Headers**: `X-Api-Key: <key>`
*   **Query Parameters**:
    *   `category_id` (Optional filter by category, e.g. `?category_id=2`)
    *   `search` (Optional text search, e.g. `?search=cadre`)
*   **Response**: `200 OK`
    ```json
    {
        "status": "success",
        "data": [
            {
                "id": 1,
                "category_id": 2,
                "candidate_name": "Rahim Uddin",
                "cadre_choice": "BCS Admin",
                "viva_board": "BPSC Board 3",
                "viva_date": "2026-05-10",
                "transcript": [
                    { "speaker": "Board", "text": "আপনার নিজের সম্পর্কে বলুন।" },
                    { "speaker": "Candidate", "text": "আমি ঢাকা বিশ্ববিদ্যালয় থেকে স্নাতকোত্তর সম্পন্ন করেছি..." }
                ]
            }
        ]
    }
    ```

### Get Single Question Bank Detail
*   **Route**: `GET /api/viva/library/{id}`
*   **Headers**: `X-Api-Key: <key>`
*   **Response**: `200 OK`
    ```json
    {
        "status": "success",
        "data": {
            "id": 1,
            "candidate_name": "Rahim Uddin",
            "transcript": [...]
        }
    }
    ```

---

## 💡 Guidelines & Rules

### Get Board Advice Guidelines
*   **Route**: `GET /api/viva/advice`
*   **Headers**: `X-Api-Key: <key>`
*   **Query Parameters (Optional)**:
    *   `category`: Filter by exam category (e.g. `?category=bcs`). If provided, returns matching exam advice AND generic `general` advice.
*   **Response**: `200 OK`
    ```json
    {
        "status": "success",
        "data": [
            {
                "id": 1,
                "category": "general",
                "title": "ভাইভা বোর্ডের পোশাক পরিচ্ছদ",
                "content": "মার্জিত ও পরিষ্কার পোশাক পরা আবশ্যক...",
                "tips": ["পুরুষদের জন্য ফুলহাতা শার্ট ও টাই", "নারীদের জন্য শালীন শাড়ি বা সালোয়ার কামিজ"]
            }
        ]
    }
    ```

### Get Board Rules & Regulations
*   **Route**: `GET /api/viva/rules`
*   **Headers**: `X-Api-Key: <key>`
*   **Query Parameters (Optional)**:
    *   `category`: Filter by exam category (e.g. `?category=bcs`). If provided, returns matching exam rules, exam-specific dos/donts, and generic dos/donts rules (`do`, `dont`, `general`).
*   **Response**: `200 OK`
    ```json
    {
        "status": "success",
        "data": [
            {
                "id": 1,
                "title": "Do Rules",
                "category": "do",
                "content": null,
                "rules": ["বোর্ডের প্রবেশ করার আগে অবশ্যই অনুমতি নিন...", "প্রশ্নের উত্তর মৃদুভাষায় দিন"]
            }
        ]
    }
    ```

---

## 🏢 Examiners & Booking Schedules

### Get Interviewers List
*   **Route**: `GET /api/viva/interviewers`
*   **Headers**: `X-Api-Key: <key>`
*   **Response**: `200 OK`
    ```json
    {
        "status": "success",
        "data": [
            {
                "id": 1,
                "name": "Dr. Tariq Jamil",
                "designation": "Former BPSC Member",
                "expertise": "General Cadre & Administration"
            }
        ]
    }
    ```

### Get Interviewer Availability Slots
*   **Route**: `GET /api/viva/interviewers/{id}/slots`
*   **Headers**: `X-Api-Key: <key>`
*   **Response**: `200 OK`
    ```json
    {
        "status": "success",
        "data": [
            {
                "id": 12,
                "interviewer_id": 1,
                "start_time": "2026-08-15 10:00:00",
                "end_time": "2026-08-15 10:30:00",
                "is_booked": false
            }
        ]
    }
    ```

### Book Mock Interview Slot
*   **Route**: `POST /api/viva/bookings`
*   **Headers**: `X-Api-Key: <key>`, `Authorization: Bearer <token>`
*   **Body (JSON)**:
    ```json
    {
        "slot_id": 12
    }
    ```
*   **Response**: `201 Created`
    ```json
    {
        "status": "success",
        "message": "Booking successful",
        "booking": {
            "id": 5,
            "slot_id": 12,
            "candidate_id": 1,
            "room_name": "room_slot_12_1723275000"
        }
    }
    ```

---

## 📰 Government Job Notices & Results (News)

### Get Job Circulars
*   **Route**: `GET /api/job-updates/circulars`
*   **Headers**: `X-Api-Key: <key>`
*   **Query Parameters**:
    *   `search` (Optional keyword search, e.g. `?search=BPSC`)
*   **Response**: `200 OK`
    ```json
    {
        "status": "success",
        "data": [
            {
                "id": 1,
                "type": "circular",
                "title": "৪৪তম বিসিএস নন-ক্যাডার নিয়োগ বিজ্ঞপ্তি",
                "organization": "BPSC",
                "vacancies": "১০২৬ টি পদ",
                "qualifications": "স্নাতক",
                "file_url": "https://viva.dcofficeutility.com/storage/circulars/44th_bcs_1723275600.pdf",
                "file_size": "1.4 MB",
                "published_date": "2026-08-10",
                "application_deadline": "2026-08-30",
                "description": "৪৪তম বিসিএস পরীক্ষার নন-ক্যাডার শূন্য পদে সরাসরি নিয়োগের জন্য বিজ্ঞপ্তি প্রকাশ।"
            }
        ]
    }
    ```

### Get Exam Results
*   **Route**: `GET /api/job-updates/results`
*   **Headers**: `X-Api-Key: <key>`
*   **Query Parameters**:
    *   `search` (Optional keyword search)
*   **Response**: `200 OK`
    ```json
    {
        "status": "success",
        "data": [
            {
                "id": 2,
                "type": "result",
                "title": "৪৫তম বিসিএস প্রিলিমিনারি পরীক্ষার ফলাফল",
                "organization": "BPSC",
                "vacancies": "N/A",
                "qualifications": "পরীক্ষার্থী",
                "file_url": "https://viva.dcofficeutility.com/storage/circulars/45th_preli_result.pdf",
                "file_size": "2.1 MB",
                "published_date": "2026-08-08",
                "application_deadline": null,
                "description": "৪৫তম বিসিএস পরীক্ষার প্রিলিমিনারি ফলাফলে মোট ১২,৭৮৯ জন উত্তীর্ণ হয়েছেন।"
            }
        ]
    }
    ```

---

## 🤖 Gemini AI Viva Portal (Practice Portal Integration)

### Generate Dynamic AI Question
*   **Route**: `POST /api/viva/ai/generate-question`
*   **Headers**: `X-Api-Key: <key>`
*   **Body (JSON)**:
    ```json
    {
        "category": "bcs_admin",
        "history": [
            { "speaker": "Board", "text": "নিজের জেলা সম্পর্কে বলুন।" },
            { "speaker": "Candidate", "text": "আমার জেলা ঢাকা, এটি বুড়িগঙ্গা নদীর তীরে অবস্থিত..." }
        ]
    }
    ```
*   **Response**: `200 OK`
    ```json
    {
        "question": "আপনার জেলায় বুড়িগঙ্গা ছাড়া আর কোন কোন উল্লেখযোগ্য নদী আছে?"
    }
    ```

### Evaluate Candidate Answer
*   **Route**: `POST /api/viva/ai/evaluate-answer`
*   **Headers**: `X-Api-Key: <key>`
*   **Body (JSON)**:
    ```json
    {
        "question": "আপনার জেলায় বুড়িগঙ্গা ছাড়া আর কোন কোন উল্লেখযোগ্য নদী আছে?",
        "answer": "ধন্যবাদ স্যার। বুড়িগঙ্গা ছাড়াও আমাদের জেলায় ধলেশ্বরী, ইছামতি আর তুরাগ নদী প্রবাহিত হয়েছে।"
    }
    ```
*   **Response**: `200 OK`
    ```json
    {
        "score": 92,
        "feedback": "উত্তরটি অত্যন্ত মার্জিত এবং সঠিক হয়েছে। ব্যাকরণগত কোনো ভুল পাওয়া যায়নি।",
        "filler_words": 0,
        "recommendations": "তুরাগ নদীর বর্তমান দূষণ ও নাব্যতা সমস্যা নিয়ে সামান্য তথ্য সংযুক্ত করলে উত্তরটি আরও সমৃদ্ধ হতো।",
        "model_answer": "ধন্যবাদ স্যার। ঢাকা জেলার চারপাশে বুড়িগঙ্গা ছাড়াও তুরাগ, ধলেশ্বরী, ইছামতি, এবং শীতলক্ষ্যা নদী রয়েছে, যা নদীবেষ্টিত রাজধানী গঠনে গুরুত্বপূর্ণ ভূমিকা পালন করেছে।"
    }
    ```

---

## 📹 LiveKit Meeting Rooms

### Get Token for Video Mock Board Room
*   **Route**: `POST /api/viva/get-token`
*   **Headers**: `X-Api-Key: <key>`, `Authorization: Bearer <token>`
*   **Body (JSON)**:
    ```json
    {
        "room_name": "room_slot_12_1723275000",
        "identity": "Candidate_Nadim"
    }
    ```
*   **Response**: `200 OK`
    ```json
    {
        "status": "success",
        "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJMS19BU..."
    }
    ```

---

## 📈 Dashboard Statistics & Sessions

### Get Candidate Dashboard Stats
*   **Route**: `GET /api/dashboard/stats`
*   **Headers**: `X-Api-Key: <key>`, `Authorization: Bearer <token>`
*   **Response**: `200 OK`
    ```json
    {
        "status": "success",
        "data": {
            "total_practice_sessions": 14,
            "average_ai_score": 84.5,
            "filler_words_trend": "decreasing",
            "upcoming_mock_boards": [
                {
                    "interviewer_name": "Dr. Tariq Jamil",
                    "start_time": "2026-08-15 10:00:00"
                }
            ]
        }
    }
    ```

### Save Mock Practice Session
*   **Route**: `POST /api/viva/sessions`
*   **Headers**: `X-Api-Key: <key>`, `Authorization: Bearer <token>`
*   **Body (JSON)**:
    ```json
    {
        "session_data": {
            "category": "bcs_admin",
            "score": 85,
            "qa_pairs": [
                {
                    "question": "নিজের জেলা সম্পর্কে বলুন।",
                    "answer": "...",
                    "feedback": "...",
                    "score": 85
                }
            ]
        }
    }
    ```
*   **Response**: `201 Created`
    ```json
    {
        "status": "success",
        "message": "Session saved successfully"
    }
    ```

### Get Mock Practice History List
*   **Route**: `GET /api/viva/sessions`
*   **Headers**: `X-Api-Key: <key>`, `Authorization: Bearer <token>`
*   **Response**: `200 OK`
    ```json
    {
        "status": "success",
        "data": [
            {
                "id": 105,
                "category": "bcs_admin",
                "score": 85,
                "date": "2026-08-10 12:45:00"
            }
        ]
    }
    ```

### Get Session Evaluation Details
*   **Route**: `GET /api/viva/sessions/{id}/evaluation`
*   **Headers**: `X-Api-Key: <key>`, `Authorization: Bearer <token>`
*   **Response**: `200 OK`
    ```json
    {
        "status": "success",
        "data": {
            "session_id": 105,
            "qa_pairs": [...]
        }
    }
    ```
