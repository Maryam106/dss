<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Cloud Risk DSS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:        #0b1d3a;
            --navy-mid:    #112753;
            --navy-light:  #1a3a6b;
            --blue:        #1d4ed8;
            --blue-soft:   #3b82f6;
            --blue-pale:   #dbeafe;
            --teal:        #0d9488;
            --teal-soft:   #14b8a6;
            --teal-pale:   #ccfbf1;
            --red:         #dc2626;
            --red-pale:    #fee2e2;
            --amber:       #d97706;
            --amber-pale:  #fef3c7;
            --green:       #059669;
            --green-pale:  #d1fae5;
            --white:       #ffffff;
            --surface:     #f1f5f9;
            --border:      #e2e8f0;
            --text:        #0f172a;
            --muted:       #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--surface);
            color: var(--text);
            min-height: 100vh;
            display: flex;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: 232px;
            background: var(--navy);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: fixed;
            top: 0; left: 0; bottom: 0;
        }

        .sidebar-logo {
            padding: 22px 18px 18px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }

        .logo-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-icon {
            width: 34px;
            height: 34px;
            background: linear-gradient(135deg, var(--blue) 0%, var(--teal) 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .logo-name { font-size: 14px; font-weight: 700; color: #fff; }
        .logo-sub  { font-size: 10px; color: rgba(255,255,255,0.35); margin-top: 1px; }

        .sidebar-nav {
            flex: 1;
            padding: 14px 10px;
            display: flex;
            flex-direction: column;
            gap: 1px;
            overflow-y: auto;
        }

        .nav-section-label {
            font-size: 10px;
            font-weight: 600;
            color: rgba(255,255,255,0.28);
            letter-spacing: 0.07em;
            text-transform: uppercase;
            padding: 14px 10px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 10px;
            border-radius: 7px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            color: rgba(255,255,255,0.5);
            transition: background 0.12s, color 0.12s;
        }
        .nav-item:hover { background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.88); }
        .nav-item.active {
            background: rgba(59,130,246,0.16);
            color: #93c5fd;
        }
        .nav-icon { font-size: 14px; width: 18px; text-align: center; flex-shrink: 0; }

        .sidebar-footer {
            padding: 14px 10px;
            border-top: 1px solid rgba(255,255,255,0.07);
        }

        .user-row {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 10px;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--blue) 0%, var(--teal) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .user-info { flex: 1; min-width: 0; }
        .user-name  { font-size: 12.5px; font-weight: 600; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-role  { font-size: 10px; color: rgba(255,255,255,0.35); margin-top: 1px; }

        .logout-btn {
            display: block;
            width: 100%;
            margin-top: 8px;
            padding: 7px;
            background: transparent;
            color: rgba(255,255,255,0.35);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 6px;
            font-size: 12px;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: color 0.12s, border-color 0.12s;
            text-align: center;
        }
        .logout-btn:hover { color: #f87171; border-color: rgba(248,113,113,0.3); }

        /* ── Main ── */
        .main {
        margin-left: 232px;
        flex: 1;
        padding: 36px 40px;
        }

        /* ── Topbar ── */
        .topbar {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 32px;
        }

        .page-greeting {
            font-size: 23px;
            font-weight: 800;
            letter-spacing: -0.025em;
            color: var(--text);
        }

        .page-date {
            font-size: 13px;
            color: var(--muted);
            margin-top: 4px;
            font-weight: 400;
        }

        .new-assess-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--navy);
            color: #fff;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background 0.12s, transform 0.1s;
            flex-shrink: 0;
        }
        .new-assess-btn:hover { background: var(--navy-mid); transform: translateY(-1px); }

        /* ── Stats ── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px 22px;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 3px;
            height: 100%;
            border-radius: 12px 0 0 12px;
        }
        .stat-blue::before  { background: var(--blue); }
        .stat-red::before   { background: var(--red); }
        .stat-amber::before { background: var(--amber); }
        .stat-teal::before  { background: var(--teal); }

        .stat-label { font-size: 12px; color: var(--muted); font-weight: 500; margin-bottom: 10px; }
        .stat-value {
            font-size: 30px;
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1;
            margin-bottom: 5px;
        }
        .stat-blue .stat-value  { color: var(--blue); }
        .stat-red .stat-value   { color: var(--red); }
        .stat-amber .stat-value { color: var(--amber); }
        .stat-teal .stat-value  { color: var(--teal); }

        .stat-sub { font-size: 11px; color: var(--muted); }

        /* ── Two Column ── */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 20px;
        }

        /* ── Section Card ── */
        .section-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .section-head {
            padding: 16px 22px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-title { font-size: 14px; font-weight: 700; color: var(--text); }

        .section-link {
            font-size: 12px;
            color: var(--blue-soft);
            text-decoration: none;
            font-weight: 500;
        }
        .section-link:hover { text-decoration: underline; }

        /* ── Empty State ── */
        .empty-state {
            padding: 52px 32px;
            text-align: center;
        }

        .empty-icon {
            width: 56px;
            height: 56px;
            background: var(--blue-pale);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin: 0 auto 16px;
        }

        .empty-title { font-size: 15px; font-weight: 700; color: var(--text); margin-bottom: 8px; }
        .empty-desc  { font-size: 13px; color: var(--muted); line-height: 1.6; margin-bottom: 22px; max-width: 360px; margin-left: auto; margin-right: auto; }
        .empty-btn {
            display: inline-block;
            background: var(--navy);
            color: #fff;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
            padding: 10px 22px;
            border-radius: 8px;
            transition: background 0.12s;
        }
        .empty-btn:hover { background: var(--navy-mid); }

        /* ── Assessment Rows ── */
        .assess-row {
            display: flex;
            align-items: center;
            padding: 14px 22px;
            border-bottom: 1px solid var(--border);
            gap: 14px;
            text-decoration: none;
            color: inherit;
            transition: background 0.1s;
        }
        .assess-row:last-child { border-bottom: none; }
        .assess-row:hover { background: var(--surface); }

        .assess-icon {
            width: 38px;
            height: 38px;
            background: var(--blue-pale);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        .assess-info { flex: 1; min-width: 0; }
        .assess-name { font-size: 13.5px; font-weight: 600; color: var(--text); }
        .assess-meta { font-size: 12px; color: var(--muted); margin-top: 2px; }

        .assess-badge {
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 12px;
            flex-shrink: 0;
        }
        .badge-done     { background: var(--green-pale); color: var(--green); }
        .badge-progress { background: var(--amber-pale); color: var(--amber); }

        /* ── Info Panel ── */
        .info-section { display: flex; flex-direction: column; gap: 20px; }

        .guide-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .guide-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 20px;
            border-bottom: 1px solid var(--border);
        }
        .guide-item:last-child { border-bottom: none; }

        .guide-num {
            width: 22px;
            height: 22px;
            background: var(--blue-pale);
            color: var(--blue);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .guide-text { font-size: 13px; color: var(--text); font-weight: 600; line-height: 1.4; }
        .guide-sub  { font-size: 11.5px; color: var(--muted); margin-top: 2px; line-height: 1.4; font-weight: 400; }

        /* ── Standards Reference Card ── */
        .standards-card {
            background: var(--navy);
            border-radius: 12px;
            padding: 20px;
        }

        .standards-card-title {
            font-size: 12px;
            font-weight: 700;
            color: rgba(255,255,255,0.5);
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        .standard-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 7px 0;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .standard-row:last-child { border-bottom: none; }

        .std-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
        .std-dot-blue  { background: var(--blue-soft); }
        .std-dot-teal  { background: var(--teal-soft); }
        .std-dot-amber { background: #fbbf24; }

        .std-name { font-size: 12px; font-weight: 600; color: rgba(255,255,255,0.75); flex: 1; }
        .std-role { font-size: 11px; color: rgba(255,255,255,0.35); }

        @media (max-width: 1000px) {
            
            .main { margin-left: 0; max-width: 100%; padding: 24px 20px; }
            .stats-row { grid-template-columns: 1fr 1fr; }
            .two-col { grid-template-columns: 1fr; }
        }
    
        

        
        

        
    /* ══════════════════════════════════════
       MOBILE RESPONSIVE — single authority
       ══════════════════════════════════════ */
    .menu-toggle {
        display: none;
        position: fixed; top: 14px; left: 14px; z-index: 200;
        width: 40px; height: 40px; border-radius: 9px;
        background: var(--navy); border: none; cursor: pointer;
        align-items: center; justify-content: center;
        flex-direction: column; gap: 5px;
    }
    .menu-toggle span { display: block; width: 18px; height: 2px; background: #fff; border-radius: 2px; }
    .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 98; }

    @media (max-width: 768px) {
        /* Prevent horizontal page scroll without blocking children */
        html, body { overflow-x: clip !important; }
        /* Hamburger button */
        .menu-toggle { display: flex !important; }
        .sidebar-overlay.open { display: block !important; }

        /* Sidebar: hidden off-screen, slides in on .open */
        .sidebar {
            position: fixed !important;
            transform: translateX(-100%) !important;
            transition: transform 0.25s ease !important;
            z-index: 99 !important;
        }
        .sidebar.open { transform: translateX(0) !important; }

        /* Main content area: full width, room for hamburger */
        .main {
            margin-left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            padding: 16px !important;
            padding-top: 64px !important;
            box-sizing: border-box !important;
            /* NO overflow-x here — let children scroll */
        }

        /* Step progress bar: scroll horizontally */
        .step-progress, .progress-bar {
            overflow-x: auto !important;
            overflow-y: visible !important;
            -webkit-overflow-scrolling: touch !important;
            padding: 14px 16px !important;
            flex-wrap: nowrap !important;
            display: flex !important;
        }
        .step-item {
            flex: 0 0 auto !important;
            flex-shrink: 0 !important;
            min-width: 120px !important;
        }
        .step-connector, .step-line {
            flex-shrink: 0 !important;
            min-width: 24px !important;
        }

        /* Threat grid: single column */
        .threat-grid { grid-template-columns: 1fr !important; }

        /* Threat card text visible */
        .threat-card-body {
            overflow: visible !important;
            word-break: break-word !important;
        }
        .threat-checkbox-card { overflow: visible !important; }
        .form-card { overflow: visible !important; }

        /* Tables: scrollable */
        .risk-table-wrap, .table-wrap {
            overflow-x: auto !important;
            overflow-y: visible !important;
            -webkit-overflow-scrolling: touch !important;
            width: 100% !important;
        }
        table {
            display: table !important;
            min-width: 600px !important;
            width: 100% !important;
        }

        /* Grids collapse */
        .form-layout { grid-template-columns: 1fr !important; }
        .form-row, .form-row-3 { grid-template-columns: 1fr !important; }
        .mit-card-body { grid-template-columns: 1fr !important; }
        .layout, .grid-2, .grid-3, .form-grid { grid-template-columns: 1fr !important; }
        .summary-card { gap: 16px !important; }

        /* Inputs full width */
        input, select, textarea {
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        /* Buttons stack */
        .form-actions, .nav-btn-row, .submit-row {
            flex-direction: column !important;
            gap: 10px !important;
            align-items: stretch !important;
        }
        .btn-back, .btn-next, .btn-submit, .btn-primary {
            width: 100% !important;
            box-sizing: border-box !important;
            text-align: center !important;
            justify-content: center !important;
        }

        /* Hide desktop-only side panels */
        .info-card, .info-panel { display: none !important; }

        /* Font size adjustments */
        .page-title, .page-header h1 { font-size: 18px !important; }
    }
</style>

</head>
<body>




<button class="menu-toggle" onclick="toggleSidebar()" aria-label="Menu">
    <span></span><span></span><span></span>
</button>
<div class="sidebar-overlay" id="overlay" onclick="toggleSidebar()"></div>
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-row">
            <div class="logo-icon">🛡</div>
            <div>
                <div class="logo-name">Cloud Risk DSS</div>
                <div class="logo-sub">OCTAVE Allegro · RGMM</div>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Workspace</div>
        <a href="{{ url('/dashboard') }}" class="nav-item active">
            <span class="nav-icon">⊞</span> Dashboard
        </a>
        <a href="{{ url('/assessments/create') }}" class="nav-item">
            <span class="nav-icon">＋</span> New Assessment
        </a>
        <a href="{{ url('/assessments') }}" class="nav-item">
            <span class="nav-icon">≡</span> All Assessments
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
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name ?? 'Researcher' }}</div>
                <div class="user-role">Risk Assessor</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Sign out</button>
        </form>
    </div>
</aside>

<main class="main">

    <!-- Topbar -->
    <div class="topbar">
        <div>
            <div class="page-greeting">
                Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }},
                {{ explode(' ', auth()->user()->name ?? 'Researcher')[0] }} 👋
            </div>
            <div class="page-date">{{ now()->format('l, d F Y') }} · Cloud Risk DSS</div>
        </div>
        <a href="{{ url('/assessments/create') }}" class="new-assess-btn">
            + New Assessment
        </a>
    </div>

    <!-- Stats -->
    <div class="stats-row">
        <div class="stat-card stat-blue">
            <div class="stat-label">Total Assessments</div>
            <div class="stat-value">{{ $totalAssessments ?? 0 }}</div>
            <div class="stat-sub">All time</div>
        </div>
        <div class="stat-card stat-red">
            <div class="stat-label">Total Risks Identified</div>
            <div class="stat-value">{{ $totalRisks ?? 0 }}</div>
            <div class="stat-sub">Across all assessments</div>
        </div>
        <div class="stat-card stat-amber">
            <div class="stat-label">Critical Risks</div>
            <div class="stat-value">{{ $criticalRisks ?? 0 }}</div>
            <div class="stat-sub">Score ≥ 17 (High priority)</div>
        </div>
        <div class="stat-card stat-teal">
            <div class="stat-label">Completed</div>
            <div class="stat-value">{{ $completedAssessments ?? 0 }}</div>
            <div class="stat-sub">Assessments finished</div>
        </div>
    </div>

    <!-- Main content -->
    <div class="two-col">

        <!-- Recent Assessments -->
        <div class="section-card">
            <div class="section-head">
                <div class="section-title">Recent Assessments</div>
                <a href="{{ url('/assessments') }}" class="section-link">View all →</a>
            </div>

            @if(isset($recentAssessments) && $recentAssessments->count() > 0)
                @foreach($recentAssessments as $a)
                <a href="{{ url('/assessments/'.$a->id.'/risks') }}" class="assess-row">
                    <div class="assess-icon">🏛</div>
                    <div class="assess-info">
                        <div class="assess-name">{{ $a->university_name }}</div>
                        <div class="assess-meta">{{ $a->assessor_name }} · {{ $a->assessment_date }}</div>
                    </div>
                    <span class="assess-badge {{ $a->status === 'completed' ? 'badge-done' : 'badge-progress' }}">
                        {{ $a->status === 'completed' ? 'Completed' : 'In progress' }}
                    </span>
                </a>
                @endforeach
            @else
                <div class="empty-state">
                    <div class="empty-icon">📋</div>
                    <div class="empty-title">No assessments yet</div>
                    <div class="empty-desc">
                        Begin your first OCTAVE Allegro assessment to identify and manage
                        cybersecurity risks in your university's cloud information systems.
                    </div>
                    <a href="{{ url('/assessments/create') }}" class="empty-btn">
                        Start first assessment
                    </a>
                </div>
            @endif
        </div>

        <!-- Right column -->
        <div class="info-section">

            <!-- How it works -->
            <div class="guide-card">
                <div class="section-head">
                    <div class="section-title">How it works</div>
                </div>
                <div class="guide-item">
                    <div class="guide-num">1</div>
                    <div>
                        <div class="guide-text">Define cloud assets</div>
                        <div class="guide-sub">LMS, student records, cloud storage, APIs</div>
                    </div>
                </div>
                <div class="guide-item">
                    <div class="guide-num">2</div>
                    <div>
                        <div class="guide-text">Set CIA requirements</div>
                        <div class="guide-sub">Confidentiality, Integrity, Availability weights</div>
                    </div>
                </div>
                <div class="guide-item">
                    <div class="guide-num">3</div>
                    <div>
                        <div class="guide-text">Add threat scenarios</div>
                        <div class="guide-sub">Ransomware, SQL injection, phishing, misconfig…</div>
                    </div>
                </div>
                <div class="guide-item">
                    <div class="guide-num">4</div>
                    <div>
                        <div class="guide-text">Score each risk</div>
                        <div class="guide-sub">Likelihood × Impact = Risk Score (NIST 800-30)</div>
                    </div>
                </div>
                <div class="guide-item">
                    <div class="guide-num">5</div>
                    <div>
                        <div class="guide-text">Get mitigation strategies</div>
                        <div class="guide-sub">ISO/IEC 27001 controls · Reduce / Avoid / Transfer</div>
                    </div>
                </div>
                <div class="guide-item">
                    <div class="guide-num">6</div>
                    <div>
                        <div class="guide-text">Export risk register</div>
                        <div class="guide-sub">Full PDF report ready to submit</div>
                    </div>
                </div>
            </div>

            <!-- Standards reference -->
            <div class="standards-card">
                <div class="standards-card-title">Integrated Standards (RGMM)</div>
                <div class="standard-row">
                    <div class="std-dot std-dot-blue"></div>
                    <div class="std-name">OCTAVE Allegro</div>
                    <div class="std-role">Core process</div>
                </div>
                <div class="standard-row">
                    <div class="std-dot std-dot-teal"></div>
                    <div class="std-name">ISO/IEC 27001:2022</div>
                    <div class="std-role">Control library</div>
                </div>
                <div class="standard-row">
                    <div class="std-dot std-dot-teal"></div>
                    <div class="std-name">ISO/IEC 27005:2022</div>
                    <div class="std-role">Treatment logic</div>
                </div>
                <div class="standard-row">
                    <div class="std-dot std-dot-amber"></div>
                    <div class="std-name">NIST SP 800-30</div>
                    <div class="std-role">Risk scoring</div>
                </div>
                <div class="standard-row">
                    <div class="std-dot std-dot-amber"></div>
                    <div class="std-name">COBIT 2019</div>
                    <div class="std-role">Governance</div>
                </div>
            </div>

        </div>
    </div>

</main>

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