<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Job Circulars & Results | Shera Viva</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-obsidian: #090D1A;
            --bg-card: rgba(17, 24, 39, 0.75);
            --border-glow: rgba(255, 255, 255, 0.08);
            --primary-emerald: #10B981;
            --text-main: #F3F4F6;
            --text-muted: #9CA3AF;
            --accent-blue: #3B82F6;
            --font-sans: 'Inter', 'Hind Siliguri', sans-serif;
            --font-display: 'Outfit', 'Hind Siliguri', sans-serif;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background-color: var(--bg-obsidian);
            color: var(--text-main);
            font-family: var(--font-sans);
            min-height: 100vh;
        }

        .header {
            padding: 16px 32px;
            background: rgba(9, 13, 26, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-glow);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-family: var(--font-display);
            font-size: 20px;
            font-weight: 800;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo span { color: var(--primary-emerald); }

        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .section-title {
            font-family: var(--font-display);
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .job-card {
            background: var(--bg-card);
            border: 1px solid var(--border-glow);
            border-radius: 14px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .org-badge {
            background: rgba(59, 130, 246, 0.15);
            color: var(--accent-blue);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            align-self: flex-start;
        }

        .job-title {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            line-height: 1.4;
        }

        .btn-download {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-glow);
            color: #fff;
            text-decoration: none;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            font-size: 13px;
            font-weight: 600;
            margin-top: auto;
            transition: all 0.2s ease;
        }

        .btn-download:hover {
            background: var(--primary-emerald);
            border-color: var(--primary-emerald);
        }
    </style>
</head>
<body>

    <div class="header">
        <a href="/dashboard" class="logo">
            <i class="fa-solid fa-graduation-cap"></i> Shera <span>Viva</span>
        </a>
        <a href="/dashboard" style="color: var(--text-muted); text-decoration: none; font-size: 14px;">Dashboard</a>
    </div>

    <div class="container">
        
        <!-- Circulars -->
        <h2 class="section-title"><i class="fa-solid fa-briefcase" style="color: var(--primary-emerald);"></i> Latest Job Circulars</h2>
        <div class="grid">
            @foreach($circulars as $circ)
                <div class="job-card">
                    <span class="org-badge">{{ $circ->organization }}</span>
                    <div class="job-title">{{ $circ->title }}</div>
                    <div style="font-size: 12px; color: var(--text-muted);">Published: {{ $circ->published_date?->format('d M, Y') }}</div>
                    <a href="{{ $circ->file_url }}" target="_blank" class="btn-download">
                        <i class="fa-solid fa-download"></i> Download PDF ({{ $circ->file_size }})
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Results -->
        <h2 class="section-title"><i class="fa-solid fa-award" style="color: #F59E0B;"></i> Exam Results & Recommendation Lists</h2>
        <div class="grid">
            @foreach($results as $res)
                <div class="job-card">
                    <span class="org-badge" style="background: rgba(245, 158, 11, 0.15); color: #F59E0B;">{{ $res->organization }}</span>
                    <div class="job-title">{{ $res->title }}</div>
                    <div style="font-size: 12px; color: var(--text-muted);">Published: {{ $res->published_date?->format('d M, Y') }}</div>
                    <a href="{{ $res->file_url }}" target="_blank" class="btn-download">
                        <i class="fa-solid fa-file-pdf"></i> View Result Sheet ({{ $res->file_size }})
                    </a>
                </div>
            @endforeach
        </div>

    </div>

</body>
</html>
