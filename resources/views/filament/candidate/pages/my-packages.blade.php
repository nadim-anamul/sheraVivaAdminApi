<x-filament-panels::page>
    <div class="space-y-8">

        <!-- Flash Notifications -->
        @if(session()->has('success'))
            <div class="bg-emerald-600/20 border border-emerald-500/40 text-emerald-300 p-4 rounded-xl font-bold flex items-center gap-3 shadow-lg">
                <i class="fa-solid fa-circle-check text-xl"></i> {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-rose-600/20 border border-rose-500/40 text-rose-300 p-4 rounded-xl font-semibold space-y-1 shadow-lg">
                <div class="font-bold flex items-center gap-2"><i class="fa-solid fa-circle-xmark"></i> Submission Error:</div>
                @foreach($errors->all() as $error)
                    <div class="text-xs">• {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Banner Header -->
        <div class="bg-gradient-to-r from-emerald-950 via-teal-900 to-indigo-950 border border-emerald-500/20 text-white p-6 sm:p-8 rounded-2xl shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="space-y-2">
                <span class="bg-emerald-500/20 text-emerald-300 text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full border border-emerald-500/30">Flexible Top-up</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold">Boost Your Board Practice with AI & Live Vivas</h2>
                <p class="text-gray-300 text-sm max-w-xl">
                    Subscribe to any package bundle via bKash Send Money. Admin verifies your Transaction ID (TrxID) and activates your credits immediately!
                </p>
            </div>
            <div class="bg-white/10 backdrop-blur-md p-4 rounded-xl border border-white/15 text-center min-w-[200px]">
                <div class="text-xs font-bold text-emerald-300 uppercase">Your Balance</div>
                <div class="text-3xl font-black text-white mt-1">{{ auth()->user()?->ai_viva_credits ?? 0 }} Vivas</div>
                <div class="text-[11px] text-gray-300 mt-1">Available for immediate practice</div>
            </div>
        </div>

        <!-- Available Package Cards Grid -->
        <div class="space-y-4">
            <h3 class="text-base font-bold text-white flex items-center gap-2">
                <i class="fa-solid fa-tags text-emerald-400"></i> Choose a Viva Package Bundle
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($packages as $pkg)
                    <div class="bg-gray-900/80 border border-white/10 rounded-2xl p-6 shadow-lg backdrop-blur-md flex flex-col justify-between hover:border-emerald-500/50 transition relative overflow-hidden">
                        @if($pkg->credits == 25)
                            <div class="absolute top-0 right-0 bg-amber-500 text-white text-[10px] font-black uppercase px-3 py-1 rounded-bl-xl tracking-wider">
                                Popular Value
                            </div>
                        @elseif($pkg->type === 'live_human')
                            <div class="absolute top-0 right-0 bg-indigo-600 text-white text-[10px] font-black uppercase px-3 py-1 rounded-bl-xl tracking-wider">
                                1-on-1 Board
                            </div>
                        @endif

                        <div class="space-y-3">
                            <h4 class="text-lg font-bold text-white">{{ $pkg->name }}</h4>
                            <div class="flex items-baseline gap-1">
                                <span class="text-3xl font-black text-emerald-400">৳{{ number_format($pkg->price_bdt, 0) }}</span>
                                <span class="text-xs text-gray-400 font-semibold">BDT</span>
                            </div>
                            
                            <div class="bg-white/5 p-3 rounded-xl border border-white/10 text-xs font-bold text-gray-300 flex items-center justify-between">
                                <span>Quota Granted:</span>
                                <span class="text-emerald-400 font-black">{{ $pkg->credits }} {{ $pkg->type === 'live_human' ? 'Live Session' : 'AI Vivas' }}</span>
                            </div>

                            <p class="text-gray-400 text-xs leading-relaxed">
                                {{ $pkg->description }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t border-white/10">
                            <button onclick="document.getElementById('payment-form-section').scrollIntoView({ behavior: 'smooth' })" class="w-full bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-bold text-xs py-2.5 rounded-xl transition shadow-md flex items-center justify-center gap-2">
                                <i class="fa-solid fa-cart-shopping"></i> Pay via bKash
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- bKash Payment Form & Instructions Section -->
        <div id="payment-form-section" class="bg-gray-900/80 border border-white/10 rounded-2xl p-6 sm:p-8 shadow-xl backdrop-blur-md grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Instructions -->
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-pink-500/20 text-pink-400 flex items-center justify-center font-bold text-xl border border-pink-500/30">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">How to Pay via bKash Send Money</h3>
                        <p class="text-xs text-gray-400">Follow these 3 simple steps to top up credits</p>
                    </div>
                </div>

                <div class="bg-pink-950/40 border border-pink-500/30 rounded-xl p-4 space-y-2 text-xs text-pink-200">
                    <div class="font-bold flex items-center gap-2">
                        <span>bKash Personal Number:</span> <span class="text-sm font-black text-pink-400 select-all">{{ $personalBkash }}</span>
                    </div>
                    <div class="font-bold flex items-center gap-2">
                        <span>bKash Merchant Number:</span> <span class="text-sm font-black text-pink-400 select-all">{{ $merchantBkash }}</span>
                    </div>
                    <p class="pt-1 text-gray-300">
                        1. Open bKash App or Dial <strong>*247#</strong> and select <strong>Send Money</strong>.<br>
                        2. Send the package amount to the number above.<br>
                        3. Copy the 10-digit <strong>TrxID</strong> and submit in the form on the right!
                    </p>
                </div>
            </div>

            <!-- bKash Submission Form -->
            <form action="{{ route('candidate.payment.submit') }}" method="POST" class="space-y-4">
                @csrf
                <h4 class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Submit bKash Payment Details</h4>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1">Selected Package</label>
                    <select name="package_id" id="package_id" class="w-full p-2.5 border border-white/10 rounded-xl text-xs bg-gray-800 text-white font-bold" required>
                        @foreach($packages as $pkg)
                            <option value="{{ $pkg->id }}">
                                {{ $pkg->name }} — ৳{{ number_format($pkg->price_bdt, 0) }} ({{ $pkg->credits }} Credits)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-300 mb-1">bKash Phone Number</label>
                        <input type="text" name="bkash_number" placeholder="01712345678" class="w-full p-2.5 border border-white/10 rounded-xl text-xs bg-gray-800 text-white" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-300 mb-1">bKash Transaction ID (TrxID)</label>
                        <input type="text" name="trx_id" placeholder="e.g. 9B27X8KL9M" class="w-full p-2.5 border border-white/10 rounded-xl text-xs bg-gray-800 text-white font-mono font-bold uppercase" required>
                    </div>
                </div>

                <button type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold text-xs py-3 rounded-xl transition shadow-md flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Submit bKash TrxID for Admin Approval
                </button>
            </form>

        </div>

        <!-- Payment History Table -->
        <div class="bg-gray-900/80 border border-white/10 rounded-2xl p-6 shadow-xl space-y-4 backdrop-blur-md">
            <h3 class="text-base font-bold text-white flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-emerald-400"></i> Your Payment Transactions History
            </h3>

            @if(count($transactions) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs text-gray-300">
                        <thead>
                            <tr class="border-b border-white/10 text-gray-400 font-bold uppercase text-[10px] tracking-wider">
                                <th class="py-3 px-4">Package</th>
                                <th class="py-3 px-4">Amount</th>
                                <th class="py-3 px-4">bKash Number</th>
                                <th class="py-3 px-4">TrxID</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($transactions as $trx)
                                <tr class="hover:bg-white/5 transition">
                                    <td class="py-3.5 px-4 font-bold text-white">{{ $trx->package?->name ?? 'N/A' }}</td>
                                    <td class="py-3.5 px-4 font-extrabold text-emerald-400">৳{{ number_format($trx->amount_bdt, 0) }}</td>
                                    <td class="py-3.5 px-4 font-mono text-gray-300">{{ $trx->bkash_number }}</td>
                                    <td class="py-3.5 px-4 font-mono font-bold text-indigo-300">{{ $trx->trx_id }}</td>
                                    <td class="py-3.5 px-4">
                                        @if($trx->status === 'approved')
                                            <span class="bg-emerald-500/20 text-emerald-300 font-bold px-2.5 py-1 rounded-full border border-emerald-500/30">
                                                <i class="fa-solid fa-check"></i> Approved & Granted
                                            </span>
                                        @elseif($trx->status === 'pending')
                                            <span class="bg-amber-500/20 text-amber-300 font-bold px-2.5 py-1 rounded-full border border-amber-500/30">
                                                <i class="fa-solid fa-hourglass-half"></i> Under Admin Review
                                            </span>
                                        @else
                                            <span class="bg-rose-500/20 text-rose-300 font-bold px-2.5 py-1 rounded-full border border-rose-500/30">
                                                <i class="fa-solid fa-xmark"></i> Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-400">{{ $trx->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-6 text-gray-400 text-xs">
                    No payment transactions submitted yet.
                </div>
            @endif
        </div>

    </div>
</x-filament-panels::page>
