@extends('layouts.app')

@section('title', 'Question Bank & Experience Library | Shera Viva')

@section('content')
<div class="max-w-[1200px] mx-auto px-6 py-10 w-full">
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="font-display text-2xl lg:text-3xl font-extrabold text-white mb-2">Question Bank & Experience Library</h1>
        <p class="text-text-muted text-sm">Browse authentic Bangladesh job viva board transcripts, advice, and board rules.</p>
    </div>
    <div>
        <a href="/viva/practice" class="btn-primary">
            <i class="fa-solid fa-robot"></i> Practice AI Viva
        </a>
    </div>
</div>

<!-- Tabs selector -->
<div class="flex gap-2.5 mb-8 border-b border-white/5 pb-3 overflow-x-auto">
    <a href="/library?exam_type=BCS" class="text-xs lg:text-sm font-semibold py-2 px-4 rounded-lg transition-all no-underline shrink-0 {{ $examType === 'BCS' ? 'bg-primary-emerald/15 text-primary-emerald' : 'text-text-muted hover:bg-white/5 hover:text-white' }}">
        BCS Viva Bank
    </a>
    <a href="/library?exam_type=Bank" class="text-xs lg:text-sm font-semibold py-2 px-4 rounded-lg transition-all no-underline shrink-0 {{ $examType === 'Bank' ? 'bg-primary-emerald/15 text-primary-emerald' : 'text-text-muted hover:bg-white/5 hover:text-white' }}">
        Bank AD Bank
    </a>
    <a href="/library?exam_type=Primary" class="text-xs lg:text-sm font-semibold py-2 px-4 rounded-lg transition-all no-underline shrink-0 {{ $examType === 'Primary' ? 'bg-primary-emerald/15 text-primary-emerald' : 'text-text-muted hover:bg-white/5 hover:text-white' }}">
        Primary Teacher Bank
    </a>
    <a href="/library?exam_type=All" class="text-xs lg:text-sm font-semibold py-2 px-4 rounded-lg transition-all no-underline shrink-0 {{ $examType === 'All' ? 'bg-primary-emerald/15 text-primary-emerald' : 'text-text-muted hover:bg-white/5 hover:text-white' }}">
        All Question Banks
    </a>
</div>

<!-- Question Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
    @forelse($items as $item)
        <div class="bg-bg-card border border-border-glow rounded-2xl p-5 flex flex-col gap-3.5 backdrop-blur-md">
            <span class="bg-primary-emerald/15 text-primary-emerald px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wide self-start">
                {{ $item->exam_type }} {{ $item->edition }}
            </span>
            
            <div class="text-base font-bold text-white leading-snug">
                {{ $item->title }}
            </div>
            
            <div class="flex flex-wrap gap-4 text-xs text-text-muted mt-0.5">
                @if($item->subject) 
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-book text-primary-emerald"></i> {{ $item->subject }}</span> 
                @endif
                @if($item->board) 
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-user-tie text-primary-emerald"></i> {{ Str::limit($item->board, 25) }}</span> 
                @endif
            </div>

            @if(!empty($item->transcript) && is_array($item->transcript))
                <div class="bg-black/25 border border-border-glow rounded-xl p-3.5 text-xs text-gray-300 max-h-[180px] overflow-y-auto mt-2">
                    @foreach(array_slice($item->transcript, 0, 4) as $qa)
                        <div class="mb-2 last:mb-0">
                            <span class="font-bold text-[10px] uppercase text-primary-emerald tracking-wide">{{ $qa['speaker'] ?? 'Board' }}:</span>
                            <span class="leading-relaxed">{{ Str::limit($qa['text'] ?? '', 100) }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @empty
        <div class="col-span-full text-center text-text-muted py-10 bg-bg-card border border-dashed border-border-glow rounded-2xl">
            No viva experiences found for this category.
        </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $items->appends(['exam_type' => $examType])->links() }}
</div>
</div>
@endsection
