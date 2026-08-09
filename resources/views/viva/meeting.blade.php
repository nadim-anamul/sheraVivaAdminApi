<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Live Viva Room | Shera Viva</title>
    
    <!-- Premium Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-obsidian: #090D1A;
            --bg-card: rgba(17, 24, 39, 0.75);
            --border-glow: rgba(255, 255, 255, 0.08);
            --primary-emerald: #10B981;
            --primary-glow: rgba(16, 185, 129, 0.15);
            --text-main: #F3F4F6;
            --text-muted: #9CA3AF;
            --accent-blue: #3B82F6;
            --accent-red: #EF4444;
            --font-sans: 'Inter', 'Hind Siliguri', sans-serif;
            --font-display: 'Outfit', 'Hind Siliguri', sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-obsidian);
            color: var(--text-main);
            font-family: var(--font-sans);
            overflow: hidden;
            height: 100vh;
            width: 100vw;
            display: flex;
            flex-direction: column;
            background-image: 
                radial-gradient(circle at 5% 5%, rgba(16, 185, 129, 0.06) 0%, transparent 35%),
                radial-gradient(circle at 95% 95%, rgba(59, 130, 246, 0.05) 0%, transparent 35%);
        }

        /* Loading Screen overlay */
        #loading-screen {
            position: fixed;
            inset: 0;
            background: #090D1A;
            z-index: 2000;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 20px;
            transition: opacity 0.5s ease;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(16, 185, 129, 0.1);
            border-radius: 50%;
            border-top-color: var(--primary-emerald);
            animation: spin 1s linear infinite;
        }

        /* Top Bar */
        .top-bar {
            padding: 16px 24px;
            background: rgba(9, 13, 26, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-glow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #fff;
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 20px;
        }

        .logo-wrapper span {
            color: var(--primary-emerald);
        }

        .meeting-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .badge-live {
            background: rgba(16, 185, 129, 0.15);
            color: var(--primary-emerald);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-live span {
            width: 6px;
            height: 6px;
            background: var(--primary-emerald);
            border-radius: 50%;
            animation: pulse-dot 1.5s infinite;
        }

        .meeting-code-display {
            font-family: monospace;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-glow);
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 14px;
            color: #fff;
            letter-spacing: 0.05em;
        }

        /* Main Workspace layout */
        .workspace {
            flex: 1;
            display: grid;
            grid-template-columns: 1fr;
            height: calc(100vh - 150px);
            position: relative;
        }

        @media (min-width: 992px) {
            .workspace {
                grid-template-columns: 1fr 340px;
            }
        }

        /* Video Area Grid */
        .video-area {
            padding: 24px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            background: #060912;
        }

        .video-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            width: 100%;
            height: 100%;
            max-width: 1000px;
            max-height: 560px;
        }

        @media (min-width: 768px) {
            .video-grid.two-participants {
                grid-template-columns: 1fr 1fr;
            }
        }

        .video-container {
            background: rgba(17, 24, 39, 0.6);
            border: 1px solid var(--border-glow);
            border-radius: 16px;
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        }

        .video-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-placeholder {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-glow) 0%, rgba(59, 130, 246, 0.1) 100%);
            border: 2px dashed rgba(255, 255, 255, 0.1);
            color: #fff;
            font-family: var(--font-display);
            font-size: 32px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.1);
        }

        .participant-label {
            position: absolute;
            bottom: 16px;
            left: 16px;
            background: rgba(9, 13, 26, 0.75);
            backdrop-filter: blur(8px);
            border: 1px solid var(--border-glow);
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Sidebar info panel */
        .sidebar {
            background: rgba(9, 13, 26, 0.6);
            border-left: 1px solid var(--border-glow);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            display: flex;
            flex-direction: column;
            padding: 24px;
            gap: 24px;
            overflow-y: auto;
        }

        .sidebar-section h3 {
            font-family: var(--font-display);
            font-size: 15px;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sidebar-section h3 i {
            color: var(--primary-emerald);
        }

        .info-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-glow);
            border-radius: 12px;
            padding: 16px;
            font-size: 13px;
        }

        .info-item {
            margin-bottom: 10px;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-item label {
            color: var(--text-muted);
            font-size: 11px;
            text-transform: uppercase;
            display: block;
            margin-bottom: 2px;
        }

        .info-item value {
            color: #fff;
            font-weight: 500;
            display: block;
        }

        /* Participant List */
        .participant-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .participant-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.01);
            border: 1px solid var(--border-glow);
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
        }

        .participant-status {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .dot-status {
            width: 8px;
            height: 8px;
            background: var(--text-muted);
            border-radius: 50%;
        }

        .dot-status.online {
            background: var(--primary-emerald);
            box-shadow: 0 0 8px var(--primary-emerald);
        }

        /* Controls Bottom Bar */
        .controls-bar {
            height: 80px;
            background: rgba(9, 13, 26, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-top: 1px solid var(--border-glow);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            z-index: 100;
        }

        .control-btn {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: 1px solid var(--border-glow);
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .control-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: scale(1.05);
        }

        .control-btn.active {
            background: var(--primary-emerald);
            border-color: var(--primary-emerald);
        }

        .control-btn.danger {
            background: var(--accent-red);
            border-color: var(--accent-red);
        }

        .control-btn.danger:hover {
            background: #DC2626;
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.4);
        }

        /* Keyframes */
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @keyframes pulse-dot {
            0% { transform: scale(0.9); opacity: 0.6; }
            50% { transform: scale(1.2); opacity: 1; }
            100% { transform: scale(0.9); opacity: 0.6; }
        }
    </style>
</head>
<body>

    <!-- Loading Screen Overlay -->
    <div id="loading-screen">
        <div class="spinner"></div>
        <p style="color: var(--text-muted); font-size: 14px; font-weight: 500;">Connecting to LiveKit server...</p>
    </div>

    <!-- Top Navigation Bar -->
    <div class="top-bar">
        <a href="#" class="logo-wrapper">
            <i class="fa-solid fa-graduation-cap"></i> Shera <span>Viva</span>
        </a>
        <div class="meeting-title">
            <span class="badge-live"><span></span> Live Meeting</span>
            <span class="meeting-code-display">{{ $booking->meeting_code }}</span>
        </div>
        <div>
            @if($isExaminer)
                <span style="font-size: 12px; color: var(--accent-blue); background: rgba(59, 130, 246, 0.1); padding: 4px 10px; border-radius: 4px; font-weight: 600;">
                    Examiner Portal
                </span>
            @else
                <span style="font-size: 12px; color: var(--primary-emerald); background: rgba(16, 185, 129, 0.1); padding: 4px 10px; border-radius: 4px; font-weight: 600;">
                    Candidate Portal
                </span>
            @endif
        </div>
    </div>

    <!-- Workspace Layout -->
    <div class="workspace">
        
        <!-- Video Grid Area -->
        <div class="video-area">
            <div class="video-grid two-participants" id="video-grid">
                
                <!-- Local User Container -->
                <div class="video-container" id="local-video-container">
                    <div class="avatar-placeholder" id="local-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="participant-label">
                        <i class="fa-solid fa-user"></i> You ({{ $role === 'examiner' ? 'Examiner' : 'Candidate' }})
                    </div>
                </div>

                <!-- Remote User Container -->
                <div class="video-container" id="remote-video-container">
                    <div class="avatar-placeholder" id="remote-avatar">
                        <i class="fa-solid fa-user-clock"></i>
                    </div>
                    <div class="participant-label" id="remote-label">
                        <i class="fa-solid fa-circle-notch fa-spin"></i> Waiting for participant...
                    </div>
                </div>

            </div>
        </div>

        <!-- Sidebar Info Panel -->
        <div class="sidebar">
            <div class="sidebar-section">
                <h3><i class="fa-solid fa-circle-info"></i> Viva Details</h3>
                <div class="info-card">
                    <div class="info-item">
                        <label>Exam Category</label>
                        <value>{{ $booking->slot->availabilityBlock->interviewer->availabilityBlocks()->first()->date ?? 'N/A' }} Mock Board</value>
                    </div>
                    <div class="info-item" style="margin-top: 10px;">
                        <label>Scheduled Date</label>
                        <value>{{ $booking->slot->availabilityBlock->date?->format('F d, Y') ?? 'N/A' }}</value>
                    </div>
                    <div class="info-item" style="margin-top: 10px;">
                        <label>Scheduled Window</label>
                        <value>{{ \Carbon\Carbon::parse($booking->slot->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($booking->slot->end_time)->format('h:i A') }}</value>
                    </div>
                </div>
            </div>

            <div class="sidebar-section">
                <h3><i class="fa-solid fa-users"></i> Board Members</h3>
                <div class="participant-list">
                    <div class="participant-item">
                        <span>Examiner: <strong>{{ $booking->interviewer->name }}</strong></span>
                        <div class="participant-status">
                            <span class="dot-status" id="status-examiner"></span>
                        </div>
                    </div>
                    <div class="participant-item">
                        <span>Candidate: <strong>{{ $booking->candidate->name }}</strong></span>
                        <div class="participant-status">
                            <span class="dot-status" id="status-candidate"></span>
                        </div>
                    </div>
                </div>
            </div>

            @if($isExaminer)
                <div class="sidebar-section" style="margin-top: auto;">
                    <a href="/examiner/bookings/{{ $booking->id }}/edit" target="_blank" class="btn-primary" style="width: 100%; justify-content: center; font-size: 13px; padding: 10px;">
                        <i class="fa-solid fa-pen-to-square"></i> Evaluate Post-viva
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Bottom Control Bar -->
    <div class="controls-bar">
        <button class="control-btn active" id="btn-mic" title="Toggle Microphone">
            <i class="fa-solid fa-microphone" id="icon-mic"></i>
        </button>
        <button class="control-btn active" id="btn-camera" title="Toggle Camera">
            <i class="fa-solid fa-video" id="icon-camera"></i>
        </button>
        <button class="control-btn danger" id="btn-hangup" title="Leave Meeting">
            <i class="fa-solid fa-phone-slash"></i>
        </button>
    </div>

    <!-- LiveKit Web Client JS SDK -->
    <script src="https://cdn.jsdelivr.net/npm/livekit-client/dist/livekit-client.umd.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const token = "{{ $token }}";
            const livekitUrl = "{{ $livekitUrl }}";
            const isExaminer = {{ $isExaminer ? 'true' : 'false' }};
            const role = "{{ $role }}";
            
            const btnMic = document.getElementById('btn-mic');
            const btnCamera = document.getElementById('btn-camera');
            const btnHangup = document.getElementById('btn-hangup');
            
            const iconMic = document.getElementById('icon-mic');
            const iconCamera = document.getElementById('icon-camera');
            
            const localAvatar = document.getElementById('local-avatar');
            const remoteAvatar = document.getElementById('remote-avatar');
            const remoteLabel = document.getElementById('remote-label');
            
            const localContainer = document.getElementById('local-video-container');
            const remoteContainer = document.getElementById('remote-video-container');

            const statusExaminer = document.getElementById('status-examiner');
            const statusCandidate = document.getElementById('status-candidate');

            // 1. Mark self status online in UI sidebar list
            if (isExaminer) {
                statusExaminer.classList.add('online');
            } else {
                statusCandidate.classList.add('online');
            }

            // 2. Initialize LiveKit Client room
            const { Room, RoomEvent, VideoPresets } = LiveKitClient;
            const room = new Room({
                videoCaptureDefaults: {
                    resolution: VideoPresets.h720.resolution,
                }
            });

            // Handle mic / camera toggles
            let micEnabled = true;
            let cameraEnabled = true;

            btnMic.addEventListener('click', async () => {
                micEnabled = !micEnabled;
                await room.localParticipant.setMicrophoneEnabled(micEnabled);
                if (micEnabled) {
                    btnMic.classList.add('active');
                    iconMic.className = 'fa-solid fa-microphone';
                } else {
                    btnMic.classList.remove('active');
                    iconMic.className = 'fa-solid fa-microphone-slash';
                }
            });

            btnCamera.addEventListener('click', async () => {
                cameraEnabled = !cameraEnabled;
                await room.localParticipant.setCameraEnabled(cameraEnabled);
                if (cameraEnabled) {
                    btnCamera.classList.add('active');
                    iconCamera.className = 'fa-solid fa-video';
                    if (localContainer.querySelector('video')) {
                        localContainer.querySelector('video').style.display = 'block';
                    }
                    localAvatar.style.display = 'none';
                } else {
                    btnCamera.classList.remove('active');
                    iconCamera.className = 'fa-solid fa-video-slash';
                    if (localContainer.querySelector('video')) {
                        localContainer.querySelector('video').style.display = 'none';
                    }
                    localAvatar.style.display = 'flex';
                }
            });

            btnHangup.addEventListener('click', () => {
                room.disconnect();
                window.location.href = isExaminer ? '/examiner' : '/dashboard';
            });

            // 3. Set up Room event listeners for remote connection
            room.on(RoomEvent.TrackSubscribed, (track, publication, participant) => {
                // Remove wait status
                remoteAvatar.style.display = 'none';

                if (track.kind === 'video') {
                    // Remove existing video if exists
                    const oldVideo = remoteContainer.querySelector('video');
                    if (oldVideo) oldVideo.remove();

                    const element = track.attach();
                    element.style.width = '100%';
                    element.style.height = '100%';
                    element.style.objectFit = 'cover';
                    remoteContainer.appendChild(element);
                } else if (track.kind === 'audio') {
                    const element = track.attach();
                    document.body.appendChild(element);
                }

                // Update status online in list
                if (participant.identity.startsWith('examiner_')) {
                    statusExaminer.classList.add('online');
                } else {
                    statusCandidate.classList.add('online');
                }

                // Update remote label
                const nameDisplay = participant.name || (participant.identity.startsWith('examiner_') ? 'Examiner' : 'Candidate');
                remoteLabel.innerHTML = `<i class="fa-solid fa-user"></i> ${nameDisplay}`;
            });

            room.on(RoomEvent.TrackUnsubscribed, (track, publication, participant) => {
                track.detach();
                if (track.kind === 'video') {
                    const videoElement = remoteContainer.querySelector('video');
                    if (videoElement) videoElement.remove();
                    remoteAvatar.style.display = 'flex';
                }
            });

            room.on(RoomEvent.ParticipantConnected, (participant) => {
                if (participant.identity.startsWith('examiner_')) {
                    statusExaminer.classList.add('online');
                } else {
                    statusCandidate.classList.add('online');
                }
            });

            room.on(RoomEvent.ParticipantDisconnected, (participant) => {
                if (participant.identity.startsWith('examiner_')) {
                    statusExaminer.classList.remove('online');
                } else {
                    statusCandidate.classList.remove('online');
                }

                // Reset remote grid video display
                const videoElement = remoteContainer.querySelector('video');
                if (videoElement) videoElement.remove();
                remoteAvatar.style.display = 'flex';
                remoteLabel.innerHTML = `<i class="fa-solid fa-circle-notch fa-spin"></i> Waiting for participant...`;
            });

            // 4. Connect to Room
            try {
                await room.connect(livekitUrl, token);
                
                // Hide loader
                const loader = document.getElementById('loading-screen');
                loader.style.opacity = 0;
                setTimeout(() => loader.style.display = 'none', 500);

                // Publish local streams
                await room.localParticipant.enableCameraAndMicrophone();

                // Display local video stream
                const localVideoTrack = room.localParticipant.getTrackPublication('video');
                if (localVideoTrack && localVideoTrack.track) {
                    const localVideoElement = localVideoTrack.track.attach();
                    localVideoElement.style.width = '100%';
                    localVideoElement.style.height = '100%';
                    localVideoElement.style.objectFit = 'cover';
                    localContainer.appendChild(localVideoElement);
                    localAvatar.style.display = 'none';
                }

            } catch (err) {
                console.error("Connection failed: ", err);
                alert("Failed to connect to LiveKit WebRTC meeting server. Check server config or retry.");
                window.location.href = isExaminer ? '/examiner' : '/dashboard';
            }
        });
    </script>
</body>
</html>
