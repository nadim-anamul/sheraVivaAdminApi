@extends('layouts.app')

@section('title', 'Question Bank & Experience Library | Shera Viva')

@section('content')
<div class="max-w-[1200px] mx-auto px-6 py-10 w-full">
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="font-display text-2xl lg:text-3xl font-extrabold text-white mb-2">Question Bank & Board Experience Library</h1>
        <p class="text-text-muted text-sm">Browse 120+ authentic Bangladesh job viva board transcripts, cadre choices, and board Q&A.</p>
    </div>
    <div>
        <a href="/dashboard/ai-simulator" class="btn-primary">
            <i class="fa-solid fa-play"></i> Practice AI Viva
        </a>
    </div>
</div>

<!-- Search & Filter Controls -->
<div class="bg-bg-card border border-border-glow p-4 rounded-2xl mb-8 flex flex-col sm:flex-row justify-between items-center gap-4">
    <!-- Filter Tabs -->
    <div class="flex gap-2 border-b sm:border-b-0 border-white/5 pb-2 sm:pb-0 overflow-x-auto w-full sm:w-auto">
        <a href="/library?exam_type=BCS" class="text-xs font-bold py-2 px-3.5 rounded-lg transition-all no-underline shrink-0 {{ $examType === 'BCS' ? 'bg-primary-emerald text-white' : 'text-text-muted hover:bg-white/5 hover:text-white' }}">
            BCS Board Bank
        </a>
        <a href="/library?exam_type=Bank" class="text-xs font-bold py-2 px-3.5 rounded-lg transition-all no-underline shrink-0 {{ $examType === 'Bank' ? 'bg-primary-emerald text-white' : 'text-text-muted hover:bg-white/5 hover:text-white' }}">
            Bank AD Bank
        </a>
        <a href="/library?exam_type=Primary" class="text-xs font-bold py-2 px-3.5 rounded-lg transition-all no-underline shrink-0 {{ $examType === 'Primary' ? 'bg-primary-emerald text-white' : 'text-text-muted hover:bg-white/5 hover:text-white' }}">
            Primary Teacher Bank
        </a>
        <a href="/library?exam_type=All" class="text-xs font-bold py-2 px-3.5 rounded-lg transition-all no-underline shrink-0 {{ $examType === 'All' ? 'bg-primary-emerald text-white' : 'text-text-muted hover:bg-white/5 hover:text-white' }}">
            All Question Banks
        </a>
    </div>

    <!-- Search Input -->
    <form action="/library" method="GET" class="w-full sm:w-72 flex items-center gap-2 bg-black/20 border border-white/10 rounded-xl px-3 py-1.5">
        <input type="hidden" name="exam_type" value="{{ $examType }}">
        <i class="fa-solid fa-magnifying-glass text-text-muted text-xs"></i>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by subject, board..." class="w-full bg-transparent border-none text-xs text-white outline-none">
        <button type="submit" class="hidden"></button>
    </form>
</div>

<!-- Question Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
    @forelse($items as $item)
        <div class="bg-bg-card border border-border-glow rounded-2xl p-5 flex flex-col justify-between gap-4 backdrop-blur-md hover:border-primary-emerald/40 transition">
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="bg-primary-emerald/15 text-primary-emerald px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wide">
                        {{ $item->exam_type }} {{ $item->edition }}
                    </span>
                    @if($item->result)
                        <span class="text-[10px] font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full border border-emerald-500/20">
                            {{ $item->result }}
                        </span>
                    @endif
                </div>
                
                <h3 class="text-base font-bold text-white leading-snug">
                    <a href="/library/{{ $item->id }}" class="hover:text-primary-emerald transition text-white no-underline">
                        {{ $item->title }}
                    </a>
                </h3>
                
                <div class="flex flex-wrap gap-3 text-xs text-text-muted">
                    @if($item->subject) 
                        <span class="flex items-center gap-1.5"><i class="fa-solid fa-book text-primary-emerald"></i> {{ $item->subject }}</span> 
                    @endif
                    @if($item->board) 
                        <span class="flex items-center gap-1.5"><i class="fa-solid fa-user-tie text-primary-emerald"></i> {{ Str::limit($item->board, 22) }}</span> 
                    @endif
                </div>
            </div>

            <div class="pt-3 border-t border-white/5">
                <a href="/library/{{ $item->id }}" class="w-full bg-white/5 hover:bg-white/10 text-emerald-400 border border-white/10 font-bold text-xs py-2 px-3 rounded-xl transition flex items-center justify-center gap-2 no-underline">
                    <i class="fa-solid fa-eye"></i> Read Full Transcript & Q&A &rarr;
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center text-text-muted py-12 bg-bg-card border border-dashed border-border-glow rounded-2xl">
            No viva experiences found matching your filter criteria.
        </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $items->appends(['exam_type' => $examType, 'search' => request('search')])->links() }}
</div>
</div>
@endsection
