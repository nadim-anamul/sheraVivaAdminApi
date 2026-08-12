@extends('layouts.app')

@section('title', 'Interactive AI Viva Practice | Shera Viva')

@section('content')
<div class="max-w-[1200px] mx-auto px-6 py-10 w-full">
<div class="max-w-[1100px] mx-auto">
    
    <div class="bg-bg-card border border-border-glow rounded-2xl p-6 lg:p-8 backdrop-blur-md">
        <h2 class="font-display text-xl lg:text-2xl font-bold mb-5 text-white flex items-center gap-2">
            <i class="fa-solid fa-robot text-primary-emerald"></i> Gemini 3.5 Flash AI Viva Board
        </h2>

        <!-- Category Selector -->
        <div class="flex gap-3 overflow-x-auto pb-2.5 mb-5 shrink-0 select-none" id="cat-selector">
            <button class="bg-primary-emerald border border-primary-emerald text-white px-4.5 py-2 rounded-full text-xs lg:text-sm font-semibold cursor-pointer whitespace-nowrap transition-all duration-200 active-cat-btn" data-cat="BCS Administration Board">BCS Administration</button>
            <button class="bg-white/3 border border-border-glow text-text-muted px-4.5 py-2 rounded-full text-xs lg:text-sm font-semibold cursor-pointer whitespace-nowrap transition-all duration-200 hover:bg-primary-emerald hover:border-primary-emerald hover:text-white" data-cat="BCS Police Board">BCS Police</button>
            <button class="bg-white/3 border border-border-glow text-text-muted px-4.5 py-2 rounded-full text-xs lg:text-sm font-semibold cursor-pointer whitespace-nowrap transition-all duration-200 hover:bg-primary-emerald hover:border-primary-emerald hover:text-white" data-cat="BCS Foreign Affairs Board">BCS Foreign Affairs</button>
            <button class="bg-white/3 border border-border-glow text-text-muted px-4.5 py-2 rounded-full text-xs lg:text-sm font-semibold cursor-pointer whitespace-nowrap transition-all duration-200 hover:bg-primary-emerald hover:border-primary-emerald hover:text-white" data-cat="Bangladesh Bank AD Board">Bank AD Board</button>
            <button class="bg-white/3 border border-border-glow text-text-muted px-4.5 py-2 rounded-full text-xs lg:text-sm font-semibold cursor-pointer whitespace-nowrap transition-all duration-200 hover:bg-primary-emerald hover:border-primary-emerald hover:text-white" data-cat="Primary Assistant School Teacher Board">Primary Teacher</button>
        </div>

        <!-- Board Question Box -->
        <div class="bg-white/2 border border-primary-emerald/20 border-l-4 border-l-primary-emerald rounded-xl p-6 mt-5 shadow-sm">
            <div class="text-xs font-bold text-primary-emerald uppercase tracking-wider mb-2 flex items-center gap-1.5">
                <i class="fa-solid fa-user-tie"></i> <span id="board-name">BCS Administration Board Chairman</span>
            </div>
            <div class="text-base lg:text-lg font-semibold leading-relaxed text-white" id="q-text">
                <i class="fa-solid fa-spinner fa-spin"></i> Generating viva question with Gemini 3.5 Flash AI...
            </div>
        </div>

        <!-- Answer Box -->
        <div class="mt-5 flex flex-col gap-4">
            <textarea id="answer-text" class="w-full bg-bg-obsidian/90 border border-border-glow rounded-xl p-4 text-white font-sans text-sm lg:text-base resize-y min-h-[110px] outline-none transition-all focus:border-primary-emerald" placeholder="Type your answer here in Bangla or English, or click 'Speak Answer' to talk..."></textarea>
            
            <div class="flex justify-between items-center gap-4 flex-wrap">
                <button class="bg-accent-blue/15 text-accent-blue border border-accent-blue/30 px-4.5 py-2.5 rounded-full font-semibold text-xs lg:text-sm cursor-pointer inline-flex items-center gap-2.5 transition-all duration-200 hover:bg-accent-blue/25" id="btn-speech">
                    <i class="fa-solid fa-microphone text-accent-blue"></i> <span id="mic-status">Speak Answer</span>
                </button>
                
                <button class="btn-primary py-2.5 px-6 rounded-full font-bold text-xs lg:text-sm" id="btn-submit">
                    Submit Answer & Evaluate <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>
        </div>

        <!-- Evaluation Results -->
        <div class="bg-primary-emerald/5 border border-primary-emerald/30 rounded-2xl p-6 mt-6 hidden" id="eval-card">
            <div class="bg-primary-emerald text-white px-4 py-1.5 rounded-full font-extrabold text-sm lg:text-base inline-block mb-3.5 shadow-sm shadow-primary-emerald/25 font-display" id="eval-score">AI Score: 85/100</div>
            <h3 class="text-white text-base font-bold mb-2">Board Feedback:</h3>
            <p id="eval-feedback" class="text-text-main text-sm lg:text-base mb-4 leading-relaxed"></p>

            <h4 class="text-primary-emerald text-xs lg:text-sm font-bold mb-1 uppercase tracking-wide">Recommendations:</h4>
            <p id="eval-recs" class="text-text-muted text-xs lg:text-sm mb-4 leading-relaxed white-space-pre-line"></p>

            <h4 class="text-accent-blue text-xs lg:text-sm font-bold mb-1 uppercase tracking-wide">Exemplary Model Answer:</h4>
            <p id="eval-model" class="text-white text-xs lg:text-sm italic bg-white/3 p-4 rounded-xl border-l-3 border-l-accent-blue leading-relaxed"></p>

            <button class="btn-primary py-2.5 px-6 rounded-full font-bold text-xs lg:text-sm mt-5 bg-gradient-to-r from-accent-blue to-blue-600 hover:shadow-blue-500/20" id="btn-next-q">
                Next Board Question <i class="fa-solid fa-arrow-right"></i>
            </button>
        </div>

    </div>

