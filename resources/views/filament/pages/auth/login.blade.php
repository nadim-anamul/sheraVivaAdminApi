<div class="auth-card">
    <h2>Admin & Examiner Portal</h2>
    <p class="subtitle">Enter your credentials to access the examiner dashboards and database.</p>

    @if (session()->has('error'))
        <div class="alert-error">
            <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="authenticate" class="space-y-6 mt-6">
        {{ $this->form }}

        <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; margin-top: 20px; padding: 12px 20px; font-weight: 600;">
            Sign In to Panel <i class="fa-solid fa-right-to-bracket ml-2"></i>
        </button>
    </form>
</div>
