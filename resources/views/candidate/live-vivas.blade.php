<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Human Live Vivas & Google Meet - SheraViva</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans min-h-screen" x-data="bookingModalApp()">

    <!-- Header Navigation -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-emerald-600 transition">
                    <i class="fa-solid fa-arrow-left text-lg"></i>
                </a>
                <h1 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-video text-indigo-600"></i>
                    <span>Human Expert Live Vivas</span>
                </h1>
            </div>
            
            <button @click="openModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs px-4 py-2 rounded-xl transition flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-calendar-plus"></i> Book Live Board Session
            </button>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-8 space-y-8">

        <!-- Flash Notifications -->
        @if(session()->has('success'))
            <div class="bg-emerald-600 text-white p-4 rounded-xl font-bold flex items-center gap-3 shadow-lg">
                <i class="fa-solid fa-circle-check text-xl"></i> {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-rose-600 text-white p-4 rounded-xl font-semibold space-y-1 shadow-lg">
                <div class="font-bold flex items-center gap-2"><i class="fa-solid fa-circle-xmark"></i> Submission Error:</div>
                @foreach($errors->all() as $error)
                    <div class="text-xs">• {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Banner Header -->
        <div class="bg-gradient-to-r from-indigo-950 via-indigo-900 to-purple-950 text-white p-8 rounded-2xl shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="space-y-2">
                <span class="bg-white/20 text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full">1-on-1 Board Practice</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold">Live Expert Interviews & Video Recordings</h2>
                <p class="text-indigo-100 text-sm max-w-xl">
                    Attend scheduled live Google Meet board sessions with former BPSC members, BCS officers, and banking experts. Re-watch recorded videos and review official scorecards anytime!
                </p>
            </div>
            <button @click="openModal()" class="bg-white text-indigo-950 hover:bg-indigo-50 font-black text-xs px-5 py-3 rounded-xl transition flex items-center gap-2 shadow-lg">
                <i class="fa-solid fa-plus-circle"></i> Book 1-on-1 Board Viva
            </button>
        </div>

        <!-- Available Expert Board Panel -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-user-tie text-indigo-600"></i> Expert Board Panel & Examiners
                </h3>
                <span class="text-xs text-gray-500 font-semibold">{{ count($interviewers) }} Active Board Experts</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($interviewers as $expert)
                    <div class="bg-white border border-gray-200 hover:border-indigo-400 rounded-2xl p-5 shadow-sm flex flex-col justify-between transition group">
                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <div class="w-14 h-14 rounded-2xl overflow-hidden border-2 border-indigo-200 shrink-0 bg-gray-100 flex items-center justify-center">
                                    @if($expert->avatar_url)
                                        <img src="{{ asset($expert->avatar_url) }}" alt="{{ $expert->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    @else
                                        <i class="fa-solid fa-user-tie text-2xl text-indigo-600"></i>
                                    @endif
                                </div>
                                <div class="space-y-1">
                                    <h4 class="text-base font-bold text-gray-900 group-hover:text-indigo-700 transition">{{ $expert->name }}</h4>
                                    <p class="text-xs font-semibold text-indigo-600 leading-snug">{{ $expert->designation }}</p>
                                </div>
                            </div>

                            @if($expert->bio)
                                <p class="text-xs text-gray-600 leading-relaxed line-clamp-2">
                                    {{ $expert->bio }}
                                </p>
                            @endif

                            <div class="flex items-center justify-between text-xs pt-2 border-t border-gray-100">
                                <span class="text-gray-600 font-medium">Session Fee: <strong class="text-emerald-700 font-bold">৳{{ number_format($expert->base_price ?: 500, 0) }} BDT</strong></span>
                                <span class="bg-indigo-50 text-indigo-700 text-[11px] font-bold px-2.5 py-0.5 rounded-full border border-indigo-200">
                                    {{ $expert->slots->count() }} Slots Available
                                </span>
                            </div>
                        </div>

                        <button @click="openModal({{ $expert->id }})" class="mt-4 w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs py-2.5 rounded-xl transition shadow-sm flex items-center justify-center gap-2">
                            <i class="fa-solid fa-clock"></i> Select Examiner & Slot
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Scheduled & Past Live Vivas List -->
        <div class="space-y-6">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-calendar-check text-indigo-600"></i> Your 1-on-1 Live Viva Sessions
            </h3>

            @if($liveVivas->count() > 0)
                <div class="space-y-4">
                    @foreach($liveVivas as $viva)
                        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm space-y-4 hover:border-indigo-300 transition">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-gray-100 pb-4">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="bg-indigo-100 text-indigo-800 text-xs font-black px-3 py-1 rounded-full uppercase">
                                            {{ $viva->exam_type }} Board
                                        </span>
                                        <span class="text-xs font-semibold text-gray-500">
                                            Target: {{ $viva->target_position ?? 'General Board' }}
                                        </span>
                                    </div>
                                    <h4 class="text-base font-bold text-gray-900 mt-1">
                                        Examiner: {{ $viva->interviewer?->name ?? 'Assigned BPSC Board Expert' }}
                                    </h4>
                                    <p class="text-xs text-gray-500">
                                        {{ $viva->interviewer?->designation ?? 'Senior Civil Service Expert' }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-3">
                                    @if($viva->status === 'scheduled' && !empty($viva->google_meet_url))
                                        <a href="{{ $viva->google_meet_url }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition flex items-center gap-2 shadow-md animate-pulse">
                                            <i class="fa-solid fa-video"></i> Join Google Meet Session
                                        </a>
                                    @elseif($viva->status === 'scheduled')
                                        <span class="bg-indigo-100 text-indigo-800 text-xs font-bold px-3 py-1 rounded-full">
                                            <i class="fa-solid fa-calendar-check"></i> Scheduled
                                        </span>
                                    @elseif($viva->status === 'completed')
                                        <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full">
                                            <i class="fa-solid fa-check"></i> Completed
                                        </span>
                                    @elseif($viva->status === 'pending_payment')
                                        <span class="bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full">
                                            <i class="fa-solid fa-hourglass-half"></i> Pending Admin Approval
                                        </span>
                                    @else
                                        <span class="bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full">
                                            <i class="fa-solid fa-clock"></i> {{ ucfirst(str_replace('_', ' ', $viva->status)) }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                                <div class="bg-gray-50 p-3 rounded-xl">
                                    <span class="text-gray-500 font-bold uppercase">Scheduled Time:</span>
                                    <div class="font-black text-gray-900 text-sm mt-0.5">
                                        {{ $viva->scheduled_at ? $viva->scheduled_at->format('d M Y, h:i A') : 'Awaiting Schedule' }}
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-3 rounded-xl">
                                    <span class="text-gray-500 font-bold uppercase">Google Meet Link:</span>
                                    <div class="font-bold text-indigo-700 truncate mt-0.5">
                                        @if($viva->google_meet_url)
                                            <a href="{{ $viva->google_meet_url }}" target="_blank" class="underline">{{ $viva->google_meet_url }}</a>
                                        @else
                                            <span class="text-gray-400 font-normal">Will be attached by Admin</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-3 rounded-xl">
                                    <span class="text-gray-500 font-bold uppercase">bKash TrxID:</span>
                                    <div class="font-bold text-pink-700 truncate mt-0.5">
                                        {{ $viva->paymentTransaction?->trx_id ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>

                            @if($viva->overall_score !== null)
                                <div class="bg-indigo-50/70 border border-indigo-200 p-4 rounded-xl space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs font-bold text-indigo-900 uppercase tracking-wider">Official Examiner Board Rating</span>
                                        <span class="text-lg font-black text-indigo-900 bg-white px-3 py-0.5 rounded-lg border border-indigo-200">
                                            {{ $viva->overall_score }} / 100
                                        </span>
                                    </div>
                                    @if($viva->board_feedback)
                                        <p class="text-xs text-indigo-950 leading-relaxed font-medium">
                                            <strong>Board Feedback:</strong> {{ $viva->board_feedback }}
                                        </p>
                                    @endif
                                </div>
                            @endif

                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white border border-gray-200 rounded-2xl p-12 text-center text-gray-500 space-y-3">
                    <i class="fa-solid fa-video-slash text-4xl text-gray-300"></i>
                    <h4 class="text-base font-bold text-gray-800">No Human Live Viva Sessions Booked Yet</h4>
                    <p class="text-xs max-w-md mx-auto">
                        Book a 1-on-1 live mock board interview with former BPSC & Bank examiners. We will generate a Google Meet link and provide a recorded video URL after your session!
                    </p>
                    <button @click="openModal()" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition">
                        <i class="fa-solid fa-plus"></i> Book Live Board Viva Now
                    </button>
                </div>
            @endif
        </div>

    </main>

    <!-- Interactive Alpine Booking Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm overflow-y-auto">
        <div class="bg-white border border-gray-200 rounded-2xl max-w-2xl w-full p-6 sm:p-8 space-y-6 shadow-2xl relative my-8" @click.outside="showModal = false">
            
            <!-- Modal Header -->
            <div class="flex items-start justify-between border-b border-gray-100 pb-4">
                <div class="space-y-1">
                    <span class="bg-indigo-100 text-indigo-800 text-[10px] font-extrabold uppercase px-2.5 py-0.5 rounded-full">1-on-1 Board Booking</span>
                    <h3 class="text-xl font-extrabold text-gray-900">Book Your Expert Live Board Viva</h3>
                    <p class="text-xs text-gray-500">Select your preferred examiner, exam category, date/time slot, and enter bKash payment details.</p>
                </div>
                <button @click="showModal = false" class="text-gray-400 hover:text-gray-700 p-1 text-lg transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('candidate.live_vivas.book') }}" method="POST" class="space-y-5">
                @csrf
                
                <!-- 1. Select Examiner -->
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-indigo-900 uppercase tracking-wider">1. Select Expert Board Examiner</label>
                    <select name="interviewer_id" x-model="selectedInterviewerId" @change="updateSlots()" class="w-full p-3 border border-gray-300 rounded-xl text-xs bg-gray-50 text-gray-900 font-bold focus:border-indigo-600 focus:outline-none" required>
                        <option value="">-- Choose Examiner --</option>
                        @foreach($interviewers as $exp)
                            <option value="{{ $exp->id }}">
                                {{ $exp->name }} ({{ $exp->designation }}) — ৳{{ number_format($exp->base_price ?: 500, 0) }} BDT
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- 2. Exam Type & Target Position -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-indigo-900 uppercase tracking-wider">2. Exam Category / Type</label>
                        <select name="exam_type" class="w-full p-3 border border-gray-300 rounded-xl text-xs bg-gray-50 text-gray-900 font-bold focus:border-indigo-600 focus:outline-none" required>
                            <option value="46th BCS Cadre Viva">46th BCS Cadre Viva</option>
                            <option value="47th BCS Viva Prep">47th BCS Viva Prep</option>
                            <option value="Bangladesh Bank AD Viva">Bangladesh Bank AD Viva</option>
                            <option value="Commercial Bank Officer Viva">Commercial Bank Officer Viva</option>
                            <option value="Primary Assistant Teacher">Primary Assistant Teacher</option>
                            <option value="NSI / Customs Officer">NSI / Customs Officer</option>
                            <option value="Judicial Service Viva">Judicial Service Viva</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-indigo-900 uppercase tracking-wider">Target Position / Cadre</label>
                        <input type="text" name="target_position" value="BCS (Administration)" placeholder="e.g. BCS Administration" class="w-full p-3 border border-gray-300 rounded-xl text-xs bg-white text-gray-900 focus:border-indigo-600 focus:outline-none" required>
                    </div>
                </div>

                <!-- 3. Available Slot -->
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-indigo-900 uppercase tracking-wider">3. Select Date & Available Time Slot</label>
                    <select name="slot_id" class="w-full p-3 border border-gray-300 rounded-xl text-xs bg-gray-50 text-gray-900 font-bold focus:border-indigo-600 focus:outline-none" required x-html="slotsOptionsHtml">
                    </select>
                </div>

                <!-- 4. bKash Payment Box -->
                <div class="bg-pink-50 border border-pink-200 rounded-xl p-4 space-y-3">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-bold text-pink-900 uppercase">bKash Send Money Payment Info</span>
                        <span class="text-pink-700 font-black">Fee: ৳500 BDT</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                        <div class="bg-white p-2.5 rounded-lg border border-pink-200">
                            <span class="text-gray-500 text-[10px] uppercase font-bold block">bKash Personal:</span>
                            <span class="font-mono font-black text-pink-700 text-sm select-all">{{ $personalBkash }}</span>
                        </div>
                        <div class="bg-white p-2.5 rounded-lg border border-pink-200">
                            <span class="text-gray-500 text-[10px] uppercase font-bold block">bKash Merchant:</span>
                            <span class="font-mono font-black text-pink-700 text-sm select-all">{{ $merchantBkash }}</span>
                        </div>
                    </div>
                </div>

                <!-- 5. bKash Input Details -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-gray-700">Your bKash Phone Number</label>
                        <input type="text" name="bkash_number" placeholder="01712345678" class="w-full p-3 border border-gray-300 rounded-xl text-xs bg-white text-gray-900 focus:border-pink-600 focus:outline-none" required>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-gray-700">bKash Transaction ID (TrxID)</label>
                        <input type="text" name="trx_id" placeholder="e.g. 9B27X8KL9M" class="w-full p-3 border border-gray-300 rounded-xl text-xs bg-white text-gray-900 font-mono font-bold uppercase focus:border-pink-600 focus:outline-none" required>
                    </div>
                </div>

                <!-- Modal Actions -->
                <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" @click="showModal = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-pink-600 hover:bg-pink-700 text-white text-xs font-bold rounded-xl shadow-lg transition flex items-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i> Submit bKash TrxID & Book Session
                    </button>
                </div>

            </form>

        </div>
    </div>

    <script>
        const interviewersData = @json($interviewers);

        function bookingModalApp() {
            return {
                showModal: false,
                selectedInterviewerId: '',
                slotsOptionsHtml: '<option value="">-- Select Examiner First --</option>',
                
                openModal(id = null) {
                    this.showModal = true;
                    if (id) {
                        this.selectedInterviewerId = id;
                    } else if (!this.selectedInterviewerId && interviewersData.length > 0) {
                        this.selectedInterviewerId = interviewersData[0].id;
                    }
                    this.updateSlots();
                },
                
                updateSlots() {
                    const exp = interviewersData.find(i => i.id == this.selectedInterviewerId);
                    if (!exp || !exp.slots || exp.slots.length === 0) {
                        this.slotsOptionsHtml = '<option value="">-- No Available Slots for this Examiner --</option>';
                        return;
                    }
                    
                    let html = '<option value="">-- Choose Available Slot --</option>';
                    exp.slots.forEach(slot => {
                        const dateStr = slot.availability_block ? slot.availability_block.date : 'Upcoming';
                        html += `<option value="${slot.id}">${dateStr} | ${slot.start_time.substring(0, 5)} - ${slot.end_time.substring(0, 5)}</option>`;
                    });
                    this.slotsOptionsHtml = html;
                }
            };
        }
    </script>
</body>
</html>