</div>
</div>
@endsection

@section('scripts')
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
        document.querySelectorAll('#cat-selector button').forEach(btn => {
            btn.addEventListener('click', (e) => {
                document.querySelectorAll('#cat-selector button').forEach(b => {
                    b.className = "bg-white/3 border border-border-glow text-text-muted px-4.5 py-2 rounded-full text-xs lg:text-sm font-semibold cursor-pointer whitespace-nowrap transition-all duration-200 hover:bg-primary-emerald hover:border-primary-emerald hover:text-white";
                });
                e.target.className = "bg-primary-emerald border border-primary-emerald text-white px-4.5 py-2 rounded-full text-xs lg:text-sm font-semibold cursor-pointer whitespace-nowrap transition-all duration-200 active-cat-btn";
                activeCategory = e.target.getAttribute('data-cat');
                boardName.innerText = activeCategory + ' Chairman';
                transcriptHistory = [];
                fetchNextQuestion();
            });
        });

        // Fetch Next Question via API
        async function fetchNextQuestion() {
            evalCard.classList.add('hidden');
            answerText.value = '';
            qText.innerHTML = `<i class="fa-solid fa-spinner fa-spin text-primary-emerald"></i> Board Chairman is thinking...`;

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
                    evalCard.classList.remove('hidden');

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
                    btnSpeech.className = 'bg-red-500/20 text-red-500 border border-red-500/30 px-4.5 py-2.5 rounded-full font-semibold text-xs lg:text-sm cursor-pointer inline-flex items-center gap-2.5 transition-all duration-200';
                } else {
                    recognition.stop();
                    listening = false;
                    micStatus.innerText = 'Speak Answer';
                    btnSpeech.className = 'bg-accent-blue/15 text-accent-blue border border-accent-blue/30 px-4.5 py-2.5 rounded-full font-semibold text-xs lg:text-sm cursor-pointer inline-flex items-center gap-2.5 transition-all duration-200 hover:bg-accent-blue/25';
                }
            });

            recognition.onresult = (event) => {
                const transcript = event.results[0][0].transcript;
                answerText.value += (answerText.value ? ' ' : '') + transcript;
            };

            recognition.onend = () => {
                listening = false;
                micStatus.innerText = 'Speak Answer';
                btnSpeech.className = 'bg-accent-blue/15 text-accent-blue border border-accent-blue/30 px-4.5 py-2.5 rounded-full font-semibold text-xs lg:text-sm cursor-pointer inline-flex items-center gap-2.5 transition-all duration-200 hover:bg-accent-blue/25';
            };
        } else {
            btnSpeech.style.display = 'none';
        }

        // Initial question fetch
        fetchNextQuestion();
    });
</script>
@endsection
