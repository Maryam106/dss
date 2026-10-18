<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risk Assessment Report — CloudRisk DSS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
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
        body { font-family: 'Inter', sans-serif; background: var(--surface); color: var(--text); min-height: 100vh; display: flex; }

        /* Sidebar */
        .sidebar { width:240px; background:var(--navy); min-height:100vh; display:flex; flex-direction:column; flex-shrink:0; position:fixed; top:0; left:0; bottom:0; }
        .sidebar-logo { padding:22px 20px 18px; border-bottom:1px solid rgba(255,255,255,0.07); }
        .logo-row { display:flex; align-items:center; gap:11px; }
        .logo-icon { width:36px; height:36px; background:linear-gradient(135deg,var(--blue) 0%,var(--teal) 100%); border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:17px; flex-shrink:0; }
        .logo-name { font-size:14px; font-weight:700; color:#fff; }
        .logo-sub  { font-size:10px; color:rgba(255,255,255,0.38); margin-top:2px; }
        .sidebar-nav { flex:1; padding:14px 10px; display:flex; flex-direction:column; gap:1px; }
        .nav-label { font-size:10px; font-weight:600; color:rgba(255,255,255,0.28); letter-spacing:0.08em; text-transform:uppercase; padding:14px 10px 6px; }
        .nav-item { display:flex; align-items:center; gap:9px; padding:9px 10px; border-radius:7px; text-decoration:none; font-size:13px; font-weight:500; color:rgba(255,255,255,0.5); transition:background 0.12s,color 0.12s; }
        .nav-item:hover { background:rgba(255,255,255,0.07); color:rgba(255,255,255,0.88); }
        .nav-item.active { background:rgba(59,130,246,0.16); color:#93c5fd; }
        .nav-icon { font-size:14px; width:18px; text-align:center; flex-shrink:0; }
        .sidebar-footer { padding:14px 10px; border-top:1px solid rgba(255,255,255,0.07); }
        .user-row { display:flex; align-items:center; gap:9px; padding:8px 10px; }
        .user-avatar { width:32px; height:32px; background:linear-gradient(135deg,var(--blue) 0%,var(--teal) 100%); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; color:#fff; flex-shrink:0; }
        .user-info { flex:1; min-width:0; }
        .user-name { font-size:12.5px; font-weight:600; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .user-role { font-size:10px; color:rgba(255,255,255,0.35); margin-top:1px; }
        .logout-btn { display:block; width:100%; margin-top:8px; padding:7px; background:transparent; color:rgba(255,255,255,0.35); border:1px solid rgba(255,255,255,0.1); border-radius:6px; font-size:12px; font-family:'Inter',sans-serif; cursor:pointer; transition:color 0.12s,border-color 0.12s; text-align:center; text-decoration:none; }
        .logout-btn:hover { color:rgba(255,255,255,0.7); border-color:rgba(255,255,255,0.25); }

        /* Main */
        .main { margin-left:240px; flex:1; padding:36px 40px 60px; min-width:0; box-sizing:border-box; }
        .topbar { background:var(--white); border-bottom:1px solid var(--border); padding:16px 32px; display:flex; align-items:center; gap:8px; font-size:13px; color:var(--muted); }
        .topbar a { color:var(--blue); text-decoration:none; font-weight:500; }
        .topbar a:hover { text-decoration:underline; }
        .topbar-sep { color:var(--border); }
        .content { padding:28px 32px 48px; }

        /* Progress bar */
        .progress-bar { background:var(--white); border:1px solid var(--border); border-radius:12px; padding:20px 28px; margin-bottom:24px; display:flex; align-items:center; }
        .step-item { display:flex; align-items:center; flex:1; }
        .step-circle { width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; flex-shrink:0; }
        .step-circle.done   { background:var(--teal); color:#fff; }
        .step-circle.active { background:var(--blue); color:#fff; box-shadow:0 0 0 4px var(--blue-pale); }
        .step-circle.pending{ background:var(--surface); color:var(--muted); border:2px solid var(--border); }
        .step-label { margin-left:10px; }
        .step-label .s-num  { font-size:10px; color:var(--muted); font-weight:600; text-transform:uppercase; letter-spacing:0.05em; }
        .step-label .s-name { font-size:12.5px; font-weight:600; color:var(--text); margin-top:1px; }
        .step-label .s-name.muted { color:var(--muted); }
        .step-line { flex:1; height:2px; background:var(--border); margin:0 12px; }
        .step-line.done { background:var(--teal); }

        /* Page header */
        .page-header { margin-bottom:24px; display:flex; align-items:flex-start; justify-content:space-between; gap:16px; }
        .page-title { font-size:22px; font-weight:800; color:var(--text); display:flex; align-items:center; gap:10px; }
        .page-title .icon { font-size:20px; }
        .page-subtitle { font-size:13px; color:var(--muted); margin-top:4px; }
        .header-actions { display:flex; gap:10px; flex-shrink:0; }
        .btn-dashboard { display:flex; align-items:center; gap:7px; padding:9px 18px; background:var(--teal); color:#fff; border:none; border-radius:8px; font-size:13px; font-weight:600; font-family:'Inter',sans-serif; cursor:pointer; text-decoration:none; transition:background 0.15s; }
        .btn-dashboard:hover { background:#0f766e; }
        .btn-print { display:flex; align-items:center; gap:7px; padding:9px 18px; background:var(--navy); color:#fff; border:none; border-radius:8px; font-size:13px; font-weight:600; font-family:'Inter',sans-serif; cursor:pointer; text-decoration:none; transition:background 0.15s; }
        .btn-print:hover { background:var(--navy-mid); }
        .btn-export { display:flex; align-items:center; gap:7px; padding:9px 18px; background:var(--blue); color:#fff; border:none; border-radius:8px; font-size:13px; font-weight:600; font-family:'Inter',sans-serif; cursor:pointer; text-decoration:none; transition:background 0.15s; }
        .btn-export:hover { background:#1e40af; }

        /* Summary strip */
        .summary-strip { background:var(--navy); border-radius:12px; padding:18px 24px; margin-bottom:24px; display:flex; gap:32px; flex-wrap:wrap; }
        .s-item { display:flex; flex-direction:column; gap:3px; }
        .s-label { font-size:10px; font-weight:600; color:rgba(255,255,255,0.4); text-transform:uppercase; letter-spacing:0.06em; }
        .s-value { font-size:14px; font-weight:700; color:#fff; }

        /* Stat cards */
        .stat-row { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px; }
        .stat-card { background:var(--white); border:1px solid var(--border); border-radius:12px; padding:20px; }
        .stat-label { font-size:11px; font-weight:600; color:var(--muted); text-transform:uppercase; letter-spacing:0.06em; margin-bottom:8px; }
        .stat-value { font-size:28px; font-weight:800; line-height:1; }
        .stat-value.red    { color:var(--red); }
        .stat-value.amber  { color:var(--amber); }
        .stat-value.blue   { color:var(--blue); }
        .stat-value.green  { color:var(--green); }
        .stat-sub { font-size:11px; color:var(--muted); margin-top:6px; }

        /* Section */
        .section { background:var(--white); border:1px solid var(--border); border-radius:12px; margin-bottom:24px; overflow:hidden; }
        .section-header { padding:18px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; }
        .section-title { font-size:14px; font-weight:700; color:var(--text); display:flex; align-items:center; gap:8px; }
        .section-badge { font-size:11px; font-weight:600; padding:2px 8px; border-radius:20px; background:var(--blue-pale); color:var(--blue); }

        /* Risk table */
        .risk-table { width:100%; border-collapse:collapse; }
        .risk-table th { padding:11px 16px; text-align:left; font-size:11px; font-weight:600; color:var(--muted); text-transform:uppercase; letter-spacing:0.05em; background:var(--surface); border-bottom:1px solid var(--border); }
        .risk-table td { padding:13px 16px; font-size:13px; border-bottom:1px solid var(--border); vertical-align:middle; }
        .risk-table tr:last-child td { border-bottom:none; }
        .risk-table tr:hover td { background:#fafbfc; }
        .rank-badge { width:28px; height:28px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; color:#fff; }
        .rank-badge.r1 { background:#ef4444; }
        .rank-badge.r2 { background:#f97316; }
        .rank-badge.r3 { background:#eab308; }
        .rank-badge.rn { background:var(--muted); }
        .threat-name { font-weight:600; color:var(--text); }
        .cia-tags { display:flex; gap:4px; margin-top:3px; }
        .cia-tag { font-size:10px; font-weight:600; padding:1px 6px; border-radius:4px; background:var(--blue-pale); color:var(--blue); }
        .score-cell { font-size:18px; font-weight:800; }
        .score-cell.critical { color:var(--red); }
        .score-cell.high     { color:var(--amber); }
        .score-cell.medium   { color:var(--blue); }
        .score-cell.low      { color:var(--green); }
        .sev-badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; }
        .sev-badge.critical { background:var(--red-pale);   color:var(--red); }
        .sev-badge.high     { background:var(--amber-pale); color:var(--amber); }
        .sev-badge.medium   { background:var(--blue-pale);  color:var(--blue); }
        .sev-badge.low      { background:var(--green-pale); color:var(--green); }
        .treatment-badge { display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:6px; font-size:11px; font-weight:600; }
        .treatment-badge.reduce   { background:#dbeafe; color:#1d4ed8; }
        .treatment-badge.avoid    { background:#fee2e2; color:#dc2626; }
        .treatment-badge.transfer { background:#fef3c7; color:#d97706; }
        .treatment-badge.accept   { background:#d1fae5; color:#059669; }

        /* Charts row */
        .charts-row { display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:24px; }
        .chart-card { background:var(--white); border:1px solid var(--border); border-radius:12px; padding:24px; }
        .chart-title { font-size:13px; font-weight:700; color:var(--text); margin-bottom:16px; }
        .chart-wrap { position:relative; height:220px; }

        /* Mitigation summary */
        .mit-grid { display:grid; gap:0; }
        .mit-row { display:grid; grid-template-columns:2fr 1fr 2fr 3fr; gap:0; border-bottom:1px solid var(--border); }
        .mit-row:last-child { border-bottom:none; }
        .mit-row.header { background:var(--surface); }
        .mit-cell { padding:12px 16px; font-size:13px; }
        .mit-cell.header-cell { font-size:11px; font-weight:600; color:var(--muted); text-transform:uppercase; letter-spacing:0.05em; }
        .mit-notes { font-size:12px; color:var(--muted); font-style:italic; }

        /* Compliance section */
        .compliance-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; padding:24px; }
        .comp-card { border:1px solid var(--border); border-radius:10px; padding:16px; }
        .comp-logo { font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:0.08em; margin-bottom:8px; }
        .comp-title { font-size:13px; font-weight:700; color:var(--text); margin-bottom:6px; }
        .comp-desc { font-size:12px; color:var(--muted); line-height:1.5; }
        .comp-status { display:inline-flex; align-items:center; gap:5px; margin-top:10px; font-size:11px; font-weight:600; color:var(--teal); }

        /* Print styles */
        @media print {
            .sidebar, .topbar, .header-actions, .progress-bar { display:none !important; }
            .main { margin-left:0 !important; }
            .content { padding:0 !important; }
            body { background:#fff !important; }
            .section, .stat-card, .chart-card { break-inside:avoid; }
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

<!-- Sidebar -->



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
        <a href="{{ route('assessments.report', $assessment->id) }}" class="nav-item active">
            <span class="nav-icon">📋</span> Last Report
        </a>
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

<!-- Main -->
<div class="main">
    <div class="topbar">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="topbar-sep">/</span>
        <span>Assessment #{{ $assessment->id }}</span>
        <span class="topbar-sep">/</span>
        <span>Risk Assessment Report</span>
    </div>

    <div class="content">

        <!-- Progress -->
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
                <div class="step-circle done">✓</div>
                <div class="step-label">
                    <div class="s-num">Module 2–3</div>
                    <div class="s-name">Risk Scoring</div>
                </div>
            </div>
            <div class="step-line done"></div>
            <div class="step-item">
                <div class="step-circle done">✓</div>
                <div class="step-label">
                    <div class="s-num">Module 4</div>
                    <div class="s-name">Mitigation</div>
                </div>
            </div>
            <div class="step-line done"></div>
            <div class="step-item">
                <div class="step-circle active">5</div>
                <div class="step-label">
                    <div class="s-num">Module 5</div>
                    <div class="s-name">Report</div>
                </div>
            </div>
        </div>

        <!-- Page header -->
        <div class="page-header">
            <div>
                <div class="page-title"><span class="icon">📋</span> Risk Assessment Report</div>
                <div class="page-subtitle">Module 5 · OCTAVE Allegro · Complete risk register and mitigation summary</div>
            </div>
            <div class="header-actions"></div>
        </div>

        @php
        $risks = $risks ?? [];
        $mitPlan = collect($assessment->mitigation_plan ?? []);

        $critical = collect($risks)->filter(fn($r) => $r['score'] >= 20)->count();
        $high     = collect($risks)->filter(fn($r) => $r['score'] >= 12 && $r['score'] < 20)->count();
        $medium   = collect($risks)->filter(fn($r) => $r['score'] >= 6  && $r['score'] < 12)->count();
        $low      = collect($risks)->filter(fn($r) => $r['score'] < 6)->count();
        $total    = count($risks);
        $avgScore = $total > 0 ? round(collect($risks)->sum('score') / $total, 1) : 0;

        function getSev($score) {
            if ($score >= 20) return 'critical';
            if ($score >= 12) return 'high';
            if ($score >= 6)  return 'medium';
            return 'low';
        }
        @endphp

        <!-- Summary strip -->
        <div class="summary-strip">
            <div class="s-item">
                <div class="s-label">System</div>
                <div class="s-value">{{ $assessment->cloud_system_name }}</div>
            </div>
            <div class="s-item">
                <div class="s-label">University</div>
                <div class="s-value">{{ $assessment->university_name }}</div>
            </div>
            <div class="s-item">
                <div class="s-label">Assessor</div>
                <div class="s-value">{{ $assessment->assessor_name }}</div>
            </div>
            <div class="s-item">
                <div class="s-label">Date</div>
                <div class="s-value">{{ $assessment->assessment_date?->format('d M Y') }}</div>
            </div>
            <div class="s-item">
                <div class="s-label">Service Model</div>
                <div class="s-value">{{ strtoupper($assessment->cloud_service_model ?? '—') }}</div>
            </div>
            <div class="s-item">
                <div class="s-label">Classification</div>
                <div class="s-value">{{ ucfirst($assessment->sensitivity_classification ?? '—') }}</div>
            </div>
        </div>

        <!-- Stat cards -->
        <div class="stat-row">
            <div class="stat-card">
                <div class="stat-label">Critical Risks</div>
                <div class="stat-value red">{{ $critical }}</div>
                <div class="stat-sub">Score ≥ 20</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">High Risks</div>
                <div class="stat-value amber">{{ $high }}</div>
                <div class="stat-sub">Score 12–19</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Medium Risks</div>
                <div class="stat-value blue">{{ $medium }}</div>
                <div class="stat-sub">Score 6–11</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Avg Risk Score</div>
                <div class="stat-value green">{{ $avgScore }}</div>
                <div class="stat-sub">Out of 25 max</div>
            </div>
        </div>

        <!-- Charts -->
        <div class="charts-row">
            <div class="chart-card">
                <div class="chart-title">Risk Distribution by Severity</div>
                <div class="chart-wrap">
                    <canvas id="sevChart"></canvas>
                </div>
            </div>
            <div class="chart-card">
                <div class="chart-title">Risk Score per Threat</div>
                <div class="chart-wrap">
                    <canvas id="scoreChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Risk Register Table -->
        <div class="section">
            <div class="section-header">
                <div class="section-title">📊 Complete Risk Register
                    <span class="section-badge">{{ $total }} Threats</span>
                </div>
                <div style="font-size:11px;color:var(--muted);">Ranked by Risk Score (highest first) · NIST SP 800-30 Rev.1</div>
            </div>
            <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;width:100%;"><table class="risk-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Threat</th>
                        <th>CIA</th>
                        <th>Likelihood</th>
                        <th>Impact</th>
                        <th>Score</th>
                        <th>Severity</th>
                        <th>Treatment</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($risks as $i => $risk)
                    @php
                        $sev = getSev($risk['score']);
                        $mitEntry = $mitPlan->firstWhere('threat_id', $risk['threat_id'] ?? '');
                        $treatment = $mitEntry['treatment'] ?? 'reduce';
                        $rankClass = $i === 0 ? 'r1' : ($i === 1 ? 'r2' : ($i === 2 ? 'r3' : 'rn'));
                    @endphp
                    <tr>
                        <td>
                            <div class="rank-badge {{ $rankClass }}">{{ $i + 1 }}</div>
                        </td>
                        <td>
                            <div class="threat-name">{{ $risk['name'] ?? '—' }}</div>
                            <div style="font-size:11px;color:var(--muted);margin-top:2px;">ID: {{ $risk['threat_id'] ?? '—' }}</div>
                        </td>
                        <td>
                            <div class="cia-tags">
                                @php $cia = is_array($risk['cia'] ?? null) ? $risk['cia'] : explode(',', $risk['cia'] ?? ''); @endphp
                                @foreach($cia as $c)
                                    @if(trim($c))<span class="cia-tag">{{ trim($c) }}</span>@endif
                                @endforeach
                            </div>
                        </td>
                        <td><strong>{{ $risk['likelihood'] ?? '—' }}</strong> / 5</td>
                        <td><strong>{{ $risk['impact'] ?? '—' }}</strong> / 5</td>
                        <td><span class="score-cell {{ $sev }}">{{ $risk['score'] ?? '—' }}</span></td>
                        <td><span class="sev-badge {{ $sev }}">{{ ucfirst($sev) }}</span></td>
                        <td>
                            <span class="treatment-badge {{ $treatment }}">
                                @if($treatment === 'reduce') 🔽 Reduce
                                @elseif($treatment === 'avoid') 🚫 Avoid
                                @elseif($treatment === 'transfer') 🔄 Transfer
                                @else ✅ Accept
                                @endif
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center;padding:40px;color:var(--muted);">
                            No risk scores found. Please complete the Risk Scoring step first.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table></div>
        </div>

        <!-- Mitigation Summary -->
        <div class="section">
            <div class="section-header">
                <div class="section-title">🛡 Mitigation Plan Summary
                    <span class="section-badge">ISO/IEC 27001:2022</span>
                </div>
            </div>
            <div class="mit-grid">
                <div class="mit-row header">
                    <div class="mit-cell header-cell">Threat</div>
                    <div class="mit-cell header-cell">Treatment</div>
                    <div class="mit-cell header-cell">ISO 27001 Controls</div>
                    <div class="mit-cell header-cell">Implementation Notes</div>
                </div>
                @forelse($risks as $risk)
                @php
                    $mitEntry = $mitPlan->first(fn($m) => (string)($m['threat_id'] ?? '') === (string)($risk['threat_id'] ?? ''));
                    $treatment = is_array($mitEntry) ? ($mitEntry['treatment'] ?? 'reduce') : 'reduce';
                    $notes     = is_array($mitEntry) ? ($mitEntry['notes'] ?? '—') : '—';
                    $controls  = is_array($mitEntry) ? ($mitEntry['controls'] ?? []) : [];
                    $controls  = is_array($controls) ? $controls : [];
                    $sev = getSev($risk['score']);
                @endphp
                <div class="mit-row">
                    <div class="mit-cell">
                        <div style="font-weight:600;font-size:13px;">{{ $risk['name'] ?? '—' }}</div>
                        <div><span class="sev-badge {{ $sev }}" style="margin-top:4px;display:inline-flex;">{{ ucfirst($sev) }} · {{ $risk['score'] ?? 0 }}</span></div>
                    </div>
                    <div class="mit-cell">
                        <span class="treatment-badge {{ $treatment }}">
                            @if($treatment === 'reduce') 🔽 Reduce
                            @elseif($treatment === 'avoid') 🚫 Avoid
                            @elseif($treatment === 'transfer') 🔄 Transfer
                            @else ✅ Accept
                            @endif
                        </span>
                    </div>
                    <div class="mit-cell" style="font-size:12px;color:var(--text-2);">
                        @if(is_array($controls) && count($controls))
                            {{ implode(', ', $controls) }}
                        @else
                            —
                        @endif
                    </div>
                    <div class="mit-cell">
                        <div class="mit-notes">{{ $notes }}</div>
                    </div>
                </div>
                @empty
                <div class="mit-row">
                    <div class="mit-cell" colspan="4" style="color:var(--muted);">No mitigation data found.</div>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Compliance Framework -->
        <div class="section">
            <div class="section-header">
                <div class="section-title">✅ Compliance Framework Alignment</div>
            </div>
            <div class="compliance-grid">
                <div class="comp-card">
                    <div class="comp-logo">OCTAVE Allegro</div>
                    <div class="comp-title">Risk Assessment Methodology</div>
                    <div class="comp-desc">All 8 steps of OCTAVE Allegro completed — asset profiling, threat identification, risk scoring, and mitigation planning.</div>
                    <div class="comp-status">✓ Completed</div>
                </div>
                <div class="comp-card">
                    <div class="comp-logo">ISO/IEC 27001:2022</div>
                    <div class="comp-title">Information Security Controls</div>
                    <div class="comp-desc">Annex A controls mapped to each identified threat across all 4 themes: Organisational, People, Physical, Technological.</div>
                    <div class="comp-status">✓ Controls Mapped</div>
                </div>
                <div class="comp-card">
                    <div class="comp-logo">ISO/IEC 27005:2022</div>
                    <div class="comp-title">Risk Treatment</div>
                    <div class="comp-desc">Treatment decisions applied per threat using the four ISO 27005 options: Reduce, Avoid, Transfer, Accept.</div>
                    <div class="comp-status">✓ Treatment Applied</div>
                </div>
                <div class="comp-card">
                    <div class="comp-logo">NIST SP 800-30 Rev.1</div>
                    <div class="comp-title">Risk Scoring Model</div>
                    <div class="comp-desc">Risk Score = Likelihood × Impact (1–5 scale). Severity thresholds: Critical ≥20, High 12–19, Medium 6–11, Low 1–5.</div>
                    <div class="comp-status">✓ Scoring Applied</div>
                </div>
                <div class="comp-card">
                    <div class="comp-logo">COBIT 2019</div>
                    <div class="comp-title">IT Governance</div>
                    <div class="comp-desc">RACI framework applied for accountability: Responsible, Accountable, Consulted, Informed roles defined per control.</div>
                    <div class="comp-status">✓ Governance Applied</div>
                </div>
                <div class="comp-card">
                    <div class="comp-logo">RGMM</div>
                    <div class="comp-title">Risk Governance Model</div>
                    <div class="comp-desc">Risk Governance & Mitigation Model integrating all five standards into a unified cloud risk assessment workflow.</div>
                    <div class="comp-status">✓ Framework Complete</div>
                </div>
            </div>
        </div>

        <!-- Footer note -->
        <div style="text-align:center;font-size:12px;color:var(--muted);padding:12px 0;">
            Generated by CloudRisk DSS · OCTAVE Allegro &amp; RGMM Framework · {{ now()->format('d M Y, H:i') }}
        </div>

        <!-- Action Buttons -->
        <div style="display:flex;justify-content:center;gap:12px;padding:24px 0 32px;">
            <a href="{{ route('dashboard') }}" class="btn-dashboard">🏠 Back to Dashboard</a>
            <button class="btn-print" onclick="window.print()">🖨 Print</button>
            <button class="btn-export" onclick="window.print()">↓ Export PDF</button>
        </div>

    </div>
</div>

<script>
@php
    $labels  = collect($risks)->pluck('name')->map(fn($n) => strlen($n) > 20 ? substr($n,0,18).'…' : $n)->toArray();
    $scores  = collect($risks)->pluck('score')->toArray();
    $colors  = collect($risks)->map(function($r) {
        $s = $r['score'];
        if ($s >= 20) return '#dc2626';
        if ($s >= 12) return '#d97706';
        if ($s >= 6)  return '#1d4ed8';
        return '#059669';
    })->toArray();
@endphp

// Severity donut
new Chart(document.getElementById('sevChart'), {
    type: 'doughnut',
    data: {
        labels: ['Critical (≥20)', 'High (12–19)', 'Medium (6–11)', 'Low (<6)'],
        datasets: [{
            data: [{{ $critical }}, {{ $high }}, {{ $medium }}, {{ $low }}],
            backgroundColor: ['#dc2626','#d97706','#1d4ed8','#059669'],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom', labels: { font: { size: 11, family: 'Inter' }, padding: 12 } }
        }
    }
});

// Score bar chart
new Chart(document.getElementById('scoreChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($labels) !!},
        datasets: [{
            label: 'Risk Score',
            data: {!! json_encode($scores) !!},
            backgroundColor: {!! json_encode($colors) !!},
            borderRadius: 5,
            borderSkipped: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                max: 25,
                grid: { color: '#f1f5f9' },
                ticks: { font: { size: 10, family: 'Inter' } }
            },
            x: {
                grid: { display: false },
                ticks: { font: { size: 9, family: 'Inter' }, maxRotation: 45 }
            }
        }
    }
});
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