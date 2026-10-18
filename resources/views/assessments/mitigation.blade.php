<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mitigation Plan — CloudRisk DSS</title>
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

        body { font-family: 'Inter', sans-serif; background: var(--surface); color: var(--text); min-height: 100vh; display: flex; }

        /* ══ Sidebar ══ */
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
        .logout-btn { display:block; width:100%; margin-top:8px; padding:7px; background:transparent; color:rgba(255,255,255,0.35); border:1px solid rgba(255,255,255,0.1); border-radius:6px; font-size:12px; font-family:'Inter',sans-serif; cursor:pointer; transition:color 0.12s,border-color 0.12s; text-align:center; }
        .logout-btn:hover { color:rgba(255,255,255,0.7); border-color:rgba(255,255,255,0.25); }

        /* ══ Main ══ */
        .main { margin-left:240px; flex:1; padding:36px 40px 60px; min-width:0; box-sizing:border-box; }
        .topbar { background:var(--white); border-bottom:1px solid var(--border); padding:16px 32px; display:flex; align-items:center; gap:8px; font-size:13px; color:var(--muted); }
        .topbar a { color:var(--blue); text-decoration:none; font-weight:500; }
        .topbar a:hover { text-decoration:underline; }
        .topbar-sep { color:var(--border); }
        .content { padding:28px 32px 48px; }

        /* ══ Progress bar ══ */
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

        /* ══ Page header ══ */
        .page-header { margin-bottom:24px; }
        .page-header h1 { font-size:22px; font-weight:800; color:var(--text); }
        .page-header p  { font-size:13.5px; color:var(--muted); margin-top:4px; }

        /* ══ Summary strip ══ */
        .summary-card { background:var(--navy); border-radius:12px; padding:18px 24px; margin-bottom:24px; display:flex; align-items:center; gap:32px; flex-wrap:wrap; }
        .summary-item .s-label { font-size:10px; color:rgba(255,255,255,0.4); text-transform:uppercase; letter-spacing:0.07em; font-weight:600; }
        .summary-item .s-value { font-size:14px; font-weight:700; color:#fff; margin-top:3px; }

        /* ══ Risk register table ══ */
        .section-head { display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; }
        .section-head h2 { font-size:15px; font-weight:700; color:var(--text); }
        .section-head p  { font-size:12px; color:var(--muted); margin-top:2px; }

        .risk-table-wrap { background:var(--white); border:1px solid var(--border); border-radius:12px; overflow:hidden; margin-bottom:28px; }

        table { width:100%; border-collapse:collapse; }
        thead tr { background:var(--surface); }
        thead th { padding:11px 16px; text-align:left; font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:0.06em; border-bottom:1px solid var(--border); }
        tbody tr { border-bottom:1px solid var(--border); transition:background 0.1s; }
        tbody tr:last-child { border-bottom:none; }
        tbody tr:hover { background:#f8fafc; }
        tbody td { padding:14px 16px; font-size:13px; vertical-align:top; }

        .rank-num { width:28px; height:28px; border-radius:7px; background:var(--surface); display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:800; color:var(--muted); }
        .rank-num.r1 { background:#fee2e2; color:#991b1b; }
        .rank-num.r2 { background:#fef3c7; color:#92400e; }
        .rank-num.r3 { background:#fef3c7; color:#92400e; }

        .threat-name-cell { font-weight:600; color:var(--text); font-size:13px; }
        .threat-cia-cell  { font-size:11px; color:var(--muted); margin-top:3px; }

        .score-pill {
            display:inline-flex; align-items:center; gap:5px;
            padding:3px 10px; border-radius:20px;
            font-size:12px; font-weight:700;
        }
        .score-pill.critical { background:#fee2e2; color:#991b1b; }
        .score-pill.high     { background:#fef3c7; color:#92400e; }
        .score-pill.medium   { background:#d1fae5; color:#065f46; }
        .score-pill.low      { background:#f1f5f9; color:#334155; }

        /* ══ Mitigation cards ══ */
        .mitigation-card {
            background:var(--white);
            border:1px solid var(--border);
            border-radius:12px;
            margin-bottom:16px;
            overflow:hidden;
        }

        .mit-card-head {
            padding:16px 20px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:16px;
            border-bottom:1px solid var(--border);
        }

        .mit-card-head-left { display:flex; align-items:center; gap:12px; flex:1; min-width:0; }

        .mit-rank {
            width:32px; height:32px; border-radius:8px;
            display:flex; align-items:center; justify-content:center;
            font-size:13px; font-weight:800; flex-shrink:0;
        }
        .mit-rank.critical { background:#fee2e2; color:#991b1b; }
        .mit-rank.high     { background:#fef3c7; color:#92400e; }
        .mit-rank.medium   { background:#d1fae5; color:#065f46; }

        .mit-name { font-size:14px; font-weight:700; color:var(--text); }
        .mit-meta { font-size:11.5px; color:var(--muted); margin-top:2px; }

        .mit-score-box {
            text-align:center; flex-shrink:0;
        }
        .mit-score-num { font-size:22px; font-weight:800; }
        .mit-score-num.critical { color:#dc2626; }
        .mit-score-num.high     { color:#d97706; }
        .mit-score-num.medium   { color:#059669; }
        .mit-score-lbl { font-size:9px; text-transform:uppercase; letter-spacing:0.06em; font-weight:700; color:var(--muted); }

        .mit-card-body { padding:18px 20px; display:grid; grid-template-columns:1fr 1fr; gap:20px; }

        .mit-section-label { font-size:10px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:0.07em; margin-bottom:8px; }

        .control-list { list-style:none; }
        .control-list li {
            display:flex; align-items:flex-start; gap:8px;
            font-size:12.5px; color:var(--text-2);
            padding:5px 0;
            border-bottom:1px solid var(--surface);
            line-height:1.4;
        }
        .control-list li:last-child { border-bottom:none; }
        .control-list li::before { content:'›'; color:var(--teal); font-weight:700; font-size:14px; flex-shrink:0; margin-top:-1px; }
        .control-code { font-size:10px; font-weight:700; color:var(--blue); background:var(--blue-pale); padding:1px 5px; border-radius:4px; margin-right:4px; flex-shrink:0; }

        /* Treatment select */
        .treatment-wrap { }
        .treatment-select {
            width:100%;
            padding:10px 14px;
            border:1.5px solid var(--border);
            border-radius:8px;
            font-size:13px; font-weight:600;
            font-family:'Inter',sans-serif;
            color:var(--text);
            background:var(--white);
            cursor:pointer;
            appearance:none;
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24'%3E%3Cpath fill='%2364748b' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat:no-repeat;
            background-position:right 12px center;
            padding-right:32px;
            transition:border-color 0.15s;
            margin-bottom:10px;
        }
        .treatment-select:focus { outline:none; border-color:var(--blue); }
        .treatment-select.avoid    { border-color:#dc2626; color:#dc2626; background-color:#fff5f5; }
        .treatment-select.reduce   { border-color:#d97706; color:#d97706; background-color:#fffbeb; }
        .treatment-select.transfer { border-color:#7c3aed; color:#7c3aed; background-color:#f5f3ff; }
        .treatment-select.accept   { border-color:#059669; color:#059669; background-color:#f0fdf4; }

        .treatment-desc {
            font-size:11.5px; color:var(--muted); line-height:1.5;
            padding:8px 10px; background:var(--surface); border-radius:6px;
        }

        .notes-input {
            width:100%; padding:8px 12px;
            border:1.5px solid var(--border); border-radius:7px;
            font-size:12px; font-family:'Inter',sans-serif;
            color:var(--text); resize:vertical; min-height:60px;
            transition:border-color 0.15s;
        }
        .notes-input:focus { outline:none; border-color:var(--blue); }

        /* ══ Submit row ══ */
        .submit-row { display:flex; align-items:center; justify-content:space-between; padding:20px 22px; background:var(--white); border:1px solid var(--border); border-radius:12px; margin-top:8px; }
        .btn-primary { background:var(--blue); color:#fff; border:none; padding:11px 24px; border-radius:8px; font-size:14px; font-weight:700; font-family:'Inter',sans-serif; cursor:pointer; transition:background 0.15s,transform 0.1s; display:flex; align-items:center; gap:8px; }
        .btn-primary:hover { background:#1e40af; transform:translateY(-1px); }
        .btn-back { background:transparent; color:var(--muted); border:1px solid var(--border); padding:10px 20px; border-radius:8px; font-size:13px; font-weight:600; font-family:'Inter',sans-serif; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:border-color 0.12s,color 0.12s; }
        .btn-back:hover { border-color:#94a3b8; color:var(--text-2); }

        /* ══ Info panel ══ */
        .layout { display:grid; grid-template-columns:1fr 280px; gap:24px; align-items:start; }
        .info-card { background:var(--white); border:1px solid var(--border); border-radius:12px; overflow:hidden; margin-bottom:16px; }
        .info-head { padding:13px 16px; border-bottom:1px solid var(--border); font-size:12px; font-weight:700; color:var(--text); }
        .info-body { padding:14px 16px; }

        .treatment-option { padding:8px 0; border-bottom:1px solid var(--surface); }
        .treatment-option:last-child { border-bottom:none; }
        .t-name { font-size:12px; font-weight:700; color:var(--text); }
        .t-desc { font-size:11px; color:var(--muted); margin-top:2px; line-height:1.4; }
        .t-avoid    .t-name { color:#dc2626; }
        .t-reduce   .t-name { color:#d97706; }
        .t-transfer .t-name { color:#7c3aed; }
        .t-accept   .t-name { color:#059669; }

        .iso-ref { font-size:11px; color:var(--muted); line-height:1.6; }
        .iso-ref strong { color:var(--text-2); font-weight:600; }

        .empty-state { text-align:center; padding:48px 24px; color:var(--muted); }
        .empty-state .ei { font-size:40px; margin-bottom:12px; }
        .empty-state h3 { font-size:15px; font-weight:700; color:var(--text-2); margin-bottom:6px; }

        @media (max-width:1000px) { .layout { grid-template-columns:1fr; } .mit-card-body { grid-template-columns:1fr; } }
        @media (max-width:900px)  { .main { margin-left:0; }  .content { padding:20px 16px 40px; } }
    
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
        <a href="{{ route('dashboard') }}" class="nav-item"><span class="nav-icon">⊞</span> Dashboard</a>
        <a href="{{ route('assessments.create') }}" class="nav-item"><span class="nav-icon">＋</span> New Assessment</a>
        <a href="{{ url('/assessments') }}" class="nav-item"><span class="nav-icon">≡</span> All Assessments</a>
        <a href="#" class="nav-item active"><span class="nav-icon">🛡</span> Mitigation</a>
        @php $latestDone = auth()->user()->assessments()->whereIn('status',['mitigated','scored'])->latest()->first(); @endphp
        @if($latestDone)
        <a href="{{ route('assessments.report', $latestDone->id) }}" class="nav-item"><span class="nav-icon">📋</span> Last Report</a>
        @else
        <a href="{{ url('/assessments') }}" class="nav-item"><span class="nav-icon">📋</span> Last Report</a>
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

<!-- Main -->
<div class="main">
    <div class="topbar">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="topbar-sep">›</span>
        <span>Assessment #{{ $assessment->id }}</span>
        <span class="topbar-sep">›</span>
        <span>Mitigation Plan</span>
    </div>

    <div class="content">

        <!-- Progress -->
        <div class="progress-bar">
            <div class="step-item">
                <div class="step-circle done">✓</div>
                <div class="step-label"><div class="s-num">Module 1</div><div class="s-name">Asset Profile</div></div>
            </div>
            <div class="step-line done"></div>
            <div class="step-item">
                <div class="step-circle done">✓</div>
                <div class="step-label"><div class="s-num">Module 2–3</div><div class="s-name">Risk Scoring</div></div>
            </div>
            <div class="step-line done"></div>
            <div class="step-item">
                <div class="step-circle active">3</div>
                <div class="step-label"><div class="s-num">Module 4</div><div class="s-name">Mitigation</div></div>
            </div>
            <div class="step-line"></div>
            <div class="step-item">
                <div class="step-circle pending">4</div>
                <div class="step-label"><div class="s-num">Module 5</div><div class="s-name muted">Report</div></div>
            </div>
        </div>

        <!-- Page header -->
        <div class="page-header">
            <h1>🛡️ Mitigation Plan — ISO/IEC 27001:2022 Controls</h1>
            <p>Module 4 · OCTAVE Allegro Step 8 · Select treatment decision and review recommended ISO 27001 Annex A controls for each risk</p>
        </div>

        <!-- Summary -->
        <div class="summary-card">
            <div class="summary-item"><div class="s-label">System</div><div class="s-value">{{ $assessment->cloud_system_name }}</div></div>
            <div class="summary-item"><div class="s-label">University</div><div class="s-value">{{ $assessment->university_name }}</div></div>
            <div class="summary-item"><div class="s-label">Risks Scored</div><div class="s-value">{{ count($risks)  }}</div></div>
            <div class="summary-item"><div class="s-label">Assessment Date</div><div class="s-value">{{ $assessment->assessment_date->format('d M Y') }}</div></div>
        </div>

        @php
        // ISO 27001:2022 Annex A controls per threat
        $isoControls = [
            '01' => [['A.5.12','Information classification'],['A.5.33','Protection of records'],['A.8.11','Data masking'],['A.8.12','Data leakage prevention']],
            '02' => [['A.8.9','Configuration management'],['A.8.20','Network security'],['A.5.37','Documented operating procedures'],['A.8.25','Secure development lifecycle']],
            '03' => [['A.5.15','Access control'],['A.5.16','Identity management'],['A.5.17','Authentication information'],['A.8.3','Information access restriction']],
            '04' => [['A.6.3','Information security awareness'],['A.5.17','Authentication information'],['A.8.5','Secure authentication'],['A.5.20','Addressing security in supplier agreements']],
            '05' => [['A.6.2','Terms and conditions of employment'],['A.6.4','Disciplinary process'],['A.5.15','Access control'],['A.8.18','Use of privileged utility programs']],
            '06' => [['A.8.7','Protection against malware'],['A.8.13','Information backup'],['A.5.26','Response to information security incidents'],['A.8.16','Monitoring activities']],
            '07' => [['A.8.20','Network security'],['A.8.21','Security of network services'],['A.5.30','ICT readiness for business continuity'],['A.8.13','Information backup']],
            '08' => [['A.5.19','Information security in supplier relationships'],['A.5.20','Addressing security in supplier agreements'],['A.5.21','Managing ICT supply chain'],['A.5.22','Monitoring supplier services']],
            '09' => [['A.8.5','Secure authentication'],['A.5.16','Identity management'],['A.8.2','Privileged access rights'],['A.8.17','Clock synchronisation']],
            '10' => [['A.8.13','Information backup'],['A.8.14','Redundancy of information processing'],['A.5.33','Protection of records'],['A.8.9','Configuration management']],
            '11' => [['A.8.15','Logging'],['A.8.16','Monitoring activities'],['A.8.17','Clock synchronisation'],['A.5.25','Assessment of information security events']],
            '12' => [['A.8.24','Use of cryptography'],['A.8.26','Application security requirements'],['A.8.29','Security testing in development'],['A.8.20','Network security']],
            '13' => [['A.8.2','Privileged access rights'],['A.8.18','Use of privileged utility programs'],['A.5.15','Access control'],['A.8.5','Secure authentication']],
            '14' => [['A.5.31','Legal, statutory, regulatory and contractual requirements'],['A.5.34','Privacy and protection of PII'],['A.5.36','Compliance with policies'],['A.5.32','Intellectual property rights']],
            '15' => [['A.7.1','Physical security perimeters'],['A.7.2','Physical entry'],['A.7.4','Physical security monitoring'],['A.7.8','Equipment siting and protection']],
        ];

        $treatmentDescriptions = [
            'reduce'   => 'Implement controls to lower the likelihood or impact of the risk to an acceptable level.',
            'avoid'    => 'Eliminate the risk by discontinuing the activity or changing the approach entirely.',
            'transfer' => 'Share the risk with a third party (cyber insurance, outsourcing, contractual clauses).',
            'accept'   => 'Acknowledge the risk and monitor it — appropriate when cost of control exceeds impact.',
        ];

        // Sort risks by score descending
        usort($risks, fn($a,$b) => $b['score'] - $a['score']);

        function getSeverityClass($score) {
            if ($score >= 20) return 'critical';
            if ($score >= 12) return 'high';
            if ($score >= 6)  return 'medium';
            return 'low';
        }
        @endphp

        @if(count($risks) === 0)
        <div style="background:var(--white);border:1px solid var(--border);border-radius:12px;padding:48px;text-align:center;">
            <div style="font-size:40px;margin-bottom:12px;">⚠️</div>
            <h3 style="font-size:15px;font-weight:700;color:var(--text-2);margin-bottom:8px;">No risk scores found</h3>
            <p style="font-size:13px;color:var(--muted);">Please complete the Risk Scoring step first.</p>
            <a href="{{ route('assessments.risks.create', $assessment->id) }}" class="btn-back" style="margin-top:16px;display:inline-flex;">← Back to Risk Scoring</a>
        </div>
        @else

        <form method="POST" action="{{ route('assessments.mitigation.store', $assessment->id) }}" id="mitForm">
            @csrf

            <div class="layout">
                <div>

                    <!-- Ranked risk register table -->
                    <div class="section-head">
                        <div>
                            <h2>📊 Ranked Risk Register</h2>
                            <p>Risks sorted by score — highest priority first (OCTAVE Allegro Step 6)</p>
                        </div>
                    </div>

                    <div class="risk-table-wrap" style="margin-bottom:28px;">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width:44px;">#</th>
                                    <th>Threat Scenario</th>
                                    <th>CIA</th>
                                    <th>Likelihood</th>
                                    <th>Impact</th>
                                    <th>Risk Score</th>
                                    <th>Severity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($risks as $i => $risk)
                                @php $sev = getSeverityClass($risk['score']); @endphp
                                <tr>
                                    <td>
                                        <div class="rank-num {{ $i < 3 ? 'r'.($i+1) : '' }}">{{ $i+1 }}</div>
                                    </td>
                                    <td>
                                        <div class="threat-name-cell">{{ $risk['name'] }}</div>
                                        <div class="threat-cia-cell">{{ $risk['cia'] ?? '' }}</div>
                                    </td>
                                    <td style="font-size:12px;color:var(--muted);">{{ $risk['cia'] ?? '—' }}</td>
                                    <td style="font-size:13px;font-weight:600;text-align:center;">{{ $risk['likelihood'] }}</td>
                                    <td style="font-size:13px;font-weight:600;text-align:center;">{{ $risk['impact'] }}</td>
                                    <td style="font-size:16px;font-weight:800;text-align:center;">{{ $risk['score'] }}</td>
                                    <td>
                                        <span class="score-pill {{ $sev }}">
                                            @if($sev==='critical') 🔴 @elseif($sev==='high') 🟠 @elseif($sev==='medium') 🟡 @else 🟢 @endif
                                            {{ strtoupper($sev) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mitigation cards -->
                    <div class="section-head">
                        <div>
                            <h2>🛡️ Mitigation Recommendations</h2>
                            <p>Module 4 · Step 8 · Select treatment and review ISO/IEC 27001:2022 Annex A controls</p>
                        </div>
                    </div>

                    @foreach($risks as $i => $risk)
                    @php
                        $sev = getSeverityClass($risk['score']);
                        $tid = $risk['threat_id'];
                        $controls = $isoControls[$tid] ?? [];
                        $defaultTreatment = $risk['score'] >= 20 ? 'reduce' : ($risk['score'] >= 12 ? 'reduce' : ($risk['score'] >= 6 ? 'reduce' : 'accept'));
                    @endphp

                    <div class="mitigation-card">
                        <div class="mit-card-head">
                            <div class="mit-card-head-left">
                                <div class="mit-rank {{ $sev }}">{{ $i+1 }}</div>
                                <div>
                                    <div class="mit-name">{{ $risk['name'] }}</div>
                                    <div class="mit-meta">
                                        Likelihood {{ $risk['likelihood'] }} × Impact {{ $risk['impact'] }} ·
                                        CIA: {{ $risk['cia'] ?? '—' }} ·
                                        {{ count($controls) }} ISO 27001 controls
                                    </div>
                                </div>
                            </div>
                            <div class="mit-score-box">
                                <div class="mit-score-num {{ $sev }}">{{ $risk['score'] }}</div>
                                <div class="mit-score-lbl">{{ strtoupper($sev) }}</div>
                            </div>
                        </div>

                        <div class="mit-card-body">
                            <!-- ISO Controls -->
                            <div>
                                <div class="mit-section-label">ISO/IEC 27001:2022 Annex A Controls</div>
                                <ul class="control-list">
                                    @foreach($controls as $ctrl)
                                    <li>
                                        <span class="control-code">{{ $ctrl[0] }}</span>
                                        {{ $ctrl[1] }}
                                    </li>
                                    @endforeach
                                    @if(empty($controls))
                                    <li>No specific controls mapped — apply general information security policies.</li>
                                    @endif
                                </ul>
                            </div>

                            <!-- Treatment -->
                            <div class="treatment-wrap">
                                <div class="mit-section-label">ISO/IEC 27005:2022 Treatment Decision</div>
                                <select
                                    name="treatment[{{ $risk['threat_id'] }}]"
                                    class="treatment-select {{ $defaultTreatment }}"
                                    onchange="updateTreatment(this)"
                                    id="treatment-{{ $tid }}">
                                    <option value="reduce"   {{ $defaultTreatment==='reduce'   ? 'selected' : '' }}>🔧 Reduce — Implement controls</option>
                                    <option value="avoid"    {{ $defaultTreatment==='avoid'    ? 'selected' : '' }}>🚫 Avoid — Eliminate the risk</option>
                                    <option value="transfer" {{ $defaultTreatment==='transfer' ? 'selected' : '' }}>🤝 Transfer — Share with third party</option>
                                    <option value="accept"   {{ $defaultTreatment==='accept'   ? 'selected' : '' }}>✅ Accept — Monitor and tolerate</option>
                                </select>
                                <div class="treatment-desc" id="tdesc-{{ $tid }}">
                                    {{ $treatmentDescriptions[$defaultTreatment] }}
                                </div>

                                <div style="margin-top:12px;">
                                    <div class="mit-section-label" style="margin-bottom:6px;">Implementation Notes</div>
                                    <textarea
                                        name="notes[{{ $risk['threat_id'] }}]"
                                        class="notes-input"
                                        placeholder="Add notes on implementation, responsible team, timeline...">{{ old('notes.'.$tid) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Submit -->
                    <div class="submit-row">
                        <a href="{{ route('assessments.risks.create', $assessment->id) }}" class="btn-back">← Back to Risk Scoring</a>
                        <div style="text-align:center;">
                            <div style="font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:0.06em;font-weight:600;">Final Step</div>
                            <div style="font-size:13px;font-weight:700;color:var(--text);margin-top:2px;">Generate Risk Register &amp; PDF Report</div>
                        </div>
                        <button type="submit" class="btn-primary">
                            Save Plan &amp; Generate Report →
                        </button>
                    </div>

                </div>

                <!-- Right panel -->
                <div>
                    <div class="info-card">
                        <div class="info-head">🔄 Treatment Options (ISO 27005)</div>
                        <div class="info-body">
                            <div class="treatment-option t-avoid">
                                <div class="t-name">🚫 Avoid</div>
                                <div class="t-desc">Stop the activity that causes the risk. Used when risk is too high to accept.</div>
                            </div>
                            <div class="treatment-option t-reduce">
                                <div class="t-name">🔧 Reduce</div>
                                <div class="t-desc">Apply controls to lower likelihood or impact. Most common treatment.</div>
                            </div>
                            <div class="treatment-option t-transfer">
                                <div class="t-name">🤝 Transfer</div>
                                <div class="t-desc">Cyber insurance, outsourcing or contractual liability shift.</div>
                            </div>
                            <div class="treatment-option t-accept">
                                <div class="t-name">✅ Accept</div>
                                <div class="t-desc">Tolerate the risk. Only when cost of control exceeds the impact.</div>
                            </div>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-head">📋 ISO/IEC 27001:2022 Reference</div>
                        <div class="info-body">
                            <div class="iso-ref">
                                <strong>Annex A</strong> contains 93 controls across 4 themes:<br><br>
                                <strong>A.5</strong> Organisational (37 controls)<br>
                                <strong>A.6</strong> People (8 controls)<br>
                                <strong>A.7</strong> Physical (14 controls)<br>
                                <strong>A.8</strong> Technological (34 controls)<br><br>
                                Controls are mapped to each threat scenario based on academic cloud security research and the OCTAVE Allegro methodology.
                            </div>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-head">📊 COBIT 2019 Governance</div>
                        <div class="info-body">
                            <div class="iso-ref">
                                Assign ownership using RACI:<br><br>
                                <strong>Responsible</strong> — IT Security Team<br>
                                <strong>Accountable</strong> — CISO / IT Director<br>
                                <strong>Consulted</strong> — Risk Committee<br>
                                <strong>Informed</strong> — University Management<br><br>
                                Aligned with COBIT 2019 DSS05 (Manage Security Services) and APO12 (Manage Risk).
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @endif

    </div>
</div>

<script>
const treatmentDescriptions = {
    reduce:   'Implement controls to lower the likelihood or impact of the risk to an acceptable level.',
    avoid:    'Eliminate the risk by discontinuing the activity or changing the approach entirely.',
    transfer: 'Share the risk with a third party (cyber insurance, outsourcing, contractual clauses).',
    accept:   'Acknowledge the risk and monitor it — appropriate when cost of control exceeds impact.',
};

function updateTreatment(select) {
    const val = select.value;
    const tid = select.id.replace('treatment-', '');

    // Update colour
    select.className = 'treatment-select ' + val;

    // Update description
    document.getElementById('tdesc-' + tid).textContent = treatmentDescriptions[val];
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