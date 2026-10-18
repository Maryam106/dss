<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risk Scoring — CloudRisk DSS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:       #0b1d3a;
            --navy-mid:   #112753;
            --blue:       #1d4ed8;
            --blue-soft:  #3b82f6;
            --blue-pale:  #dbeafe;
            --teal:       #0d9488;
            --teal-pale:  #ccfbf1;
            --amber:      #d97706;
            --amber-pale: #fef3c7;
            --red:        #dc2626;
            --red-pale:   #fee2e2;
            --green:      #059669;
            --green-pale: #d1fae5;
            --white:      #ffffff;
            --surface:    #f1f5f9;
            --border:     #e2e8f0;
            --text:       #0f172a;
            --text-2:     #334155;
            --muted:      #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--surface);
            color: var(--text);
            min-height: 100vh;
            display: flex;
        }

        /* ══ Sidebar ══ */
        .sidebar {
            width: 240px;
            background: var(--navy);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: fixed;
            top: 0; left: 0; bottom: 0;
        }

        .sidebar-logo {
            padding: 22px 20px 18px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }

        .logo-row { display:flex; align-items:center; gap:11px; }

        .logo-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--blue) 0%, var(--teal) 100%);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 17px; flex-shrink: 0;
        }

        .logo-name { font-size:14px; font-weight:700; color:#fff; }
        .logo-sub  { font-size:10px; color:rgba(255,255,255,0.38); margin-top:2px; }

        .sidebar-nav { flex:1; padding:14px 10px; display:flex; flex-direction:column; gap:1px; }

        .nav-label {
            font-size:10px; font-weight:600; color:rgba(255,255,255,0.28);
            letter-spacing:0.08em; text-transform:uppercase; padding:14px 10px 6px;
        }

        .nav-item {
            display:flex; align-items:center; gap:9px;
            padding:9px 10px; border-radius:7px;
            text-decoration:none; font-size:13px; font-weight:500;
            color:rgba(255,255,255,0.5); transition:background 0.12s,color 0.12s;
        }
        .nav-item:hover { background:rgba(255,255,255,0.07); color:rgba(255,255,255,0.88); }
        .nav-item.active { background:rgba(59,130,246,0.16); color:#93c5fd; }
        .nav-icon { font-size:14px; width:18px; text-align:center; flex-shrink:0; }

        .sidebar-footer { padding:14px 10px; border-top:1px solid rgba(255,255,255,0.07); }
        .user-row { display:flex; align-items:center; gap:9px; padding:8px 10px; }

        .user-avatar {
            width:32px; height:32px;
            background:linear-gradient(135deg,var(--blue) 0%,var(--teal) 100%);
            border-radius:50%; display:flex; align-items:center; justify-content:center;
            font-size:13px; font-weight:700; color:#fff; flex-shrink:0;
        }

        .user-info { flex:1; min-width:0; }
        .user-name { font-size:12.5px; font-weight:600; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .user-role { font-size:10px; color:rgba(255,255,255,0.35); margin-top:1px; }

        .logout-btn {
            display:block; width:100%; margin-top:8px; padding:7px;
            background:transparent; color:rgba(255,255,255,0.35);
            border:1px solid rgba(255,255,255,0.1); border-radius:6px;
            font-size:12px; font-family:'Inter',sans-serif; cursor:pointer;
            transition:color 0.12s,border-color 0.12s; text-align:center;
        }
        .logout-btn:hover { color:rgba(255,255,255,0.7); border-color:rgba(255,255,255,0.25); }

        /* ══ Main ══ */
        .main {
            margin-left: 240px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .topbar {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--muted);
        }
        .topbar a { color: var(--blue); text-decoration: none; font-weight: 500; }
        .topbar a:hover { text-decoration: underline; }
        .topbar-sep { color: var(--border); }

        .content { padding: 28px 32px 48px; max-width: 1100px; }

        /* ══ Progress bar ══ */
        .progress-bar {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px 28px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 0;
        }

        .step-item {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .step-circle {
            width: 32px; height: 32px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700;
            flex-shrink: 0;
        }
        .step-circle.done { background: var(--teal); color: #fff; }
        .step-circle.active { background: var(--blue); color: #fff; box-shadow: 0 0 0 4px var(--blue-pale); }
        .step-circle.pending { background: var(--surface); color: var(--muted); border: 2px solid var(--border); }

        .step-label { margin-left: 10px; }
        .step-label .s-num { font-size: 10px; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
        .step-label .s-name { font-size: 12.5px; font-weight: 600; color: var(--text); margin-top: 1px; }
        .step-label .s-name.muted { color: var(--muted); }

        .step-line {
            flex: 1;
            height: 2px;
            background: var(--border);
            margin: 0 12px;
        }
        .step-line.done { background: var(--teal); }

        /* ══ Page header ══ */
        .page-header {
            margin-bottom: 24px;
        }
        .page-header h1 { font-size: 22px; font-weight: 800; color: var(--text); }
        .page-header p { font-size: 13.5px; color: var(--muted); margin-top: 4px; }

        /* ══ Summary card ══ */
        .summary-card {
            background: var(--navy);
            border-radius: 12px;
            padding: 18px 24px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 32px;
            flex-wrap: wrap;
        }
        .summary-item { }
        .summary-item .s-label { font-size: 10px; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.07em; font-weight: 600; }
        .summary-item .s-value { font-size: 14px; font-weight: 700; color: #fff; margin-top: 3px; }

        /* ══ Two-column layout ══ */
        .layout { display: grid; grid-template-columns: 1fr 300px; gap: 24px; align-items: start; }

        /* ══ Section card ══ */
        .card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .card-head {
            padding: 16px 22px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-head-icon {
            width: 30px; height: 30px;
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px;
        }

        .card-head h2 { font-size: 14px; font-weight: 700; color: var(--text); }
        .card-head p  { font-size: 12px; color: var(--muted); margin-top: 2px; }

        .card-body { padding: 20px 22px; }

        /* ══ Risk rows ══ */
        .risk-row {
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 18px 20px;
            margin-bottom: 14px;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .risk-row:last-child { margin-bottom: 0; }
        .risk-row:hover { border-color: #93c5fd; box-shadow: 0 2px 8px rgba(29,78,216,0.07); }

        .risk-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 14px;
        }

        .risk-info { flex: 1; }
        .risk-name { font-size: 14px; font-weight: 700; color: var(--text); }
        .risk-desc { font-size: 12px; color: var(--muted); margin-top: 3px; line-height: 1.5; }

        .risk-badges { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 8px; }

        .badge {
            font-size: 10px; font-weight: 700;
            padding: 2px 7px; border-radius: 20px;
            letter-spacing: 0.04em;
        }
        .badge-c   { background: #fee2e2; color: #991b1b; }
        .badge-h   { background: #fef3c7; color: #92400e; }
        .badge-m   { background: #d1fae5; color: #065f46; }
        .badge-cia { background: var(--blue-pale); color: #1e40af; }
        .badge-impact { background: #f1f5f9; color: var(--text-2); }

        /* Score display */
        .score-display {
            text-align: center;
            flex-shrink: 0;
        }

        .score-box {
            width: 60px; height: 60px;
            border-radius: 12px;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            font-weight: 800;
        }
        .score-box.critical { background: #fee2e2; color: #991b1b; }
        .score-box.high     { background: #fef3c7; color: #92400e; }
        .score-box.medium   { background: #d1fae5; color: #065f46; }
        .score-box.low      { background: #f1f5f9; color: #334155; }

        .score-num  { font-size: 22px; line-height: 1; }
        .score-lbl  { font-size: 8px; text-transform: uppercase; letter-spacing: 0.06em; margin-top: 2px; font-weight: 700; }

        /* Likelihood slider */
        .likelihood-section { }

        .likelihood-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .likelihood-header label {
            font-size: 12px; font-weight: 600; color: var(--text-2);
        }

        .likelihood-value {
            font-size: 13px; font-weight: 800; color: var(--blue);
            background: var(--blue-pale);
            padding: 2px 10px; border-radius: 20px;
        }

        .slider-wrap { position: relative; }

        input[type="range"] {
            width: 100%;
            height: 6px;
            -webkit-appearance: none;
            background: linear-gradient(to right, var(--blue) 0%, var(--blue) var(--pct, 60%), var(--border) var(--pct, 60%), var(--border) 100%);
            border-radius: 3px;
            outline: none;
            cursor: pointer;
        }

        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 18px; height: 18px;
            border-radius: 50%;
            background: var(--white);
            border: 2.5px solid var(--blue);
            box-shadow: 0 1px 4px rgba(0,0,0,0.15);
            cursor: pointer;
        }

        .slider-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
        }
        .slider-labels span {
            font-size: 10px; color: var(--muted); font-weight: 500;
        }

        /* Formula line */
        .formula-line {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 12px;
            padding: 8px 12px;
            background: var(--surface);
            border-radius: 7px;
            font-size: 12px;
            color: var(--text-2);
        }
        .formula-line .f-num {
            font-weight: 800; font-size: 13px;
        }
        .formula-line .f-op { color: var(--muted); }

        /* ══ Info panel ══ */
        .info-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 16px;
        }
        .info-head {
            padding: 13px 16px;
            border-bottom: 1px solid var(--border);
            font-size: 12px; font-weight: 700; color: var(--text);
        }
        .info-body { padding: 14px 16px; }

        .severity-item {
            display: flex; align-items: center; gap: 10px;
            padding: 7px 0;
            border-bottom: 1px solid var(--surface);
        }
        .severity-item:last-child { border-bottom: none; }
        .sev-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
        .sev-dot.critical { background: var(--red); }
        .sev-dot.high     { background: var(--amber); }
        .sev-dot.medium   { background: var(--green); }
        .sev-dot.low      { background: #94a3b8; }
        .sev-label { font-size: 12px; font-weight: 600; color: var(--text); flex: 1; }
        .sev-range { font-size: 11px; color: var(--muted); font-weight: 500; }

        .matrix-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 3px;
            margin-top: 4px;
        }
        .matrix-cell {
            aspect-ratio: 1;
            border-radius: 4px;
            display: flex; align-items: center; justify-content: center;
            font-size: 9px; font-weight: 700; color: rgba(255,255,255,0.9);
        }

        .tip-box {
            background: var(--blue-pale);
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 12px;
            color: #1e40af;
            line-height: 1.6;
        }
        .tip-box strong { display: block; margin-bottom: 4px; font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; }

        /* ══ Submit row ══ */
        .submit-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 8px;
            padding: 20px 22px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
        }

        .btn-primary {
            background: var(--blue);
            color: #fff;
            border: none;
            padding: 11px 24px;
            border-radius: 8px;
            font-size: 14px; font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: background 0.15s, transform 0.1s;
            display: flex; align-items: center; gap: 8px;
        }
        .btn-primary:hover { background: #1e40af; transform: translateY(-1px); }

        .btn-back {
            background: transparent;
            color: var(--muted);
            border: 1px solid var(--border);
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 13px; font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px;
            transition: border-color 0.12s, color 0.12s;
        }
        .btn-back:hover { border-color: #94a3b8; color: var(--text-2); }

        .total-score-preview {
            text-align: center;
        }
        .total-score-preview .ts-label { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.06em; font-weight: 600; }
        .total-score-preview .ts-risks { font-size: 20px; font-weight: 800; color: var(--text); margin-top: 2px; }
        .total-score-preview .ts-sub { font-size: 11px; color: var(--muted); }

        .no-threats {
            text-align: center;
            padding: 48px 24px;
            color: var(--muted);
        }
        .no-threats .nt-icon { font-size: 40px; margin-bottom: 12px; }
        .no-threats h3 { font-size: 15px; font-weight: 700; color: var(--text-2); margin-bottom: 6px; }
        .no-threats p { font-size: 13px; line-height: 1.6; }

        @media (max-width: 900px) {
            .layout { grid-template-columns: 1fr; }
            .main { margin-left: 0; }
            
            .content { padding: 20px 16px 40px; }
        }
    
        /* Mobile responsive */
        .menu-toggle {
            display: none; position: fixed; top: 14px; left: 14px; z-index: 200;
            width: 38px; height: 38px; border-radius: 9px;
            background: var(--navy); border: none; cursor: pointer;
            align-items: center; justify-content: center; flex-direction: column; gap: 5px;
        }
        .menu-toggle span { display: block; width: 18px; height: 2px; background: #fff; border-radius: 2px; }
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 98; }
        @media (max-width: 768px) {
            body, html { overflow-x: hidden !important; max-width: 100vw !important; }
            .menu-toggle { display: flex; }
            .sidebar { transform: translateX(-100%); transition: transform 0.25s ease; z-index: 99; }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay.open { display: block; }
            .main { margin-left: 0 !important; width: 100% !important; max-width: 100% !important; padding: 16px !important; padding-top: 64px !important; box-sizing: border-box !important; overflow-x: hidden !important; }
            .page-header { flex-direction: column; align-items: flex-start; gap: 12px; }
            .page-title { font-size: 18px; }
            table { display: block; overflow-x: auto; white-space: nowrap; }
            .grid-2, .grid-3, .form-grid { grid-template-columns: 1fr !important; }
        }

        
        /* ══ Extra mobile fixes ══ */
        @media (max-width: 768px) {
            * { box-sizing: border-box !important; }
            .stepper, .module-stepper, [class*="stepper"] {
                overflow-x: auto !important;
                white-space: nowrap !important;
            }
            .layout { grid-template-columns: 1fr !important; }
            .mit-card-body { grid-template-columns: 1fr !important; }
            .info-card, .risk-table-wrap, .card, .mit-card {
                max-width: 100% !important;
                overflow: hidden !important;
            }
            .nav-btn-row, [class*="btn-row"], [class*="nav-btn"] {
                flex-direction: column !important;
                gap: 10px !important;
            }
            .nav-btn-row a, .nav-btn-row button {
                width: 100% !important;
                text-align: center !important;
            }
            input, select, textarea {
                width: 100% !important;
                max-width: 100% !important;
            }
        }

        </style>

    <style>
    /* ══ Mobile override (injected) ══ */
    @media (max-width: 768px) {
        html, body { overflow-x: hidden !important; }
        .main { margin-left: 0 !important; width: 100vw !important; max-width: 100vw !important; padding: 16px !important; padding-top: 64px !important; box-sizing: border-box !important; }
        .sidebar { transform: translateX(-100%) !important; transition: transform 0.25s ease !important; }
        .sidebar.open { transform: translateX(0) !important; }
        .risk-table-wrap, .table-wrap, [class*="table-wrap"] { overflow-x: auto !important; -webkit-overflow-scrolling: touch !important; }
        table { min-width: 500px !important; }
        .layout { grid-template-columns: 1fr !important; }
        .stepper-wrap, [class*="stepper"] { overflow-x: auto !important; }
    }
    </style>


    <style>
    /* ══ Final mobile fixes ══ */
    @media (max-width: 768px) {
        .threat-grid { grid-template-columns: 1fr !important; }
        .submit-row { display: flex !important; flex-direction: column !important; gap: 10px !important; }
        .submit-row a, .submit-row button, .btn-back, .btn-primary { width: 100% !important; box-sizing: border-box !important; text-align: center !important; }
        .stepper, [class*="stepper"], .modules-stepper { overflow-x: auto !important; white-space: nowrap !important; }
        .step-item { display: inline-flex !important; white-space: normal !important; min-width: 90px !important; }
        .mit-card-body, .layout { grid-template-columns: 1fr !important; }
        .info-card { display: none !important; }
        .risk-table-wrap { overflow-x: auto !important; border-radius: 8px !important; }
        .risk-table-wrap table { min-width: 480px !important; }
    }
    </style>

</head>
<body>

<!-- ══ Sidebar ══ -->



<button class="menu-toggle" onclick="toggleSidebar()" aria-label="Menu">
    <span></span><span></span><span></span>
</button>
<div class="sidebar-overlay" id="overlay" onclick="toggleSidebar()"></div>
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-row">
            <div class="logo-icon">🛡️</div>
            <div>
                <div class="logo-name">CloudRisk DSS</div>
                <div class="logo-sub">OCTAVE Allegro · RGMM</div>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" class="nav-item">
            <span class="nav-icon">⊞</span> Dashboard
        </a>
        <a href="{{ route('assessments.create') }}" class="nav-item">
            <span class="nav-icon">＋</span> New Assessment
        </a>
        <a href="{{ url('/assessments') }}" class="nav-item">
            <span class="nav-icon">≡</span> All Assessments
        </a>
        <a href="#" class="nav-item active">
            <span class="nav-icon">▦</span> Risk Scoring
        </a>
        @php $latestDone = auth()->user()->assessments()->whereIn('status',['mitigated','scored'])->latest()->first(); @endphp
        @if($latestDone)
        <a href="{{ route('assessments.report', $latestDone->id) }}" class="nav-item">
            <span class="nav-icon">📋</span> Last Report
        </a>
        @else
        <a href="{{ url('/assessments') }}" class="nav-item">
            <span class="nav-icon">📋</span> Last Report
        </a>
        @endif
    </nav>

    <div class="sidebar-footer">
        <div class="user-row">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Risk Assessor</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Sign out</button>
        </form>
    </div>
</aside>

<!-- ══ Main ══ -->
<div class="main">
    <!-- Breadcrumb -->
    <div class="topbar">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="topbar-sep">›</span>
        <a href="{{ route('assessments.create') }}">New Assessment</a>
        <span class="topbar-sep">›</span>
        <span>Risk Scoring</span>
    </div>

    <div class="content">

        <!-- Progress bar -->
        <div class="progress-bar">
            <div class="step-item">
                <div class="step-circle done">✓</div>
                <div class="step-label">
                    <div class="s-num">Module 1</div>
                    <div class="s-name">Asset Profile</div>
                </div>
            </div>
            <div class="step-line done"></div>
            <div class="step-item">
                <div class="step-circle active">2</div>
                <div class="step-label">
                    <div class="s-num">Module 2–3</div>
                    <div class="s-name">Risk Scoring</div>
                </div>
            </div>
            <div class="step-line"></div>
            <div class="step-item">
                <div class="step-circle pending">3</div>
                <div class="step-label">
                    <div class="s-num">Module 4</div>
                    <div class="s-name muted">Mitigation</div>
                </div>
            </div>
            <div class="step-line"></div>
            <div class="step-item">
                <div class="step-circle pending">4</div>
                <div class="step-label">
                    <div class="s-num">Module 5</div>
                    <div class="s-name muted">Report</div>
                </div>
            </div>
        </div>

        <!-- Page header -->
        <div class="page-header">
            <h1>⚖️ Risk Scoring — Likelihood Assessment</h1>
            <p>Modules 2 & 3 · OCTAVE Allegro Steps 4–7 · For each threat, set the Likelihood (1–5). Risk Score = Likelihood × Impact (NIST SP 800-30 Rev.1)</p>
        </div>

        <!-- Assessment summary -->
        <div class="summary-card">
            <div class="summary-item">
                <div class="s-label">System</div>
                <div class="s-value">{{ $assessment->cloud_system_name }}</div>
            </div>
            <div class="summary-item">
                <div class="s-label">Category</div>
                <div class="s-value">{{ ucfirst($assessment->asset_category) }}</div>
            </div>
            <div class="summary-item">
                <div class="s-label">Service Model</div>
                <div class="s-value">{{ strtoupper($assessment->cloud_service_model) }}</div>
            </div>
            <div class="summary-item">
                <div class="s-label">Classification</div>
                <div class="s-value">{{ ucfirst($assessment->sensitivity_classification) }}</div>
            </div>
            <div class="summary-item">
                <div class="s-label">Threats Selected</div>
                <div class="s-value">{{ count($threats) }}</div>
            </div>
        </div>

        @php
        $allThreats = [
            ['id'=>'01','name'=>'Data Breach',                      'desc'=>'Unauthorised exposure of sensitive student or institutional data stored in the cloud.',         'impact'=>5,'likelihood_default'=>4,'severity'=>'critical','cia'=>['C']],
            ['id'=>'02','name'=>'Cloud Misconfiguration',            'desc'=>'Improperly configured cloud services exposing data or granting unintended access.',             'impact'=>5,'likelihood_default'=>4,'severity'=>'critical','cia'=>['C','I']],
            ['id'=>'03','name'=>'Unauthorised Access',               'desc'=>'Attackers gaining access to cloud resources without valid credentials or authorisation.',        'impact'=>4,'likelihood_default'=>4,'severity'=>'high','cia'=>['C','I']],
            ['id'=>'04','name'=>'Credential Compromise / Phishing',  'desc'=>'Theft of login credentials via phishing attacks targeting staff or students.',                  'impact'=>4,'likelihood_default'=>4,'severity'=>'high','cia'=>['C']],
            ['id'=>'05','name'=>'Insider Threat',                    'desc'=>'Malicious or negligent actions by authorised users causing data loss or system damage.',        'impact'=>5,'likelihood_default'=>3,'severity'=>'high','cia'=>['C','I']],
            ['id'=>'06','name'=>'Ransomware / Malware Attack',       'desc'=>'Malicious software encrypting or corrupting cloud-hosted academic data for ransom.',            'impact'=>5,'likelihood_default'=>3,'severity'=>'high','cia'=>['A','I']],
            ['id'=>'07','name'=>'DDoS / Service Disruption',         'desc'=>'Distributed attacks overwhelming cloud services, making them unavailable to users.',            'impact'=>4,'likelihood_default'=>3,'severity'=>'high','cia'=>['A']],
            ['id'=>'08','name'=>'Third-Party / Vendor Risk',         'desc'=>'Security failures in cloud providers or third-party integrations affecting institutional data.', 'impact'=>4,'likelihood_default'=>3,'severity'=>'high','cia'=>['C']],
            ['id'=>'09','name'=>'Account Hijacking',                 'desc'=>'Takeover of administrator or privileged accounts to gain full control of cloud systems.',       'impact'=>4,'likelihood_default'=>3,'severity'=>'high','cia'=>['C','I']],
            ['id'=>'10','name'=>'Accidental Data Loss',              'desc'=>'Unintentional deletion or corruption of academic records and research data.',                   'impact'=>4,'likelihood_default'=>3,'severity'=>'high','cia'=>['I']],
            ['id'=>'11','name'=>'Insufficient Logging & Monitoring', 'desc'=>'Lack of audit trails preventing detection of security incidents and breaches.',                 'impact'=>3,'likelihood_default'=>3,'severity'=>'medium','cia'=>['C']],
            ['id'=>'12','name'=>'Insecure API',                      'desc'=>'Vulnerabilities in cloud APIs allowing data exfiltration or unauthorised manipulation.',        'impact'=>3,'likelihood_default'=>3,'severity'=>'medium','cia'=>['C','I']],
            ['id'=>'13','name'=>'Privilege Escalation',              'desc'=>'Users gaining higher-level permissions than authorised, accessing restricted resources.',       'impact'=>4,'likelihood_default'=>2,'severity'=>'medium','cia'=>['C']],
            ['id'=>'14','name'=>'Non-Compliance / Data Protection',  'desc'=>'Failure to comply with GDPR, PDPA or institutional data governance requirements.',             'impact'=>3,'likelihood_default'=>3,'severity'=>'medium','cia'=>['C']],
            ['id'=>'15','name'=>'Physical Access to Infrastructure', 'desc'=>'Unauthorised physical access to cloud data centres or networking equipment.',                   'impact'=>4,'likelihood_default'=>2,'severity'=>'medium','cia'=>['C','I']],
        ];

        $selectedIds = $assessment->selected_threats ?? [];
        $threats = array_filter($allThreats, fn($t) => in_array($t['id'], $selectedIds));
        $threats = array_values($threats);
        @endphp

        <form method="POST" action="{{ route('assessments.risks.store', $assessment->id) }}" id="riskForm">
            @csrf

            <div class="layout">
                <div class="left-col">

                    @if(count($threats) === 0)
                    <div class="card">
                        <div class="card-body">
                            <div class="no-threats">
                                <div class="nt-icon">⚠️</div>
                                <h3>No threats selected</h3>
                                <p>You didn't select any threat scenarios in the previous step.<br>Go back and select the threats relevant to your cloud system.</p>
                                <a href="{{ route('assessments.create') }}" class="btn-back" style="margin-top:16px; display:inline-flex;">← Back to Asset Profile</a>
                            </div>
                        </div>
                    </div>
                    @else

                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-icon" style="background:#fef3c7;">⚠️</div>
                            <div>
                                <h2>Threat Likelihood Assessment</h2>
                                <p>Set likelihood score (1–5) for each selected threat · Impact scores are pre-set from the Cloud Risk Register</p>
                            </div>
                        </div>
                        <div class="card-body">

                            @foreach($threats as $i => $threat)
                            @php
                                $impact = $threat['impact'];
                                $defaultL = $threat['likelihood_default'];
                                $defaultScore = $defaultL * $impact;
                                $sev = $threat['severity'];
                            @endphp

                            <div class="risk-row" id="row-{{ $threat['id'] }}">
                                <div class="risk-top">
                                    <div class="risk-info">
                                        <div class="risk-name">{{ $threat['name'] }}</div>
                                        <div class="risk-desc">{{ $threat['desc'] }}</div>
                                        <div class="risk-badges">
                                            @if($sev === 'critical')
                                                <span class="badge badge-c">● CRITICAL</span>
                                            @elseif($sev === 'high')
                                                <span class="badge badge-h">● HIGH</span>
                                            @else
                                                <span class="badge badge-m">● MEDIUM</span>
                                            @endif
                                            @foreach($threat['cia'] as $dim)
                                                <span class="badge badge-cia">{{ $dim }}</span>
                                            @endforeach
                                            <span class="badge badge-impact">Impact: {{ $impact }}/5</span>
                                        </div>
                                    </div>
                                    <div class="score-display">
                                        <div class="score-box {{ $sev }}" id="scorebox-{{ $threat['id'] }}">
                                            <div class="score-num" id="score-{{ $threat['id'] }}">{{ $defaultScore }}</div>
                                            <div class="score-lbl" id="sevlbl-{{ $threat['id'] }}">{{ strtoupper($sev) }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Likelihood slider -->
                                <div class="likelihood-section">
                                    <div class="likelihood-header">
                                        <label>Likelihood in your institution (1 = Rare, 5 = Almost Certain)</label>
                                        <span class="likelihood-value" id="lval-{{ $threat['id'] }}">{{ $defaultL }}</span>
                                    </div>
                                    <div class="slider-wrap">
                                        <input type="range" min="1" max="5" value="{{ $defaultL }}"
                                            name="likelihood[{{ $threat['id'] }}]"
                                            id="slider-{{ $threat['id'] }}"
                                            data-impact="{{ $impact }}"
                                            data-threat="{{ $threat['id'] }}"
                                            style="--pct: {{ ($defaultL - 1) / 4 * 100 }}%"
                                            oninput="updateScore(this)">
                                    </div>
                                    <div class="slider-labels">
                                        <span>1 · Rare</span>
                                        <span>2 · Unlikely</span>
                                        <span>3 · Possible</span>
                                        <span>4 · Likely</span>
                                        <span>5 · Almost Certain</span>
                                    </div>

                                    <!-- Formula -->
                                    <div class="formula-line">
                                        <span>Risk Score</span>
                                        <span class="f-op">=</span>
                                        <span>Likelihood</span>
                                        <span class="f-op">×</span>
                                        <span>Impact</span>
                                        <span class="f-op">=</span>
                                        <span class="f-num" id="flikelihood-{{ $threat['id'] }}">{{ $defaultL }}</span>
                                        <span class="f-op">×</span>
                                        <span class="f-num">{{ $impact }}</span>
                                        <span class="f-op">=</span>
                                        <span class="f-num" style="color:var(--blue)" id="fscore-{{ $threat['id'] }}">{{ $defaultScore }}</span>
                                    </div>
                                </div>

                                <input type="hidden" name="impact[{{ $threat['id'] }}]" value="{{ $impact }}">
                                <input type="hidden" name="threat_name[{{ $threat['id'] }}]" value="{{ $threat['name'] }}">
                                <input type="hidden" name="threat_cia[{{ $threat['id'] }}]" value="{{ implode(',', $threat['cia']) }}">
                            </div>
                            @endforeach

                        </div>
                    </div>

                    <!-- Submit row -->
                    <div class="submit-row">
                        <a href="{{ route('assessments.create') }}" class="btn-back">← Back</a>
                        <div class="total-score-preview">
                            <div class="ts-label">Threats being scored</div>
                            <div class="ts-risks" id="totalCount">{{ count($threats) }}</div>
                            <div class="ts-sub">across all severity levels</div>
                        </div>
                        <button type="submit" class="btn-primary">
                            Save Risk Scores &amp; Continue →
                        </button>
                    </div>

                    @endif

                </div>

                <!-- ══ Right panel ══ -->
                <div class="right-col">

                    <!-- Severity Scale -->
                    <div class="info-card">
                        <div class="info-head">📊 NIST Severity Scale</div>
                        <div class="info-body">
                            <div class="severity-item">
                                <div class="sev-dot critical"></div>
                                <div class="sev-label">Critical</div>
                                <div class="sev-range">20–25</div>
                            </div>
                            <div class="severity-item">
                                <div class="sev-dot high"></div>
                                <div class="sev-label">High</div>
                                <div class="sev-range">12–19</div>
                            </div>
                            <div class="severity-item">
                                <div class="sev-dot medium"></div>
                                <div class="sev-label">Medium</div>
                                <div class="sev-range">6–11</div>
                            </div>
                            <div class="severity-item">
                                <div class="sev-dot low"></div>
                                <div class="sev-label">Low</div>
                                <div class="sev-range">1–5</div>
                            </div>
                        </div>
                    </div>

                    <!-- Likelihood guide -->
                    <div class="info-card">
                        <div class="info-head">📋 Likelihood Scale (NIST SP 800-30)</div>
                        <div class="info-body">
                            <div class="severity-item">
                                <div class="sev-label" style="font-size:11px;">5 · Almost Certain</div>
                                <div class="sev-range">Expected to occur</div>
                            </div>
                            <div class="severity-item">
                                <div class="sev-label" style="font-size:11px;">4 · Likely</div>
                                <div class="sev-range">Will probably occur</div>
                            </div>
                            <div class="severity-item">
                                <div class="sev-label" style="font-size:11px;">3 · Possible</div>
                                <div class="sev-range">Might occur at some time</div>
                            </div>
                            <div class="severity-item">
                                <div class="sev-label" style="font-size:11px;">2 · Unlikely</div>
                                <div class="sev-range">Could occur but rare</div>
                            </div>
                            <div class="severity-item">
                                <div class="sev-label" style="font-size:11px;">1 · Rare</div>
                                <div class="sev-range">May only in exceptional</div>
                            </div>
                        </div>
                    </div>

                    <!-- 5×5 Matrix -->
                    <div class="info-card">
                        <div class="info-head">🔢 Risk Matrix (L × I)</div>
                        <div class="info-body">
                            <div style="font-size:10px;color:var(--muted);margin-bottom:6px;">Impact →  /  Likelihood ↓</div>
                            <div class="matrix-grid">
                                @php
                                $colors = [
                                    1  => '#d1fae5', 2  => '#d1fae5', 3  => '#fef3c7',
                                    4  => '#fef3c7', 5  => '#fee2e2', 6  => '#d1fae5',
                                    8  => '#fef3c7', 9  => '#fef3c7', 10 => '#fef3c7',
                                    12 => '#fef3c7', 15 => '#fee2e2', 16 => '#fee2e2',
                                    20 => '#fee2e2', 25 => '#dc2626',
                                ];
                                for($l=5;$l>=1;$l--):
                                    for($imp=1;$imp<=5;$imp++):
                                        $s=$l*$imp;
                                        $bg = $s>=20?'#dc2626':($s>=12?'#d97706':($s>=6?'#059669':'#94a3b8'));
                                @endphp
                                <div class="matrix-cell" style="background:{{ $bg }}">{{ $s }}</div>
                                @php endfor; endfor; @endphp
                            </div>
                        </div>
                    </div>

                    <!-- Tip -->
                    <div class="tip-box">
                        <strong>💡 Scoring Tip</strong>
                        Adjust the likelihood slider to reflect your institution's specific context. The impact scores are pre-set from the Cloud Risk Register based on academic system research.
                    </div>

                </div>
            </div>
        </form>

    </div>
</div>

<script>
function getSeverity(score) {
    if (score >= 20) return { label: 'CRITICAL', cls: 'critical' };
    if (score >= 12) return { label: 'HIGH',     cls: 'high' };
    if (score >= 6)  return { label: 'MEDIUM',   cls: 'medium' };
    return { label: 'LOW', cls: 'low' };
}

function updateScore(slider) {
    const id      = slider.dataset.threat;
    const impact  = parseInt(slider.dataset.impact);
    const l       = parseInt(slider.value);
    const score   = l * impact;
    const sev     = getSeverity(score);
    const pct     = ((l - 1) / 4 * 100) + '%';

    // Update slider fill
    slider.style.setProperty('--pct', pct);

    // Update display
    document.getElementById('lval-' + id).textContent       = l;
    document.getElementById('score-' + id).textContent      = score;
    document.getElementById('sevlbl-' + id).textContent     = sev.label;
    document.getElementById('flikelihood-' + id).textContent = l;
    document.getElementById('fscore-' + id).textContent     = score;

    // Update score box colour
    const box = document.getElementById('scorebox-' + id);
    box.className = 'score-box ' + sev.cls;
}
</script>

<script>
function toggleSidebar(){
    var s = document.querySelector('.sidebar');
    var o = document.getElementById('soverlay');
    s.classList.toggle('open');
    o.classList.toggle('open');
}
</script>
</body>
</html>