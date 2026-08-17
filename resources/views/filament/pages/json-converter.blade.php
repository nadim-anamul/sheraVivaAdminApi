<x-filament-panels::page>
    <style>
        .converter-card {
            background: #ffffff;
            border: 1px solid #E5E7EB;
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
        }

        .dark .converter-card {
            background: #111827;
            border-color: #1F2937;
            box-shadow: none;
        }

        .dropzone-box {
            border: 2px dashed #10B981;
            background: #F0FDF4;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .dark .dropzone-box {
            background: rgba(16, 185, 129, 0.05);
            border-color: #059669;
        }

        .dropzone-box:hover {
            border-color: #059669;
            background: #DCFCE7;
        }

        .dark .dropzone-box:hover {
            background: rgba(16, 185, 129, 0.1);
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #374151;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .dark .form-label {
            color: #D1D5DB;
        }

        .form-select, .form-textarea {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #D1D5DB;
            background: #F9FAFB;
            color: #111827;
            font-size: 14px;
            outline: none;
            transition: all 0.2s ease;
        }

        .dark .form-select, .dark .form-textarea {
            background: #1F2937;
            border-color: #374151;
            color: #F9FAFB;
        }

        .form-select:focus, .form-textarea:focus {
            border-color: #10B981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
        }

        .btn-emerald {
            background: linear-gradient(135deg, #059669 0%, #10B981 100%);
            color: #ffffff;
            border: none;
            padding: 14px 24px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
            transition: all 0.2s ease;
        }

        .btn-emerald:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.35);
        }

        .btn-indigo {
            background: linear-gradient(135deg, #4F46E5 0%, #3B82F6 100%);
            color: #ffffff;
            border: none;
            padding: 14px 24px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
            transition: all 0.2s ease;
        }

        .btn-indigo:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        }

        .status-alert {
            padding: 16px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .status-success {
            background: #ECFDF5;
            border: 1px solid #10B981;
            color: #047857;
        }

        .dark .status-success {
            background: rgba(16, 185, 129, 0.15);
            border-color: #10B981;
            color: #34D399;
        }

        .progress-bar-bg {
            width: 100%;
            height: 10px;
            background: #E5E7EB;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 8px;
        }

        .dark .progress-bar-bg {
            background: #374151;
        }

        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #10B981 0%, #059669 100%);
            transition: width 0.3s ease;
        }
    </style>

    <div 
        x-data="{
            filesQueue: [],
            isBatchRunning: false,
            currentIndex: 0,
            progressPercent: 0,

            handleFileSelect(event) {
                this.filesQueue = Array.from(event.target.files);
            },

            async startBatchUpload() {
                if (this.filesQueue.length === 0) return;
                this.isBatchRunning = true;
                this.currentIndex = 0;
                this.progressPercent = 0;

                await $wire.startBatchQueue(this.filesQueue.length);

                for (let i = 0; i < this.filesQueue.length; i++) {
                    this.currentIndex = i + 1;
                    this.progressPercent = Math.round((this.currentIndex / this.filesQueue.length) * 100);
                    const currentFile = this.filesQueue[i];

                    await new Promise((resolve) => {
                        $wire.upload('singleFile', currentFile, async () => {
                            await $wire.processSingleFile(i + 1, this.filesQueue.length);
                            resolve();
                        }, (error) => {
                            console.error('Upload error for ' + currentFile.name, error);
                            resolve();
                        });
                    });
                }

                this.isBatchRunning = false;
                this.filesQueue = [];
            }
        }"
        style="display: flex; flex-direction: column; gap: 24px;"
    >
        
        <!-- Header Hero Banner -->
        <div style="background: linear-gradient(135deg, #065F46 0%, #1E40AF 100%); padding: 28px; border-radius: 16px; color: #ffffff; box-shadow: 0 10px 25px rgba(6, 95, 70, 0.15);">
            <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 10px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                </div>
                <div>
                    <h2 style="font-size: 22px; font-weight: 800; line-height: 1.2;">
                        Sequential Multi-Document Viva JSON Converter
                    </h2>
                    <p style="font-size: 14px; opacity: 0.9; margin-top: 2px;">
                        Powered by <strong>Google Gemini 3.5 Flash AI</strong>. Upload single or 100+ PDF/Doc files without size limits.
                    </p>
                </div>
            </div>
        </div>

        <!-- Sequential Batch Upload Progress Banner -->
        <template x-if="isBatchRunning">
            <div style="background: #EFF6FF; border: 1px solid #3B82F6; color: #1E40AF; padding: 20px; border-radius: 12px;" class="dark:bg-blue-950/40 dark:border-blue-500 dark:text-blue-200">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <div style="font-weight: 800; font-size: 16px; display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-spinner fa-spin" style="font-size: 20px; color: #3B82F6;"></i>
                        <span>Processing File <span x-text="currentIndex"></span> of <span x-text="filesQueue.length"></span></span>
                    </div>
                    <div style="font-weight: 800; font-size: 15px;" x-text="progressPercent + '%'"></div>
                </div>
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill" :style="'width: ' + progressPercent + '%'"></div>
                </div>
                <div style="font-size: 13px; opacity: 0.85; margin-top: 8px;">
                    Uploading & converting items sequentially with Gemini 3.5 Flash and storing into Database...
                </div>
            </div>
        </template>

        <!-- Status Message Alert -->
        @if($statusMessage && !$isProcessing)
            <div class="status-alert status-success">
                <i class="fa-solid fa-circle-check" style="font-size: 20px;"></i>
                <span>{{ $statusMessage }}</span>
            </div>
        @endif

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 24px;">
            
            <!-- Option 1: Multi-File Batch Dropzone Box -->
            <div class="converter-card" style="display: flex; flex-direction: column; gap: 20px;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <h3 style="font-size: 17px; font-weight: 800; color: #10B981; display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-folder-open"></i> Sequential Batch Upload
                    </h3>
                    <span style="background: rgba(16, 185, 129, 0.1); color: #10B981; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px; text-transform: uppercase;">
                        Unlimited Files
                    </span>
                </div>

                <div>
                    <label class="form-label">Target Question Bank Category</label>
                    <select wire:model="examType" class="form-select">
                        <option value="BCS">BCS Viva Question Bank</option>
                        <option value="Bank">Bank AD / Officer Viva Bank</option>
                        <option value="Primary">Primary Teacher Viva Bank</option>
                        <option value="Other">Other Government Exam Bank</option>
                    </select>
                </div>

                <!-- Dropzone Box -->
                <div class="dropzone-box" onclick="document.getElementById('fileInputEl').click();">
                    <i class="fa-solid fa-file-pdf" style="font-size: 36px; color: #10B981; margin-bottom: 10px;"></i>
                    <div style="font-size: 15px; font-weight: 700; color: #1F2937;" class="dark:text-white">
                        Click to select PDF or Doc files
                    </div>
                    <div style="font-size: 12px; color: #6B7280; margin-top: 4px;">
                        Supports .pdf, .doc, .docx, .txt (Unlimited files uploaded 1-by-1)
                    </div>

                    <input 
                        id="fileInputEl"
                        type="file" 
                        @change="handleFileSelect($event)" 
                        multiple 
                        accept=".pdf,.doc,.docx,.txt"
                        style="display: none;"
                    />
                </div>

                <template x-if="filesQueue.length > 0">
                    <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); padding: 10px 14px; border-radius: 8px; font-size: 13px; font-weight: 700; color: #047857;" class="dark:text-emerald-400">
                        <i class="fa-solid fa-paperclip"></i> Ready for batch conversion: <span x-text="filesQueue.length"></span> file(s) queued
                    </div>
                </template>

                <div style="display: flex; align-items: center; gap: 10px; margin-top: 4px;">
                    <input type="checkbox" wire:model="autoSaveToDb" id="chkAutoSave1" style="width: 18px; height: 18px; accent-color: #10B981; cursor: pointer;">
                    <label for="chkAutoSave1" style="font-size: 13px; font-weight: 600; color: #4B5563; cursor: pointer;" class="dark:text-gray-300">
                        Automatically store converted Q&A items into Database
                    </label>
                </div>

                <button 
                    @click="startBatchUpload()" 
                    :disabled="isBatchRunning || filesQueue.length === 0"
                    type="button"
                    class="btn-emerald"
                    :style="filesQueue.length === 0 ? 'opacity: 0.5; cursor: not-allowed;' : ''"
                >
                    <template x-if="!isBatchRunning">
                        <span><i class="fa-solid fa-microchip"></i> Convert All Files with Gemini 3.5 & Store in DB</span>
                    </template>
                    <template x-if="isBatchRunning">
                        <span><i class="fa-solid fa-spinner fa-spin"></i> Processing Queue (<span x-text="currentIndex"></span>/<span x-text="filesQueue.length"></span>)...</span>
                    </template>
                </button>
            </div>

            <!-- Option 2: Paste Raw Document Text Box -->
            <div class="converter-card" style="display: flex; flex-direction: column; gap: 20px;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <h3 style="font-size: 17px; font-weight: 800; color: #3B82F6; display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-align-left"></i> Direct Text Paste
                    </h3>
                    <span style="background: rgba(59, 130, 246, 0.1); color: #3B82F6; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px; text-transform: uppercase;">
                        Quick Input
                    </span>
                </div>

                <div>
                    <label class="form-label">Raw Document Content</label>
                    <textarea 
                        wire:model="rawContent" 
                        rows="7" 
                        class="form-textarea"
                        placeholder="Paste real viva experience notes or raw document text here..."
                    ></textarea>
                </div>

                <div style="display: flex; align-items: center; gap: 10px; margin-top: 4px;">
                    <input type="checkbox" wire:model="autoSaveToDb" id="chkAutoSave2" style="width: 18px; height: 18px; accent-color: #3B82F6; cursor: pointer;">
                    <label for="chkAutoSave2" style="font-size: 13px; font-weight: 600; color: #4B5563; cursor: pointer;" class="dark:text-gray-300">
                        Automatically store converted Q&A items into Database
                    </label>
                </div>

                <button 
                    wire:click="convertWithGemini" 
                    wire:loading.attr="disabled"
                    type="button"
                    class="btn-indigo"
                >
                    <span wire:loading.remove wire:target="convertWithGemini">
                        <i class="fa-solid fa-bolt"></i> Convert Text & Store in DB
                    </span>
                    <span wire:loading wire:target="convertWithGemini" style="display: inline-flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-spinner fa-spin"></i> Converting Text...
                    </span>
                </button>
            </div>

        </div>

        <!-- Processing Step Logs -->
        @if(!empty($processingLog))
            <div style="background: #111827; border: 1px solid #1F2937; border-radius: 12px; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
                <h4 style="font-size: 13px; font-weight: 800; color: #9CA3AF; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-list-check" style="color: #10B981;"></i> Batch Processing Step Log
                </h4>
                <div style="font-family: monospace; font-size: 13px; color: #34D399; line-height: 1.7; background: #030712; padding: 16px; border-radius: 8px; border: 1px solid #1F2937; max-height: 300px; overflow-y: auto;">
                    @foreach($processingLog as $logLine)
                        <div>> {{ $logLine }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- JSON Output Preview & Manual Re-Store Section -->
        @if($convertedJson)
            <div style="background: #111827; border: 1px solid #10B981; border-radius: 12px; padding: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
                    <h3 style="font-size: 17px; font-weight: 800; color: #10B981; display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-code"></i> Batch Generated JSON Output ({{ $itemsCount }} Items Total)
                    </h3>
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <button 
                            wire:click="downloadBatchJson" 
                            type="button"
                            style="background: linear-gradient(135deg, #059669 0%, #10B981 100%); color: #fff; border: none; padding: 10px 18px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;"
                        >
                            <i class="fa-solid fa-download"></i> Download Full JSON File ({{ $itemsCount }} Items)
                        </button>
                        <button 
                            wire:click="saveToQuestionBank" 
                            type="button"
                            style="background: #3B82F6; color: #fff; border: none; padding: 10px 18px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;"
                        >
                            <i class="fa-solid fa-database"></i> Re-Save to {{ $examType }} Bank
                        </button>
                    </div>
                </div>

                <textarea 
                    wire:model="convertedJson" 
                    rows="14" 
                    style="width: 100%; padding: 16px; border-radius: 8px; background: #030712; color: #10B981; border: 1px solid #1F2937; font-family: monospace; font-size: 13px; outline: none;"
                ></textarea>
            </div>
        @endif

    </div>
</x-filament-panels::page>
