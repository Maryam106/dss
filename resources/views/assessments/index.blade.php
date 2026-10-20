<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Assessments — CloudRisk DSS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --navy:#0b1d3a; --navy-mid:#112753; --blue:#1d4ed8; --blue-soft:#3b82f6;
            --blue-pale:#dbeafe; --teal:#0d9488; --teal-pale:#ccfbf1;
            --amber:#d97706; --amber-pale:#fef3c7; --red:#dc2626; --red-pale:#fee2e2;
            --green:#059669; --green-pale:#d1fae5; --purple:#7c3aed; --purple-pale:#ede9fe;
            --white:#ffffff; --surface:#f1f5f9; --border:#e2e8f0;
            --text:#0f172a; --text-2:#334155; --muted:#64748b;
        }
        body { font-family:'Inter',sans-serif; background:var(--surface); color:var(--text); min-height:100vh; display:flex; }

        /* Sidebar */
        .sidebar { width:240px; background:var(--navy); min-height:100vh; display:flex; flex-direction:column; flex-shrink:0; position:fixed; top:0; left:0; bottom:0; overflow-y:auto; }
        .sidebar-logo { padding:22px 20px 18px; border-bottom:1px solid rgba(255,255,255,0.07); }
        .logo-row { display:flex; align-items:center; gap:11px; }
        .logo-icon { width:36px; height:36px; background:linear-gradient(135deg,var(--blue) 0%,var(--teal) 100%); border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:17px; flex-shrink:0; }
        .logo-name { font-size:14px; font-weight:700; color:#fff; }
        .logo-sub  { font-size:10px; color:rgba(255,255,255,0.38); margin-top:2px; line-height:1.3; }
        .sidebar-nav { flex:1; padding:14px 10px; display:flex; flex-direction:column; gap:1px; }
        .nav-label { font-size:10px; font-weight:600; color:rgba(255,255,255,0.28); letter-spacing:0.08em; text-transform:uppercase; padding:14px 10px 6px; }
        .nav-item { display:flex; align-items:center; gap:9px; padding:9px 10px; border-radius:7px; text-decoration:none; font-size:13px; font-weight:500; color:rgba(255,255,255,0.5); transition:background 0.12s,color 0.12s; }
        .nav-item:hover { background:rgba(255,255,255,0.07); color:rgba(255,255,255,0.88); }
        .nav-item.active { background:rgba(59,130,246,0.16); color:#93c5fd; }
        .nav-icon { font-size:14px; width:18px; text-align:center; flex-shrink:0; }
        .sidebar-footer { padding:14px 10px; border-top:1px solid rgba(255,255,255,0.07); }
        .user-row { display:flex; align-items:center; gap:9px; padding:8px 10px; }
        .user-avatar { width:30px; height:30px; background:linear-gradient(135deg,var(--blue),var(--teal)); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:#fff; flex-shrink:0; }
        .user-info .user-name { font-size:12px; font-weight:600; color:#fff; }
        .user-info .user-role { font-size:10px; color:rgba(255,255,255,0.38); }
        .logout-btn { width:100%; margin-top:6px; padding:7px 10px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:6px; color:rgba(255,255,255,0.45); font-size:12px; font-family:'Inter',sans-serif; cursor:pointer; transition:background 0.12s; }
        .logout-btn:hover { background:rgba(255,255,255,0.1); color:#fff; }

        /* Main */
        .main { margin-left:240px; flex:1; padding:36px 40px 60px; min-width:0; box-sizing:border-box; }

        /* Header */
        .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; }
        .page-title { font-size:22px; font-weight:700; color:var(--text); }
        .page-subtitle { font-size:13px; color:var(--muted); margin-top:3px; }
        .new-btn { display:inline-flex; align-items:center; gap:7px; padding:10px 20px; background:var(--blue); color:#fff; border-radius:8px; font-size:13px; font-weight:600; text-decoration:none; transition:background 0.15s; }
        .new-btn:hover { background:#1e40af; }

        /* Table card */
        .card { background:#fff; border-radius:14px; border:1px solid var(--border); overflow:hidden; }
        .card-empty { padding:60px 24px; text-align:center; }
        .card-empty .empty-icon { font-size:40px; margin-bottom:12px; }
        .card-empty p { color:var(--muted); font-size:14px; margin-bottom:20px; }

        table { width:100%; border-collapse:collapse; }
        thead th { padding:12px 20px; text-align:left; font-size:11px; font-weight:600; color:var(--muted); text-transform:uppercase; letter-spacing:0.05em; border-bottom:1px solid var(--border); background:#fafbfc; }
        tbody tr { border-bottom:1px solid var(--border); transition:background 0.1s; }
        tbody tr:last-child { border-bottom:none; }
        tbody tr:hover { background:#f8fafc; }
        td { padding:14px 20px; font-size:13px; color:var(--text-2); vertical-align:middle; }
        td.name { font-weight:600; color:var(--text); }

        /* Status badges */
        .badge { display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; }
        .badge.draft     { background:#f1f5f9; color:#64748b; }
        .badge.scored    { background:var(--amber-pale); color:var(--amber); }
        .badge.mitigated { background:var(--green-pale); color:var(--green); }

        /* Action links */
        .actions { display:flex; gap:8px; align-items:center; }
        .btn-sm { display:inline-flex; align-items:center; gap:5px; padding:6px 12px; border-radius:6px; font-size:12px; font-weight:600; text-decoration:none; transition:background 0.12s; }
        .btn-continue { background:var(--blue-pale); color:var(--blue); }
        .btn-continue:hover { background:#bfdbfe; }
        .btn-report { background:var(--green-pale); color:var(--green); }
        .btn-report:hover { background:#a7f3d0; }
        .btn-delete { background:var(--red-pale); color:var(--red); border:none; cursor:pointer; font-family:'Inter',sans-serif; }
        .btn-delete:hover { background:#fecaca; }
    
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
        html, body { overflow-x: hidden !important; }

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
            overflow-x: hidden !important;
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
        input:not([type="checkbox"]):not([type="radio"]), select, textarea { width: 100% !important; max-width: 100% !important; box-sizing: border-box !important; }

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

        /* Assessment list: keep actions usable without widening the page */
        .actions { flex-wrap: wrap !important; gap: 6px !important; }
        .actions .btn-sm { min-height: 34px; }
        .actions form { margin: 0; }
        .card { min-width: 0; }
        .card > div[style*="overflow-x:auto"] { max-width: 100%; }

        /* Hide optional info panels on mobile, if present */
        .info-card, .info-panel { display: none !important; }
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
        <a href="{{ url('/assessments/create') }}" class="nav-item">
            <span class="nav-icon">＋</span> New Assessment
        </a>
        <a href="{{ url('/assessments') }}" class="nav-item active">
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
    <div class="page-header">
        <div>
            <div class="page-title">All Assessments</div>
            <div class="page-subtitle">{{ $assessments->count() }} assessment{{ $assessments->count() !== 1 ? 's' : '' }} found</div>
        </div>
        <a href="{{ url('/assessments/create') }}" class="new-btn">＋ New Assessment</a>
    </div>

    <div class="card">
        @if($assessments->isEmpty())
        <div class="card-empty">
            <div class="empty-icon">📋</div>
            <p>No assessments yet. Start your first risk assessment.</p>
            <a href="{{ url('/assessments/create') }}" class="new-btn">＋ New Assessment</a>
        </div>
        @else
        <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;width:100%;"><table>
            <thead>
                <tr>
                    <th>University / Institution</th>
                    <th>Assessor</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assessments as $assessment)
                <tr>
                    <td class="name">{{ $assessment->university_name ?? '—' }}</td>
                    <td>{{ $assessment->assessor_name ?? '—' }}</td>
                    <td>
                        @if($assessment->status === 'mitigated')
                            <span class="badge mitigated">✓ Complete</span>
                        @elseif($assessment->status === 'scored')
                            <span class="badge scored">⚡ Scored</span>
                        @else
                            <span class="badge draft">◌ Draft</span>
                        @endif
                    </td>
                    <td>{{ $assessment->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="actions">
                            @if($assessment->status === 'mitigated')
                                <a href="{{ route('assessments.report', $assessment->id) }}" target="_blank" class="btn-sm btn-report" onclick="var w=window.open(this.href,'_blank');setTimeout(function(){w.print();},1200);return false;">↓ Export PDF</a>
                            @elseif($assessment->status === 'scored')
                                <a href="{{ route('assessments.mitigation.create', $assessment->id) }}" class="btn-sm btn-continue">🛡 Mitigate</a>
                            @else
                                <a href="{{ route('assessments.risks.create', $assessment->id) }}" class="btn-sm btn-continue">▶ Continue</a>
                            @endif
                            <form method="POST" action="{{ route('assessments.destroy', $assessment->id) }}" onsubmit="return confirm('Delete this assessment?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-delete">🗑</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table></div>
        @endif
    </div>
</div>

<script>
function toggleSidebar(){
    var s = document.querySelector('.sidebar');
    var o = document.getElementById('overlay');
    s.classList.toggle('open');
    o.classList.toggle('open');
}
</script>
</body>
</html>