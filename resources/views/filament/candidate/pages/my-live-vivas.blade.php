<x-filament-panels::page>
    <div class="space-y-8">

        <!-- Flash Notifications -->
        @if(session()->has('success'))
            <div class="bg-emerald-600/20 border border-emerald-500/40 text-emerald-300 p-4 rounded-xl font-bold flex items-center gap-3 shadow-lg">
                <i class="fa-solid fa-circle-check text-xl"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Banner Header -->
        <div class="bg-gradient-to-r from-indigo-950 via-purple-900 to-indigo-950 border border-indigo-500/20 text-white p-6 sm:p-8 rounded-2xl shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="space-y-2">
                <span class="bg-indigo-500/20 text-indigo-300 text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full border border-indigo-500/30">1-on-1 Board Practice</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold">Live Expert Interviews & Video Recordings</h2>
                <p class="text-gray-300 text-sm max-w-xl">
                    Attend scheduled live Google Meet board sessions with former BPSC members, BCS officers, and banking experts. Re-watch recorded videos and review official scorecards anytime!
                </p>
            </div>
            <button wire:click="openBookingModal" class="bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-bold text-xs sm:text-sm px-5 py-3 rounded-xl transition flex items-center gap-2 shadow-lg animate-pulse">
                <i class="fa-solid fa-calendar-plus"></i> Book Live Board Session
            </button>
        </div>

        <!-- Available Expert Board Panel -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-user-tie text-indigo-400"></i> Expert Board Panel & Examiners
                </h3>
                <span class="text-xs text-gray-400 font-semibold">{{ count($interviewers) }} Active Experts Available</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($interviewers as $expert)
                    <div class="bg-gray-900/90 border border-white/10 hover:border-indigo-500/40 rounded-2xl p-5 shadow-lg backdrop-blur-md flex flex-col justify-between transition group">
                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <div class="w-14 h-14 rounded-2xl overflow-hidden border-2 border-indigo-500/30 shrink-0 bg-gray-800 flex items-center justify-center">
                                    @if($expert->avatar_url)
                                        <img src="{{ asset($expert->avatar_url) }}" alt="{{ $expert->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    @else
                                        <i class="fa-solid fa-user-tie text-2xl text-indigo-300"></i>
                                    @endif
                                </div>
                                <div class="space-y-1">
                                    <h4 class="text-base font-bold text-white group-hover:text-indigo-300 transition">{{ $expert->name }}</h4>
                                    <p class="text-xs font-semibold text-indigo-400 leading-snug">{{ $expert->designation }}</p>
                                </div>
                            </div>

                            @if($expert->bio)
                                <p class="text-xs text-gray-300 leading-relaxed line-clamp-2">
                                    {{ $expert->bio }}
                                </p>
                            @endif

                            <div class="flex items-center justify-between text-xs pt-2 border-t border-white/10">
                                <span class="text-gray-400 font-medium">Session Fee: <strong class="text-emerald-400 font-bold">৳{{ number_format($expert->base_price ?: 500, 0) }} BDT</strong></span>
                                <span class="bg-indigo-500/20 text-indigo-300 text-[11px] font-bold px-2.5 py-0.5 rounded-full border border-indigo-500/30">
                                    {{ $expert->slots_count }} Slots
                                </span>
                            </div>
                        </div>

                        <button wire:click="openBookingModal({{ $expert->id }})" class="mt-4 w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs py-2.5 rounded-xl transition shadow-md flex items-center justify-center gap-2">
                            <i class="fa-solid fa-clock"></i> Select Examiner & Slot
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Scheduled & Past Live Vivas List -->
        <div class="space-y-4">
            <h3 class="text-base font-bold text-white flex items-center gap-2">
                <i class="fa-solid fa-calendar-check text-indigo-400"></i> Your 1-on-1 Live Viva Sessions
            </h3>

            @if(count($liveVivas) > 0)
                <div class="space-y-4">
                    @foreach($liveVivas as $viva)
                        <div class="bg-gray-900/80 border border-white/10 rounded-2xl p-6 shadow-xl space-y-4 backdrop-blur-md hover:border-indigo-500/40 transition">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-white/10 pb-4">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="bg-indigo-500/20 text-indigo-300 text-xs font-black px-3 py-1 rounded-full border border-indigo-500/30 uppercase">
                                            {{ $viva->exam_type }} Board
                                        </span>
                                        <span class="text-xs font-semibold text-gray-300">
                                            Target: {{ $viva->target_position ?? 'General Board' }}
                                        </span>
                                    </div>
                                    <h4 class="text-base font-bold text-white mt-1">
                                        Examiner: {{ $viva->interviewer?->name ?? 'Assigned BPSC Board Expert' }}
                                    </h4>
                                    <p class="text-xs text-gray-400">
                                        {{ $viva->interviewer?->designation ?? 'Senior Civil Service Expert' }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-3">
                                    @if($viva->status === 'scheduled' && !empty($viva->google_meet_url))
                                        <a href="{{ $viva->google_meet_url }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition flex items-center gap-2 shadow-md animate-pulse">
                                            <i class="fa-solid fa-video"></i> Join Google Meet Session
                                        </a>
                                    @elseif($viva->status === 'scheduled')
                                        <span class="bg-indigo-500/20 text-indigo-300 text-xs font-bold px-3 py-1 rounded-full border border-indigo-500/30">
                                            <i class="fa-solid fa-calendar-check"></i> Scheduled
                                        </span>
                                    @elseif($viva->status === 'completed')
                                        <span class="bg-emerald-500/20 text-emerald-300 text-xs font-bold px-3 py-1 rounded-full border border-emerald-500/30">
                                            <i class="fa-solid fa-check"></i> Completed
                                        </span>
                                    @elseif($viva->status === 'pending_payment')
                                        <span class="bg-amber-500/20 text-amber-300 text-xs font-bold px-3 py-1 rounded-full border border-amber-500/30">
                                            <i class="fa-solid fa-hourglass-half"></i> Pending Admin Approval
                                        </span>
                                    @else
                                        <span class="bg-amber-500/20 text-amber-300 text-xs font-bold px-3 py-1 rounded-full border border-amber-500/30">
                                            <i class="fa-solid fa-clock"></i> {{ ucfirst(str_replace('_', ' ', $viva->status)) }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                                <div class="bg-white/5 p-3 rounded-xl border border-white/10">
                                    <span class="text-gray-400 font-bold uppercase text-[10px]">Scheduled Time:</span>
                                    <div class="font-black text-white text-sm mt-0.5">
                                        {{ $viva->scheduled_at ? $viva->scheduled_at->format('d M Y, h:i A') : 'Awaiting Schedule' }}
                                    </div>
                                </div>

                                <div class="bg-white/5 p-3 rounded-xl border border-white/10">
                                    <span class="text-gray-400 font-bold uppercase text-[10px]">Google Meet Link:</span>
                                    <div class="font-bold text-indigo-300 truncate mt-0.5">
                                        @if($viva->google_meet_url)
                                            <a href="{{ $viva->google_meet_url }}" target="_blank" class="underline">{{ $viva->google_meet_url }}</a>
                                        @else
                                            <span class="text-gray-400 font-normal">Will be attached by Admin</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="bg-white/5 p-3 rounded-xl border border-white/10">
                                    <span class="text-gray-400 font-bold uppercase text-[10px]">bKash TrxID:</span>
                                    <div class="font-bold text-pink-300 truncate mt-0.5">
                                        {{ $viva->paymentTransaction?->trx_id ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>

                            @if($viva->overall_score !== null)
                                <div class="bg-indigo-950/40 border border-indigo-500/30 p-4 rounded-xl space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs font-bold text-indigo-300 uppercase tracking-wider">Official Board Scorecard Rating</span>
                                        <span class="text-base font-black text-indigo-200 bg-indigo-900/60 px-3 py-0.5 rounded-lg border border-indigo-500/40">
                                            {{ $viva->overall_score }} / 100
                                        </span>
                                    </div>
                                    @if($viva->board_feedback)
                                        <p class="text-xs text-gray-200 leading-relaxed font-medium">
                                            <strong>Board Feedback:</strong> {{ $viva->board_feedback }}
                                        </p>
                                    @endif
                                </div>
                            @endif

                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-900/80 border border-white/10 rounded-2xl p-12 text-center text-gray-400 space-y-3 backdrop-blur-md">
                    <i class="fa-solid fa-video-slash text-4xl text-gray-600"></i>
                    <h4 class="text-base font-bold text-white">No Human Live Viva Sessions Booked Yet</h4>
                    <p class="text-xs max-w-md mx-auto text-gray-400">
                        Book a 1-on-1 live mock board interview with former BPSC & Bank examiners. We will generate a Google Meet link and provide a recorded video URL after your session!
                    </p>
                    <button wire:click="openBookingModal" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition shadow-md">
                        <i class="fa-solid fa-plus"></i> Book Live Board Session Now
                    </button>
                </div>
            @endif
        </div>

        <!-- Livewire Interactive Booking Modal -->
        @if($showBookingModal)
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md overflow-y-auto">
                <div class="bg-gray-900 border border-indigo-500/30 rounded-2xl max-w-2xl w-full p-6 sm:p-8 space-y-6 shadow-2xl relative my-8">
                    
                    <!-- Modal Header -->
                    <div class="flex items-start justify-between border-b border-white/10 pb-4">
                        <div class="space-y-1">
                            <span class="bg-indigo-500/20 text-indigo-300 text-[10px] font-extrabold uppercase px-2.5 py-0.5 rounded-full border border-indigo-500/30">1-on-1 Board Booking</span>
                            <h3 class="text-xl font-extrabold text-white">Book Your Expert Live Board Viva</h3>
                            <p class="text-xs text-gray-400">Select your preferred examiner, exam category, date/time slot, and enter bKash payment details.</p>
                        </div>
                        <button wire:click="closeBookingModal" class="text-gray-400 hover:text-white p-1 text-lg transition">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <!-- Modal Body Form -->
                    <form wire:submit.prevent="submitBooking" class="space-y-5">
                        
                        <!-- 1. Select Examiner -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-indigo-300 uppercase tracking-wider">1. Select Expert Board Examiner</label>
                            <select wire:model.live="selectedInterviewerId" class="w-full p-3 border border-white/20 rounded-xl text-xs bg-gray-800 text-white font-bold focus:border-indigo-500 focus:outline-none" required>
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
                                <label class="block text-xs font-bold text-indigo-300 uppercase tracking-wider">2. Exam Category / Type</label>
                                <select wire:model="examType" class="w-full p-3 border border-white/20 rounded-xl text-xs bg-gray-800 text-white font-bold focus:border-indigo-500 focus:outline-none" required>
                                    <option value="46th BCS Cadre Viva">46th BCS Cadre Viva</option>
                                    <option value="47th BCS Viva Prep">47th BCS Viva Prep</option>
                                    <option value="Bangladesh Bank AD Viva">Bangladesh Bank AD Viva</option>
                                    <option value="Commercial Bank Officer">Commercial Bank Officer Viva</option>
                                    <option value="Primary Teacher Viva">Primary Assistant Teacher</option>
                                    <option value="NSI / Customs Officer">NSI / Customs Officer</option>
                                    <option value="Judicial Service Viva">Judicial Service Viva</option>
                                </select>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-indigo-300 uppercase tracking-wider">Target Position / Cadre</label>
                                <input type="text" wire:model="targetPosition" placeholder="e.g. BCS Administration" class="w-full p-3 border border-white/20 rounded-xl text-xs bg-gray-800 text-white focus:border-indigo-500 focus:outline-none" required>
                            </div>
                        </div>

                        <!-- 3. Available Slot -->
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-indigo-300 uppercase tracking-wider">3. Select Date & Available Time Slot</label>
                            @if(count($availableSlots) > 0)
                                <select wire:model="selectedSlotId" class="w-full p-3 border border-white/20 rounded-xl text-xs bg-gray-800 text-white font-bold focus:border-indigo-500 focus:outline-none" required>
                                    <option value="">-- Choose Available Slot --</option>
                                    @foreach($availableSlots as $slot)
                                        <option value="{{ $slot['id'] }}">{{ $slot['label'] }}</option>
                                    @endforeach
                                </select>
                            @else
                                <div class="bg-amber-950/40 border border-amber-500/30 p-3 rounded-xl text-xs text-amber-300 flex items-center gap-2">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    <span>No available slots found for this examiner right now. Please select another examiner.</span>
                                </div>
                            @endif
                        </div>

                        <!-- 4. bKash Payment Box -->
                        <div class="bg-pink-950/40 border border-pink-500/30 rounded-xl p-4 space-y-3">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold text-pink-300 uppercase">bKash Send Money Payment Info</span>
                                <span class="text-pink-400 font-black">Fee: ৳500 BDT</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                <div class="bg-black/30 p-2.5 rounded-lg border border-pink-500/20">
                                    <span class="text-gray-400 text-[10px] uppercase font-bold block">bKash Personal:</span>
                                    <span class="font-mono font-black text-pink-300 text-sm select-all">{{ $personalBkash }}</span>
                                </div>
                                <div class="bg-black/30 p-2.5 rounded-lg border border-pink-500/20">
                                    <span class="text-gray-400 text-[10px] uppercase font-bold block">bKash Merchant:</span>
                                    <span class="font-mono font-black text-pink-300 text-sm select-all">{{ $merchantBkash }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- 5. bKash Input Details -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-gray-300">Your bKash Phone Number</label>
                                <input type="text" wire:model="bkashNumber" placeholder="01712345678" class="w-full p-3 border border-white/20 rounded-xl text-xs bg-gray-800 text-white focus:border-pink-500 focus:outline-none" required>
                                @error('bkashNumber') <span class="text-rose-400 text-[11px]">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-gray-300">bKash Transaction ID (TrxID)</label>
                                <input type="text" wire:model="trxId" placeholder="e.g. 9B27X8KL9M" class="w-full p-3 border border-white/20 rounded-xl text-xs bg-gray-800 text-white font-mono font-bold uppercase focus:border-pink-500 focus:outline-none" required>
                                @error('trxId') <span class="text-rose-400 text-[11px]">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Modal Actions -->
                        <div class="pt-4 border-t border-white/10 flex justify-end gap-3">
                            <button type="button" wire:click="closeBookingModal" class="px-5 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs font-bold rounded-xl transition">
                                Cancel
                            </button>
                            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-pink-600 to-purple-600 hover:from-pink-700 hover:to-purple-700 text-white text-xs font-bold rounded-xl shadow-lg transition flex items-center gap-2">
                                <i class="fa-solid fa-paper-plane"></i> Submit bKash TrxID & Book Session
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        @endif

    </div>
</x-filament-panels::page>
