<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud Risk DSS — University Cloud Security Assessment</title>
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
            --teal-pale:   #ccfbf1;
            --amber:       #d97706;
            --amber-pale:  #fef3c7;
            --white:       #ffffff;
            --surface:     #f0f4f8;
            --muted:       #94a3b8;
            --border:      rgba(255,255,255,0.10);
            --border-dark: rgba(255,255,255,0.06);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--navy);
            color: var(--white);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Navbar ── */
        nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 56px;
            height: 68px;
            border-bottom: 1px solid var(--border-dark);
            backdrop-filter: blur(8px);
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(11,29,58,0.92);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--blue) 0%, var(--teal) 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(29,78,216,0.35);
        }

        .logo-name {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.01em;
        }

        .logo-tagline {
            font-size: 11px;
            color: var(--muted);
            font-weight: 400;
            margin-top: 1px;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-ghost-sm {
            color: var(--muted);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            padding: 7px 16px;
            border-radius: 7px;
            border: 1px solid var(--border);
            transition: color 0.15s, border-color 0.15s, background 0.15s;
        }
        .btn-ghost-sm:hover {
            color: #fff;
            border-color: rgba(255,255,255,0.25);
            background: rgba(255,255,255,0.05);
        }

        .btn-cta-nav {
            background: var(--blue);
            color: #fff;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 7px;
            transition: background 0.15s, transform 0.1s;
            box-shadow: 0 2px 8px rgba(29,78,216,0.4);
        }
        .btn-cta-nav:hover { background: #1e40af; transform: translateY(-1px); }

        /* ── Hero ── */
        .hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 90px 24px 70px;
            position: relative;
            overflow: hidden;
        }

        /* Subtle grid background */
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(59,130,246,0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59,130,246,0.06) 1px, transparent 1px);
            background-size: 48px 48px;
            pointer-events: none;
        }

        /* Radial glow */
        .hero::after {
            content: '';
            position: absolute;
            top: -120px;
            left: 50%;
            transform: translateX(-50%);
            width: 700px;
            height: 700px;
            background: radial-gradient(ellipse, rgba(29,78,216,0.18) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-content { position: relative; z-index: 1; }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(13,148,136,0.12);
            border: 1px solid rgba(13,148,136,0.28);
            color: #5eead4;
            font-size: 12px;
            font-weight: 500;
            padding: 6px 16px;
            border-radius: 20px;
            margin-bottom: 36px;
            letter-spacing: 0.01em;
        }
        .hero-badge .dot {
            width: 6px;
            height: 6px;
            background: #2dd4bf;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .hero-title {
            font-size: clamp(34px, 5.5vw, 60px);
            font-weight: 800;
            line-height: 1.08;
            letter-spacing: -0.035em;
            max-width: 760px;
            margin: 0 auto 22px;
        }

        .hero-title .accent { color: var(--blue-soft); }
        .hero-title .accent2 { color: #5eead4; }

        .hero-desc {
            font-size: 17px;
            color: var(--muted);
            line-height: 1.75;
            max-width: 540px;
            margin: 0 auto 16px;
            font-weight: 400;
        }

        .frameworks-line {
            font-size: 12px;
            color: rgba(148,163,184,0.7);
            margin-bottom: 48px;
            letter-spacing: 0.01em;
        }
        .frameworks-line span {
            color: rgba(148,163,184,0.95);
            font-weight: 500;
        }

        .hero-cta {
            display: flex;
            gap: 14px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 80px;
        }

        .btn-primary-lg {
            background: var(--blue);
            color: #fff;
            text-decoration: none;
            font-size: 15px;
            font-weight: 700;
            padding: 15px 36px;
            border-radius: 9px;
            transition: background 0.15s, transform 0.1s, box-shadow 0.15s;
            box-shadow: 0 4px 16px rgba(29,78,216,0.45);
        }
        .btn-primary-lg:hover {
            background: #1e40af;
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(29,78,216,0.55);
        }

        .btn-outline-lg {
            background: transparent;
            color: #fff;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            padding: 15px 36px;
            border-radius: 9px;
            border: 1px solid rgba(255,255,255,0.18);
            transition: border-color 0.15s, background 0.15s;
        }
        .btn-outline-lg:hover {
            border-color: rgba(255,255,255,0.35);
            background: rgba(255,255,255,0.05);
        }

        /* ── Feature Cards ── */
        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            max-width: 900px;
            width: 100%;
            margin: 0 auto;
        }

        .feature-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            padding: 26px 22px;
            text-align: left;
            transition: border-color 0.2s, background 0.2s;
        }
        .feature-card:hover {
            background: rgba(255,255,255,0.065);
            border-color: rgba(255,255,255,0.14);
        }

        .feature-icon-wrap {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 14px;
        }
        .icon-blue  { background: rgba(29,78,216,0.18); }
        .icon-teal  { background: rgba(13,148,136,0.18); }
        .icon-amber { background: rgba(217,119,6,0.18); }

        .feature-title {
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 8px;
        }

        .feature-desc {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.65;
        }

        /* ── Standards Strip ── */
        .standards-section {
            padding: 28px 56px;
            border-top: 1px solid var(--border-dark);
            background: rgba(255,255,255,0.02);
        }

        .standards-label {
            font-size: 11px;
            font-weight: 600;
            color: rgba(148,163,184,0.5);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 16px;
        }

        .standards-list {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            flex-wrap: wrap;
        }

        .standard-pill {
            font-size: 12px;
            font-weight: 500;
            color: rgba(148,163,184,0.8);
            padding: 5px 14px;
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.07);
            background: rgba(255,255,255,0.03);
            margin: 4px;
            white-space: nowrap;
        }

        .standard-pill.highlight {
            color: var(--blue-soft);
            border-color: rgba(59,130,246,0.25);
            background: rgba(59,130,246,0.08);
            font-weight: 600;
        }

        /* ── Process Steps ── */
        .steps-section {
            padding: 24px 56px;
            border-top: 1px solid var(--border-dark);
        }

        .steps-inner {
            max-width: 900px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            flex-wrap: wrap;
        }

        .step-chip {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12.5px;
            color: var(--muted);
        }

        .step-chip-num {
            width: 22px;
            height: 22px;
            background: var(--navy-mid);
            border: 1px solid rgba(59,130,246,0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            color: var(--blue-soft);
            flex-shrink: 0;
        }

        .step-divider {
            width: 20px;
            height: 1px;
            background: rgba(255,255,255,0.1);
        }

        @media (max-width: 768px) {
            nav { padding: 0 20px; }
            .hero { padding: 60px 20px 50px; }
            .features { grid-template-columns: 1fr; }
            .standards-section { padding: 20px; }
            .steps-section { padding: 20px; }
            .step-divider { display: none; }
        }
        @media (max-width: 480px) {
            .hero-title { font-size: 30px; }
            .logo-tagline { display: none; }
        }
    </style>
</head>
<body>

<nav>
    <a href="/" class="logo">
        <div class="logo-icon">🛡</div>
        <div>
            <div class="logo-name">Cloud Risk DSS</div>
            <div class="logo-tagline">OCTAVE Allegro · Risk Governance Framework</div>
        </div>
    </a>
    <div class="nav-right">
        <a href="{{ route('login') }}" class="btn-ghost-sm">Sign in</a>
        <a href="{{ route('register') }}" class="btn-cta-nav">Get started →</a>
    </div>
</nav>

<div class="hero">
    <div class="hero-content">
        <div class="hero-badge">
            <span class="dot"></span>
            8-Step OCTAVE Allegro Methodology · Multi-Standard Architecture
        </div>

        <h1 class="hero-title">
            Cloud risk assessment for<br>
            <span class="accent">university</span> <span class="accent2">information systems</span>
        </h1>

        <p class="hero-desc">
            A structured, web-based Decision Support System that guides university administrators
            and IT personnel through systematic cloud risk assessment — from asset identification
            to actionable mitigation strategies.
        </p>

        <p class="frameworks-line">
            Powered by <span>OCTAVE Allegro</span> · <span>ISO/IEC 27001:2022</span> ·
            <span>ISO/IEC 27005:2022</span> · <span>NIST SP 800-30</span> · <span>COBIT 2019</span>
        </p>

        <div class="hero-cta">
            <a href="{{ route('register') }}" class="btn-primary-lg">Start your assessment</a>
            <a href="{{ route('login') }}" class="btn-outline-lg">Sign in to continue</a>
        </div>

        <div class="features">
            <div class="feature-card">
                <div class="feature-icon-wrap icon-blue">🗂</div>
                <div class="feature-title">8-Step guided assessment</div>
                <div class="feature-desc">Walk through the complete OCTAVE Allegro process — asset identification, CIA requirements, threat scenarios, and risk prioritization.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon-wrap icon-teal">📊</div>
                <div class="feature-title">Automated risk scoring</div>
                <div class="feature-desc">Risks are scored using Likelihood × Impact (NIST SP 800-30) and ranked automatically, giving you a clear, prioritized risk register.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon-wrap icon-amber">📋</div>
                <div class="feature-title">Standards-aligned mitigations</div>
                <div class="feature-desc">Every risk maps to ISO/IEC 27001:2022 controls and ISO/IEC 27005:2022 treatment options — Reduce, Avoid, Transfer, or Accept.</div>
            </div>
        </div>
    </div>
</div>

<div class="standards-section">
    <div class="standards-label">Integrated Risk Governance &amp; Mitigation Model (RGMM)</div>
    <div class="standards-list">
        <span class="standard-pill highlight">OCTAVE Allegro</span>
        <span class="standard-pill">ISO/IEC 27001:2022</span>
        <span class="standard-pill">ISO/IEC 27005:2022</span>
        <span class="standard-pill">NIST SP 800-30 Rev.1</span>
        <span class="standard-pill">COBIT 2019</span>
    </div>
</div>

<div class="steps-section">
    <div class="steps-inner">
        <div class="step-chip"><div class="step-chip-num">1</div> Define assets</div>
        <div class="step-divider"></div>
        <div class="step-chip"><div class="step-chip-num">2</div> Set CIA requirements</div>
        <div class="step-divider"></div>
        <div class="step-chip"><div class="step-chip-num">3</div> Identify threats</div>
        <div class="step-divider"></div>
        <div class="step-chip"><div class="step-chip-num">4</div> Score risks</div>
        <div class="step-divider"></div>
        <div class="step-chip"><div class="step-chip-num">5</div> Prioritize register</div>
        <div class="step-divider"></div>
        <div class="step-chip"><div class="step-chip-num">6</div> Map mitigations</div>
        <div class="step-divider"></div>
        <div class="step-chip"><div class="step-chip-num">7</div> Treatment decisions</div>
        <div class="step-divider"></div>
        <div class="step-chip"><div class="step-chip-num">8</div> Export PDF report</div>
    </div>
</div>

</body>
</html>