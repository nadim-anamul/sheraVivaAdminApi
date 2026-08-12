@extends('layouts.app')

@section('title', 'Viva Preparation Guidelines & Rules | Shera Viva')

@section('content')
<div class="max-w-[1100px] mx-auto pb-12">
    
    <!-- Guidelines Header -->
    <div class="bg-[#111827]/60 border border-border-glow p-8 rounded-2xl mb-8 text-center backdrop-blur-md">
        <i class="fa-solid fa-book-open-reader text-5xl text-primary-emerald mb-4"></i>
        <h1 class="font-display text-2xl lg:text-3xl font-extrabold text-white mb-2.5">Viva Guidelines & Rules</h1>
        <p class="text-text-muted max-w-[600px] mx-auto text-sm leading-relaxed">
            Master your oral board behavior, dress codes, guidelines, and behavioral Do's & Don'ts tailored for every government exam board in Bangladesh.
        </p>
    </div>

    <!-- Exam Type Tabs Filter -->
    <div class="flex justify-center gap-3 mb-9 flex-wrap">
        <a href="/guidelines?exam_type=all" 
           class="text-xs lg:text-sm font-semibold py-2.5 px-5 rounded-full border transition-all duration-200 no-underline {{ $examType === 'all' ? 'bg-primary-emerald border-primary-emerald text-white shadow-md' : 'bg-white/3 border-border-glow text-white hover:bg-white/5 hover:border-white/12' }}">
            <i class="fa-solid fa-list"></i> All Guidelines
        </a>
        <a href="/guidelines?exam_type=bcs" 
           class="text-xs lg:text-sm font-semibold py-2.5 px-5 rounded-full border transition-all duration-200 no-underline {{ $examType === 'bcs' ? 'bg-primary-emerald border-primary-emerald text-white shadow-md' : 'bg-white/3 border-border-glow text-white hover:bg-white/5 hover:border-white/12' }}">
            <i class="fa-solid fa-gavel"></i> BCS Exams
        </a>
        <a href="/guidelines?exam_type=bank" 
           class="text-xs lg:text-sm font-semibold py-2.5 px-5 rounded-full border transition-all duration-200 no-underline {{ $examType === 'bank' ? 'bg-primary-emerald border-primary-emerald text-white shadow-md' : 'bg-white/3 border-border-glow text-white hover:bg-white/5 hover:border-white/12' }}">
            <i class="fa-solid fa-building-columns"></i> Bank Exams
        </a>
        <a href="/guidelines?exam_type=primary" 
           class="text-xs lg:text-sm font-semibold py-2.5 px-5 rounded-full border transition-all duration-200 no-underline {{ $examType === 'primary' ? 'bg-primary-emerald border-primary-emerald text-white shadow-md' : 'bg-white/3 border-border-glow text-white hover:bg-white/5 hover:border-white/12' }}">
            <i class="fa-solid fa-graduation-cap"></i> Primary Teacher Exams
        </a>
    </div>

    <!-- Main Content Layout Grid -->
    <div class="grid grid-cols-1 md:grid-cols-[1.1fr_0.9fr] gap-8">
        
        <!-- Left Side: Viva Advice -->
        <div>
            <h2 class="font-display text-lg lg:text-xl font-bold text-white mb-5 flex items-center gap-2.5">
                <i class="fa-solid fa-lightbulb text-accent-orange"></i> Board Expert Advice
            </h2>
            
            @forelse($advices as $adv)
                <div class="bg-[#111827]/70 border border-border-glow rounded-xl p-6 mb-5 backdrop-blur-sm">
                    <div class="flex justify-between items-start mb-3 gap-3">
                        <h3 class="text-base font-bold text-white">{{ $adv->title }}</h3>
                        <span class="text-[9px] font-extrabold uppercase py-1 px-2.5 rounded-full bg-accent-blue/15 text-accent-blue border border-accent-blue/20 tracking-wider shrink-0">
                            {{ $adv->category }}
                        </span>
                    </div>
                    
                    @if(!empty($adv->content))
                        <p class="text-xs lg:text-sm text-text-muted leading-relaxed mb-4">
                            {{ $adv->content }}
                        </p>
                    @endif

                    @if(!empty($adv->tips) && is_array($adv->tips))
                        <div class="bg-white/2 border-l-3 border-l-primary-emerald py-3 px-4 rounded-r-lg">
                            <h4 class="text-xs font-bold text-primary-emerald mb-2 uppercase tracking-wide">Key Tips</h4>
                            <ul class="list-none pl-0 flex flex-col gap-2 mb-0">
                                @foreach($adv->tips as $tip)
                                    <li class="text-xs lg:text-sm text-text-main flex items-start gap-2 leading-snug">
                                        <i class="fa-solid fa-check text-primary-emerald text-[10px] mt-1 shrink-0"></i>
                                        <span>{{ $tip }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-[#111827]/30 border border-dashed border-border-glow rounded-xl p-10 text-center text-text-muted">
                    <i class="fa-solid fa-folder-open text-3xl mb-3"></i>
                    <p class="text-xs">No advice guidelines found for this exam type.</p>
                </div>
            @endforelse
        </div>

        <!-- Right Side: Viva Rules (Do's & Don'ts) -->
        <div>
            <h2 class="font-display text-lg lg:text-xl font-bold text-white mb-5 flex items-center gap-2.5">
                <i class="fa-solid fa-shield-halved text-primary-emerald"></i> Board Rules, Do's & Don'ts
            </h2>

            @forelse($rules as $rule)
                @php
                    $isDont = str_contains($rule->category, 'dont') || str_contains($rule->category, 'donts');
                    $isDo = str_contains($rule->category, 'do') && !$isDont;
                    
                    $borderClass = 'border-border-glow';
                    $textAccentClass = 'text-text-muted';
                    $icon = 'fa-circle-info';
                    
                    if ($isDo) {
                        $borderClass = 'border-primary-emerald/20';
                        $textAccentClass = 'text-primary-emerald';
                        $icon = 'fa-circle-check';
                    } elseif ($isDont) {
                        $borderClass = 'border-red-500/20';
                        $textAccentClass = 'text-red-400';
                        $icon = 'fa-circle-xmark';
                    }
                @endphp
                
                <div class="bg-[#111827]/70 border {{ $borderClass }} rounded-xl p-6 mb-5 backdrop-blur-sm">
                    <div class="flex justify-between items-start mb-3 gap-3">
                        <h3 class="text-sm lg:text-base font-bold text-white flex items-center gap-2">
                            <i class="fa-solid {{ $icon }} {{ $textAccentClass }}"></i>
                            {{ $rule->title }}
                        </h3>
                        <span class="text-[9px] font-extrabold uppercase py-0.5 px-2 rounded bg-white/5 text-text-muted shrink-0 tracking-wide">
                            {{ $rule->category }}
                        </span>
                    </div>

                    @if(!empty($rule->content))
                        <p class="text-xs lg:text-sm text-text-muted leading-relaxed mb-4">
                            {{ $rule->content }}
                        </p>
                    @endif

                    @if(!empty($rule->rules) && is_array($rule->rules))
                        <ul class="list-none pl-0 flex flex-col gap-2.5 mb-0">
                            @foreach($rule->rules as $rl)
                                <li class="text-xs lg:text-sm text-text-main flex items-start gap-2.5 leading-snug">
                                    <i class="fa-solid fa-circle {{ $textAccentClass }} text-[5px] mt-2 shrink-0"></i>
                                    <span>{{ $rl }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @empty
                <div class="bg-[#111827]/30 border border-dashed border-border-glow rounded-xl p-10 text-center text-text-muted">
                    <i class="fa-solid fa-folder-open text-3xl mb-3"></i>
                    <p class="text-xs">No rules guidelines found for this exam type.</p>
                </div>
            @endforelse
        </div>

    </div>

</div>
@endsection
