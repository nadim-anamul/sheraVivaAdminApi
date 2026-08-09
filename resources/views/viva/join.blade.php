@extends('layouts.app')

@section('title', 'Join Meeting | Shera Viva')

@section('content')
<div class="auth-card" style="max-width: 500px; margin-top: 60px;">
    <h2>Join Live Viva Board</h2>
    <p class="subtitle">Enter the unique Google Meet-style meeting code generated for your viva slot to connect via secure LiveKit WebRTC.</p>

    @if($errors->any())
        <div class="alert-error">
            <i class="fa-solid fa-triangle-exclamation"></i> {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('viva.join.handle') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="meeting_code">Meeting Code</label>
            <input type="text" id="meeting_code" name="meeting_code" placeholder="e.g. vva-abcd-xyz" required value="{{ old('meeting_code') }}" style="text-align: center; font-family: monospace; font-size: 16px; letter-spacing: 0.05em;">
            <p style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">Meeting codes are sent to your dashboard and mobile notifications upon successful slot booking.</p>
        </div>

        <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 12px 20px; font-size: 15px; margin-top: 10px;">
            <i class="fa-solid fa-video"></i> Connect to Meeting
        </button>
    </form>

    <div class="auth-footer" style="margin-top: 30px; border-top: 1px solid var(--border-glow); padding-top: 20px;">
        <p>Not ready yet? <a href="{{ route('dashboard') }}">Go to Dashboard</a></p>
    </div>
</div>
@endsection
