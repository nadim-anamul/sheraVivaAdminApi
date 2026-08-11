@extends('layouts.app')

@section('title', 'Viva Preparation Guidelines & Rules | Shera Viva')

@section('content')
<div class="guidelines-container" style="max-width: 1100px; margin: 0 auto; padding-bottom: 50px;">
    
    <!-- Guidelines Header -->
    <div class="header-card" style="background: rgba(17, 24, 39, 0.6); border: 1px solid var(--border-glow); padding: 30px; border-radius: 16px; margin-bottom: 30px; text-align: center; backdrop-filter: blur(10px);">
        <i class="fa-solid fa-book-open-reader" style="font-size: 48px; color: var(--primary-emerald); margin-bottom: 16px;"></i>
        <h1 style="font-family: var(--font-display); font-size: 28px; font-weight: 800; color: #fff; margin-bottom: 10px;">Viva Guidelines & Rules</h1>
        <p style="color: var(--text-muted); max-width: 600px; margin: 0 auto; font-size: 14px; line-height: 1.5;">
            Master your oral board behavior, dress codes, guidelines, and behavioral Do's & Don'ts tailored for every government exam board in Bangladesh.
        </p>
    </div>

    <!-- Exam Type Tabs Filter -->
    <div class="tabs-container" style="display: flex; justify-content: center; gap: 12px; margin-bottom: 36px; flex-wrap: wrap;">
        <a href="/guidelines?exam_type=all" 
           style="text-decoration: none; padding: 10px 20px; border-radius: 30px; font-weight: 600; font-size: 13px; transition: all 0.2s; border: 1px solid {{ $examType === 'all' ? 'var(--primary-emerald)' : 'var(--border-glow)' }}; background: {{ $examType === 'all' ? 'var(--primary-emerald)' : 'rgba(255, 255, 255, 0.03)' }}; color: #fff;">
            <i class="fa-solid fa-list"></i> All Guidelines
        </a>
        <a href="/guidelines?exam_type=bcs" 
           style="text-decoration: none; padding: 10px 20px; border-radius: 30px; font-weight: 600; font-size: 13px; transition: all 0.2s; border: 1px solid {{ $examType === 'bcs' ? 'var(--primary-emerald)' : 'var(--border-glow)' }}; background: {{ $examType === 'bcs' ? 'var(--primary-emerald)' : 'rgba(255, 255, 255, 0.03)' }}; color: #fff;">
            <i class="fa-solid fa-gavel"></i> BCS Exams
        </a>
        <a href="/guidelines?exam_type=bank" 
           style="text-decoration: none; padding: 10px 20px; border-radius: 30px; font-weight: 600; font-size: 13px; transition: all 0.2s; border: 1px solid {{ $examType === 'bank' ? 'var(--primary-emerald)' : 'var(--border-glow)' }}; background: {{ $examType === 'bank' ? 'var(--primary-emerald)' : 'rgba(255, 255, 255, 0.03)' }}; color: #fff;">
            <i class="fa-solid fa-building-columns"></i> Bank Exams
        </a>
        <a href="/guidelines?exam_type=primary" 
           style="text-decoration: none; padding: 10px 20px; border-radius: 30px; font-weight: 600; font-size: 13px; transition: all 0.2s; border: 1px solid {{ $examType === 'primary' ? 'var(--primary-emerald)' : 'var(--border-glow)' }}; background: {{ $examType === 'primary' ? 'var(--primary-emerald)' : 'rgba(255, 255, 255, 0.03)' }}; color: #fff;">
            <i class="fa-solid fa-graduation-cap"></i> Primary Teacher Exams
        </a>
    </div>

    <!-- Main Content Layout Grid -->
    <div style="display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 30px;" class="guidelines-grid">
        
        <!-- Left Side: Viva Advice -->
        <div>
            <h2 style="font-family: var(--font-display); font-size: 20px; font-weight: 700; color: #fff; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-lightbulb" style="color: #F59E0B;"></i> Board Expert Advice
            </h2>
            
            @forelse($advices as $adv)
                <div style="background: rgba(17, 24, 39, 0.7); border: 1px solid var(--border-glow); border-radius: 12px; padding: 24px; margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <h3 style="font-size: 16px; font-weight: 700; color: #fff;">{{ $adv->title }}</h3>
                        <span style="font-size: 10px; font-weight: 700; text-transform: uppercase; padding: 4px 10px; border-radius: 20px; background: rgba(59, 130, 246, 0.15); color: #3B82F6;">
                            {{ $adv->category }}
                        </span>
                    </div>
                    
                    @if(!empty($adv->content))
                        <p style="font-size: 13px; color: var(--text-muted); line-height: 1.6; margin-bottom: 16px;">
                            {{ $adv->content }}
                        </p>
                    @endif

                    @if(!empty($adv->tips) && is_array($adv->tips))
                        <div style="background: rgba(255, 255, 255, 0.02); border-left: 3px solid var(--primary-emerald); padding: 12px 16px; border-radius: 0 8px 8px 0;">
                            <h4 style="font-size: 12px; font-weight: 700; color: var(--primary-emerald); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em;">Key Tips</h4>
                            <ul style="list-style: none; padding-left: 0; display: flex; flex-direction: column; gap: 6px;">
                                @foreach($adv->tips as $tip)
                                    <li style="font-size: 12px; color: var(--text-main); display: flex; align-items: flex-start; gap: 8px; line-height: 1.45;">
                                        <i class="fa-solid fa-check" style="color: var(--primary-emerald); font-size: 10px; margin-top: 3px;"></i>
                                        <span>{{ $tip }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @empty
                <div style="background: rgba(17, 24, 39, 0.3); border: 1px dashed var(--border-glow); border-radius: 12px; padding: 40px; text-align: center; color: var(--text-muted);">
                    <i class="fa-solid fa-folder-open" style="font-size: 32px; margin-bottom: 12px;"></i>
                    <p style="font-size: 13px;">No advice guidelines found for this exam type.</p>
                </div>
            @endforelse
        </div>

        <!-- Right Side: Viva Rules (Do's & Don'ts) -->
        <div>
            <h2 style="font-family: var(--font-display); font-size: 20px; font-weight: 700; color: #fff; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-shield-halved" style="color: var(--primary-emerald);"></i> Board Rules, Do's & Don'ts
            </h2>

            @forelse($rules as $rule)
                @php
                    $isDont = str_contains($rule->category, 'dont') || str_contains($rule->category, 'donts');
                    $isDo = str_contains($rule->category, 'do') && !$isDont;
                    
                    $borderColor = 'var(--border-glow)';
                    $accentColor = 'var(--text-muted)';
                    $icon = 'fa-circle-info';
                    
                    if ($isDo) {
                        $borderColor = 'rgba(16, 185, 129, 0.2)';
                        $accentColor = 'var(--primary-emerald)';
                        $icon = 'fa-circle-check';
                    } elseif ($isDont) {
                        $borderColor = 'rgba(239, 68, 68, 0.2)';
                        $accentColor = '#EF4444';
                        $icon = 'fa-circle-xmark';
                    }
                @endphp
                
                <div style="background: rgba(17, 24, 39, 0.7); border: 1px solid {{ $borderColor }}; border-radius: 12px; padding: 24px; margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <h3 style="font-size: 15px; font-weight: 700; color: #fff; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid {{ $icon }}" style="color: {{ $accentColor }};"></i>
                            {{ $rule->title }}
                        </h3>
                        <span style="font-size: 9px; font-weight: 700; text-transform: uppercase; padding: 2px 8px; border-radius: 4px; background: rgba(255, 255, 255, 0.05); color: var(--text-muted);">
                            {{ $rule->category }}
                        </span>
                    </div>

                    @if(!empty($rule->content))
                        <p style="font-size: 13px; color: var(--text-muted); line-height: 1.5; margin-bottom: 16px;">
                            {{ $rule->content }}
                        </p>
                    @endif

                    @if(!empty($rule->rules) && is_array($rule->rules))
                        <ul style="list-style: none; padding-left: 0; display: flex; flex-direction: column; gap: 8px;">
                            @foreach($rule->rules as $rl)
                                <li style="font-size: 12.5px; color: var(--text-main); display: flex; align-items: flex-start; gap: 10px; line-height: 1.45;">
                                    <i class="fa-solid fa-circle" style="color: {{ $accentColor }}; font-size: 5px; margin-top: 7px; flex-shrink: 0;"></i>
                                    <span>{{ $rl }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @empty
                <div style="background: rgba(17, 24, 39, 0.3); border: 1px dashed var(--border-glow); border-radius: 12px; padding: 40px; text-align: center; color: var(--text-muted);">
                    <i class="fa-solid fa-folder-open" style="font-size: 32px; margin-bottom: 12px;"></i>
                    <p style="font-size: 13px;">No rules guidelines found for this exam type.</p>
                </div>
            @endforelse
        </div>

    </div>

</div>

<style>
    @media (max-width: 768px) {
        .guidelines-grid {
            grid-template-columns: 1fr !important;
            gap: 20px !important;
        }
    }
</style>
@endsection
