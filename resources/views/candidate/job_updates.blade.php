@extends('layouts.app')

@section('title', 'Job Circulars & Results | Shera Viva')

@section('content')
<div class="max-w-[1200px] mx-auto px-6 py-10 w-full">
<!-- Circulars -->
<h2 class="font-display text-xl lg:text-2xl font-bold text-white mb-5 flex items-center gap-2.5">
    <i class="fa-solid fa-briefcase text-primary-emerald"></i> Latest Job Circulars
</h2>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-10">
    @foreach($circulars as $circ)
        <div class="bg-bg-card border border-border-glow rounded-2xl p-5 flex flex-col gap-3.5 backdrop-blur-md">
            <span class="bg-accent-blue/15 text-accent-blue px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase self-start tracking-wide">
                {{ $circ->organization }}
            </span>
            <div class="text-base font-bold text-white leading-snug">
                {{ $circ->title }}
            </div>
            <div class="text-xs text-text-muted mt-auto mb-1">
                Published: {{ $circ->published_date?->format('d M, Y') }}
            </div>
            <a href="{{ $circ->file_url }}" target="_blank" class="btn-secondary w-full justify-center hover:bg-primary-emerald hover:border-primary-emerald hover:text-white transition-all duration-200">
                <i class="fa-solid fa-download"></i> Download PDF ({{ $circ->file_size }})
            </a>
        </div>
    @endforeach
</div>

<!-- Results -->
<h2 class="font-display text-xl lg:text-2xl font-bold text-white mb-5 flex items-center gap-2.5">
    <i class="fa-solid fa-award text-accent-orange"></i> Exam Results & Recommendation Lists
</h2>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
    @foreach($results as $res)
        <div class="bg-bg-card border border-border-glow rounded-2xl p-5 flex flex-col gap-3.5 backdrop-blur-md">
            <span class="bg-accent-orange/15 text-accent-orange px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase self-start tracking-wide">
                {{ $res->organization }}
            </span>
            <div class="text-base font-bold text-white leading-snug">
                {{ $res->title }}
            </div>
            <div class="text-xs text-text-muted mt-auto mb-1">
                Published: {{ $res->published_date?->format('d M, Y') }}
            </div>
            <a href="{{ $res->file_url }}" target="_blank" class="btn-secondary w-full justify-center hover:bg-primary-emerald hover:border-primary-emerald hover:text-white transition-all duration-200">
                <i class="fa-solid fa-file-pdf"></i> View Result Sheet ({{ $res->file_size }})
            </a>
        </div>
    @endforeach
</div>
</div>
@endsection
