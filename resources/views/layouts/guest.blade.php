<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CloudRisk DSS') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { background: #fff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 40px; width: 100%; max-width: 420px; box-shadow: 0 4px 24px rgba(0,0,0,0.07); }
        .logo { text-align: center; margin-bottom: 28px; }
        .logo-icon { width: 48px; height: 48px; background: linear-gradient(135deg, #1d4ed8, #0d9488); border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 10px; }
        .logo-name { font-size: 18px; font-weight: 700; color: #0f172a; }
        .logo-sub { font-size: 12px; color: #64748b; margin-top: 2px; }
        label { display: block; font-size: 13px; font-weight: 500; color: #334155; margin-bottom: 5px; }
        input[type=text], input[type=email], input[type=password] { width: 100%; padding: 9px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; color: #0f172a; outline: none; transition: border 0.15s; }
        input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        .form-group { margin-bottom: 18px; }
        .btn { width: 100%; padding: 10px; background: #1d4ed8; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; transition: background 0.15s; }
        .btn:hover { background: #1e40af; }
        .link { color: #1d4ed8; text-decoration: none; font-size: 13px; }
        .link:hover { text-decoration: underline; }
        .row { display: flex; align-items: center; justify-content: space-between; margin-top: 18px; }
        .checkbox-row { display: flex; align-items: center; gap: 7px; font-size: 13px; color: #334155; }
        .error { color: #dc2626; font-size: 12px; margin-top: 4px; }
        .errors { background: #fee2e2; border: 1px solid #fecaca; border-radius: 8px; padding: 10px 14px; margin-bottom: 18px; }
        .errors ul { list-style: none; }
        .errors li { color: #dc2626; font-size: 13px; }
        .status { background: #d1fae5; border: 1px solid #a7f3d0; border-radius: 8px; padding: 10px 14px; margin-bottom: 18px; color: #059669; font-size: 13px; }
    </style>
</head>
<body>
<div class="card">
    <div class="logo">
        <div class="logo-icon">🛡</div>
        <div class="logo-name">CloudRisk DSS</div>
        <div class="logo-sub">OCTAVE Allegro · RGMM</div>
    </div>
    {{ $slot }}
</div>
</body>
</html>
