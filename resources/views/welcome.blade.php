<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shera Viva | Ultimate Government Job Mock Viva & AI Portal</title>
    
    <!-- Premium Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-obsidian: #090D1A;
            --bg-card: rgba(17, 24, 39, 0.7);
            --border-glow: rgba(255, 255, 255, 0.08);
            --primary-emerald: #10B981;
            --primary-glow: rgba(16, 185, 129, 0.15);
            --text-main: #F3F4F6;
            --text-muted: #9CA3AF;
            --accent-blue: #3B82F6;
            --accent-orange: #F59E0B;
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
            overflow-x: hidden;
            line-height: 1.6;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(16, 185, 129, 0.08) 0%, transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.06) 0%, transparent 40%);
            background-attachment: fixed;
        }

        /* Utility Scrollbars */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--bg-obsidian);
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-emerald);
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Glassmorphic Header */
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(9, 13, 26, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-glow);
            padding: 16px 0;
            transition: all 0.3s ease;
        }

        header.scrolled {
            background: rgba(9, 13, 26, 0.9);
            padding: 12px 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .nav-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 24px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .logo span {
            color: var(--primary-emerald);
            background: linear-gradient(135deg, var(--primary-emerald), #6EE7B7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 28px;
        }

        .nav-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: color 0.2s ease;
        }

        .nav-links a:hover {
            color: var(--text-main);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-emerald), #059669);
            color: #fff !important;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .btn-secondary {
            background: transparent;
            color: var(--text-main);
            border: 1px solid var(--border-glow);
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.15);
        }

        /* Hero Section */
        .hero {
            padding-top: 160px;
            padding-bottom: 90px;
            position: relative;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 60px;
            align-items: center;
        }

        .hero-content h1 {
            font-family: var(--font-display);
            font-size: 52px;
            font-weight: 800;
            line-height: 1.15;
            margin-bottom: 20px;
            letter-spacing: -0.02em;
        }

        .hero-content h1 span {
            background: linear-gradient(135deg, #fff, var(--text-muted));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-content h1 span.gradient {
            background: linear-gradient(135deg, var(--primary-emerald), #3B82F6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-content p {
            font-size: 18px;
            color: var(--text-muted);
            margin-bottom: 36px;
            max-width: 540px;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 48px;
        }

        .hero-stats {
            display: flex;
            align-items: center;
            gap: 40px;
            border-top: 1px solid var(--border-glow);
            padding-top: 28px;
        }

        .stat-item h3 {
            font-family: var(--font-display);
            font-size: 28px;
            font-weight: 700;
            color: #fff;
        }

        .stat-item p {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 0;
        }

        /* Interactive AI Simulator Card */
        .ai-simulator {
            background: var(--bg-card);
            border: 1px solid var(--border-glow);
            border-radius: 20px;
            padding: 24px;
            backdrop-filter: blur(10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            position: relative;
            overflow: hidden;
        }

        .ai-simulator::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--primary-emerald), transparent);
        }

        .sim-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding-bottom: 16px;
            margin-bottom: 20px;
        }

        .sim-badge {
            background: rgba(16, 185, 129, 0.1);
            color: var(--primary-emerald);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .sim-badge span {
            width: 6px;
            height: 6px;
            background: var(--primary-emerald);
            border-radius: 50%;
            display: inline-block;
            animation: pulse 1.5s infinite;
        }

        .sim-avatar-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sim-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--primary-emerald);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
        }

        .sim-title h4 {
            font-size: 13px;
            font-weight: 600;
            color: #fff;
        }

        .sim-title p {
            font-size: 11px;
            color: var(--text-muted);
        }

        .sim-chat-box {
            height: 200px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 16px;
            padding-right: 4px;
            margin-bottom: 20px;
        }

        .chat-bubble {
            max-width: 85%;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            line-height: 1.45;
        }

        .chat-bubble.bot {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.05);
            color: var(--text-main);
            align-self: flex-start;
            border-top-left-radius: 2px;
        }

        .chat-bubble.user {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: #fff;
            align-self: flex-end;
            border-top-right-radius: 2px;
        }

        .sim-input-area {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 8px 12px;
        }

        .sim-input-area input {
            flex: 1;
            background: transparent;
            border: none;
            color: #fff;
            font-size: 13px;
            outline: none;
        }

        .sim-input-area input::placeholder {
            color: var(--text-muted);
        }

        .sim-btn-send {
            width: 32px;
            height: 32px;
            background: var(--primary-emerald);
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            transition: background 0.2s ease;
        }

        .sim-btn-send:hover {
            background: #059669;
        }

        .visualizer {
            display: flex;
            align-items: center;
            gap: 3px;
            height: 20px;
        }

        .vis-bar {
            width: 2px;
            background: var(--primary-emerald);
            border-radius: 1px;
            animation: bounce-bar 1.2s ease-in-out infinite alternate;
        }

        /* Scorecard popup overlay inside simulator */
        .scorecard-overlay {
            position: absolute;
            inset: 0;
            background: rgba(9, 13, 26, 0.95);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 30px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 20px;
            z-index: 10;
        }

        .scorecard-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        .score-circle {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 4px solid var(--primary-emerald);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.2);
        }

        .score-val {
            font-family: var(--font-display);
            font-size: 32px;
            font-weight: 800;
            color: #fff;
        }

        .score-label {
            font-size: 9px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .score-metrics {
            display: flex;
            gap: 20px;
            width: 100%;
            margin-bottom: 20px;
        }

        .metric-card {
            flex: 1;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            padding: 10px;
            text-align: center;
        }

        .metric-card h5 {
            font-size: 11px;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .metric-card p {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
        }

        .metric-card p.accent {
            color: var(--accent-orange);
        }

        .score-feedback {
            font-size: 12px;
            text-align: center;
            color: var(--text-muted);
            margin-bottom: 24px;
            line-height: 1.5;
        }

        /* Features Section */
        .features {
            padding: 90px 0;
            border-top: 1px solid var(--border-glow);
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-header h2 {
            font-family: var(--font-display);
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 16px;
        }

        .section-header p {
            color: var(--text-muted);
            font-size: 16px;
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .feature-card {
            background: var(--bg-card);
            border: 1px solid var(--border-glow);
            border-radius: 16px;
            padding: 36px;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            border-color: rgba(16, 185, 129, 0.3);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.05);
        }

        .feat-icon {
            width: 48px;
            height: 48px;
            background: var(--primary-glow);
            color: var(--primary-emerald);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 24px;
        }

        .feature-card h3 {
            font-family: var(--font-display);
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 14px;
            color: #fff;
        }

        .feature-card p {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* Expert Panel Section */
        .experts {
            padding: 90px 0;
            background: rgba(255, 255, 255, 0.01);
            border-top: 1px solid var(--border-glow);
        }

        .experts-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .expert-card {
            background: var(--bg-card);
            border: 1px solid var(--border-glow);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .expert-card:hover {
            transform: translateY(-5px);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .expert-info {
            padding: 28px;
            flex: 1;
        }

        .exp-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .exp-avatar {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.05);
        }

        .exp-meta h3 {
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 4px;
        }

        .exp-meta p {
            font-size: 12px;
            color: var(--primary-emerald);
            font-weight: 600;
        }

        .expert-card p.bio {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 24px;
        }

        .exp-pricing-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding-top: 20px;
        }

        .exp-price h4 {
            font-family: var(--font-display);
            font-size: 20px;
            font-weight: 700;
            color: #fff;
        }

        .exp-price span {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 400;
        }

        .exp-slots {
            background: rgba(59, 130, 246, 0.1);
            color: var(--accent-blue);
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
        }

        .exp-action-btn {
            background: rgba(255, 255, 255, 0.03);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            text-align: center;
            padding: 16px;
            color: var(--text-main);
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.2s ease;
        }

        .exp-action-btn:hover {
            background: var(--primary-emerald);
            color: #fff;
        }

        /* Scraped Jobs Portal board */
        .job-portal {
            padding: 90px 0;
            border-top: 1px solid var(--border-glow);
        }

        .search-container {
            max-width: 500px;
            margin: -20px auto 50px auto;
            position: relative;
        }

        .search-container input {
            width: 100%;
            background: rgba(17, 24, 39, 0.5);
            border: 1px solid var(--border-glow);
            border-radius: 12px;
            padding: 14px 18px 14px 44px;
            color: #fff;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
        }

        .search-container input:focus {
            border-color: var(--primary-emerald);
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.1);
        }

        .search-container i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 14px;
        }

        .job-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        .job-column-title {
            font-family: var(--font-display);
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .job-column-title span {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--primary-emerald);
        }

        .job-column-title.results span {
            background: var(--accent-blue);
        }

        .job-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .job-item {
            background: var(--bg-card);
            border: 1px solid var(--border-glow);
            border-radius: 12px;
            padding: 20px;
            transition: all 0.2s ease;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
        }

        .job-item:hover {
            border-color: rgba(255, 255, 255, 0.15);
            background: rgba(17, 24, 39, 0.9);
        }

        .job-details {
            flex: 1;
        }

        .job-org-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .job-badge {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-muted);
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
        }

        .job-details h4 {
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            line-height: 1.4;
            margin-bottom: 12px;
        }

        .job-meta-row {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 11px;
            color: var(--text-muted);
        }

        .job-meta-row span i {
            margin-right: 4px;
        }

        .job-download-btn {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-glow);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .job-download-btn:hover {
            background: var(--primary-emerald);
            border-color: var(--primary-emerald);
            color: #fff;
        }

        .job-item.is-result .job-download-btn:hover {
            background: var(--accent-blue);
            border-color: var(--accent-blue);
        }

        /* Mobile App Showcase */
        .app-showcase {
            padding: 90px 0;
            border-top: 1px solid var(--border-glow);
            background: linear-gradient(180deg, transparent, rgba(16, 185, 129, 0.02), transparent);
        }

        .app-grid {
            display: grid;
            grid-template-columns: 0.95fr 1.05fr;
            gap: 60px;
            align-items: center;
        }

        .app-mockup {
            position: relative;
            display: flex;
            justify-content: center;
        }

        .phone-frame {
            width: 280px;
            height: 560px;
            background: #000;
            border: 8px solid #1F2937;
            border-radius: 36px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
            padding: 10px;
            position: relative;
            overflow: hidden;
        }

        .phone-screen {
            background: var(--bg-obsidian);
            width: 100%;
            height: 100%;
            border-radius: 24px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 16px;
            position: relative;
        }

        .phone-notch {
            width: 120px;
            height: 18px;
            background: #1F2937;
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
            z-index: 10;
        }

        .phone-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-top: 10px;
        }

        .phone-header h5 {
            font-size: 13px;
            color: #fff;
        }

        .phone-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-glow);
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 12px;
        }

        .phone-card h6 {
            font-size: 11px;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .phone-card p {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
        }

        .phone-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 12px;
        }

        .app-qr-code {
            position: absolute;
            bottom: -30px;
            right: 0px;
            background: var(--bg-card);
            border: 1px solid var(--border-glow);
            border-radius: 16px;
            padding: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .app-qr-code:hover {
            transform: scale(1.05);
        }

        .qr-placeholder {
            width: 100px;
            height: 100px;
            background: #fff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-size: 54px;
        }

        .qr-text {
            font-size: 10px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        .app-content h2 {
            font-family: var(--font-display);
            font-size: 36px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 16px;
        }

        .app-content p {
            color: var(--text-muted);
            font-size: 16px;
            margin-bottom: 28px;
        }

        .app-bullets {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 36px;
        }

        .bullet-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .bullet-icon {
            width: 24px;
            height: 24px;
            background: var(--primary-glow);
            color: var(--primary-emerald);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            margin-top: 2px;
        }

        .bullet-text h4 {
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 2px;
        }

        .bullet-text p {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 0;
        }

        /* Footer */
        footer {
            border-top: 1px solid var(--border-glow);
            padding: 48px 0;
            background: rgba(0, 0, 0, 0.2);
        }

        .footer-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .footer-logo {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 20px;
            color: #fff;
            text-decoration: none;
        }

        .footer-logo span {
            color: var(--primary-emerald);
        }

        .footer-copyright {
            font-size: 13px;
            color: var(--text-muted);
        }

        .footer-links {
            display: flex;
            gap: 20px;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 13px;
            transition: color 0.2s ease;
        }

        .footer-links a:hover {
            color: #fff;
        }

        /* Animations */
        @keyframes pulse {
            0% {
                transform: scale(0.9);
                opacity: 0.6;
            }
            50% {
                transform: scale(1.2);
                opacity: 1;
            }
            100% {
                transform: scale(0.9);
                opacity: 0.6;
            }
        }

        @keyframes bounce-bar {
            0% {
                height: 4px;
            }
            100% {
                height: 18px;
            }
        }

        /* Responsive Layouts */
        @media (max-width: 1024px) {
            .hero-grid {
                grid-template-columns: 1fr;
                gap: 50px;
            }
            .hero-content {
                text-align: center;
            }
            .hero-content p {
                margin-left: auto;
                margin-right: auto;
            }
            .hero-actions {
                justify-content: center;
            }
            .hero-stats {
                justify-content: center;
            }
            .features-grid, .experts-grid {
                grid-template-columns: 1fr 1fr;
            }
            .app-grid {
                grid-template-columns: 1fr;
                gap: 50px;
            }
            .app-mockup {
                order: 2;
            }
            .app-content {
                text-align: center;
            }
            .app-bullets {
                align-items: center;
            }
            .bullet-item {
                text-align: left;
                max-width: 480px;
            }
        }

        @media (max-width: 768px) {
            .features-grid, .experts-grid, .job-grid {
                grid-template-columns: 1fr;
            }
            .hero-content h1 {
                font-size: 38px;
            }
            .footer-row {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
            .nav-links {
                display: none; /* Mobile Navigation Toggle Simple Fallback */
            }
        }
    </style>
</head>
<body>

    <!-- Glassmorphic Header -->
    <header id="header">
        <div class="container nav-wrapper">
            <a href="/" class="logo">
                <i class="fa-solid fa-graduation-cap"></i> Shera <span>Viva</span>
            </a>
            
            <nav class="nav-links">
                <a href="#features">Features</a>
                <a href="#experts">Expert Board Panel</a>
                <a href="#jobs">Job Portal</a>
                <a href="#app">Mobile App</a>
                @auth
                    <a href="/dashboard" class="btn-primary">
                        <i class="fa-solid fa-gauge-high"></i> Dashboard
                    </a>
                @else
                    <a href="/login" class="btn-secondary">Log in</a>
                    <a href="/register" class="btn-primary">Get Started</a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div class="hero-content">
                <h1>
                    <span>বিসিএস ও ব্যাংক ভাইভার</span><br>
                    <span class="gradient">সেরা প্রস্তুতি</span>
                </h1>
                <p>Prepare for BPSC Cadre, Bangladesh Bank AD, and Primary Teacher oral exams. Interact with expert board examiners and practice with real-time speech analytics & instant AI scorecards.</p>
                
                <div class="hero-actions">
                    <a href="/register" class="btn-primary">
                        Start Mock Practice <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <a href="#experts" class="btn-secondary">
                        Explore Board Panel
                    </a>
                </div>

                <div class="hero-stats">
                    <div class="stat-item">
                        <h3>{{ count($interviewers) }}+</h3>
                        <p>Expert Board Panelists</p>
                    </div>
                    <div class="stat-item">
                        <h3>15+</h3>
                        <p>Available Time Slots Today</p>
                    </div>
                    <div class="stat-item">
                        <h3>98%</h3>
                        <p>AI Assessment Accuracy</p>
                    </div>
                </div>
            </div>

            <!-- AI Simulator Interactive Card -->
            <div class="ai-simulator-wrapper">
                <div class="ai-simulator" id="ai-sim-card">
                    <div class="sim-header">
                        <div class="sim-avatar-group">
                            <div class="sim-avatar">
                                <i class="fa-solid fa-robot"></i>
                            </div>
                            <div class="sim-title">
                                <h4>Shera AI Examiner</h4>
                                <p>Monetary & Administrative Policy Board</p>
                            </div>
                        </div>
                        <div class="sim-badge">
                            <span></span> Live Session
                        </div>
                    </div>

                    <!-- Chat Container -->
                    <div class="sim-chat-box" id="sim-chat-box">
                        <div class="chat-bubble bot">
                            আসসালামু আলাইকুম। Shera Viva AI বোর্ডে আপনাকে স্বাগত। আপনার নিজের সম্পর্কে সংক্ষেপে বলুন এবং আপনার ১ম ক্যাডার চয়েস অ্যাডমিনিস্ট্রেশন কেন, তা ব্যাখ্যা করুন।
                        </div>
                    </div>

                    <!-- Visualizer & Microphone Input Simulation -->
                    <div class="sim-input-area">
                        <input type="text" id="sim-user-input" placeholder="Type your response in English or Bengali..." autocomplete="off">
                        
                        <div class="visualizer" id="audio-vis" style="display: none;">
                            <div class="vis-bar" style="height: 12px; animation-delay: 0.1s;"></div>
                            <div class="vis-bar" style="height: 18px; animation-delay: 0.3s;"></div>
                            <div class="vis-bar" style="height: 8px; animation-delay: 0.2s;"></div>
                            <div class="vis-bar" style="height: 14px; animation-delay: 0.4s;"></div>
                        </div>

                        <button class="sim-btn-send" id="sim-send-btn">
                            <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </div>

                    <!-- Scorecard Overlay -->
                    <div class="scorecard-overlay" id="scorecard-overlay">
                        <div class="score-circle">
                            <span class="score-val" id="score-val">86</span>
                            <span class="score-label">AI Grade</span>
                        </div>
                        
                        <div class="score-metrics">
                            <div class="metric-card">
                                <h5>Filler Words</h5>
                                <p class="accent" id="filler-val">3</p>
                            </div>
                            <div class="metric-card">
                                <h5>Tone Quality</h5>
                                <p id="tone-val">Excellent</p>
                            </div>
                        </div>

                        <p class="score-feedback" id="feedback-val">
                            "Excellent attempt! You structured your thoughts logically and maintained an administrative cadence. Reduce filler words like 'um' under pressure."
                        </p>

                        <button class="btn-primary" style="padding: 8px 16px; font-size: 12px;" onclick="resetSimulator()">
                            Practice Again <i class="fa-solid fa-rotate-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-header">
                <h2>Bespoke Mock Preparation Capabilities</h2>
                <p>Everything you need to confidently clear the toughest government oral selection boards in Bangladesh.</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feat-icon">
                        <i class="fa-solid fa-microphone-lines"></i>
                    </div>
                    <h3>AI Speech Analytics</h3>
                    <p>Track filler word usage, speaking speed, grammar errors, and confidence index using advanced speech processing algorithms instantly.</p>
                </div>

                <div class="feature-card">
                    <div class="feat-icon">
                        <i class="fa-solid fa-video"></i>
                    </div>
                    <h3>Live WebRTC Vivas</h3>
                    <p>Book real-world retired BPSC panel members, BB general managers, and BCS cadres. Connect with secure low-latency LiveKit visual interview rooms.</p>
                </div>

                <div class="feature-card">
                    <div class="feat-icon">
                        <i class="fa-solid fa-newspaper"></i>
                    </div>
                    <h3>Govt Jobs Auto-Crawler</h3>
                    <p>Get automated instant scraping of BPSC, DPE, and Bangladesh Bank. Be the first to download new circular notices and result PDFs.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Expert Panel Section -->
    <section class="experts" id="experts">
        <div class="container">
            <div class="section-header">
                <h2>Panel of Expert Oral Board Examiners</h2>
                <p>Book live face-to-face simulated interview sessions with premium BCS & Central Banking officials.</p>
            </div>

            <div class="experts-grid">
                @forelse($interviewers as $interviewer)
                    <div class="expert-card">
                        <div class="expert-info">
                            <div class="exp-header">
                                <img src="{{ $interviewer->avatar_url ?? 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=150' }}" alt="{{ $interviewer->name }}" class="exp-avatar">
                                <div class="exp-meta">
                                    <h3>{{ $interviewer->name }}</h3>
                                    <p>{{ $interviewer->designation }}</p>
                                </div>
                            </div>
                            <p class="bio">{{ $interviewer->bio }}</p>
                            
                            <div class="exp-pricing-row">
                                <div class="exp-price">
                                    <h4>BDT {{ $interviewer->base_price }}</h4>
                                    <span>per 20-min session</span>
                                </div>
                                <div class="exp-slots">
                                    <i class="fa-solid fa-calendar-check"></i> {{ $interviewer->slots_count }} Slots Available
                                </div>
                            </div>
                        </div>
                        <a href="/admin/bookings/create" class="exp-action-btn">
                            Book Live Session <i class="fa-solid fa-arrow-right-long" style="margin-left: 6px;"></i>
                        </a>
                    </div>
                @empty
                    <div class="expert-card" style="grid-column: span 3; text-align: center; padding: 40px;">
                        <p class="bio">No active board interviewers currently seeded. Visit Filament panel to add interviewers.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Scraped Jobs Portal board -->
    <section class="job-portal" id="jobs">
        <div class="container">
            <div class="section-header">
                <h2>Real-Time Government Jobs Board</h2>
                <p>Auto-crawled circular notifications and exam results directly from BPSC and Bangladesh Bank.</p>
            </div>

            <!-- Client Side Live Search -->
            <div class="search-container">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="job-search-input" placeholder="Search notices, organizations, or exams..." onkeyup="filterJobs()">
            </div>

            <div class="job-grid">
                <!-- Circulars Column -->
                <div>
                    <h3 class="job-column-title">
                        <span></span> Latest Job Circulars
                    </h3>
                    <div class="job-list" id="circular-list">
                        @forelse($circulars as $item)
                            <div class="job-item search-target">
                                <div class="job-details">
                                    <div class="job-org-row">
                                        <span class="job-badge">{{ $item->organization }}</span>
                                    </div>
                                    <h4 class="job-title">{{ $item->title }}</h4>
                                    <div class="job-meta-row">
                                        <span><i class="fa-regular fa-calendar"></i> {{ $item->published_date->format('M d, Y') }}</span>
                                        <span><i class="fa-regular fa-file-pdf"></i> {{ $item->file_size }}</span>
                                    </div>
                                </div>
                                <a href="{{ $item->file_url }}" target="_blank" class="job-download-btn" title="Download Notice PDF">
                                    <i class="fa-solid fa-download"></i>
                                </a>
                            </div>
                        @empty
                            <p style="color: var(--text-muted); font-size: 13px;">No job circulars crawled yet.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Results Column -->
                <div>
                    <h3 class="job-column-title results">
                        <span></span> Exam Results & Recommendations
                    </h3>
                    <div class="job-list" id="result-list">
                        @forelse($results as $item)
                            <div class="job-item is-result search-target">
                                <div class="job-details">
                                    <div class="job-org-row">
                                        <span class="job-badge" style="background: rgba(59, 130, 246, 0.1); color: var(--accent-blue);">{{ $item->organization }}</span>
                                    </div>
                                    <h4 class="job-title">{{ $item->title }}</h4>
                                    <div class="job-meta-row">
                                        <span><i class="fa-regular fa-calendar"></i> {{ $item->published_date->format('M d, Y') }}</span>
                                        <span><i class="fa-regular fa-file-pdf"></i> {{ $item->file_size }}</span>
                                    </div>
                                </div>
                                <a href="{{ $item->file_url }}" target="_blank" class="job-download-btn" title="Download Results PDF">
                                    <i class="fa-solid fa-file-arrow-down"></i>
                                </a>
                            </div>
                        @empty
                            <p style="color: var(--text-muted); font-size: 13px;">No exam results crawled yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mobile App Showcase -->
    <section class="app-showcase" id="app">
        <div class="container app-grid">
            
            <!-- App Mockup Phone UI -->
            <div class="app-mockup">
                <div class="phone-frame">
                    <div class="phone-notch"></div>
                    <div class="phone-screen">
                        <div class="phone-header">
                            <h5>Shera Viva App</h5>
                            <i class="fa-solid fa-circle-user" style="color: var(--primary-emerald); font-size: 16px;"></i>
                        </div>
                        
                        <div class="phone-card">
                            <h6>Average AI Score</h6>
                            <p>87%</p>
                        </div>

                        <div class="phone-row">
                            <div class="phone-card" style="margin-bottom: 0;">
                                <h6>Mocks Practiced</h6>
                                <p style="font-size: 14px;">12 Sessions</p>
                            </div>
                            <div class="phone-card" style="margin-bottom: 0;">
                                <h6>Upcoming Board</h6>
                                <p style="font-size: 14px; color: var(--accent-blue);">Today 4 PM</p>
                            </div>
                        </div>

                        <div class="phone-card" style="flex: 1; display: flex; flex-direction: column; justify-content: space-between; margin-bottom: 0; margin-top: 12px; background: rgba(16, 185, 129, 0.05); border-color: rgba(16, 185, 129, 0.1);">
                            <div>
                                <h6 style="color: var(--primary-emerald);">Active Room Channel</h6>
                                <p style="font-size: 13px; font-weight: 500; margin-top: 4px;">Live Board #401</p>
                            </div>
                            <button class="btn-primary" style="padding: 6px 12px; font-size: 10px; width: 100%; justify-content: center; border-radius: 6px;">
                                <i class="fa-solid fa-video"></i> Join LiveKit Room
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Interactive App QR Trigger -->
                <div class="app-qr-code" onclick="alert('Shera Viva Candidate App APK will start downloading. Full App Store link active in production!')">
                    <div class="qr-placeholder">
                        <i class="fa-solid fa-qrcode"></i>
                    </div>
                    <span class="qr-text">Scan for Mobile App</span>
                </div>
            </div>

            <!-- App Content details -->
            <div class="app-content">
                <h2>Practice Anytime, Anywhere on Our Mobile App</h2>
                <p>Install the Shera Viva mobile application to practice oral board interviews on the go, receive notifications for crawled government jobs, and stream live WebRTC board reviews.</p>
                
                <div class="app-bullets">
                    <div class="bullet-item">
                        <div class="bullet-icon">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                        </div>
                        <div class="bullet-text">
                            <h4>Hands-free AI Voice Practice</h4>
                            <p>Practice simulated BPSC/BB viva boards entirely using speech recognition. Receive instant grading directly on your phone.</p>
                        </div>
                    </div>

                    <div class="bullet-item">
                        <div class="bullet-icon">
                            <i class="fa-solid fa-bell"></i>
                        </div>
                        <div class="bullet-text">
                            <h4>Job Scraper Push Alerts</h4>
                            <p>Get push notifications the exact second BPSC or Bangladesh Bank releases a circular or written results sheet.</p>
                        </div>
                    </div>

                    <div class="bullet-item">
                        <div class="bullet-icon">
                            <i class="fa-solid fa-circle-play"></i>
                        </div>
                        <div class="bullet-text">
                            <h4>Mobile WebRTC Audio Rooms</h4>
                            <p>Low-bandwidth voice and video calls for live examiner bookings, working flawlessly even on 3G cellular connections.</p>
                        </div>
                    </div>
                </div>

                <a href="#app" class="btn-primary" onclick="alert('Shera Viva App package download started!')">
                    <i class="fa-brands fa-google-play"></i> Download Android APK
                </a>
            </div>
        </div>
    </section>

    <!-- Modern Footer -->
    <footer>
        <div class="container footer-row">
            <a href="/" class="footer-logo">
                Shera <span>Viva</span>
            </a>
            
            <p class="footer-copyright">&copy; 2026 Shera Viva mock portal. All rights reserved.</p>

            <div class="footer-links">
                <a href="/admin">Filament Panel</a>
                <a href="/api/viva/categories" target="_blank">API Reference</a>
                <a href="https://github.com/gemini-antigravity" target="_blank">OSS Github</a>
            </div>
        </div>
    </footer>

    <!-- Premium Interactive JS Simulator Logic & Scrolling Styling -->
    <script>
        // Header scroll styles
        window.addEventListener('scroll', function() {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Live Client-side Job search filter
        function filterJobs() {
            const input = document.getElementById('job-search-input');
            const filter = input.value.toLowerCase();
            const items = document.getElementsByClassName('search-target');

            for (let i = 0; i < items.length; i++) {
                const title = items[i].getElementsByClassName('job-title')[0].innerText.toLowerCase();
                const badge = items[i].getElementsByClassName('job-badge')[0].innerText.toLowerCase();
                if (title.indexOf(filter) > -1 || badge.indexOf(filter) > -1) {
                    items[i].style.display = "";
                } else {
                    items[i].style.display = "none";
                }
            }
        }

        // AI Mock Simulator Interactive Script
        const simInput = document.getElementById('sim-user-input');
        const simSend = document.getElementById('sim-send-btn');
        const chatBox = document.getElementById('sim-chat-box');
        const audioVis = document.getElementById('audio-vis');
        const scorecard = document.getElementById('scorecard-overlay');

        let step = 1;

        simSend.addEventListener('click', handleSimInput);
        simInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') handleSimInput();
        });

        function handleSimInput() {
            const text = simInput.value.trim();
            if (!text) return;

            // 1. Append user response bubble
            appendBubble(text, 'user');
            simInput.value = '';
            simInput.disabled = true;

            // 2. Trigger audio visualizer for AI processing
            audioVis.style.display = 'flex';
            simSend.style.display = 'none';

            setTimeout(() => {
                // Remove visualizer
                audioVis.style.display = 'none';
                simSend.style.display = 'flex';
                simInput.disabled = false;

                if (step === 1) {
                    // Bot responds with second query
                    appendBubble("চমৎকার। এবার বলুন, বাংলাদেশ ব্যাংকের সাম্প্রতিক রেপো রেট বৃদ্ধির সিদ্ধান্ত মূল্যস্ফীতি নিয়ন্ত্রণে কীভাবে অবদান রাখতে পারে?", 'bot');
                    step = 2;
                } else {
                    // Show AI Scorecard summary
                    const score = Math.floor(Math.random() * (95 - 76) + 76);
                    const fillers = Math.floor(Math.random() * 6);
                    const tones = ['Excellent & Formal', 'Structured & Confident', 'Slightly Hesitant'];
                    const tone = tones[Math.floor(Math.random() * tones.length)];
                    
                    document.getElementById('score-val').innerText = score;
                    document.getElementById('filler-val').innerText = fillers;
                    document.getElementById('tone-val').innerText = tone;

                    scorecard.classList.add('active');
                }
            }, 2200);
        }

        function appendBubble(text, sender) {
            const bubble = document.createElement('div');
            bubble.classList.add('chat-bubble', sender);
            bubble.innerText = text;
            chatBox.appendChild(bubble);
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        function resetSimulator() {
            scorecard.classList.remove('active');
            chatBox.innerHTML = `
                <div class="chat-bubble bot">
                    আসসালামু আলাইকুম। Shera Viva AI বোর্ডে আপনাকে স্বাগত। আপনার নিজের সম্পর্কে সংক্ষেপে বলুন এবং আপনার ১ম ক্যাডার চয়েস অ্যাডমিনিস্ট্রেশন কেন, তা ব্যাখ্যা করুন।
                </div>
            `;
            step = 1;
        }
    </script>
</body>
</html>
