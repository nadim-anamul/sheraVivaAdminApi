<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Viva Question Bank & Advice Library | Shera Viva</title>
    
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
            position: sticky;
            top: 0;
            z-index: 100;
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
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .page-title {
            font-family: var(--font-display);
            font-size: 28px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 8px;
        }

        .tabs {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
            border-bottom: 1px solid var(--border-glow);
            padding-bottom: 12px;
        }

        .tab-link {
            color: var(--text-muted);
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .tab-link.active, .tab-link:hover {
            background: rgba(16, 185, 129, 0.15);
            color: var(--primary-emerald);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
        }

        .item-card {
            background: var(--bg-card);
            border: 1px solid var(--border-glow);
            border-radius: 14px;
            padding: 20px;
            backdrop-filter: blur(12px);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .badge-exam {
            background: rgba(16, 185, 129, 0.15);
            color: var(--primary-emerald);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            align-self: flex-start;
        }

        .item-title {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            line-height: 1.4;
        }

        .item-meta {
            font-size: 13px;
            color: var(--text-muted);
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .transcript-preview {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-glow);
            border-radius: 8px;
            padding: 12px;
            font-size: 13px;
            color: #D1D5DB;
            max-height: 180px;
            overflow-y: auto;
        }

        .qa-pair {
            margin-bottom: 8px;
        }

        .qa-pair:last-child { margin-bottom: 0; }

        .qa-speaker {
            font-weight: 700;
            color: var(--primary-emerald);
            font-size: 11px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <div class="header">
        <a href="/dashboard" class="logo">
            <i class="fa-solid fa-graduation-cap"></i> Shera <span>Viva</span>
        </a>
        <div>
            <a href="/viva/practice" style="background: var(--primary-emerald); color: #fff; text-decoration: none; padding: 8px 18px; border-radius: 20px; font-weight: 700; font-size: 13px;">
                <i class="fa-solid fa-robot"></i> Practice AI Viva
            </a>
            <a href="/dashboard" style="color: var(--text-muted); text-decoration: none; font-size: 14px; margin-left: 16px;">Dashboard</a>
        </div>
    </div>

    <div class="container">
        <h1 class="page-title">Viva Question Bank & Experience Library</h1>
        <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 24px;">Browse authentic Bangladesh job viva board transcripts, advice, and board rules.</p>

        <div class="tabs">
            <a href="/library?exam_type=BCS" class="tab-link {{ $examType === 'BCS' ? 'active' : '' }}">BCS Viva Bank</a>
            <a href="/library?exam_type=Bank" class="tab-link {{ $examType === 'Bank' ? 'active' : '' }}">Bank AD Bank</a>
            <a href="/library?exam_type=Primary" class="tab-link {{ $examType === 'Primary' ? 'active' : '' }}">Primary Teacher Bank</a>
            <a href="/library?exam_type=All" class="tab-link {{ $examType === 'All' ? 'active' : '' }}">All Question Banks</a>
        </div>

        <div class="grid">
            @forelse($items as $item)
                <div class="item-card">
                    <span class="badge-exam">{{ $item->exam_type }} {{ $item->edition }}</span>
                    <div class="item-title">{{ $item->title }}</div>
                    
                    <div class="item-meta">
                        @if($item->subject) <span><i class="fa-solid fa-book"></i> {{ $item->subject }}</span> @endif
                        @if($item->board) <span><i class="fa-solid fa-user-tie"></i> {{ Str::limit($item->board, 25) }}</span> @endif
                    </div>

                    @if(!empty($item->transcript) && is_array($item->transcript))
                        <div class="transcript-preview">
                            @foreach(array_slice($item->transcript, 0, 4) as $qa)
                                <div class="qa-pair">
                                    <span class="qa-speaker">{{ $qa['speaker'] ?? 'Board' }}:</span>
                                    <span>{{ Str::limit($qa['text'] ?? '', 100) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; color: var(--text-muted); padding: 40px;">
                    No viva experiences found for this category.
                </div>
            @endforelse
        </div>

        <div style="margin-top: 24px;">
            {{ $items->appends(['exam_type' => $examType])->links() }}
        </div>
    </div>

</body>
</html>
