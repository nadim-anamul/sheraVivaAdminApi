<x-filament-panels::page>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .search-container {
            background: #ffffff;
            border: 1px solid #E5E7EB;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            margin-bottom: 24px;
        }
        .dark .search-container {
            background: #111827;
            border-color: #1F2937;
        }

        .category-tabs {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 12px;
            margin-bottom: 16px;
            border-b: 1px solid #F3F4F6;
        }
        .dark .category-tabs {
            border-color: #1F2937;
        }

        .cat-tab {
            padding: 8px 16px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            border: 1px solid #E5E7EB;
            background: #F9FAFB;
            color: #4B5563;
            white-space: nowrap;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .dark .cat-tab {
            background: #1F2937;
            border-color: #374151;
            color: #D1D5DB;
        }
        .cat-tab:hover {
            border-color: #F59E0B;
            color: #D97706;
        }
        .cat-tab.active {
            background: #F59E0B;
            border-color: #D97706;
            color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
        }

        .search-row {
            display: flex;
            gap: 16px;
            align-items: center;
        }
        @media (max-width: 640px) {
            .search-row {
                flex-direction: column;
                align-items: stretch;
            }
        }

        .search-input {
            flex-grow: 1;
            padding: 12px 16px;
            border: 1px solid #D1D5DB;
            border-radius: 8px;
            font-size: 14px;
            background: #F9FAFB;
            color: #111827;
            transition: all 0.2s;
        }
        .dark .search-input {
            background: #1F2937;
            border-color: #374151;
            color: #ffffff;
        }
        .search-input:focus {
            outline: none;
            border-color: #F59E0B;
            ring: 2px solid rgba(245, 158, 11, 0.2);
        }

        .search-btn {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            color: #ffffff;
            font-weight: 700;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 10px rgba(245, 158, 11, 0.2);
        }
        .search-btn:hover {
            opacity: 0.95;
            transform: translateY(-1px);
        }
        .search-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .log-display {
            font-family: monospace;
            font-size: 13px;
            color: #D97706;
            background: rgba(245, 158, 11, 0.05);
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid rgba(245, 158, 11, 0.2);
            margin-top: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .dark .log-display {
            background: rgba(245, 158, 11, 0.02);
        }

        .jobs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 20px;
            margin-top: 24px;
        }

        .job-card {
            background: #ffffff;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.2s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .dark .job-card {
            background: #111827;
            border-color: #1F2937;
        }
        .job-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }
        .job-card.imported {
            border-color: #10B981;
            background: rgba(16, 185, 129, 0.01);
        }
        .dark .job-card.imported {
            border-color: #064E3B;
            background: rgba(6, 78, 59, 0.02);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
            gap: 8px;
        }

        .type-badge {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 4px 8px;
            border-radius: 9999px;
        }
        .type-circular {
            background: rgba(59, 130, 246, 0.1);
            color: #3B82F6;
        }
        .type-result {
            background: rgba(16, 185, 129, 0.1);
            color: #10B981;
        }

        .form-group {
            margin-bottom: 12px;
        }
        .form-label {
            font-size: 11px;
            font-weight: 700;
            color: #6B7280;
            text-transform: uppercase;
            margin-bottom: 4px;
            display: block;
        }
        .dark .form-label {
            color: #9CA3AF;
        }

        .field-input {
            width: 100%;
            padding: 6px 10px;
            font-size: 13px;
            border: 1px solid #D1D5DB;
            border-radius: 6px;
            background: #ffffff;
            color: #111827;
        }
        .dark .field-input {
            background: #1F2937;
            border-color: #374151;
            color: #ffffff;
        }
        .field-input:focus {
            outline: none;
            border-color: #F59E0B;
        }

        .card-actions {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid #E5E7EB;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }
        .dark .card-actions {
            border-color: #1F2937;
        }

        .import-btn {
            background: #10B981;
            color: white;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .import-btn:hover {
            background: #059669;
        }
        .import-btn:disabled {
            background: #9CA3AF;
            cursor: not-allowed;
        }

        .preview-link {
            font-size: 13px;
            color: #6B7280;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .preview-link:hover {
            color: #374151;
            text-decoration: underline;
        }
        .dark .preview-link {
            color: #9CA3AF;
        }
        .dark .preview-link:hover {
            color: #D1D5DB;
        }

        .pulse-circle {
            width: 8px;
            height: 8px;
            background-color: #D97706;
            border-radius: 50%;
            display: inline-block;
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(217, 119, 6, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(217, 119, 6, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(217, 119, 6, 0); }
        }

        .skeleton-card {
            border: 1px dashed #D1D5DB;
            border-radius: 12px;
            padding: 24px;
            background: rgba(229, 231, 235, 0.1);
            text-align: center;
            height: 250px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .dark .skeleton-card {
            border-color: #374151;
            background: rgba(55, 65, 81, 0.05);
        }
        
        .empty-state {
            background: #ffffff;
            border: 1px solid #E5E7EB;
            border-radius: 16px;
            padding: 48px;
            text-align: center;
            color: #6B7280;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            margin-top: 24px;
        }
        .dark .empty-state {
            background: #111827;
            border-color: #1F2937;
        }
    </style>

    <!-- Session Alert Banners -->
    @if(session()->has('success'))
        <div style="background: #10B981; color: white; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif
    @if(session()->has('error'))
        <div style="background: #EF4444; color: white; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Search & Sector Filter Panel -->
    <div class="search-container">
        
        <!-- Category Filter Tabs -->
        <div class="category-tabs">
            <button wire:click="selectCategory('all')" class="cat-tab {{ $selectedCategory === 'all' ? 'active' : '' }}">
                <i class="fa-solid fa-globe"></i> All Job Circulars
            </button>
            <button wire:click="selectCategory('bcs')" class="cat-tab {{ $selectedCategory === 'bcs' ? 'active' : '' }}">
                <i class="fa-solid fa-gavel"></i> BPSC & BCS
            </button>
            <button wire:click="selectCategory('bank')" class="cat-tab {{ $selectedCategory === 'bank' ? 'active' : '' }}">
                <i class="fa-solid fa-building-columns"></i> Bangladesh Bank & Govt Banks
            </button>
            <button wire:click="selectCategory('pvt_bank')" class="cat-tab {{ $selectedCategory === 'pvt_bank' ? 'active' : '' }}">
                <i class="fa-solid fa-credit-card"></i> Private Banks (MTO/PO)
            </button>
            <button wire:click="selectCategory('corporate')" class="cat-tab {{ $selectedCategory === 'corporate' ? 'active' : '' }}">
                <i class="fa-solid fa-building"></i> Big Corporate & MNCs
            </button>
            <button wire:click="selectCategory('primary')" class="cat-tab {{ $selectedCategory === 'primary' ? 'active' : '' }}">
                <i class="fa-solid fa-school"></i> Primary Assistant Teacher
            </button>
            <button wire:click="selectCategory('defence')" class="cat-tab {{ $selectedCategory === 'defence' ? 'active' : '' }}">
                <i class="fa-solid fa-shield-halved"></i> Defence, Police & NSI
            </button>
            <button wire:click="selectCategory('ministry')" class="cat-tab {{ $selectedCategory === 'ministry' ? 'active' : '' }}">
                <i class="fa-solid fa-landmark"></i> Ministries & ACC
            </button>
        </div>

        <!-- Live Search Row -->
        <div class="search-row">
            <input 
                type="text" 
                wire:model="searchQuery" 
                class="search-input" 
                placeholder="Type specific job title or leave blank to auto-discover all active circulars..."
                wire:keydown.enter="searchJobs"
            >
            <button wire:click="searchJobs" class="search-btn" wire:loading.attr="disabled" wire:target="searchJobs">
                <span wire:loading.remove wire:target="searchJobs">
                    <i class="fa-solid fa-magnifying-glass"></i> Deep Scan Portals
                </span>
                <span wire:loading wire:target="searchJobs">
                    <i class="fa-solid fa-spinner animate-spin"></i> Scanning BD Portals...
                </span>
            </button>
        </div>

        @if($isSearching)
            <div class="log-display">
                <span class="pulse-circle"></span>
                <span>{{ $statusMessage }}</span>
            </div>
        @elseif($statusMessage)
            <div style="font-size: 14px; margin-top: 12px; color: #10B981; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-circle-check"></i> {{ $statusMessage }}
            </div>
        @endif
    </div>

    <!-- Bulk Import Control -->
    @if(count($discoveredJobs) > 0 && !$isSearching)
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 16px; background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.2); padding: 16px; border-radius: 12px;">
            <div>
                <h4 style="font-size: 15px; font-weight: 800; color: #047857;" class="dark:text-emerald-400">
                    Discovered {{ count($discoveredJobs) }} Official Bangladesh Govt Circulars
                </h4>
                <p style="font-size: 13px; color: #6B7280;" class="dark:text-gray-400">Review or edit details below, then import them directly to Job Updates & Candidate Library.</p>
            </div>
            <button 
                wire:click="importAll" 
                wire:loading.attr="disabled"
                wire:target="importAll"
                class="import-btn"
                style="background: #047857;"
                @if(count($importedIndices) === count($discoveredJobs)) disabled @endif
            >
                <span wire:loading.remove wire:target="importAll">
                    <i class="fa-solid fa-cloud-arrow-down"></i> Import All Discovered Circulars
                </span>
                <span wire:loading wire:target="importAll" style="display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-spinner fa-spin"></i> Saving Circulars to Database...
                </span>
            </button>
        </div>
    @endif

    <!-- Main Results Interface -->
    @if($isSearching)
        <div class="jobs-grid">
            @for($i = 0; $i < 6; $i++)
                <div class="skeleton-card">
                    <i class="fa-solid fa-circle-notch animate-spin" style="font-size: 32px; color: #F59E0B; margin-bottom: 12px;"></i>
                    <p style="font-size: 14px; color: #6B7280; font-weight: 600;">Scanning bpsc.gov.bd, erecruitment.bb.org.bd, dpe.gov.bd...</p>
                </div>
            @endfor
        </div>
    @elseif(count($discoveredJobs) > 0)
        <div class="jobs-grid">
            @foreach($discoveredJobs as $index => $job)
                @php
                    $isImported = in_array($index, $importedIndices);
                @endphp
                <div class="job-card {{ $isImported ? 'imported' : '' }}">
                    <div>
                        <!-- Card Header -->
                        <div class="card-header">
                            <span class="type-badge {{ ($job['type'] ?? 'circular') === 'circular' ? 'type-circular' : 'type-result' }}">
                                {{ $job['type'] ?? 'circular' }}
                            </span>
                            @if($isImported)
                                <span style="font-size: 11px; font-weight: 700; color: #10B981; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fa-solid fa-check-double"></i> IMPORTED
                                </span>
                            @endif
                        </div>

                        <!-- Editable Fields -->
                        <div class="form-group">
                            <label class="form-label">Job Post / Notice Title</label>
                            <input 
                                type="text" 
                                wire:model="discoveredJobs.{{ $index }}.title" 
                                class="field-input" 
                                @if($isImported) disabled @endif
                            >
                        </div>

                        <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                            <div>
                                <label class="form-label">Organization</label>
                                <input 
                                    type="text" 
                                    wire:model="discoveredJobs.{{ $index }}.organization" 
                                    class="field-input" 
                                    @if($isImported) disabled @endif
                                >
                            </div>
                            <div>
                                <label class="form-label">Notice Type</label>
                                <select 
                                    wire:model="discoveredJobs.{{ $index }}.type" 
                                    class="field-input" 
                                    @if($isImported) disabled @endif
                                >
                                    <option value="circular">Circular</option>
                                    <option value="result">Result</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                            <div>
                                <label class="form-label">Publish Date</label>
                                <input 
                                    type="date" 
                                    wire:model="discoveredJobs.{{ $index }}.published_date" 
                                    class="field-input" 
                                    @if($isImported) disabled @endif
                                >
                            </div>
                            <div>
                                <label class="form-label">File Size</label>
                                <input 
                                    type="text" 
                                    wire:model="discoveredJobs.{{ $index }}.file_size" 
                                    class="field-input" 
                                    @if($isImported) disabled @endif
                                >
                            </div>
                        </div>

                        <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                            <div>
                                <label class="form-label">Vacancies</label>
                                <input 
                                    type="text" 
                                    wire:model="discoveredJobs.{{ $index }}.vacancies" 
                                    class="field-input" 
                                    placeholder="e.g. ১০২৬ টি পদ"
                                    @if($isImported) disabled @endif
                                >
                            </div>
                            <div>
                                <label class="form-label">Apply Deadline</label>
                                <input 
                                    type="date" 
                                    wire:model="discoveredJobs.{{ $index }}.application_deadline" 
                                    class="field-input" 
                                    @if($isImported) disabled @endif
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Required Qualifications</label>
                            <input 
                                type="text" 
                                wire:model="discoveredJobs.{{ $index }}.qualifications" 
                                class="field-input" 
                                placeholder="e.g. স্নাতক ডিগ্রি"
                                @if($isImported) disabled @endif
                            >
                        </div>

                        <div class="form-group">
                            <label class="form-label">Notice/Result Summary</label>
                            <textarea 
                                wire:model="discoveredJobs.{{ $index }}.description" 
                                class="field-input" 
                                rows="2" 
                                placeholder="Summary context..."
                                style="resize: vertical;"
                                @if($isImported) disabled @endif
                            ></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Circular/PDF URL</label>
                            <input 
                                type="text" 
                                wire:model="discoveredJobs.{{ $index }}.file_url" 
                                class="field-input" 
                                @if($isImported) disabled @endif
                            >
                        </div>
                    </div>

                    <!-- Card Actions -->
                    <div class="card-actions">
                        @if(!empty($job['file_url']))
                            <a href="{{ $job['file_url'] }}" target="_blank" class="preview-link">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i> Open Official PDF
                            </a>
                        @else
                            <span></span>
                        @endif

                        <button 
                            wire:click="importJob({{ $index }})" 
                            wire:loading.attr="disabled"
                            wire:target="importJob({{ $index }})"
                            class="import-btn"
                            @if($isImported) disabled @endif
                        >
                            <span wire:loading.remove wire:target="importJob({{ $index }})">
                                @if($isImported)
                                    <i class="fa-solid fa-check"></i> Saved
                                @else
                                    <i class="fa-solid fa-floppy-disk"></i> Save & Import
                                @endif
                            </span>
                            <span wire:loading wire:target="importJob({{ $index }})" style="display: inline-flex; align-items: center; gap: 4px;">
                                <i class="fa-solid fa-spinner fa-spin"></i> Saving...
                            </span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Welcome / Empty State -->
        <div class="empty-state">
            <i class="fa-solid fa-wand-magic-sparkles" style="font-size: 56px; color: #F59E0B; margin-bottom: 16px; opacity: 0.8;"></i>
            <h3 style="font-size: 18px; font-weight: 800; color: #1F2937;" class="dark:text-white">AI Bangladesh Govt Job Discovery Engine</h3>
            <p style="font-size: 14px; margin-top: 8px; max-width: 520px; margin-left: auto; margin-right: auto; line-height: 1.6;">
                Click any sector tab above (<strong>BPSC & BCS</strong>, <strong>Bangladesh Bank</strong>, <strong>Primary Teacher</strong>, <strong>Defence/NSI</strong>, or <strong>Ministries</strong>) or click <strong>Deep Scan Portals</strong> to discover live government job circulars published across Bangladesh.
            </p>
        </div>
    @endif
</x-filament-panels::page>
