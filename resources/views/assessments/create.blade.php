<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Assessment — CloudRisk DSS</title>
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
        .logout-btn:hover { color:#f87171; border-color:rgba(248,113,113,0.3); }

        /* ══ Main ══ */
        .main { margin-left:240px; flex:1; padding:36px 40px 60px; min-width:0; box-sizing:border-box; }

        /* ══ Breadcrumb ══ */
        .breadcrumb {
            display:flex; align-items:center; gap:8px;
            font-size:13px; color:var(--muted); margin-bottom:24px;
        }
        .breadcrumb a { color:var(--blue-soft); text-decoration:none; }
        .breadcrumb a:hover { text-decoration:underline; }
        .breadcrumb-sep { color:var(--border); }

        /* ══ Page header ══ */
        .page-header { margin-bottom:28px; }
        .page-title { font-size:22px; font-weight:800; letter-spacing:-0.02em; color:var(--text); margin-bottom:6px; }
        .page-subtitle { font-size:13.5px; color:var(--muted); line-height:1.5; }

        /* ══ Step progress bar ══ */
        .step-progress {
            display: flex;
            align-items: center;
            gap: 0;
            margin-bottom: 32px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px 28px;
        }

        .step-item {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
        }

        .step-circle {
            width: 32px; height: 32px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700;
            flex-shrink: 0;
            transition: all 0.2s;
        }

        .step-circle.done    { background:var(--blue); color:#fff; }
        .step-circle.active  { background:var(--blue); color:#fff; box-shadow:0 0 0 4px var(--blue-pale); }
        .step-circle.pending { background:var(--surface); color:var(--muted); border:2px solid var(--border); }

        .step-label-wrap { display:flex; flex-direction:column; }
        .step-module { font-size:10px; font-weight:600; color:var(--muted); text-transform:uppercase; letter-spacing:0.05em; }
        .step-name   { font-size:13px; font-weight:600; color:var(--text); }
        .step-name.pending { color:var(--muted); }

        .step-connector {
            flex-shrink: 0;
            width: 32px; height: 2px;
            background: var(--border);
            margin: 0 8px;
        }
        .step-connector.done { background:var(--blue); }

        /* ══ Two-column layout ══ */
        .form-layout { display:grid; grid-template-columns:1fr 300px; gap:24px; }

        /* ══ Form card ══ */
        .form-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: visible;
        }

        .form-card-head {
            padding: 22px 28px;
            border-bottom: 1px solid var(--border);
            background: var(--surface);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .form-head-icon {
            width: 42px; height: 42px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            background: var(--blue-pale);
        }

        .form-head-title { font-size:15px; font-weight:700; color:var(--text); }
        .form-head-sub   { font-size:12px; color:var(--muted); margin-top:3px; }

        .form-body { padding:28px; }

        /* ══ Section divider within form ══ */
        .form-section {
            margin-bottom: 28px;
            padding-bottom: 28px;
            border-bottom: 1px solid var(--border);
        }
        .form-section:last-child { margin-bottom:0; padding-bottom:0; border-bottom:none; }

        .form-section-title {
            font-size: 13px; font-weight: 700;
            color: var(--text-2);
            margin-bottom: 16px;
            display: flex; align-items: center; gap: 8px;
        }

        .form-section-badge {
            font-size: 10px; font-weight: 600;
            padding: 2px 8px; border-radius: 10px;
            background: var(--blue-pale); color: var(--blue);
        }

        /* ══ Form groups ══ */
        .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
        .form-row-3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; }
        .form-group { display:flex; flex-direction:column; gap:6px; }
        .form-group.full { grid-column:1/-1; }

        label {
            font-size:12.5px; font-weight:600;
            color:var(--text-2);
            display:flex; align-items:center; gap:6px;
        }

        .req { color:var(--red); }

        .field-hint { font-size:11px; color:var(--muted); margin-top:2px; }

        input[type="text"],
        input[type="date"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 10px 14px;
            font-size: 13.5px;
            font-family: 'Inter', sans-serif;
            color: var(--text);
            background: var(--white);
            border: 1.5px solid var(--border);
            border-radius: 8px;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        input:focus, select:focus, textarea:focus {
            border-color: var(--blue-soft);
            box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
        }

        textarea { resize:vertical; min-height:80px; line-height:1.6; }

        select { cursor:pointer; }

        /* ══ CIA checkboxes ══ */
        .cia-row { display:flex; gap:12px; flex-wrap:wrap; }

        .cia-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 8px;
            border: 1.5px solid var(--border);
            font-size: 13px; font-weight: 500;
            color: var(--text-2);
            cursor: pointer;
            transition: all 0.15s;
            user-select: none;
        }

        .cia-btn input { display:none; }

        .cia-btn:has(input:checked),
        .cia-btn.checked {
            border-color: var(--blue-soft);
            background: var(--blue-pale);
            color: var(--blue);
            font-weight: 600;
        }

        .cia-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .cia-c .cia-dot { background: #7c3aed; }
        .cia-i .cia-dot { background: var(--teal); }
        .cia-a .cia-dot { background: var(--amber); }

        /* ══ Threat scenario library ══ */
        .threat-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .threat-checkbox-card {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            cursor: pointer;
            transition: border-color 0.15s, background 0.15s;
            user-select: none;
        }

        .threat-checkbox-card:has(input:checked),
        .threat-checkbox-card.selected {
            border-color: var(--blue-soft);
            background: rgba(219,234,254,0.4);
        }

        .threat-checkbox-card input[type="checkbox"] { margin-top:2px; flex-shrink:0; accent-color:var(--blue); }

        .threat-card-body { flex:1; min-width:0; word-break:break-word; }

        .threat-name { font-size:13px; font-weight:600; color:var(--text); margin-bottom:4px; }
        .threat-desc { font-size:12px; color:var(--muted); line-height:1.5; }

        .threat-badges { display:flex; gap:6px; flex-wrap:wrap; margin-top:6px; }

        .threat-badge {
            font-size:10px; font-weight:500;
            padding:2px 8px; border-radius:10px;
        }

        .tb-critical { background:var(--red-pale); color:var(--red); }
        .tb-high     { background:var(--amber-pale); color:var(--amber); }
        .tb-medium   { background:#fef9c3; color:#92400e; }

        .tb-c { background:#ede9fe; color:#7c3aed; }
        .tb-i { background:var(--teal-pale); color:var(--teal); }
        .tb-a { background:var(--amber-pale); color:var(--amber); }

        /* ══ Form actions ══ */
        .form-actions {
            display:flex; align-items:center; justify-content:space-between;
            padding:20px 28px;
            border-top:1px solid var(--border);
            background:var(--surface);
        }

        .btn-back {
            display:inline-flex; align-items:center; gap:7px;
            padding:10px 20px; border-radius:8px;
            font-size:13.5px; font-weight:500;
            color:var(--muted); background:var(--white);
            border:1.5px solid var(--border);
            text-decoration:none; cursor:pointer;
            font-family:'Inter',sans-serif;
            transition:color 0.12s,border-color 0.12s;
        }
        .btn-back:hover { color:var(--text); border-color:var(--text-2); }

        .btn-next {
            display:inline-flex; align-items:center; gap:8px;
            padding:10px 24px; border-radius:8px;
            font-size:13.5px; font-weight:700;
            color:#fff; background:var(--blue);
            border:none; cursor:pointer;
            font-family:'Inter',sans-serif;
            transition:background 0.15s,transform 0.1s;
            text-decoration:none;
        }
        .btn-next:hover { background:#1e40af; transform:translateY(-1px); }

        .btn-submit {
            display:inline-flex; align-items:center; gap:8px;
            padding:10px 24px; border-radius:8px;
            font-size:13.5px; font-weight:700;
            color:#fff; background:var(--teal);
            border:none; cursor:pointer;
            font-family:'Inter',sans-serif;
            transition:background 0.15s;
        }
        .btn-submit:hover { background:#0f766e; }

        /* ══ Info panel ══ */
        .info-panel { display:flex; flex-direction:column; gap:16px; }

        .info-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 18px 20px;
        }

        .info-card-title {
            font-size: 12px; font-weight: 700;
            color: var(--muted); text-transform: uppercase;
            letter-spacing: 0.06em; margin-bottom: 12px;
        }

        .info-item { margin-bottom:12px; }
        .info-item:last-child { margin-bottom:0; }

        .info-label { font-size:12px; font-weight:600; color:var(--text-2); margin-bottom:3px; }
        .info-text  { font-size:12px; color:var(--muted); line-height:1.6; }

        .octave-step {
            display:flex; align-items:flex-start; gap:10px;
            padding:8px 0; border-bottom:1px solid var(--border);
        }
        .octave-step:last-child { border-bottom:none; }

        .octave-num {
            width:22px; height:22px; border-radius:6px;
            background:var(--blue-pale); color:var(--blue);
            display:flex; align-items:center; justify-content:center;
            font-size:10px; font-weight:700; flex-shrink:0; margin-top:1px;
        }
        .octave-num.now { background:var(--blue); color:#fff; }

        .octave-text { font-size:12px; color:var(--text); font-weight:500; line-height:1.4; }
        .octave-sub  { font-size:11px; color:var(--muted); }

        .tip-box {
            background: var(--blue-pale);
            border: 1px solid rgba(59,130,246,0.2);
            border-radius: 8px;
            padding: 12px 14px;
            font-size:12px; color:var(--blue);
            line-height: 1.6;
        }

        @media (max-width:1100px) { .form-layout { grid-template-columns:1fr; } }
        @media (max-width:900px) {
            .form-row, .form-row-3 { grid-template-columns:1fr; }
            .threat-grid { grid-template-columns:1fr; }
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
            html, body { overflow-x: clip !important; }
            .menu-toggle { display: flex; }
            .sidebar { transform: translateX(-100%); transition: transform 0.25s ease; z-index: 99; }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay.open { display: block; }
            .main { margin-left: 0 !important; width: 100% !important; max-width: 100% !important; padding: 16px !important; padding-top: 64px !important; box-sizing: border-box !important; }
            .page-header { flex-direction: column; align-items: flex-start; gap: 12px; }
            .page-title { font-size: 18px; }
            /* table scroll handled in mobile block below */
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
    /* ══ Mobile responsive — single clean block ══ */
    .menu-toggle {
        display: none;
        position: fixed; top: 14px; left: 14px; z-index: 200;
        width: 38px; height: 38px; border-radius: 9px;
        background: var(--navy); border: none; cursor: pointer;
        align-items: center; justify-content: center; flex-direction: column; gap: 5px;
    }
    .menu-toggle span { display: block; width: 18px; height: 2px; background: #fff; border-radius: 2px; }
    .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 98; }

    @media (max-width: 768px) {
        html, body { overflow-x: clip !important; }

        /* Hamburger */
        .menu-toggle { display: flex !important; }
        .sidebar-overlay.open { display: block !important; }

        /* Sidebar slides in */
        .sidebar {
            transform: translateX(-100%) !important;
            transition: transform 0.25s ease !important;
            z-index: 99 !important;
            position: fixed !important;
        }
        .sidebar.open { transform: translateX(0) !important; }

        /* Main content: full width, padded top for hamburger */
        .main {
            margin-left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            padding: 16px !important;
            padding-top: 64px !important;
            box-sizing: border-box !important;
            overflow-x: visible !important;
        }

        /* Page header */
        .page-header { flex-direction: column !important; align-items: flex-start !important; gap: 12px !important; }
        .page-title { font-size: 18px !important; }

        /* Step progress bar: scroll horizontally, do NOT use inline-flex */
        .step-progress {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            padding: 12px 16px !important;
            flex-wrap: nowrap !important;
        }
        .step-item { flex-shrink: 0 !important; min-width: 110px !important; }
        .step-connector { flex-shrink: 0 !important; }

        /* Threat cards grid: single column */
        .threat-grid { grid-template-columns: 1fr !important; }

        /* Tables: wrap in scrollable container — apply to table elements */
        table {
            display: block !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            white-space: nowrap !important;
            width: 100% !important;
        }

        /* Table wrappers */
        .risk-table-wrap, .table-wrap {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            max-width: 100% !important;
        }

        /* Grids collapse to single column */
        .form-layout, .layout, .grid-2, .grid-3, .form-grid { grid-template-columns: 1fr !important; }
        .form-row, .form-row-3 { grid-template-columns: 1fr !important; }
        .mit-card-body { grid-template-columns: 1fr !important; }

        /* Inputs full width */
        input, select, textarea { width: 100% !important; max-width: 100% !important; box-sizing: border-box !important; }

        /* Action buttons stack */
        .form-actions, .nav-btn-row, [class*="btn-row"], [class*="nav-btn"], .submit-row {
            flex-direction: column !important;
            gap: 10px !important;
            align-items: stretch !important;
        }
        .btn-back, .btn-next, .btn-submit, .btn-primary,
        .nav-btn-row a, .nav-btn-row button,
        .submit-row a, .submit-row button {
            width: 100% !important;
            box-sizing: border-box !important;
            text-align: center !important;
            justify-content: center !important;
        }

        /* Hide info sidebar panels on mobile */
        .info-card, .info-panel { display: none !important; }
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
                <div class="logo-name">CloudRisk DSS</div>
                <div class="logo-sub">OCTAVE Allegro · RGMM</div>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" class="nav-item">
            <span class="nav-icon">⊞</span> Dashboard
        </a>
        <a href="{{ url('/assessments/create') }}" class="nav-item active">
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
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
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

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ url('/dashboard') }}">Dashboard</a>
        <span class="breadcrumb-sep">›</span>
        <span>New Assessment</span>
    </div>

    <!-- Page header -->
    <div class="page-header">
        <div class="page-title">New Risk Assessment</div>
        <div class="page-subtitle">
            Follow the OCTAVE Allegro 8-step process to assess cloud risks in your university's
            academic information systems. Module 1 covers Steps 1–3 (Asset Management).
        </div>
    </div>

    <!-- Step Progress -->
    <div class="step-progress">
        <div class="step-item">
            <div class="step-circle active">1</div>
            <div class="step-label-wrap">
                <div class="step-module">Module 1 · Steps 1–3</div>
                <div class="step-name">Asset Profile</div>
            </div>
        </div>
        <div class="step-connector"></div>
        <div class="step-item">
            <div class="step-circle pending">2</div>
            <div class="step-label-wrap">
                <div class="step-module">Module 2 · Steps 4–5</div>
                <div class="step-name pending">Threat Scenarios</div>
            </div>
        </div>
        <div class="step-connector"></div>
        <div class="step-item">
            <div class="step-circle pending">3</div>
            <div class="step-label-wrap">
                <div class="step-module">Module 3 · Steps 5–7</div>
                <div class="step-name pending">Risk Scoring</div>
            </div>
        </div>
        <div class="step-connector"></div>
        <div class="step-item">
            <div class="step-circle pending">4</div>
            <div class="step-label-wrap">
                <div class="step-module">Module 4 · Step 8</div>
                <div class="step-name pending">Mitigation</div>
            </div>
        </div>
        <div class="step-connector"></div>
        <div class="step-item">
            <div class="step-circle pending">5</div>
            <div class="step-label-wrap">
                <div class="step-module">Module 5 · Output</div>
                <div class="step-name pending">Report</div>
            </div>
        </div>
    </div>

    <!-- Form layout -->
    <form method="POST" action="{{ route('assessments.store') }}">
        @csrf

        <div class="form-layout">

            <!-- ══ Form card ══ -->
            <div>
                <div class="form-card">
                    <div class="form-card-head">
                        <div class="form-head-icon">🏛</div>
                        <div>
                            <div class="form-head-title">Module 1 — Asset Management</div>
                            <div class="form-head-sub">OCTAVE Allegro Steps 1, 2 &amp; 3 · Cloud Risk Identification · Threat Profiling</div>
                        </div>
                    </div>

                    <div class="form-body">

                        <!-- Step 1: Assessment Context -->
                        <div class="form-section">
                            <div class="form-section-title">
                                Assessment Context
                                <span class="form-section-badge">Step 1 — Risk Measurement Criteria</span>
                            </div>

                            <div class="form-row" style="margin-bottom:16px;">
                                <div class="form-group">
                                    <label>University / Institution Name <span class="req">*</span></label>
                                    <input type="text" name="university_name"
                                        placeholder="e.g. Universiti Teknologi Malaysia"
                                        value="{{ old('university_name') }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Assessment Date <span class="req">*</span></label>
                                    <input type="date" name="assessment_date"
                                        value="{{ old('assessment_date', now()->format('Y-m-d')) }}" required>
                                </div>
                            </div>

                            <div class="form-row" style="margin-bottom:16px;">
                                <div class="form-group">
                                    <label>Assessor Name <span class="req">*</span></label>
                                    <input type="text" name="assessor_name"
                                        placeholder="Full name of the risk assessor"
                                        value="{{ old('assessor_name', auth()->user()->name ?? '') }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Assessor Role / Title</label>
                                    <input type="text" name="assessor_role"
                                        placeholder="e.g. ICT Director, Cloud Administrator"
                                        value="{{ old('assessor_role') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Risk Measurement Criteria — Institutional Impact Definition</label>
                                <select name="impact_criteria">
                                    <option value="standard" {{ old('impact_criteria') === 'standard' ? 'selected' : '' }}>
                                        Standard (NIST SP 800-30 Rev.1 — 1=Very Low to 5=Very High)
                                    </option>
                                </select>
                                <div class="field-hint">OCTAVE Allegro Step 1 — the scoring scale used to evaluate impact across all risk scenarios in this assessment.</div>
                            </div>
                        </div>

                        <!-- Step 2: Asset Profile -->
                        <div class="form-section">
                            <div class="form-section-title">
                                Information Asset Profile
                                <span class="form-section-badge">Step 2 — Asset Profile</span>
                            </div>

                            <div class="form-row" style="margin-bottom:16px;">
                                <div class="form-group">
                                    <label>Cloud System / Asset Name <span class="req">*</span></label>
                                    <input type="text" name="cloud_system_name"
                                        placeholder="e.g. Blackboard LMS, Student Information System"
                                        value="{{ old('cloud_system_name') }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Asset Category <span class="req">*</span></label>
                                    <select name="asset_category" required>
                                        <option value="">Select category…</option>
                                        <option value="lms" {{ old('asset_category') === 'lms' ? 'selected' : '' }}>Learning Management System (LMS)</option>
                                        <option value="sis" {{ old('asset_category') === 'sis' ? 'selected' : '' }}>Student Information System (SIS)</option>
                                        <option value="email" {{ old('asset_category') === 'email' ? 'selected' : '' }}>Email &amp; Collaboration Platform</option>
                                        <option value="storage" {{ old('asset_category') === 'storage' ? 'selected' : '' }}>Cloud Storage / Repository</option>
                                        <option value="research" {{ old('asset_category') === 'research' ? 'selected' : '' }}>Research Data Platform</option>
                                        <option value="erp" {{ old('asset_category') === 'erp' ? 'selected' : '' }}>ERP / Administrative System</option>
                                        <option value="auth" {{ old('asset_category') === 'auth' ? 'selected' : '' }}>Authentication / Identity System</option>
                                        <option value="api" {{ old('asset_category') === 'api' ? 'selected' : '' }}>API / Integration Layer</option>
                                        <option value="other" {{ old('asset_category') === 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" style="margin-bottom:16px;">
                                <label>Asset Description</label>
                                <textarea name="asset_description" placeholder="Describe this cloud asset — its purpose, the data it holds, and who uses it…">{{ old('asset_description') }}</textarea>
                            </div>

                            <div class="form-row" style="margin-bottom:16px;">
                                <div class="form-group">
                                    <label>Cloud Service Model</label>
                                    <select name="cloud_service_model">
                                        <option value="">Select…</option>
                                        <option value="saas" {{ old('cloud_service_model') === 'saas' ? 'selected' : '' }}>SaaS — Software as a Service</option>
                                        <option value="paas" {{ old('cloud_service_model') === 'paas' ? 'selected' : '' }}>PaaS — Platform as a Service</option>
                                        <option value="iaas" {{ old('cloud_service_model') === 'iaas' ? 'selected' : '' }}>IaaS — Infrastructure as a Service</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Cloud Deployment Model</label>
                                    <select name="cloud_deployment_model">
                                        <option value="">Select…</option>
                                        <option value="public"  {{ old('cloud_deployment_model') === 'public'  ? 'selected' : '' }}>Public Cloud</option>
                                        <option value="private" {{ old('cloud_deployment_model') === 'private' ? 'selected' : '' }}>Private Cloud</option>
                                        <option value="hybrid"  {{ old('cloud_deployment_model') === 'hybrid'  ? 'selected' : '' }}>Hybrid Cloud</option>
                                        <option value="community" {{ old('cloud_deployment_model') === 'community' ? 'selected' : '' }}>Community Cloud</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Primary Custodian</label>
                                    <input type="text" name="primary_custodian"
                                        placeholder="e.g. ICT Department, Cloud Administrator"
                                        value="{{ old('primary_custodian') }}">
                                    <div class="field-hint">The role responsible for day-to-day management of this asset.</div>
                                </div>
                                <div class="form-group">
                                    <label>Data Sensitivity Classification</label>
                                    <select name="sensitivity_classification">
                                        <option value="">Select…</option>
                                        <option value="confidential" {{ old('sensitivity_classification') === 'confidential' ? 'selected' : '' }}>Confidential — Restricted access</option>
                                        <option value="internal"     {{ old('sensitivity_classification') === 'internal'     ? 'selected' : '' }}>Internal — Staff &amp; students only</option>
                                        <option value="public"       {{ old('sensitivity_classification') === 'public'       ? 'selected' : '' }}>Public — Open access</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Containers -->
                        <div class="form-section">
                            <div class="form-section-title">
                                Asset Containers
                                <span class="form-section-badge">Step 3 — Infrastructure Evaluation</span>
                            </div>
                            <div class="field-hint" style="margin-bottom:14px;font-size:12px;">
                                Containers are the systems, networks, and physical locations where this asset is stored, transmitted, or processed.
                            </div>

                            <div class="form-row" style="margin-bottom:16px;">
                                <div class="form-group">
                                    <label>Technical Container</label>
                                    <input type="text" name="tech_container"
                                        placeholder="e.g. AWS S3 buckets, Azure AD, Google Workspace"
                                        value="{{ old('tech_container') }}">
                                    <div class="field-hint">Cloud services, servers, databases holding this asset.</div>
                                </div>
                                <div class="form-group">
                                    <label>Network Container</label>
                                    <input type="text" name="network_container"
                                        placeholder="e.g. University VPN, public internet, campus LAN"
                                        value="{{ old('network_container') }}">
                                    <div class="field-hint">Networks and pathways through which this asset travels.</div>
                                </div>
                            </div>

                            <div class="form-row" style="margin-bottom:16px;">
                                <div class="form-group">
                                    <label>Physical Container</label>
                                    <input type="text" name="physical_container"
                                        placeholder="e.g. Data centre in Singapore, provider's facility"
                                        value="{{ old('physical_container') }}">
                                    <div class="field-hint">Physical locations where data resides.</div>
                                </div>
                                <div class="form-group">
                                    <label>Human / People Container</label>
                                    <input type="text" name="human_container"
                                        placeholder="e.g. Students, academic staff, third-party vendor"
                                        value="{{ old('human_container') }}">
                                    <div class="field-hint">People who store, access, or process this asset.</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>CIA Triad — Primary Security Requirements</label>
                                <div class="cia-row">
                                    <label class="cia-btn cia-c">
                                        <input type="checkbox" name="cia_confidentiality" value="1" {{ old('cia_confidentiality') ? 'checked' : '' }}>
                                        <div class="cia-dot"></div>
                                        Confidentiality
                                    </label>
                                    <label class="cia-btn cia-i">
                                        <input type="checkbox" name="cia_integrity" value="1" {{ old('cia_integrity') ? 'checked' : '' }}>
                                        <div class="cia-dot"></div>
                                        Integrity
                                    </label>
                                    <label class="cia-btn cia-a">
                                        <input type="checkbox" name="cia_availability" value="1" {{ old('cia_availability') ? 'checked' : '' }}>
                                        <div class="cia-dot"></div>
                                        Availability
                                    </label>
                                </div>
                                <div class="field-hint">Select the CIA dimensions most critical to this asset's security.</div>
                            </div>
                        </div>

                        <!-- Step 4–5: Threat Scenarios -->
                        <div class="form-section">
                            <div class="form-section-title">
                                Pre-loaded Threat Scenario Library
                                <span class="form-section-badge">Steps 4–5 — Areas of Concern</span>
                            </div>
                            <div class="field-hint" style="margin-bottom:16px;font-size:12px;">
                                Select the threat scenarios applicable to your cloud system. Each scenario is pre-scored based on the NIST SP 800-30 Rev.1 Likelihood × Impact formula.
                                You can adjust individual scores in the next step (Module 2).
                            </div>

                            <div class="threat-grid">

                                <label class="threat-checkbox-card">
                                    <input type="checkbox" name="threats[]" value="01">
                                    <div class="threat-card-body">
                                        <div class="threat-name">01 · Data Breach</div>
                                        <div class="threat-desc">Unauthorised exposure of confidential student, staff, or institutional data stored in cloud systems by an external attacker.</div>
                                        <div class="threat-badges">
                                            <span class="threat-badge tb-critical">Critical · 20</span>
                                            <span class="threat-badge tb-c">C</span>
                                        </div>
                                    </div>
                                </label>

                                <label class="threat-checkbox-card">
                                    <input type="checkbox" name="threats[]" value="02">
                                    <div class="threat-card-body">
                                        <div class="threat-name">02 · Cloud Misconfiguration</div>
                                        <div class="threat-desc">Improperly configured cloud storage buckets, access policies, or network settings that inadvertently expose institutional assets.</div>
                                        <div class="threat-badges">
                                            <span class="threat-badge tb-critical">Critical · 20</span>
                                            <span class="threat-badge tb-c">C</span>
                                            <span class="threat-badge tb-i">I</span>
                                        </div>
                                    </div>
                                </label>

                                <label class="threat-checkbox-card">
                                    <input type="checkbox" name="threats[]" value="03">
                                    <div class="threat-card-body">
                                        <div class="threat-name">03 · Unauthorised Access</div>
                                        <div class="threat-desc">External attacker or unauthorised internal user gains access to cloud-hosted academic systems and institutional records.</div>
                                        <div class="threat-badges">
                                            <span class="threat-badge tb-high">High · 16</span>
                                            <span class="threat-badge tb-c">C</span>
                                            <span class="threat-badge tb-i">I</span>
                                        </div>
                                    </div>
                                </label>

                                <label class="threat-checkbox-card">
                                    <input type="checkbox" name="threats[]" value="04">
                                    <div class="threat-card-body">
                                        <div class="threat-name">04 · Credential Compromise / Phishing</div>
                                        <div class="threat-desc">User credentials stolen through phishing, social engineering, or brute force, enabling impersonation of authorised users.</div>
                                        <div class="threat-badges">
                                            <span class="threat-badge tb-high">High · 16</span>
                                            <span class="threat-badge tb-c">C</span>
                                        </div>
                                    </div>
                                </label>

                                <label class="threat-checkbox-card">
                                    <input type="checkbox" name="threats[]" value="05">
                                    <div class="threat-card-body">
                                        <div class="threat-name">05 · Insider Threat</div>
                                        <div class="threat-desc">Malicious or negligent actions by current or former staff, students, or contractors with privileged access.</div>
                                        <div class="threat-badges">
                                            <span class="threat-badge tb-high">High · 15</span>
                                            <span class="threat-badge tb-c">C</span>
                                            <span class="threat-badge tb-i">I</span>
                                        </div>
                                    </div>
                                </label>

                                <label class="threat-checkbox-card">
                                    <input type="checkbox" name="threats[]" value="06">
                                    <div class="threat-card-body">
                                        <div class="threat-name">06 · Ransomware / Malware Attack</div>
                                        <div class="threat-desc">Malicious software encrypts or corrupts institutional cloud data, rendering academic systems unavailable.</div>
                                        <div class="threat-badges">
                                            <span class="threat-badge tb-high">High · 15</span>
                                            <span class="threat-badge tb-a">A</span>
                                            <span class="threat-badge tb-i">I</span>
                                        </div>
                                    </div>
                                </label>

                                <label class="threat-checkbox-card">
                                    <input type="checkbox" name="threats[]" value="07">
                                    <div class="threat-card-body">
                                        <div class="threat-name">07 · DDoS / Service Disruption</div>
                                        <div class="threat-desc">DDoS attacks overwhelm cloud-based academic systems, rendering them unavailable during critical periods (enrolment, exams).</div>
                                        <div class="threat-badges">
                                            <span class="threat-badge tb-high">High · 12</span>
                                            <span class="threat-badge tb-a">A</span>
                                        </div>
                                    </div>
                                </label>

                                <label class="threat-checkbox-card">
                                    <input type="checkbox" name="threats[]" value="08">
                                    <div class="threat-card-body">
                                        <div class="threat-name">08 · Third-Party / Vendor Risk</div>
                                        <div class="threat-desc">Cloud service providers or third-party vendors fail to meet contractual security obligations, exposing institutional data.</div>
                                        <div class="threat-badges">
                                            <span class="threat-badge tb-high">High · 12</span>
                                            <span class="threat-badge tb-c">C</span>
                                        </div>
                                    </div>
                                </label>

                                <label class="threat-checkbox-card">
                                    <input type="checkbox" name="threats[]" value="09">
                                    <div class="threat-card-body">
                                        <div class="threat-name">09 · Account Hijacking</div>
                                        <div class="threat-desc">Attacker gains full control of a privileged institutional cloud account through credential theft or session token interception.</div>
                                        <div class="threat-badges">
                                            <span class="threat-badge tb-high">High · 12</span>
                                            <span class="threat-badge tb-c">C</span>
                                            <span class="threat-badge tb-i">I</span>
                                        </div>
                                    </div>
                                </label>

                                <label class="threat-checkbox-card">
                                    <input type="checkbox" name="threats[]" value="10">
                                    <div class="threat-card-body">
                                        <div class="threat-name">10 · Accidental Data Loss</div>
                                        <div class="threat-desc">Unintentional deletion, overwriting, or corruption of institutional records by authorised users, resulting in permanent data loss.</div>
                                        <div class="threat-badges">
                                            <span class="threat-badge tb-high">High · 12</span>
                                            <span class="threat-badge tb-i">I</span>
                                        </div>
                                    </div>
                                </label>

                                <label class="threat-checkbox-card">
                                    <input type="checkbox" name="threats[]" value="11">
                                    <div class="threat-card-body">
                                        <div class="threat-name">11 · Insufficient Logging &amp; Monitoring</div>
                                        <div class="threat-desc">Absence of adequate audit trails and real-time security alerts prevents timely detection and response to security incidents.</div>
                                        <div class="threat-badges">
                                            <span class="threat-badge tb-medium">Medium · 9</span>
                                            <span class="threat-badge tb-c">C</span>
                                        </div>
                                    </div>
                                </label>

                                <label class="threat-checkbox-card">
                                    <input type="checkbox" name="threats[]" value="12">
                                    <div class="threat-card-body">
                                        <div class="threat-name">12 · Insecure API</div>
                                        <div class="threat-desc">Vulnerabilities in cloud APIs allow unauthorised data access, injection attacks, or system manipulation through exposed endpoints.</div>
                                        <div class="threat-badges">
                                            <span class="threat-badge tb-medium">Medium · 9</span>
                                            <span class="threat-badge tb-c">C</span>
                                            <span class="threat-badge tb-i">I</span>
                                        </div>
                                    </div>
                                </label>

                                <label class="threat-checkbox-card">
                                    <input type="checkbox" name="threats[]" value="13">
                                    <div class="threat-card-body">
                                        <div class="threat-name">13 · Privilege Escalation</div>
                                        <div class="threat-desc">An authenticated user exploits system vulnerabilities or misconfigurations to gain higher access permissions than authorised.</div>
                                        <div class="threat-badges">
                                            <span class="threat-badge tb-medium">Medium · 8</span>
                                            <span class="threat-badge tb-c">C</span>
                                        </div>
                                    </div>
                                </label>

                                <label class="threat-checkbox-card">
                                    <input type="checkbox" name="threats[]" value="14">
                                    <div class="threat-card-body">
                                        <div class="threat-name">14 · Non-Compliance / Data Protection</div>
                                        <div class="threat-desc">Failure to comply with data protection laws (e.g. PDPA Malaysia) exposes the institution to legal liability and regulatory penalties.</div>
                                        <div class="threat-badges">
                                            <span class="threat-badge tb-medium">Medium · 9</span>
                                            <span class="threat-badge tb-c">C</span>
                                        </div>
                                    </div>
                                </label>

                                <label class="threat-checkbox-card">
                                    <input type="checkbox" name="threats[]" value="15">
                                    <div class="threat-card-body">
                                        <div class="threat-name">15 · Physical Access to Infrastructure</div>
                                        <div class="threat-desc">Unauthorised physical access to server rooms or data centre facilities hosting institutional cloud services, enabling tampering.</div>
                                        <div class="threat-badges">
                                            <span class="threat-badge tb-medium">Medium · 8</span>
                                            <span class="threat-badge tb-c">C</span>
                                            <span class="threat-badge tb-i">I</span>
                                        </div>
                                    </div>
                                </label>

                            </div><!-- /threat-grid -->
                        </div>

                        <!-- Additional notes -->
                        <div class="form-section">
                            <div class="form-section-title">Assessment Notes</div>
                            <div class="form-group">
                                <label>Additional Context / Notes</label>
                                <textarea name="notes" placeholder="Any additional context about the assessment scope, constraints, or specific institutional considerations…">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                    </div><!-- /form-body -->

                    <div class="form-actions">
                        <a href="{{ url('/dashboard') }}" class="btn-back">← Back to Dashboard</a>
                        <button type="submit" class="btn-next">
                            Save &amp; Continue to Threat Scoring →
                        </button>
                    </div>
                </div>
            </div>

            <!-- ══ Info panel ══ -->
            <div class="info-panel">

                <div class="info-card">
                    <div class="info-card-title">OCTAVE Allegro — This Step</div>
                    <div class="octave-step">
                        <div class="octave-num now">1</div>
                        <div>
                            <div class="octave-text">Risk measurement criteria</div>
                            <div class="octave-sub">Define institutional impact levels</div>
                        </div>
                    </div>
                    <div class="octave-step">
                        <div class="octave-num now">2</div>
                        <div>
                            <div class="octave-text">Information asset profile</div>
                            <div class="octave-sub">Name, category, custodian, classification</div>
                        </div>
                    </div>
                    <div class="octave-step">
                        <div class="octave-num now">3</div>
                        <div>
                            <div class="octave-text">Asset containers</div>
                            <div class="octave-sub">Technical, network, physical, human</div>
                        </div>
                    </div>
                    <div class="octave-step">
                        <div class="octave-num">4</div>
                        <div>
                            <div class="octave-text">Areas of concern</div>
                            <div class="octave-sub">Select applicable threat scenarios</div>
                        </div>
                    </div>
                    <div class="octave-step">
                        <div class="octave-num">5–7</div>
                        <div>
                            <div class="octave-text">Risk scoring</div>
                            <div class="octave-sub">Likelihood × Impact · Next step</div>
                        </div>
                    </div>
                    <div class="octave-step">
                        <div class="octave-num">8</div>
                        <div>
                            <div class="octave-text">Mitigation plan</div>
                            <div class="octave-sub">ISO 27001 controls · Treatment</div>
                        </div>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-card-title">Severity Legend</div>
                    <div class="info-item">
                        <div class="info-label" style="color:#dc2626;">🔴 Critical · Score 20–25</div>
                        <div class="info-text">Immediate action required. Very High likelihood × Very High impact.</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label" style="color:#d97706;">🟠 High · Score 12–19</div>
                        <div class="info-text">Priority attention needed. Significant likelihood or impact.</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label" style="color:#ca8a04;">🟡 Medium · Score 6–11</div>
                        <div class="info-text">Plan mitigation. Moderate likelihood and impact combination.</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label" style="color:#059669;">🟢 Low · Score 1–5</div>
                        <div class="info-text">Monitor and review. Risk within acceptable tolerance.</div>
                    </div>
                </div>

                <div class="tip-box">
                    💡 <strong>Tip:</strong> Select all threats that <em>could</em> apply to this asset. In the next step
                    (Module 2) you will assign a specific Likelihood score (1–5) to each selected threat,
                    and the system will calculate Risk Score = Likelihood × Impact automatically.
                </div>

                <div class="info-card">
                    <div class="info-card-title">CIA Triad Reference</div>
                    <div class="info-item">
                        <div class="info-label" style="color:#7c3aed;">C — Confidentiality</div>
                        <div class="info-text">Protecting information from unauthorised disclosure — student data, research records, credentials.</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label" style="color:#0d9488;">I — Integrity</div>
                        <div class="info-text">Ensuring data accuracy and completeness — preventing unauthorised modification of grades, records.</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label" style="color:#d97706;">A — Availability</div>
                        <div class="info-text">Guaranteeing system access when needed — during enrolment, examination periods, and daily teaching.</div>
                    </div>
                </div>

            </div><!-- /info-panel -->
        </div><!-- /form-layout -->
    </form>

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