<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI & Live Viva Packages - SheraViva</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-gray-50 text-gray-800 font-sans min-h-screen">

    <!-- Header Navigation -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-emerald-600 transition">
                    <i class="fa-solid fa-arrow-left text-lg"></i>
                </a>
                <h1 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-gem text-emerald-600"></i>
                    <span>AI Viva Packages & bKash Top-up</span>
                </h1>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="bg-emerald-50 border border-emerald-200 px-3.5 py-1.5 rounded-full flex items-center gap-2">
                    <i class="fa-solid fa-coins text-emerald-600"></i>
                    <span class="text-xs font-extrabold text-emerald-900">
                        {{ $user->ai_viva_credits }} AI Credits Available
                    </span>
                </div>
            </div>
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
        <div class="bg-gradient-to-r from-emerald-900 via-emerald-800 to-indigo-950 text-white p-8 rounded-2xl shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="space-y-2">
                <span class="bg-white/20 text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full">Flexible Packages</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold">Boost Your Board Confidence with AI & Live Vivas</h2>
                <p class="text-emerald-100 text-sm max-width-xl">
                    Subscribe to any package bundle via bKash Send Money. Admin verifies your Transaction ID (TrxID) and activates your credits immediately!
                </p>
            </div>
            <div class="bg-white/10 backdrop-blur-md p-4 rounded-xl border border-white/15 text-center min-w-[200px]">
                <div class="text-xs font-bold text-emerald-200 uppercase">Your Current Balance</div>
                <div class="text-3xl font-black text-white mt-1">{{ $user->ai_viva_credits }} Vivas</div>
                <div class="text-xs text-emerald-300 mt-1">Available for immediate practice</div>
            </div>
        </div>

        <!-- Available Package Cards Grid -->
        <div class="space-y-4">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-tags text-emerald-600"></i> Choose a Viva Package Bundle
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($packages as $pkg)
                    <div class="bg-white border {{ $pkg->type === 'live_human' ? 'border-indigo-300 shadow-md' : 'border-gray-200' }} rounded-2xl p-6 shadow-sm flex flex-col justify-between hover:border-emerald-500 transition relative overflow-hidden">
                        @if($pkg->credits == 25)
                            <div class="absolute top-0 right-0 bg-amber-500 text-white text-[10px] font-black uppercase px-3 py-1 rounded-bl-xl tracking-wider">
                                Most Popular
                            </div>
                        @elseif($pkg->type === 'live_human')
                            <div class="absolute top-0 right-0 bg-indigo-600 text-white text-[10px] font-black uppercase px-3 py-1 rounded-bl-xl tracking-wider">
                                1-on-1 Human Board
                            </div>
                        @endif

                        <div class="space-y-3">
                            <h4 class="text-lg font-bold text-gray-900">{{ $pkg->name }}</h4>
                            <div class="flex items-baseline gap-1">
                                <span class="text-3xl font-black text-emerald-700">৳{{ number_format($pkg->price_bdt, 0) }}</span>
                                <span class="text-xs text-gray-500 font-semibold">BDT</span>
                            </div>
                            
                            <div class="bg-gray-50 p-3 rounded-xl border border-gray-100 text-xs font-bold text-gray-700 flex items-center justify-between">
                                <span>Quota Granted:</span>
                                <span class="text-emerald-700 font-black">{{ $pkg->credits }} {{ $pkg->type === 'live_human' ? 'Live Session' : 'AI Vivas' }}</span>
                            </div>

                            <p class="text-gray-600 text-xs leading-relaxed">
                                {{ $pkg->description }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <button onclick="selectPackage('{{ $pkg->id }}', '{{ $pkg->name }}', '{{ $pkg->price_bdt }}')" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-2.5 rounded-xl transition flex items-center justify-center gap-2 shadow-sm">
                                <i class="fa-solid fa-cart-shopping"></i> Pay via bKash
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- bKash Send Money Instruction & Form Modal / Section -->
        <div id="payment-section" class="bg-white border border-emerald-200 rounded-2xl p-6 sm:p-8 shadow-sm grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left Column: Instructions -->
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold text-xl">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">How to Pay via bKash Send Money</h3>
                        <p class="text-xs text-gray-500">Follow these 3 simple steps to top-up credits</p>
                    </div>
                </div>

                <div class="bg-pink-50/70 border border-pink-200 rounded-xl p-4 space-y-2 text-xs text-gray-800">
                    <div class="font-bold text-pink-900 flex items-center gap-2">
                        <i class="fa-solid fa-1"></i> bKash Personal Number: <span class="text-sm font-black text-pink-700 select-all">{{ $personalBkash }}</span>
                    </div>
                    <div class="font-bold text-pink-900 flex items-center gap-2">
                        <i class="fa-solid fa-1"></i> bKash Merchant Number: <span class="text-sm font-black text-pink-700 select-all">{{ $merchantBkash }}</span>
                    </div>
                    <p class="pt-1 text-gray-600">
                        1. Open bKash App or Dial <strong>*247#</strong> and select <strong>Send Money</strong>.<br>
                        2. Send the package amount to the number above.<br>
                        3. Copy the 10-digit <strong>TrxID</strong> and submit in the form on the right!
                    </p>
                </div>
            </div>

            <!-- Right Column: Submission Form -->
            <form action="{{ route('candidate.payment.submit') }}" method="POST" class="space-y-4">
                @csrf
                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Submit bKash Payment Details</h4>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Selected Package</label>
                    <select name="package_id" id="package_id" class="w-full p-2.5 border border-gray-300 rounded-xl text-xs bg-gray-50 font-bold" required>
                        @foreach($packages as $pkg)
                            <option value="{{ $pkg->id }}">
                                {{ $pkg->name }} — ৳{{ number_format($pkg->price_bdt, 0) }} ({{ $pkg->credits }} Credits)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Your bKash Phone Number</label>
                        <input type="text" name="bkash_number" placeholder="01712345678" class="w-full p-2.5 border border-gray-300 rounded-xl text-xs" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">bKash Transaction ID (TrxID)</label>
                        <input type="text" name="trx_id" placeholder="e.g. 9B27X8KL9M" class="w-full p-2.5 border border-gray-300 rounded-xl text-xs font-mono font-bold uppercase" required>
                    </div>
                </div>

                <button type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold text-xs py-3 rounded-xl transition shadow-md flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Submit bKash TrxID for Admin Approval
                </button>
            </form>
        </div>

        <!-- Payment History Table -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm space-y-4">
            <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-emerald-600"></i> Your Payment Transactions History
            </h3>

            @if($transactions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-gray-200 text-gray-500 font-bold uppercase">
                                <th class="py-3 px-4">Package</th>
                                <th class="py-3 px-4">Amount</th>
                                <th class="py-3 px-4">bKash Number</th>
                                <th class="py-3 px-4">TrxID</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($transactions as $trx)
                                <tr>
                                    <td class="py-3.5 px-4 font-bold text-gray-900">{{ $trx->package?->name ?? 'N/A' }}</td>
                                    <td class="py-3.5 px-4 font-extrabold text-emerald-700">৳{{ number_format($trx->amount_bdt, 0) }}</td>
                                    <td class="py-3.5 px-4 font-mono text-gray-700">{{ $trx->bkash_number }}</td>
                                    <td class="py-3.5 px-4 font-mono font-bold text-indigo-700">{{ $trx->trx_id }}</td>
                                    <td class="py-3.5 px-4">
                                        @if($trx->status === 'approved')
                                            <span class="bg-emerald-100 text-emerald-800 font-bold px-2.5 py-1 rounded-full">
                                                <i class="fa-solid fa-check"></i> Approved & Granted
                                            </span>
                                        @elseif($trx->status === 'pending')
                                            <span class="bg-amber-100 text-amber-800 font-bold px-2.5 py-1 rounded-full">
                                                <i class="fa-solid fa-hourglass-half"></i> Under Admin Review
                                            </span>
                                        @else
                                            <span class="bg-rose-100 text-rose-800 font-bold px-2.5 py-1 rounded-full">
                                                <i class="fa-solid fa-xmark"></i> Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-500">{{ $trx->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-6 text-gray-500 text-xs">
                    No payment transactions submitted yet.
                </div>
            @endif
        </div>

    </main>

    <script>
        function selectPackage(id, name, price) {
            document.getElementById('package_id').value = id;
            document.getElementById('payment-section').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>
</html>
