<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Interactive AI Viva Practice | Shera Viva</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-obsidian: #090D1A;
            --bg-card: rgba(17, 24, 39, 0.75);
            --border-glow: rgba(255, 255, 255, 0.08);
            --primary-emerald: #10B981;
            --primary-glow: rgba(16, 185, 129, 0.15);
            --text-main: #F3F4F6;
            --text-muted: #9CA3AF;
            --accent-blue: #3B82F6;
            --font-sans: 'Inter', 'Hind Siliguri', sans-serif;
            --font-display: 'Outfit', 'Hind Siliguri', sans-serif;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background-color: var(--bg-obsidian);
            color: var(--text-main);
            font-family: var(--font-sans);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-image: 
                radial-gradient(circle at 10% 10%, rgba(16, 185, 129, 0.06) 0%, transparent 40%),
                radial-gradient(circle at 90% 90%, rgba(59, 130, 246, 0.06) 0%, transparent 40%);
        }

        .header {
            padding: 16px 32px;
            background: rgba(9, 13, 26, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-glow);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-family: var(--font-display);
            font-size: 20px;
            font-weight: 800;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo span { color: var(--primary-emerald); }

        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .board-card {
            background: var(--bg-card);
            border: 1px solid var(--border-glow);
            border-radius: 16px;
            padding: 28px;
            backdrop-filter: blur(12px);
        }

        .category-selector {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            padding-bottom: 10px;
        }

        .cat-btn {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-glow);
            color: var(--text-muted);
            padding: 10px 18px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s ease;
        }

        .cat-btn.active, .cat-btn:hover {
            background: var(--primary-emerald);
            color: #fff;
            border-color: var(--primary-emerald);
        }

        .question-box {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-left: 4px solid var(--primary-emerald);
            border-radius: 12px;
            padding: 24px;
            margin-top: 20px;
        }

        .speaker-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--primary-emerald);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .question-text {
            font-size: 18px;
            font-weight: 600;
            line-height: 1.6;
            color: #fff;
        }

        .answer-box {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        textarea {
            width: 100%;
            background: rgba(9, 13, 26, 0.9);
            border: 1px solid var(--border-glow);
            border-radius: 12px;
            padding: 16px;
            color: #fff;
            font-family: var(--font-sans);
            font-size: 15px;
            resize: vertical;
            min-height: 110px;
        }

        textarea:focus {
            outline: none;
            border-color: var(--primary-emerald);
        }

        .controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-action {
            background: var(--primary-emerald);
            color: #fff;
            border: none;
            padding: 12px 28px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-mic {
            background: rgba(59, 130, 246, 0.15);
            color: var(--accent-blue);
            border: 1px solid rgba(59, 130, 246, 0.3);
            padding: 10px 18px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .evaluation-card {
            background: rgba(16, 185, 129, 0.05);
            border: 1px solid var(--primary-emerald);
            border-radius: 16px;
            padding: 24px;
            margin-top: 24px;
            display: none;
        }

        .score-badge {
            background: var(--primary-emerald);
            color: #fff;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 800;
            font-size: 16px;
            display: inline-block;
            margin-bottom: 14px;
        }
    </style>
</head>
<body>

    <div class="header">
        <a href="/dashboard" class="logo">
            <i class="fa-solid fa-graduation-cap"></i> Shera <span>Viva</span>
        </a>
        <a href="/dashboard" style="color: var(--text-muted); text-decoration: none; font-size: 14px; font-weight: 500;">
            <i class="fa-solid fa-arrow-left"></i> Dashboard
        </a>
    </div>

    <div class="container">
        
        <div class="board-card">
            <h2 style="font-family: var(--font-display); font-size: 22px; font-weight: 700; margin-bottom: 16px; color: #fff;">
                <i class="fa-solid fa-robot" style="color: var(--primary-emerald);"></i> Gemini 3.5 Flash AI Viva Board
            </h2>

            <div class="category-selector" id="cat-selector">
                <button class="cat-btn active" data-cat="BCS Administration Board">BCS Administration</button>
                <button class="cat-btn" data-cat="BCS Police Board">BCS Police</button>
                <button class="cat-btn" data-cat="BCS Foreign Affairs Board">BCS Foreign Affairs</button>
                <button class="cat-btn" data-cat="Bangladesh Bank AD Board">Bank AD Board</button>
                <button class="cat-btn" data-cat="Primary Assistant School Teacher Board">Primary Teacher</button>
            </div>

            <!-- Board Question Box -->
            <div class="question-box">
                <div class="speaker-label">
                    <i class="fa-solid fa-user-tie"></i> <span id="board-name">BCS Administration Board Chairman</span>
                </div>
                <div class="question-text" id="q-text">
                    <i class="fa-solid fa-spinner fa-spin"></i> Generating viva question with Gemini 3.5 Flash AI...
                </div>
            </div>

            <!-- Answer Box -->
            <div class="answer-box">
                <textarea id="answer-text" placeholder="Type your answer here in Bangla or English, or click 'Speak Answer' to talk..."></textarea>
                
                <div class="controls">
                    <button class="btn-mic" id="btn-speech">
                        <i class="fa-solid fa-microphone"></i> <span id="mic-status">Speak Answer</span>
                    </button>
                    
                    <button class="btn-action" id="btn-submit">
                        Submit Answer & Evaluate <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
            </div>

            <!-- Evaluation Results -->
            <div class="evaluation-card" id="eval-card">
                <div class="score-badge" id="eval-score">AI Score: 85/100</div>
                <h3 style="color: #fff; font-size: 16px; margin-bottom: 8px;">Board Feedback:</h3>
                <p id="eval-feedback" style="color: var(--text-main); font-size: 14px; margin-bottom: 14px; line-height: 1.5;"></p>

                <h4 style="color: var(--primary-emerald); font-size: 14px; margin-bottom: 4px;">Recommendations:</h4>
                <p id="eval-recs" style="color: var(--text-muted); font-size: 13px; margin-bottom: 14px; white-space: pre-line;"></p>

                <h4 style="color: var(--accent-blue); font-size: 14px; margin-bottom: 4px;">Exemplary Model Answer:</h4>
                <p id="eval-model" style="color: var(--text-main); font-size: 13px; font-style: italic; background: rgba(255,255,255,0.03); padding: 12px; border-radius: 8px; border-left: 3px solid var(--accent-blue);"></p>

                <button class="btn-action" id="btn-next-q" style="margin-top: 18px; background: var(--accent-blue);">
                    Next Board Question <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let activeCategory = 'BCS Administration Board';
            let currentQuestion = '';
            let transcriptHistory = [];

            const qText = document.getElementById('q-text');
            const answerText = document.getElementById('answer-text');
            const btnSubmit = document.getElementById('btn-submit');
            const btnSpeech = document.getElementById('btn-speech');
            const micStatus = document.getElementById('mic-status');
            const evalCard = document.getElementById('eval-card');
            const evalScore = document.getElementById('eval-score');
            const evalFeedback = document.getElementById('eval-feedback');
            const evalRecs = document.getElementById('eval-recs');
            const evalModel = document.getElementById('eval-model');
            const btnNextQ = document.getElementById('btn-next-q');
            const boardName = document.getElementById('board-name');

            // Category Selection
            document.querySelectorAll('.cat-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    document.querySelectorAll('.cat-btn').forEach(b => b.classList.remove('active'));
                    e.target.classList.add('active');
                    activeCategory = e.target.getAttribute('data-cat');
                    boardName.innerText = activeCategory + ' Chairman';
                    transcriptHistory = [];
                    fetchNextQuestion();
                });
            });

            // Fetch Next Question via API
            async function fetchNextQuestion() {
                evalCard.style.display = 'none';
                answerText.value = '';
                qText.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> Board Chairman is thinking...`;

                try {
                    const res = await fetch('/api/viva/ai/generate-question', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            category: activeCategory,
                            transcript_history: transcriptHistory
                        })
                    });
                    const json = await res.json();
                    if (json.status === 'success' && json.data && json.data.question) {
                        currentQuestion = json.data.question;
                        qText.innerText = currentQuestion;
                    } else {
                        currentQuestion = "Introduce yourself and explain why you are candidate for " + activeCategory + ".";
                        qText.innerText = currentQuestion;
                    }
                } catch (err) {
                    currentQuestion = "Tell us about your academic background and how it applies to " + activeCategory + ".";
                    qText.innerText = currentQuestion;
                }
            }

            // Evaluate Answer
            btnSubmit.addEventListener('click', async () => {
                const ans = answerText.value.trim();
                if (!ans) {
                    alert('Please type or speak your answer before submitting.');
                    return;
                }

                btnSubmit.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> Evaluating...`;
                btnSubmit.disabled = true;

                try {
                    const res = await fetch('/api/viva/ai/evaluate-answer', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            question: currentQuestion,
                            answer: ans,
                            category: activeCategory
                        })
                    });
                    const json = await res.json();
                    btnSubmit.innerHTML = `Submit Answer & Evaluate <i class="fa-solid fa-paper-plane"></i>`;
                    btnSubmit.disabled = false;

                    if (json.status === 'success' && json.data) {
                        const data = json.data;
                        evalScore.innerText = `AI Score: ${data.score}/100`;
                        evalFeedback.innerText = data.feedback || '';
                        evalRecs.innerText = data.recommendations || '';
                        evalModel.innerText = data.model_answer || '';
                        evalCard.style.display = 'block';

                        // Save into history
                        transcriptHistory.push({ speaker: 'Chairman', text: currentQuestion });
                        transcriptHistory.push({ speaker: 'Candidate', text: ans });
                    }
                } catch (err) {
                    btnSubmit.innerHTML = `Submit Answer & Evaluate <i class="fa-solid fa-paper-plane"></i>`;
                    btnSubmit.disabled = false;
                    alert('Evaluation error. Please try again.');
                }
            });

            btnNextQ.addEventListener('click', fetchNextQuestion);

            // Speech Recognition (Web Speech API)
            if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
                const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                const recognition = new SpeechRecognition();
                recognition.continuous = false;
                recognition.interimResults = false;
                recognition.lang = 'bn-BD'; // Default to Bangla, falls back to English

                let listening = false;

                btnSpeech.addEventListener('click', () => {
                    if (!listening) {
                        recognition.start();
                        listening = true;
                        micStatus.innerText = 'Listening...';
                        btnSpeech.style.background = 'rgba(239, 68, 68, 0.2)';
                        btnSpeech.style.color = '#EF4444';
                    } else {
                        recognition.stop();
                        listening = false;
                        micStatus.innerText = 'Speak Answer';
                        btnSpeech.style.background = 'rgba(59, 130, 246, 0.15)';
                        btnSpeech.style.color = 'var(--accent-blue)';
                    }
                });

                recognition.onresult = (event) => {
                    const transcript = event.results[0][0].transcript;
                    answerText.value += (answerText.value ? ' ' : '') + transcript;
                };

                recognition.onend = () => {
                    listening = false;
                    micStatus.innerText = 'Speak Answer';
                    btnSpeech.style.background = 'rgba(59, 130, 246, 0.15)';
                    btnSpeech.style.color = 'var(--accent-blue)';
                };
            } else {
                btnSpeech.style.display = 'none';
            }

            // Initial question fetch
            fetchNextQuestion();
        });
    </script>
</body>
</html>
