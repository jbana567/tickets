<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INKOMANE | Advanced Support System</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <style>
          :root {
            --primary: #4e54c8;
            --secondary: #8f94fb;
            --accent: #00d2ff;
            --success: #2ecc71;
            --danger: #e74c3c;
            --warning: #f1c40f;
            --text: #ffffff;
            --text-dim: #b0b0b0;
            --glass-bg: rgba(20, 20, 35, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        body {
            color: var(--text);
            background: linear-gradient(-45deg, #0f0c29, #302b63, #24243e, #1a1a2e);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        @keyframes gradientBG {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .glass-panel {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            overflow-x: auto; /* Allow horizontal scroll for wide tables */
        }
        .glass-panel::-webkit-scrollbar { height: 6px; }
        .glass-panel::-webkit-scrollbar-track { background: rgba(255,255,255,0.02); }
        .glass-panel::-webkit-scrollbar-thumb { background: var(--glass-border); border-radius: 10px; }

        button { cursor: pointer; border: none; outline: none; transition: 0.3s; border-radius: 6px; padding: 10px 18px; font-weight: 500; }
        .btn-primary  { background: linear-gradient(90deg, var(--primary), var(--secondary)); color: white; box-shadow: 0 4px 15px rgba(78,84,200,0.4); }
        .btn-primary:hover  { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(78,84,200,0.6); }
        .btn-danger   { background: rgba(231,76,60,0.2);  color: var(--danger);  border: 1px solid var(--danger);  }
        .btn-danger:hover   { background: var(--danger);  color: white; }
        .btn-success  { background: rgba(46,204,113,0.2); color: var(--success); border: 1px solid var(--success); }
        .btn-success:hover  { background: var(--success); color: white; }
        .btn-warning  { background: rgba(241,196,15,0.2); color: var(--warning); border: 1px solid var(--warning); }
        .btn-warning:hover  { background: var(--warning); color: #000; }
        .btn-outline  { background: transparent; border: 1px solid var(--accent); color: var(--accent); }
        .btn-outline:hover  { background: var(--accent); color: #000; }
        .btn-icon     { background: rgba(255,255,255,0.1); color: #ccc; padding: 8px 12px; border-radius: 6px; }
        .btn-icon:hover     { background: rgba(255,255,255,0.2); color: white; }
        .btn-configure { background: rgba(0,210,255,0.1); color: var(--accent); border: 1px solid var(--accent); padding: 5px 12px; font-size: 0.85rem; }
        .btn-configure:hover { background: var(--accent); color: #fff; }

        input, select, textarea {
            width: 100%; padding: 12px; margin-top: 5px; margin-bottom: 15px;
            background: rgba(0,0,0,0.3); border: 1px solid var(--glass-border);
            color: white; border-radius: 6px; transition: 0.3s;
        }
        input:focus, select:focus, textarea:focus { border-color: var(--accent); outline: none; box-shadow: 0 0 8px rgba(0,210,255,0.3); }
        select option { background: #1e1e2f; color: white; }

        nav {
            display: flex; justify-content: space-between; align-items: center;
            padding: 15px 5%; background: rgba(0,0,0,0.6); backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--glass-border); position: sticky; top: 0; z-index: 1000; height: 70px;
        }
        .logo { font-size: 1.5rem; font-weight: 700; background: linear-gradient(90deg, #fff, var(--accent)); background-clip: text; -webkit-text-fill-color: transparent; }
        .nav-links { display: flex; align-items: center; }
        .nav-links button { background: none; color: #ccc; margin-left: 20px; font-size: 0.95rem; }
        .nav-links button:hover { color: var(--accent); text-shadow: 0 0 8px rgba(0,210,255,0.5); }

        .view-section { display: none; padding: 40px 5%; animation: fadeIn 0.5s; max-width: 1400px; margin: 0 auto; width: 100%; }
        .view-section.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        .center-box { max-width: 490px; margin: 40px auto; }

        /* ── Status banner ── */
        .status-banner {
            border-radius: 14px; padding: 28px 24px; margin-bottom: 24px;
            display: flex; align-items: flex-start; gap: 20px; border: 2px solid;
        }
        .status-banner.confirmed { background: rgba(46,204,113,0.1); border-color: var(--success); }
        .status-banner.pending   { background: rgba(231,76,60,0.09); border-color: var(--danger);  }
        .status-banner .s-icon   { font-size: 2.6rem; flex-shrink: 0; margin-top: 2px; }
        .status-banner.confirmed .s-icon { color: var(--success); }
        .status-banner.pending   .s-icon { color: var(--danger);  }
        .status-banner .s-body h3 { font-size: 1.15rem; margin-bottom: 8px; }
        .status-banner.confirmed .s-body h3 { color: var(--success); }
        .status-banner.pending   .s-body h3 { color: var(--danger);  }
        .status-banner .s-body p  { color: var(--text-dim); font-size: 0.9rem; line-height: 1.55; }

        /* ── Applied ticket card ── */
        .applied-card {
            background: rgba(255,255,255,0.04); border: 1px solid var(--glass-border);
            border-radius: 10px; padding: 18px 20px; margin-bottom: 14px;
            display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;
        }
        .applied-card .ac-left h4 { font-size: 0.98rem; margin-bottom: 5px; }
        .applied-card .ac-left p  { font-size: 0.82rem; color: var(--text-dim); }
        .applied-pill { padding: 5px 16px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.4px; display: inline-flex; align-items: center; gap: 6px; }
        .pill-confirmed { background: rgba(46,204,113,0.18); color: var(--success); border: 1px solid var(--success); }
        .pill-pending   { background: rgba(231,76,60,0.14);  color: var(--danger);  border: 1px solid var(--danger);  }

        /* ── Wait page ── */
        .wait-box { text-align: center; padding: 50px 20px; }
        .wait-icon { font-size: 4.5rem; color: var(--accent); margin-bottom: 22px; animation: pulse 2s ease-in-out infinite; display: block; }
        @keyframes pulse { 0%,100%{opacity:1;} 50%{opacity:0.35;} }
        .wait-box h2 { font-size: 1.7rem; margin-bottom: 14px; }
        .wait-box p  { color: var(--text-dim); font-size: 0.95rem; line-height: 1.65; max-width: 420px; margin: 0 auto 10px; }

        /* ── Customer management table ── */
        .customer-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap:10px; }
        .customer-actions { display: flex; gap: 10px; }
        .customer-actions select { width: auto; margin: 0; padding: 8px 15px; background: rgba(0,0,0,0.5); }
        .customer-table { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
        .customer-table th { padding: 12px 15px; color: #888; font-weight: 500; text-transform: uppercase; font-size: 0.83rem; letter-spacing: 0.5px; }
        .customer-table td { background: rgba(255,255,255,0.03); padding: 13px 15px; }
        .customer-table tr:hover td { background: rgba(255,255,255,0.07); }
        .payment-badge { display: inline-flex; align-items: center; gap: 5px; font-size: 0.9rem; }
        .payment-badge.warning { color: var(--danger); }
        .category-tag { background: rgba(255,255,255,0.1); padding: 3px 10px; border-radius: 4px; font-size: 0.82rem; }
        .clickthrough-container { width: 90px; background: rgba(255,255,255,0.1); height: 5px; border-radius: 3px; overflow: hidden; margin-top: 4px; }
        .clickthrough-bar { height: 100%; background: var(--accent); border-radius: 3px; }
        .action-btns { display: flex; gap: 6px; }

        /* ── Admin badge ── */
        .app-badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; text-transform: uppercase; }
        .app-confirmed { background: rgba(46,204,113,0.15); color: var(--success); border: 1px solid var(--success); }
        .app-pending   { background: rgba(231,76,60,0.15);  color: var(--danger);  border: 1px solid var(--danger);  }

        /* ── Docs ── */
        .doc-container { display: grid; grid-template-columns: 240px 1fr; gap: 28px; }
        .doc-sidebar { background: rgba(0,0,0,0.2); padding: 20px; border-radius: 12px; border: 1px solid var(--glass-border); height: fit-content; }
        .doc-sidebar button { display: block; width: 100%; text-align: left; background: none; color: var(--text-dim); padding: 12px; margin-bottom: 4px; border-radius: 6px; border: none; }
        .doc-sidebar button:hover, .doc-sidebar button.active-doc { background: rgba(255,255,255,0.1); color: var(--accent); border-left: 3px solid var(--accent); }
        .doc-content h2 { color: var(--accent); border-bottom: 1px solid var(--glass-border); padding-bottom: 10px; margin-bottom: 18px; }
        .doc-content p  { line-height: 1.6; color: #ddd; margin-bottom: 14px; }
        .doc-content ul { margin-left: 20px; line-height: 1.7; color: #ddd; }

        /* ── 3D cube ── */
        .scene { width: 200px; height: 200px; margin: 24px auto; perspective: 800px; }
        .cube  { width: 100%; height: 100%; position: relative; transform-style: preserve-3d; transition: transform 0.8s cubic-bezier(0.4,0,0.2,1); }
        .cube-face {
            position: absolute; width: 200px; height: 200px;
            background: rgba(78,84,200,0.85); border: 2px solid var(--accent);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; font-weight: bold; backface-visibility: hidden;
            cursor: pointer; box-shadow: 0 0 20px rgba(0,210,255,0.2); user-select: none;
        }
        .front  { transform: rotateY(  0deg) translateZ(100px); }
        .right  { transform: rotateY( 90deg) translateZ(100px); }
        .back   { transform: rotateY(180deg) translateZ(100px); }
        .left   { transform: rotateY(-90deg) translateZ(100px); }
        .top    { transform: rotateX( 90deg) translateZ(100px); }
        .bottom { transform: rotateX(-90deg) translateZ(100px); }

        /* ── Admin dashboard ── */
        .dashboard-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; flex-wrap: wrap; gap:10px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px,1fr)); gap: 18px; margin-bottom: 28px; }
        .stat-card  { text-align: center; border: 1px solid rgba(255,255,255,0.1); padding: 20px; border-radius: 12px; background: rgba(0,0,0,0.2); }
        .stat-num   { font-size: 2.4rem; font-weight: bold; color: var(--accent); margin-bottom: 5px; }
        .admin-layout { display: grid; grid-template-columns: 2.2fr 1fr; gap: 24px; }
        @media (max-width: 900px) { .admin-layout { grid-template-columns: 1fr; } .doc-container { grid-template-columns: 1fr; } }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; table-layout: auto; }
        th { text-align: left; padding: 12px 10px; border-bottom: 2px solid var(--glass-border); color: var(--accent); font-size: 0.82rem; text-transform: uppercase; letter-spacing: 1px; white-space: nowrap; }
        td { padding: 12px 10px; border-bottom: 1px solid rgba(255,255,255,0.05); font-size: 0.88rem; white-space: nowrap; }
        td b { white-space: normal; } /* Allow names to wrap if needed */
        td .category-tag { white-space: nowrap; }
        tr:hover { background: rgba(255,255,255,0.04); }

        .chart-box { height: 300px; display: flex; align-items: flex-end; justify-content: space-around; padding-top: 40px; border-bottom: 2px solid var(--glass-border); }
        .bar { width: 50px; background: linear-gradient(to top, var(--primary), var(--accent)); border-radius: 8px 8px 0 0; position: relative; box-shadow: 0 0 15px rgba(78,84,200,0.5); }
        .bar:hover { filter: brightness(1.2); }
        .bar-label { position: absolute; bottom: -28px; left: 50%; transform: translateX(-50%); font-size: 0.82rem; color: #ccc; width: 90px; text-align: center; }
        .bar-value { position: absolute; top: -28px; left: 50%; transform: translateX(-50%); font-weight: bold; color: white; }

        .modal { display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); backdrop-filter: blur(5px); align-items: center; justify-content: center; }
        .modal-content { background: #1e1e2f; padding: 30px; border-radius: 12px; width: 90%; max-width: 420px; border: 1px solid var(--accent); position: relative; animation: slideUp 0.3s ease; }
        @keyframes slideUp { from {transform: translateY(50px); opacity:0;} to {transform: translateY(0); opacity:1;} }
        .close { position: absolute; top: 15px; right: 20px; font-size: 24px; cursor: pointer; color: #aaa; }
        .close:hover { color: var(--danger); }
        .modal-content label { font-size: 0.84rem; color: var(--text-dim); display: block; margin-bottom: 2px; }

        footer { margin-top: auto; background: rgba(0,0,0,0.4); border-top: 1px solid var(--glass-border); padding: 55px 5% 20px; }
        .footer-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(190px,1fr)); gap: 28px; margin-bottom: 36px; }
        .footer-col h3 { color: var(--accent); margin-bottom: 18px; font-size: 1rem; }
        .footer-col p, .footer-col li { color: var(--text-dim); line-height: 1.8; font-size: 0.88rem; }
        .footer-col ul { list-style: none; }
        .footer-col a { color: var(--text-dim); text-decoration: none; transition: 0.3s; }
        .footer-col a:hover { color: var(--accent); }
        .social-icons a { font-size: 1.4rem; margin-right: 14px; color: white; transition: 0.3s; }
        .social-icons a:hover { color: var(--accent); }
        .map-frame { width: 100%; height: 140px; border-radius: 8px; filter: invert(90%) hue-rotate(180deg); border: 1px solid var(--glass-border); }
        .footer-bottom { text-align: center; padding-top: 18px; border-top: 1px solid rgba(255,255,255,0.05); font-size: 0.83rem; color: #777; }

        #toast { visibility: hidden; min-width: 250px; background: #333; color: #fff; text-align: center; border-radius: 4px; padding: 16px; position: fixed; z-index: 3000; left: 50%; bottom: 30px; transform: translateX(-50%); box-shadow: 0 4px 10px rgba(0,0,0,0.3); border-left: 5px solid var(--accent); }
        #toast.show { visibility: visible; animation: fadein 0.5s, fadeout 0.5s 2.5s; }
        @keyframes fadein  { from {bottom:0; opacity:0;} to {bottom:30px; opacity:1;} }
        @keyframes fadeout { from {bottom:30px; opacity:1;} to {bottom:0; opacity:0;} }

        .empty-state { text-align: center; padding: 38px; color: var(--text-dim); }
        .empty-state i { font-size: 2.8rem; margin-bottom: 14px; opacity: 0.35; display: block; }

        form-label { display: block; font-size: 0.84rem; color: var(--text-dim); margin-bottom: 3px; text-align: left; }
        
        /* ── New Styles for Agent Login & Admin Auth ── */
        .login-options { display: flex; justify-content: center; width: 100%; }
        .login-card {
            background: rgba(255,255,255,0.03); border: 1px solid var(--glass-border);
            padding: 35px; border-radius: 12px; text-align: center; transition: 0.3s;
            max-width: 400px; width: 100%;
        }
        
        .login-card {
            background: rgba(255,255,255,0.03); border: 1px solid var(--glass-border);
            padding: 20px; border-radius: 10px; text-align: center; transition: 0.3s;
        }
        .login-card:hover { border-color: var(--accent); transform: translateY(-3px); }
        .login-card h3 { margin: 10px 0; font-size: 1.1rem; }
        .login-card i { font-size: 2rem; margin-bottom: 10px; color: var(--secondary); }
        .agent-card i { color: var(--warning); }
        .admin-card i { color: var(--danger); }
        .login-input-group { text-align: left; margin-top: 10px; }

        /* ── Navigation Layouts ── */
        .top-navbar {
            display: flex; justify-content: space-between; align-items: center;
            padding: 0 5%; background: rgba(10,15,30,0.85); backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--glass-border); position: sticky; top: 0; z-index: 1100; height: 75px;
            width: 100%; transition: 0.3s;
        }
        .top-navbar .logo { font-size: 1.6rem; font-weight: 700; color: #fff; text-decoration: none; }
        .top-navbar .nav-links { display: flex; flex-direction: row; gap: 25px; align-items: center; }
        .top-navbar .nav-links button { 
            background: none; color: #ccc; font-size: 0.95rem; font-weight: 500; padding: 5px 0;
            border-bottom: 2px solid transparent; border-radius: 0;
        }
        .top-navbar .nav-links button:hover { color: var(--accent); border-bottom-color: var(--accent); }

        .sidebar {
            width: 260px; height: 100vh; position: fixed; left: 0; top: 0;
            background: rgba(15, 20, 35, 0.95); backdrop-filter: blur(25px);
            border-right: 1px solid var(--glass-border); display: flex; flex-direction: column;
            padding: 30px 0; z-index: 1000; box-shadow: 10px 0 30px rgba(0,0,0,0.3);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .sidebar .logo { font-size: 1.8rem; font-weight: 800; color: var(--accent); padding: 0 30px; margin-bottom: 45px; letter-spacing: 2px; }
        .sidebar .nav-links { display: flex; flex-direction: column; gap: 4px; width: 100%; }
        .sidebar .nav-links button {
            text-align: left; padding: 14px 30px; background: none; border: none; color: #ccc;
            font-size: 0.95rem; cursor: pointer; transition: 0.2s; border-left: 4px solid transparent;
            display: flex; align-items: center; gap: 15px; border-radius: 0;
        }
        .sidebar .nav-links button i { font-size: 1.1rem; width: 22px; text-align: center; }
        .sidebar .nav-links button:hover, .sidebar .nav-links button.active-nav { 
            background: rgba(0,210,255,0.08); color: var(--accent); border-left-color: var(--accent); 
        }
        
        .main-content { flex: 1; display: flex; flex-direction: column; min-height: 100vh; transition: 0.3s; }
        body.with-sidebar .main-content { margin-left: 260px; padding: 40px 5%; }
        body.with-sidebar .top-navbar { display: none; }
        body.no-sidebar .sidebar { transform: translateX(-260px); }
        body.no-sidebar .main-content { margin-left: 0; padding: 0; }

        @media (max-width: 1100px) {
            body.with-sidebar .main-content { margin-left: 80px; }
            .sidebar { width: 80px; }
            .sidebar .logo { font-size: 0; padding: 0; text-align: center; }
            .sidebar .logo::before { content: 'IK'; font-size: 1.8rem; }
            .sidebar button span { display: none; }
        }

        .notif-sidebar { margin-top: auto; padding: 25px 30px; border-top: 1px solid var(--glass-border); position: relative; }
        .notif-badge-sidebar { background: var(--danger); color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.7rem; margin-left: 5px; min-width: 18px; text-align: center; }
        .notif-dot { position: absolute; top: 25px; left: 42px; width: 8px; height: 8px; background: var(--danger); border-radius: 50%; display: none; box-shadow: 0 0 8px var(--danger); }
        
        .notif-item {
            padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.05); font-size: 0.85rem; 
            transition: 0.2s; border-radius: 6px; margin-bottom: 5px;
        }
        .notif-item:hover { background: rgba(255,255,255,0.05); }
        .notif-item.unread { border-left: 3px solid var(--accent); background: rgba(0,210,255,0.03); }
        .notif-item i { margin-right: 8px; color: var(--accent); }
    </style>
</head>
<body class="no-sidebar">

<nav class="top-navbar" id="topNav">
    <div class="logo">INKOMANE</div>
    <div class="nav-links" id="topNavLinks"></div>
</nav>

<div class="sidebar" id="sideNav">
    <div class="logo">INKOMANE</div>
    <div class="nav-links" id="sideNavLinks"></div>
    <div class="notif-sidebar" onclick="toggleNotifications()">
        <div id="notifDot" class="notif-dot"></div>
        <button style="background:none; border:none; color:var(--accent); cursor:pointer; display:flex; align-items:center; gap:10px; padding:0;">
            <i class="fas fa-bell"></i> <span>Notifications</span>
            <span id="notifBadge" class="notif-badge-sidebar" style="display: none;">0</span>
        </button>
        <div id="notifDropdown" class="glass-panel" style="position: absolute; bottom: 80px; left: 20px; width: 280px; max-height: 400px; overflow-y: auto; display: none; z-index: 2001; padding: 15px;">
            <h4 style="margin-bottom: 10px; border-bottom: 1px solid var(--glass-border); padding-bottom: 5px;">Notifications</h4>
            <div id="notifList"></div>
            <button class="btn-configure" style="width: 100%; margin-top: 10px;" onclick="clearNotifications()">Clear All</button>
        </div>
    </div>
</div>

<div class="main-content">

<!-- ═══════════════ HOME ═══════════════ -->
<section id="home" class="view-section active">
    <div style="text-align:center; margin-top:60px; margin-bottom:55px;">
        <h1 style="font-size:3.2rem; margin-bottom:18px; background:linear-gradient(to right,#fff,var(--accent)); background-clip:text; -webkit-text-fill-color:transparent;">
            Next-Gen Support Ticketing
        </h1>
        <p style="color:var(--text-dim); font-size:1.15rem; max-width:760px; margin:0 auto 36px; line-height:1.65;">
            Experience streamlined support. Apply for a ticket, wait for agent assignment, then log back in to see your real-time confirmation status.
        </p>
        <button class="btn-primary" style="font-size:1.05rem; padding:12px 32px;" onclick="router('login')">Get Started</button>
    </div>
    <div class="glass-panel">
        <h2 style="color:var(--accent); margin-bottom:20px; text-align:center;">How It Works</h2>
        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); gap:28px;">
            <div style="text-align:center;">
                <i class="fas fa-paper-plane" style="font-size:2.8rem; color:var(--secondary); margin-bottom:14px;"></i>
                <h3>1. Apply</h3>
                <p style="color:var(--text-dim); margin-top:8px; font-size:0.9rem;">Register and submit your support ticket application with your issue details.</p>
            </div>
            <div style="text-align:center;">
                <i class="fas fa-hourglass-half" style="font-size:2.8rem; color:var(--warning); margin-bottom:14px;"></i>
                <h3>2. Wait for Assignment</h3>
                <p style="color:var(--text-dim); margin-top:8px; font-size:0.9rem;">An admin reviews your application and assigns a support agent.</p>
            </div>
            <div style="text-align:center;">
                <i class="fas fa-check-circle" style="font-size:2.8rem; color:var(--success); margin-bottom:14px;"></i>
                <h3>3. Get Confirmed</h3>
                <p style="color:var(--text-dim); margin-top:8px; font-size:0.9rem;">Log back in with your email — see green if confirmed, red if still pending.</p>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════ LOGIN (UPDATED) ═══════════════ -->
<section id="login" class="view-section">
    <div class="center-box" style="max-width: 900px;">
        <div class="glass-panel" style="text-align:center;">
            <h2 style="margin-bottom:6px;">System Login</h2>
            <p style="color:var(--text-dim); margin-bottom:26px; font-size:0.9rem;">Select your role to access the portal.</p>

            <div class="login-options">
                <div class="login-card">
                    <i class="fas fa-shield-alt" style="font-size: 3rem; color: var(--accent); margin-bottom: 20px;"></i>
                    <h3 style="font-size: 1.5rem; margin-bottom: 10px;">Login to Portal</h3>
                    <p style="font-size:0.85rem; color:var(--text-dim); margin-bottom:25px;">Enter your credentials to access your dashboard.</p>
                    
                    <div style="text-align: left; margin-bottom: 15px;">
                        <label style="font-size: 0.8rem; color: var(--text-dim);">Email Address</label>
                        <input type="email" id="uniEmail" placeholder="email@example.com">
                    </div>
                    
                    <div style="text-align: left; margin-bottom: 25px;">
                        <label style="font-size: 0.8rem; color: var(--text-dim);">Password</label>
                        <input type="password" id="uniPass" placeholder="••••••••">
                    </div>

                    <button class="btn-primary" style="width:100%; padding: 14px; font-size: 1rem;" onclick="unifiedLogin()">
                        <i class="fas fa-sign-in-alt"></i> Access System
                    </button>
                </div>
            </div>

            <p style="margin-top:25px; font-size:0.85rem; color:var(--text-dim);">
                Need support? <a href="#" onclick="router('apply')" style="color:var(--accent); font-weight:600;">Apply for Support →</a>
            </p>
            <p style="margin-top:10px; font-size:0.85rem; color:var(--text-dim);">
                New Staff? <a href="#" onclick="router('register')" style="color:var(--secondary); font-weight:600;">Create Internal Account</a>
            </p>
        </div>
    </div>
</section>

<!-- ═══════════════ APPLY FOR SUPPORT (CUSTOMER ONLY) ═══════════════ -->
<section id="apply" class="view-section">
    <div class="center-box" style="max-width:530px;">
        <div class="glass-panel">
            <h2 style="margin-bottom:5px;"><i class="fas fa-paper-plane"></i> Apply for Support</h2>
            <p style="color:var(--text-dim); font-size:0.88rem; margin-bottom:22px;">
                Tell us who you are and describe your issue. An agent will be assigned — log back in with your email to see your confirmation.
            </p>

            <p style="font-size:0.82rem; color:var(--text-dim); margin-bottom:3px; text-align:left;">Full Name *</p>
            <input type="text"  id="applyName"    placeholder="e.g. Alice Smith">

            <p style="font-size:0.82rem; color:var(--text-dim); margin-bottom:3px; text-align:left;">Email Address *</p>
            <input type="email" id="applyEmail"   placeholder="e.g. alice@email.com">

            <p style="font-size:0.82rem; color:var(--text-dim); margin-bottom:3px; text-align:left;">Create Tracking Password *</p>
            <input type="password" id="applyPass" placeholder="••••••••">

            <p style="font-size:0.82rem; color:var(--text-dim); margin-bottom:3px; text-align:left;">Department</p>
            <select id="applyDept">
                <option value="Sales">Sales Department</option>
                <option value="Technical">Technical Support</option>
                <option value="Billing">Billing Accounts</option>
            </select>

            <p style="font-size:0.82rem; color:var(--text-dim); margin-bottom:6px; text-align:left;">Issue Category — rotate the cube and click a face</p>
            <div class="scene">
                <div class="cube" id="applyCube">
                    <div class="cube-face front"  onclick="setRegCat('Hardware')">Hardware</div>
                    <div class="cube-face back"   onclick="setRegCat('Software')">Software</div>
                    <div class="cube-face right"  onclick="setRegCat('Network')">Network</div>
                    <div class="cube-face left"   onclick="setRegCat('Account')">Account</div>
                    <div class="cube-face top"    onclick="setRegCat('Access')">Access</div>
                    <div class="cube-face bottom" onclick="setRegCat('Other')">Other</div>
                </div>
            </div>
            <p style="text-align:center; margin-bottom:6px; font-size:0.88rem;">
                Selected: <strong id="applySelectedCat" style="color:var(--accent);">Hardware</strong>
            </p>
            <div style="display:flex; gap:8px; justify-content:center; margin-bottom:18px;">
                <button class="btn-outline" style="padding:7px 18px;" onclick="rotateRegCube(-1)">&#8592; Left</button>
                <button class="btn-outline" style="padding:7px 18px;" onclick="rotateRegCube(1)">Right &#8594;</button>
            </div>

            <p style="font-size:0.82rem; color:var(--text-dim); margin-bottom:3px; text-align:left;">Issue Subject *</p>
            <input type="text" id="applySubject" placeholder="Brief one-line description of your problem">

            <p style="font-size:0.82rem; color:var(--text-dim); margin-bottom:3px; text-align:left;">Additional Details</p>
            <textarea id="applyDesc" rows="3" placeholder="Any extra context that will help the agent..."></textarea>

            <p style="font-size:0.82rem; color:var(--text-dim); margin-bottom:3px; text-align:left;">Attach File (Screenshot/Logs)</p>
            <input type="file" id="applyFile" style="padding: 8px;">

            <button class="btn-primary" style="width:100%; font-size:0.98rem; padding:13px;" onclick="submitApplication()">
                <i class="fas fa-paper-plane"></i>&nbsp; Submit Application
            </button>
            <button class="btn-outline" style="width:100%; margin-top:10px;" onclick="router('login')">Cancel</button>
        </div>
    </div>
</section>

<!-- ═══════════════ INTERNAL REGISTRATION (USERS/AGENTS) ═══════════════ -->
<section id="register" class="view-section">
    <div class="center-box" style="max-width:450px;">
        <div class="glass-panel">
            <h2 style="margin-bottom:5px;"><i class="fas fa-user-plus"></i> Internal Registration</h2>
            <p style="color:var(--text-dim); font-size:0.88rem; margin-bottom:22px;">Create an account for staff or administration access.</p>

            <p style="font-size:0.82rem; color:var(--text-dim); margin-bottom:3px; text-align:left;">User Category *</p>
            <select id="regRole">
                <option value="User">General User</option>
                <option value="Team Agent">Team Agent</option>
                <option value="Admin">Administrator</option>
            </select>

            <p style="font-size:0.82rem; color:var(--text-dim); margin-bottom:3px; text-align:left;">Full Name *</p>
            <input type="text"  id="regName" placeholder="Full Name">

            <p style="font-size:0.82rem; color:var(--text-dim); margin-bottom:3px; text-align:left;">Email Address *</p>
            <input type="email" id="regEmail" placeholder="Email">

            <p style="font-size:0.82rem; color:var(--text-dim); margin-bottom:3px; text-align:left;">Password *</p>
            <input type="password" id="regPass" placeholder="••••••••">

            <button class="btn-primary" style="width:100%; font-size:0.98rem; padding:13px;" onclick="unifiedRegister()">
                <i class="fas fa-check-circle"></i>&nbsp; Create Account
            </button>
            <button class="btn-outline" style="width:100%; margin-top:10px;" onclick="router('login')">Cancel</button>
        </div>
    </div>
</section>

<!-- ═══════════════ WAIT PAGE ═══════════════ -->
<section id="wait-page" class="view-section">
    <div class="center-box">
        <div class="glass-panel">
            <div class="wait-box">
                <span class="wait-icon"><i class="fas fa-hourglass-half"></i></span>
                <h2>Application Submitted!</h2>
                <p>Thank you, <strong id="waitName"></strong>. Your support ticket is now in the queue and awaiting agent assignment.</p>
                <p style="margin-bottom:30px;">
                    Come back and <strong>log in with your email</strong> to see whether your application has been confirmed.
                </p>
                <button class="btn-primary" style="padding:12px 36px; font-size:0.98rem;" onclick="router('home')">
                    <i class="fas fa-home"></i>&nbsp; Back to Home
                </button>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════ CUSTOMER STATUS PAGE ═══════════════ -->
<section id="customer-status" class="view-section">
    <div style="max-width:640px; margin:0 auto;">
        <!-- Banner injected by JS -->
        <div id="customerStatusBanner"></div>

        <div class="glass-panel">
            <h3 style="margin-bottom:18px;"><i class="fas fa-ticket-alt"></i> Active Tickets</h3>
            <div id="customerActiveTickets"></div>
            
            <hr style="border:0; border-top:1px solid var(--glass-border); margin:25px 0;">
            
            <h3 style="margin-bottom:18px;"><i class="fas fa-clipboard-list"></i> Your Application Details</h3>
            <div id="customerApplicationCards"></div>
        </div>

        <div style="text-align:center; margin-top:10px;">
            <button class="btn-danger" onclick="logout()">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </div>
    </div>
</section>

<!-- Admin Overview and Old App Queue Removed -->

<!-- ═══════════════ AGENT DASHBOARD ═══════════════ -->
<section id="agent-dashboard" class="view-section">
    <div class="dashboard-header">
        <h1><i class="fas fa-headset"></i> Agent Workspace</h1>
    </div>
    
    <div class="admin-layout">
        <div class="glass-panel">
            <h3>My Assigned Tickets</h3>
            <p style="color:var(--text-dim); margin-bottom:15px; font-size:0.9rem;">Tickets currently assigned to you for resolution.</p>
            <table id="agentTicketTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="agentTicketBody"></tbody>
            </table>
        </div>

        <div class="glass-panel profile-card">
            <h3><i class="fas fa-id-card"></i> My Contact Info</h3>
            <p style="color:var(--text-dim); margin-bottom:15px; font-size:0.85rem;">This info is visible to customers on their tickets.</p>
            <label>Display Name</label>
            <input type="text" id="agentProfileName" placeholder="Public Name">
            <label>Contact Phone</label>
            <input type="text" id="agentProfilePhone" placeholder="+123 456 789">
            <label>Work Email</label>
            <input type="email" id="agentProfileEmail" placeholder="agent@email.com">
            <button class="btn-primary" style="width:100%" onclick="saveAgentProfile()">Update Profile</button>
        </div>
    </div>
</section>

<!-- ═══════════════ APPLICATIONS QUEUE (Agent Managed) ═══════════════ -->
<section id="applications-queue" class="view-section">
    <div class="dashboard-header">
        <h1><i class="fas fa-clipboard-list"></i> Applications Queue</h1>
        <button class="btn-success" onclick="confirmAll()"><i class="fas fa-check-double"></i> Confirm All</button>
    </div>
    <div class="glass-panel">
        <table class="customer-table">
            <thead>
                <tr>
                    <th>Applicant</th><th>Email</th><th>Category</th>
                    <th>Subject</th><th>Submitted</th><th>Status</th><th>Action</th>
                </tr>
            </thead>
            <tbody id="appsTableBody"></tbody>
        </table>
    </div>
</section>

<!-- ═══════════════ CUSTOMER MANAGEMENT (Admin CRUD) ═══════════════ -->
<section id="customer-management" class="view-section">
    <div class="glass-panel">
        <div class="customer-header">
            <h2>Team & User Management</h2>
            <div class="customer-actions">
                <button class="btn-warning" onclick="openDbConfigModal()"><i class="fas fa-database"></i> DB Config</button>
                <select id="filterSelect" onchange="filterUsers()">
                    <option value="all">All</option>
                    <option value="Sales">Sales</option>
                    <option value="Technical">Technical</option>
                    <option value="Billing">Billing</option>
                </select>
                <button class="btn-icon" onclick="loadUsers()" title="Refresh"><i class="fas fa-sync-alt"></i></button>
                <button class="btn-primary" onclick="openUserModal()"><i class="fas fa-user-plus"></i> Add User</button>
            </div>
        </div>
        <table class="customer-table">
            <thead>
                <tr><th>Full Name</th><th>Email</th><th>Department</th><th>Role</th><th>Payment</th><th>Clickthrough</th><th>Actions</th></tr>
            </thead>
            <tbody id="customerTableBody">
                <tr><td colspan="7"><div class="empty-state"><i class="fas fa-spinner fa-spin"></i>Loading...</div></td></tr>
            </tbody>
        </table>
    </div>
</section>

<!-- ═══════════════ DOCS ═══════════════ -->
<section id="docs" class="view-section">
    <h1 style="margin-bottom:28px; text-align:center;">Project Documentation</h1>
    <div class="doc-container">
        <div class="doc-sidebar">
            <button onclick="showDoc('overview')"       class="active-doc" id="btn-overview">System Overview</button>
            <button onclick="showDoc('functional')"     id="btn-functional">Functional Req.</button>
            <button onclick="showDoc('non-functional')" id="btn-non-functional">Non-Functional</button>
        </div>
        <div class="glass-panel doc-content" id="docDisplay"></div>
    </div>
</section>

</main>

<!-- MODAL: Add / Edit User -->
<div id="userModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeUserModal()">&times;</span>
        <h3 id="userModalTitle"><i class="fas fa-user-plus"></i> Add New User</h3>
        <input type="hidden" id="editUserId">
        <label>Full Name *</label>
        <input type="text"  id="newName"  placeholder="Full Name">
        <label>Email *</label>
        <input type="email" id="newEmail" placeholder="Email Address">
        <label>Role</label>
        <select id="newRole">
            <option value="Customer">Customer</option>
            <option value="User">User</option>
            <option value="Team Agent">Team Agent</option>
            <option value="Admin">Admin</option>
        </select>
        <label>Department</label>
        <select id="newDept">
            <option value="Sales">Sales</option>
            <option value="Technical">Technical</option>
            <option value="Billing">Billing</option>
        </select>
        <label>Payment Method</label>
        <select id="newPayment">
            <option value="VISA • Active">VISA • Active</option>
            <option value="MC • Active">MC • Active</option>
            <option value="VISA • Expiring">VISA • Expiring</option>
            <option value="MC • Expiring">MC • Expiring</option>
            <option value="None">None</option>
        </select>
        <button class="btn-primary" style="width:100%" onclick="saveUser()"><i class="fas fa-save"></i> Save User</button>
    </div>
</div>

<!-- MODAL: Create Ticket (New) -->
<div id="createTicketModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeCreateTicketModal()">&times;</span>
        <h3><i class="fas fa-plus-circle"></i> Create New Ticket</h3>
        <label>Customer Email</label>
        <input type="email" id="ticketCustomerEmail" placeholder="customer@example.com">
        <label>Subject</label>
        <input type="text" id="ticketSubject" placeholder="Ticket Subject">
        <label>Category</label>
        <select id="ticketCategory">
            <option value="Hardware">Hardware</option>
            <option value="Software">Software</option>
            <option value="Network">Network</option>
            <option value="Account">Account</option>
            <option value="Billing">Billing</option>
        </select>
        <label>Assign To Agent</label>
        <select id="ticketAgent">
            <!-- Populated by JS -->
        </select>
        <label>Priority</label>
        <select id="ticketPriority">
            <option value="Low">Low</option>
            <option value="Medium">Medium</option>
            <option value="High">High</option>
        </select>
        <button class="btn-primary" style="width:100%" onclick="submitNewTicket()">Create & Assign</button>
    </div>
</div>

<!-- MODAL: Configure Ticket -->
<div id="ticketConfigModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeTicketConfig()">&times;</span>
        <h3>Configure Ticket</h3>
        <p id="configTicketId" style="color:var(--accent); font-size:0.88rem; margin-bottom:12px;"></p>
        <label>Subject</label>
        <input type="text" id="configSubject" placeholder="Subject">
        <label>Status</label>
        <select id="configStatus">
            <option value="Open">Open</option>
            <option value="In Progress">In Progress</option>
            <option value="Resolved">Resolved</option>
            <option value="Closed">Closed</option>
        </select>
        <label>Priority</label>
        <select id="configPriority">
            <option value="Low">Low</option>
            <option value="Medium">Medium</option>
            <option value="High">High</option>
        </select>
        <label>Agent Response</label>
        <textarea id="configResponse" placeholder="Write your response to the customer here..." style="width:100%; height:100px; padding:10px; border-radius:6px; background:rgba(255,255,255,0.05); border:1px solid var(--glass-border); color:white; margin-bottom:15px; resize:vertical;"></textarea>
        <button class="btn-primary" style="width:100%" onclick="saveTicketConfig()">Update Ticket</button>
    </div>
</div>

<!-- MODAL: DB Config (Admin Only) -->
<div id="dbConfigModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeDbConfigModal()">&times;</span>
        <h3><i class="fas fa-database"></i> Database Configuration</h3>
        <p style="font-size:0.8rem; color:var(--text-dim); margin-bottom:15px;">Configure the system database connection.</p>
        <label>DB Host</label>
        <input type="text" id="dbHost" value="127.0.0.1">
        <label>DB Name</label>
        <input type="text" id="dbName" value="inkomane">
        <label>DB User</label>
        <input type="text" id="dbUser" value="root">
        <label>DB Password</label>
        <input type="password" id="dbPass" value="">
        <button class="btn-primary" style="width:100%" onclick="saveDbConfig()">Update Connection</button>
    </div>
</div>

<!-- Footer -->
<footer>
    <div class="footer-grid">
        <div class="footer-col">
            <h3>INKOMANE</h3>
            <p>Advanced customer support ticketing system with interactive 3D tools and real-time analytics.</p>
            <div class="social-icons" style="margin-top:14px;">
                <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com"  target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <div class="footer-col">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="#" onclick="router('home')">Home</a></li>
                <li><a href="#" onclick="router('docs')">Documentation</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms of Service</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h3>Contact Us</h3>
            <p><i class="fas fa-map-marker-alt"></i> 123 Innovation Dr, Tech City</p>
            <p><i class="fas fa-envelope"></i> support@inkomane.com</p>
            <p><i class="fas fa-phone"></i> +1 (555) 123-4567</p>
        </div>
        <div class="footer-col">
            <h3>Locate Us</h3>
         <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3525.3699972122804!2d30.094612574365634!3d-1.9708071367561184!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19dca70046d8c8e9%3A0xbf7e6f38dd3d9b3c!2sGoodLink%20Solutions%20-%20INKOMANE!5e1!3m2!1sen!2srw!4v1776849198885!5m2!1sen!2srw" class="map-frame"  width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <div class="footer-bottom">&copy; 2026 INKOMANE Project. All Rights Reserved.</div>
</footer>

<div id="toast">Message</div>

<script>
// ──────────────────────────────────────────────
// DOCS DATA
// ──────────────────────────────────────────────

    // ──────────────────────────────────────────────
// DOCS DATA
// ──────────────────────────────────────────────
const docsData = {
    overview:        '<h2>System Overview</h2><p>INKOMANE is an application-based support ticketing system. Users apply for support, admins confirm via a queue, and applicants see colour-coded confirmation status on their next login.</p>',
    functional:      '<h2>Functional Requirements</h2><ul><li>Application-based ticket submission with 3D category cube</li><li>Instant wait page after applying</li><li>Admin Applications Queue with one-click confirm</li><li>Customer status page: green = confirmed, red = pending</li><li>Full User & Ticket CRUD for admins</li><li>Agent Dashboard for assigned tickets</li></ul>',
    'non-functional':'<h2>Non-Functional</h2><p>Fast, Secure, and Scalable with graceful fallback when the backend API is unavailable.</p>'
};

// ──────────────────────────────────────────────
// STATE
// ──────────────────────────────────────────────
const state = {
    currentUser:     null,
    regCubeRot:      0,
    regSelectedCat:  'Hardware',
    editingTicketId: null,
    editingUserId:   null,
    adminCredentials: { email: 'admin@inkomane.com', pass: 'admin123' },
    applications: [],
    tickets: [],
    users: []
};

// ──────────────────────────────────────────────
// API HELPER — strictly fetch
// ──────────────────────────────────────────────
async function api(action, method = 'POST', data = {}) {
  try {
        let url = '/api?api=' + action;
        let opts = {
            method: method,
            headers: { 'Accept': 'application/json' }
        };

        if (data instanceof FormData) {
            opts.body = data;
        } else {
            opts.headers['Content-Type'] = 'application/json';
            if (method === 'GET' && Object.keys(data).length) {
                url += '&' + new URLSearchParams(data).toString();
            } else if (method !== 'GET') {
                opts.body = JSON.stringify(data);
            }
        }

        const res = await fetch(url, opts);
        const json = await res.json();
        return json;
    } catch (e) {
        console.error('API Error:', e);
        return { success: false, message: 'Connection Error: ' + e.message };
    }
}

// ──────────────────────────────────────────────
// DATA LOADERS
// ──────────────────────────────────────────────
async function loadSystemData() {
    const data = await api('get_data', 'GET');
    if (data.success) {
        state.users        = data.users        || [];
        state.tickets      = data.tickets      || [];
        state.applications = data.applications || [];
        state.currentUser  = data.auth || null;
        
        renderNotifications(data.notifications || []);

        // Initial Routing Logic
        const lastView = localStorage.getItem('lastView');
        if (state.currentUser) {
            // If logged in and on a public page, go to dashboard
            if (!state.currentView || state.currentView === 'home' || state.currentView === 'login' || state.currentView === 'register') {
                if (lastView && lastView !== 'login' && lastView !== 'register') {
                    router(lastView);
                } else {
                    // Default role-based routing
                    if (state.currentUser.role === 'Admin') router('admin-dashboard');
                    else if (state.currentUser.role === 'Team Agent') router('agent-dashboard');
                    else if (state.currentUser.role === 'User') router('home');
                    else router('customer-status');
                }
            } else {
                router(state.currentView);
            }
        } else {
            // Not logged in
            if (!state.currentView) router('home');
            else if (['admin-dashboard', 'agent-dashboard', 'customer-management', 'applications-queue', 'customer-status'].includes(state.currentView)) {
                router('login');
            } else {
                router(state.currentView);
            }
        }
    }
}

function renderNotifications(notifs) {
    const list = document.getElementById('notifList');
    const badge = document.getElementById('notifBadge');
    const dot = document.getElementById('notifDot');
    
    if (notifs.length > 0) {
        badge.innerText = notifs.length;
        badge.style.display = 'block';
        if (dot) dot.style.display = 'block';
        
        list.innerHTML = notifs.map(n => {
            let icon = 'fa-info-circle';
            if (n.message.toLowerCase().includes('confirmed')) icon = 'fa-check-circle';
            if (n.message.toLowerCase().includes('assigned')) icon = 'fa-user-tag';
            if (n.message.toLowerCase().includes('updated')) icon = 'fa-sync-alt';

            return `
                <div class="notif-item ${n.is_read ? '' : 'unread'}">
                    <p style="margin: 0;"><i class="fas ${icon}"></i> ${n.message}</p>
                    <small style="color: var(--text-dim); font-size: 0.7rem; display: block; margin-top: 4px;">
                        <i class="far fa-clock" style="font-size: 0.7rem; color: inherit;"></i> ${new Date(n.created_at).toLocaleString()}
                    </small>
                </div>
            `;
        }).join('');
    } else {
        badge.style.display = 'none';
        if (dot) dot.style.display = 'none';
        list.innerHTML = '<div style="text-align: center; padding: 20px; color: var(--text-dim);"><i class="fas fa-bell-slash" style="font-size: 1.5rem; display: block; margin-bottom: 10px; opacity: 0.3;"></i> No new notifications</div>';
    }
}

function toggleNotifications() {
    const dropdown = document.getElementById('notifDropdown');
    dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
}

async function clearNotifications() {
    await api('clear_notifications', 'POST');
    loadSystemData();
}

// Initial load
loadSystemData();

// ──────────────────────────────────────────────
// ROUTER
// ──────────────────────────────────────────────
function router(view) {
    state.currentView = view;
    localStorage.setItem('lastView', view);
    
    const adminViews = ['admin-dashboard', 'customer-management'];
    const agentViews = ['agent-dashboard', 'applications-queue'];
    const dashboardViews = [...adminViews, ...agentViews, 'customer-status'];

    if (adminViews.includes(view)) {
        if (!state.currentUser || state.currentUser.role !== 'Admin') {
            showToast('Access Denied: Admin role required');
            router(state.currentUser ? (state.currentUser.role === 'Team Agent' ? 'agent-dashboard' : (state.currentUser.role === 'User' ? 'home' : 'customer-status')) : 'login');
            return;
        }
    }

    if (agentViews.includes(view)) {
        if (!state.currentUser || (state.currentUser.role !== 'Team Agent' && state.currentUser.role !== 'Admin')) {
            showToast('Access Denied: Agent role required');
            router(state.currentUser ? 'customer-status' : 'login');
            return;
        }
    }

    document.querySelectorAll('.view-section').forEach(el => el.classList.remove('active'));
    const target = document.getElementById(view);
    if (target) target.classList.add('active');

    // Layout Toggle: Dashboards get Sidebar, Public pages get Top Nav
    if (dashboardViews.includes(view) && state.currentUser) {
        document.body.classList.remove('no-sidebar');
        document.body.classList.add('with-sidebar');
    } else {
        document.body.classList.remove('with-sidebar');
        document.body.classList.add('no-sidebar');
    }

    updateNav();

    if (view === 'admin-dashboard')     syncDashboard();
    if (view === 'customer-management') loadUsers();
    if (view === 'applications-queue')  renderAppsTable();
    if (view === 'customer-status')     renderCustomerStatus();
    if (view === 'agent-dashboard')     renderAgentDashboard();
    
    // Scroll to top
    window.scrollTo(0, 0);
}

function updateNav() {
    const topNav = document.getElementById('topNavLinks');
    const sideNav = document.getElementById('sideNavLinks');
    
    // 1. PUBLIC TOP NAV
    let publicLinks = `
        <button onclick="router('home')">Home</button>
        <button onclick="router('docs')">Docs</button>
        <button onclick="router('apply')">Apply support</button>
        <button onclick="router('login')" style="color:var(--accent); font-weight:600;">Login</button>
        <button class="btn-primary" onclick="router('register')" style="padding:7px 20px; font-size:0.85rem; margin-left:10px;">Staff Signup</button>
    `;
    if (topNav) topNav.innerHTML = publicLinks;

    // 2. DASHBOARD SIDE NAV
    if (!state.currentUser) {
        if (sideNav) sideNav.innerHTML = '';
        return;
    }

    let sideLinks = `
        <button onclick="router('home')" id="link-home"><i class="fas fa-home"></i> <span>Home Portal</span></button>
        <button onclick="router('docs')" id="link-docs"><i class="fas fa-book"></i> <span>Documentation</span></button>
    `;
    
    if (state.currentUser.role === 'Admin') {
        sideLinks += `<button onclick="router('customer-management')" id="link-customer-management"><i class="fas fa-users-cog"></i> <span>User Management</span></button>`;
    } else if (state.currentUser.role === 'Team Agent') {
        const activeCount = state.tickets.filter(t => t.assigned_to === state.currentUser.name && t.status !== 'Resolved' && t.status !== 'Closed').length;
        sideLinks += `
            <button onclick="router('agent-dashboard')" id="link-agent-dashboard">
                <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                ${activeCount > 0 ? `<span class="notif-badge-sidebar" style="margin-left:auto; background:var(--accent);">${activeCount}</span>` : ''}
            </button>
            <button onclick="router('applications-queue')" id="link-applications-queue"><i class="fas fa-clipboard-list"></i> <span>Applications</span></button>
        `;
    } else if (state.currentUser.role === 'User') {
        sideLinks += `<button onclick="router('home')" id="link-home-user"><i class="fas fa-user-circle"></i> <span>Staff Portal</span></button>`;
    } else {
        sideLinks += `<button onclick="router('customer-status')" id="link-customer-status"><i class="fas fa-tasks"></i> <span>My Status</span></button>`;
    }
    
    sideLinks += `<button onclick="logout()" style="color:var(--danger); margin-top:30px;"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></button>`;
    
    if (sideNav) sideNav.innerHTML = sideLinks;

    // Highlight active link in sidebar
    document.querySelectorAll('.sidebar .nav-links button').forEach(b => b.classList.remove('active-nav'));
    const activeBtn = document.getElementById('link-' + state.currentView);
    if (activeBtn) activeBtn.classList.add('active-nav');
}



// ──────────────────────────────────────────────
// AUTH — ALL THREE ROLES
// ──────────────────────────────────────────────
async function unifiedLogin() {
    const email = document.getElementById('uniEmail').value.trim();
    const password = document.getElementById('uniPass').value;
    if (!email || !password) return showToast('Please enter both email and password');

    const data = await api('login', 'POST', { email, password });

    if (data.success) {
        state.currentUser = data.user;
        await loadSystemData();
        showToast('Welcome, ' + data.user.name + '!');
        
        // Dynamic redirection based on role
        if (data.user.role === 'Admin') router('admin-dashboard');
        else if (data.user.role === 'Team Agent') router('agent-dashboard');
        else if (data.user.role === 'User') router('home');
        else router('customer-status');
        
        document.getElementById('uniEmail').value = '';
        document.getElementById('uniPass').value = '';
    } else {
        showToast(data.message);
    }
}

async function unifiedRegister() {
    const role = document.getElementById('regRole').value;
    const name = document.getElementById('regName').value.trim();
    const email = document.getElementById('regEmail').value.trim();
    const password = document.getElementById('regPass').value;

    if (!name || !email || !password) return showToast('Fill all required fields');

    const res = await api('register', 'POST', { name, email, password, role });
    if (res.success) {
        showToast(res.message);
        router('login');
    } else {
        showToast(res.message);
    }
}

async function submitApplication() {
    const name    = document.getElementById('applyName').value.trim();
    const email   = document.getElementById('applyEmail').value.trim();
    const pass    = document.getElementById('applyPass').value;
    const subject = document.getElementById('applySubject').value.trim();
    const dept    = document.getElementById('applyDept').value;
    const desc    = document.getElementById('applyDesc').value.trim();
    const file    = document.getElementById('applyFile').files[0];

    if (!name || !email || !subject || !pass) return showToast('Please fill all required fields');

    const formData = new FormData();
    formData.append('role', 'Customer');
    formData.append('name', name);
    formData.append('email', email);
    formData.append('password', pass);
    formData.append('subject', subject);
    formData.append('category', state.regSelectedCat);
    formData.append('department', dept);
    formData.append('description', desc);
    if (file) formData.append('file', file);

    const res = await api('submit_application', 'POST', formData);
    if (res.success) {
        document.getElementById('waitName').innerText = name;
        router('wait-page');
        showToast('Application submitted successfully!');
    } else {
        showToast(res.message);
    }
}

function rotateRegCube(d) {
    state.regCubeRot += d * 90;
    const cubeId = (state.currentView === 'apply') ? 'applyCube' : 'regCube';
    const cube = document.getElementById(cubeId);
    if (cube) cube.style.transform = 'rotateY(' + state.regCubeRot + 'deg)';
}
function setRegCat(c) {
    state.regSelectedCat = c;
    const id = (state.currentView === 'apply') ? 'applySelectedCat' : 'regSelectedCat';
    const el = document.getElementById(id);
    if (el) el.innerText = c;
}

function toggleRegFields() {
    // Legacy function, no longer needed as we split sections
}

async function logout() {
    await api('logout', 'POST');
    state.currentUser = null;
    localStorage.removeItem('lastView');
    router('home');
}

// ──────────────────────────────────────────────
// REGISTER / APPLY
// ──────────────────────────────────────────────
// Cube logic moved to unified functions above



// ──────────────────────────────────────────────
// CUSTOMER STATUS PAGE
// ──────────────────────────────────────────────
async function renderCustomerStatus() {
    if (!state.currentUser) return;
    const email = state.currentUser.email.toLowerCase();
    const name = state.currentUser.name || 'Customer';

    const banner   = document.getElementById('customerStatusBanner');
    const cardsEl  = document.getElementById('customerApplicationCards');
    const tickEl   = document.getElementById('customerActiveTickets');

    const data = await api('customer_status', 'GET', { email: email });
    let apps = [], tickets = [];

    if (data.success && !data.fallback) {
        apps    = data.applications || [];
        tickets = data.tickets      || [];
    } else {
        apps    = state.applications.filter(a => a.email && a.email.toLowerCase() === email);
        tickets = state.tickets.filter(t => t.applicant_email && t.applicant_email.toLowerCase() === email);
    }

    // Modern Personalized Banner
    const hour = new Date().getHours();
    const greeting = hour < 12 ? 'Good Morning' : hour < 18 ? 'Good Afternoon' : 'Good Evening';
    
    banner.innerHTML = `
        <div class="glass-panel" style="background:linear-gradient(135deg, rgba(0,210,255,0.1), rgba(78,84,200,0.1)); border-left:5px solid var(--accent); margin-bottom:30px; padding:30px;">
            <h1 style="font-size:1.8rem; margin-bottom:10px;"><i class="fas fa-sparkles" style="color:var(--accent)"></i> ${greeting}, ${name}!</h1>
            <p style="color:var(--text-dim); font-size:1rem;">Welcome back to your support portal. Here is the latest update on your requests.</p>
        </div>
    `;

    // Sort apps: Pending first
    apps.sort((a, b) => (a.status === 'pending' ? -1 : 1));

    // Application cards (Pending/Review)
    cardsEl.innerHTML = apps.length
        ? apps.map(a => {
            const isPending = a.status === 'pending';
            return `
                <div class="applied-card" style="border-left:4px solid ${isPending ? 'var(--warning)' : 'var(--success)'}; background:rgba(255,255,255,0.02);">
                    <div class="ac-left">
                        <h4 style="font-size:1.1rem; margin-bottom:5px;">${a.subject}</h4>
                        <p style="font-size:0.85rem; color:var(--text-dim);"><i class="fas fa-calendar-alt"></i> Submitted: ${new Date(a.submitted_at || a.created_at).toLocaleDateString()} • <span style="color:var(--accent)">${a.category}</span></p>
                    </div>
                    <div class="applied-pill ${isPending ? 'pill-pending' : 'pill-confirmed'}" style="padding:8px 20px;">${a.status.toUpperCase()}</div>
                </div>
            `;
        }).join('')
        : '<div class="empty-state"><i class="fas fa-clipboard-list"></i><p>No applications in review.</p></div>';

    // Ticket cards (Active/Resolved) - THE MAIN FOCUS
    tickEl.innerHTML = tickets.length
        ? tickets.map(t => {
            const isResolved = t.status === 'Resolved' || t.status === 'Closed';
            const fileLink = t.file_path ? `<a href="/${t.file_path}" target="_blank" style="color:var(--accent); font-size:0.85rem; margin-top:10px; display:inline-flex; align-items:center; gap:8px; text-decoration:none; background:rgba(0,210,255,0.1); padding:6px 12px; border-radius:6px;"><i class="fas fa-paperclip"></i> View Attachment</a>` : '';
            
            let agentInfo = '';
            if (t.agent_name) {
                let phone = '';
                if (t.agent_contact) {
                    try {
                        const meta = JSON.parse(t.agent_contact);
                        phone = meta.phone ? ` • <i class="fas fa-phone" style="font-size:0.7rem;"></i> ${meta.phone}` : '';
                    } catch(e) {}
                }
                agentInfo = `
                    <div style="display:flex; align-items:center; gap:10px; margin-top:12px; padding-top:12px; border-top:1px solid rgba(255,255,255,0.05);">
                        <div style="width:32px; height:32px; border-radius:50%; background:var(--accent); display:flex; align-items:center; justify-content:center; color:white; font-weight:bold; font-size:0.8rem;">${t.agent_name.charAt(0)}</div>
                        <p style="color:var(--text-dim); font-size:0.85rem;"><b>Support Agent:</b> ${t.agent_name}${phone}</p>
                    </div>
                `;
            }
            
            return `
                <div class="applied-card" style="display:block; padding:25px; margin-bottom:20px; border-left: 5px solid ${isResolved ? 'var(--text-dim)' : 'var(--secondary)'}; background:rgba(255,255,255,0.03); transition:0.3s; box-shadow:0 4px 20px rgba(0,0,0,0.15);" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:15px;">
                        <div>
                            <span style="font-size:0.75rem; color:var(--accent); text-transform:uppercase; letter-spacing:1px; font-weight:bold;">Ticket #${t.id}</span>
                            <h3 style="font-size:1.25rem; margin-top:5px; color:white;">${t.subject}</h3>
                        </div>
                        <div class="category-tag" style="padding:6px 15px; border-radius:20px; ${isResolved ? 'background:rgba(255,255,255,0.05); color:#888;' : 'background:rgba(0,210,255,0.15); color:var(--accent); border:1px solid var(--accent);'}">
                            ${isResolved ? '<i class="fas fa-check-circle"></i> ' : '<i class="fas fa-circle-notch fa-spin"></i> '}${t.status}
                        </div>
                    </div>
                    
                    <div style="margin-bottom:15px; color:var(--text-dim); font-size:0.92rem; line-height:1.5;">
                        <span style="margin-right:15px;"><i class="fas fa-layer-group"></i> ${t.category}</span>
                        <span><i class="fas fa-signal"></i> ${t.priority} Priority</span>
                    </div>

                    ${t.agent_response ? `
                        <div style="background:rgba(0,210,255,0.06); padding:18px; border-radius:12px; border-left:4px solid var(--accent); margin-bottom:15px; box-shadow:inset 0 0 10px rgba(0,0,0,0.1);">
                            <p style="font-size:0.8rem; color:var(--accent); font-weight:bold; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;"><i class="fas fa-comment-dots"></i> Agent Feedback</p>
                            <p style="font-size:0.95rem; color:rgba(255,255,255,0.9); line-height:1.6;">${t.agent_response}</p>
                        </div>
                    ` : ''}

                    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                        ${agentInfo}
                        ${fileLink}
                    </div>
                </div>
            `;
          }).join('')
        : '<div class="empty-state"><i class="fas fa-ticket-alt"></i><p>You have no active support tickets at the moment.</p></div>';
}

// ──────────────────────────────────────────────
// ADMIN — APPLICATIONS QUEUE
// ──────────────────────────────────────────────
function renderAppsTable() {
    const tbody = document.getElementById('appsTableBody');
    if (!state.applications.length) {
        tbody.innerHTML = '<tr><td colspan="7"><div class="empty-state"><i class="fas fa-inbox"></i><p>No applications yet.</p></div></td></tr>';
        return;
    }
    tbody.innerHTML = state.applications.map(a => {
        let cls = 'app-pending';
        if (a.status === 'confirmed') cls = 'app-confirmed';
        if (a.status === 'rejected')  cls = 'app-pending'; // Keep red for rejected

        let actions = '';
        if (a.status === 'pending') {
            actions = `
                <div style="display:flex; gap:5px;">
                    <button class="btn-success" style="padding:6px 12px; font-size:0.8rem;" onclick="confirmApp(${a.id})"><i class="fas fa-check"></i></button>
                    <button class="btn-danger" style="padding:6px 12px; font-size:0.8rem;" onclick="rejectApp(${a.id})"><i class="fas fa-times"></i></button>
                </div>
            `;
        } else {
            actions = `<span style="color:var(--text-dim); font-size:0.82rem;"><i class="fas ${a.status === 'confirmed' ? 'fa-check-double' : 'fa-times-circle'}"></i> ${a.status}</span>`;
        }
        
        return '<tr><td><b>' + a.name + '</b></td><td style="color:var(--text-dim)">' + a.email + '</td><td><span class="category-tag">' + (a.category||'') + '</span></td><td>' + a.subject + '</td><td style="color:var(--text-dim);font-size:0.82rem;">' + (a.submitted_at||'') + '</td><td><span class="app-badge ' + cls + '">' + a.status + '</span></td><td>' + actions + '</td></tr>';
    }).join('');
    syncDashboard();
}

async function confirmApp(id) {
    const data = await api('confirm_app', 'POST', { id: id });
    if (data.success && !data.fallback) {
        await loadSystemData();
        renderAppsTable();
        showToast('Application confirmed');
    } else if (data.fallback) {
        const idx = state.applications.findIndex(a => a.id === id);
        if (idx !== -1) { state.applications[idx].status = 'confirmed'; persistLocal(); }
        renderAppsTable();
        showToast('Application confirmed');
    } else {
        showToast(data.message);
    }
}

async function rejectApp(id) {
    if (!confirm('Reject this application?')) return;
    const data = await api('reject_app', 'POST', { id: id });
    if (data.success) {
        await loadSystemData();
        renderAppsTable();
        showToast('Application rejected');
    } else {
        showToast(data.message);
    }
}

async function confirmAll() {
    if (!state.applications.some(a => a.status === 'pending')) return showToast('No pending applications.');
    if (!confirm('Confirm ALL pending requests?')) return;

    const data = await api('confirm_all', 'POST');
    if (data.success && !data.fallback) {
        await loadSystemData();
        renderAppsTable();
        showToast(data.message);
    } else if (data.fallback) {
        state.applications.forEach(a => { if (a.status === 'pending') a.status = 'confirmed'; });
        persistLocal();
        renderAppsTable();
        showToast('All pending confirmed!');
    } else {
        showToast(data.message);
    }
}

// ──────────────────────────────────────────────
// ADMIN — DASHBOARD SYNC
// ──────────────────────────────────────────────
function syncDashboard() {
    document.getElementById('statUsers').innerText     = state.users.length;
    document.getElementById('statTickets').innerText   = state.tickets.length;
    document.getElementById('statPending').innerText   = state.applications.filter(a => a.status === 'pending').length;
    document.getElementById('statConfirmed').innerText = state.applications.filter(a => a.status === 'confirmed').length;
    renderAdminTicketTable();
}

function renderAdminTicketTable() {
    const tbody = document.querySelector('#adminTicketTable tbody');
    if (!state.tickets.length) {
        tbody.innerHTML = '<tr><td colspan="7"><div class="empty-state"><i class="fas fa-inbox"></i><p>No tickets.</p></div></td></tr>';
        return;
    }
    tbody.innerHTML = state.tickets.map(t => {
        const sc = t.status === 'Open' ? 'var(--success)' : t.status === 'Resolved' ? 'var(--danger)' : 'var(--warning)';
        const pc = t.priority === 'High' ? 'var(--danger)' : t.priority === 'Medium' ? 'var(--warning)' : 'var(--success)';
        const fileIcon = t.file_path ? `<a href="/${t.file_path}" target="_blank" title="Download"><i class="fas fa-file-download" style="color:var(--accent)"></i></a>` : '';
        return '<tr><td>#' + t.id + '</td><td>' + t.subject + ' ' + fileIcon + '</td><td style="color:var(--accent)">' + (t.assigned_to||'Unassigned') + '</td><td style="color:var(--text-dim)">' + (t.applicant_email||'—') + '</td><td style="color:' + pc + '">' + (t.priority||'') + '</td><td style="color:' + sc + '">' + (t.status||'') + '</td><td><button class="btn-configure" onclick="openTicketConfig(' + t.id + ')"><i class="fas fa-edit"></i> Edit</button></td></tr>';
    }).join('');
}

// ──────────────────────────────────────────────
// ADMIN — CREATE TICKET
// ──────────────────────────────────────────────
function openCreateTicketModal() {
    const sel = document.getElementById('ticketAgent');
    const agents = state.users.filter(u => u.role === 'Team Agent');
    sel.innerHTML = agents.length
        ? agents.map(a => '<option value="' + a.name + '">' + a.name + '</option>').join('')
        : '<option value="">No Agents Available</option>';
    document.getElementById('createTicketModal').style.display = 'flex';
}
function closeCreateTicketModal() {
    document.getElementById('createTicketModal').style.display = 'none';
}

async function submitNewTicket() {
    const email   = document.getElementById('ticketCustomerEmail').value.trim();
    const subject = document.getElementById('ticketSubject').value.trim();
    const agent   = document.getElementById('ticketAgent').value;
    if (!email || !subject || !agent) return showToast('Please fill all fields');

    const data = await api('create_ticket', 'POST', {
        email: email, subject: subject,
        category: document.getElementById('ticketCategory').value,
        assignedTo: agent,
        priority: document.getElementById('ticketPriority').value
    });

    if (data.success && !data.fallback) {
        await loadSystemData();
        renderAdminTicketTable();
        closeCreateTicketModal();
        showToast('Ticket created!');
    } else if (data.fallback) {
        state.tickets.unshift({
            id: Date.now(), subject, category: document.getElementById('ticketCategory').value,
            priority: document.getElementById('ticketPriority').value, status: 'Open',
            applicant_email: email, assigned_to: agent
        });
        persistLocal();
        renderAdminTicketTable();
        closeCreateTicketModal();
        showToast('Ticket created!');
    } else {
        showToast(data.message);
    }
}

// ──────────────────────────────────────────────
// ADMIN — CONFIGURE TICKET
// ──────────────────────────────────────────────
function openTicketConfig(id) {
    const t = state.tickets.find(x => x.id == id);
    if (!t) return;
    state.editingTicketId = id;
    document.getElementById('configTicketId').innerText  = 'Editing Ticket #' + id;
    document.getElementById('configSubject').value       = t.subject || '';
    document.getElementById('configStatus').value        = t.status || 'Open';
    document.getElementById('configPriority').value      = t.priority || 'Medium';
    document.getElementById('configResponse').value      = t.agent_response || '';
    document.getElementById('ticketConfigModal').style.display = 'flex';
}
function closeTicketConfig() {
    document.getElementById('ticketConfigModal').style.display = 'none';
    state.editingTicketId = null;
}

async function saveTicketConfig() {
    const data = await api('update_ticket', 'POST', {
        id: state.editingTicketId,
        subject:  document.getElementById('configSubject').value.trim(),
        status:   document.getElementById('configStatus').value,
        priority: document.getElementById('configPriority').value,
        agent_response: document.getElementById('configResponse').value.trim()
    });

    if (data.success && !data.fallback) {
        await loadSystemData();
        if (state.currentUser && state.currentUser.role === 'Team Agent') renderAgentDashboard();
        else renderAdminTicketTable();
        closeTicketConfig();
        showToast('Ticket updated');
    } else if (data.fallback) {
        const t = state.tickets.find(x => x.id == state.editingTicketId);
        if (t) {
            t.subject  = document.getElementById('configSubject').value.trim();
            t.status   = document.getElementById('configStatus').value;
            t.priority = document.getElementById('configPriority').value;
            persistLocal();
        }
        if (state.currentUser && state.currentUser.role === 'Team Agent') renderAgentDashboard();
        else renderAdminTicketTable();
        closeTicketConfig();
        showToast('Ticket updated');
    } else {
        showToast(data.message);
    }
}

// ──────────────────────────────────────────────
// AGENT DASHBOARD
// ──────────────────────────────────────────────
async function renderAgentDashboard() {
    if (!state.currentUser) return;
    const tbody = document.getElementById('agentTicketBody');

    // Populate profile fields
    document.getElementById('agentProfileName').value = state.currentUser.name || '';
    document.getElementById('agentProfileEmail').value = state.currentUser.email || '';
    if (state.currentUser.metadata) {
        try {
            const meta = JSON.parse(state.currentUser.metadata);
            document.getElementById('agentProfilePhone').value = meta.phone || '';
        } catch(e) {}
    }

    const data = await api('agent_tickets', 'GET', { agentName: state.currentUser.name });
    let myTickets = [];

    if (data.success && !data.fallback) {
        myTickets = data.tickets || [];
    } else {
        myTickets = state.tickets.filter(t => t.assigned_to === state.currentUser.name);
    }

    if (!myTickets.length) {
        tbody.innerHTML = '<tr><td colspan="6"><div class="empty-state"><i class="fas fa-clipboard-check"></i><p>No tickets assigned to you yet.</p></div></td></tr>';
        return;
    }

    // Sort: Pending/Open first, then Resolved/Closed
    myTickets.sort((a, b) => {
        const priority = { 'Open': 0, 'In Progress': 1, 'Resolved': 2, 'Closed': 3 };
        return (priority[a.status] || 0) - (priority[b.status] || 0);
    });



    tbody.innerHTML = myTickets.map(t => {
        const isDone = t.status === 'Resolved' || t.status === 'Closed';
        const sc = t.status === 'Open' ? 'var(--success)' : isDone ? 'var(--text-dim)' : 'var(--warning)';
        const fileIcon = t.file_path ? `<a href="/${t.file_path}" target="_blank" title="View Attachment"><i class="fas fa-paperclip" style="color:var(--accent)"></i></a>` : '';
        const actionBtn = isDone 
            ? `<button class="btn-outline" style="padding:5px 10px; font-size:0.75rem;" onclick="openTicketConfig(${t.id})">Reopen</button>`
            : `<button class="btn-primary" style="padding:5px 10px; font-size:0.75rem;" onclick="openTicketConfig(${t.id})">Update</button>`;
        
        return `
            <tr style="${isDone ? 'opacity: 0.7;' : ''}">
                <td>#${t.id}</td>
                <td>${t.applicant_email||''}</td>
                <td>${t.subject} ${fileIcon}</td>
                <td style="color:${sc}; font-weight:bold;">
                    ${isDone ? '<i class="fas fa-check-circle"></i> ' : ''}${t.status||''}
                </td>
                <td>${t.priority||''}</td>
                <td>${actionBtn}</td>
            </tr>
        `;
    }).join('');
}

async function saveAgentProfile() {
    const name  = document.getElementById('agentProfileName').value;
    const email = document.getElementById('agentProfileEmail').value;
    const phone = document.getElementById('agentProfilePhone').value;

    const res = await api('update_agent_profile', 'POST', { name, email, phone });
    if (res.success) {
        showToast('Profile updated!');
        state.currentUser.name = name;
        state.currentUser.email = email;
        await loadSystemData();
    } else {
        showToast(res.message);
    }
}

// ──────────────────────────────────────────────
// USERS — CRUD
// ──────────────────────────────────────────────
async function loadUsers() {
    renderCustomerTable();
    document.getElementById('statUsers').innerText = state.users.length;
}

function renderCustomerTable(list) {
    const tbody = document.getElementById('customerTableBody');
    const users = list || state.users;
    if (!users.length) {
        tbody.innerHTML = '<tr><td colspan="7"><div class="empty-state"><i class="fas fa-users-slash"></i><p>No users found.</p></div></td></tr>';
        return;
    }
    tbody.innerHTML = users.map(u => {
        const ct  = u.clickthrough || 0;
        const pay = (u.payment || '').includes('Expiring') ? 'warning' : '';
        const payIcon = pay ? '<i class="fas fa-exclamation-triangle"></i>' : '<i class="fas fa-check-circle" style="color:var(--success)"></i>';
        return '<tr>'
            + '<td><b>' + (u.name||'') + '</b></td>'
            + '<td style="color:var(--text-dim)">' + (u.email||'—') + '</td>'
            + '<td><span class="category-tag">' + (u.department||'—') + '</span></td>'
            + '<td>' + (u.role||'Customer') + '</td>'
            + '<td><span class="payment-badge ' + pay + '">' + payIcon + ' ' + (u.payment||'—') + '</span></td>'
            + '<td><div style="display:flex;align-items:center;gap:7px;"><div class="clickthrough-container"><div class="clickthrough-bar" style="width:' + ct + '%"></div></div><span style="font-size:0.8rem">' + ct + '%</span></div></td>'
            + '<td><div class="action-btns">'
            + '<button class="btn-icon btn-warning" title="Edit" onclick="openEditUserModal(' + u.id + ')"><i class="fas fa-pencil-alt"></i></button>'
            + '<button class="btn-icon btn-danger" title="Delete" onclick="removeUser(' + u.id + ')"><i class="fas fa-trash"></i></button>'
            + '</div></td></tr>';
    }).join('');
}

function filterUsers() {
    const val = document.getElementById('filterSelect').value;
    if (val === 'all') return renderCustomerTable();
    renderCustomerTable(state.users.filter(u => u.department === val));
}

function openUserModal() {
    state.editingUserId = null;
    document.getElementById('userModalTitle').innerHTML = '<i class="fas fa-user-plus"></i> Add New User';
    document.getElementById('editUserId').value = '';
    document.getElementById('newName').value    = '';
    document.getElementById('newEmail').value   = '';
    document.getElementById('newRole').value    = 'Customer';
    document.getElementById('newDept').value    = 'Sales';
    document.getElementById('newPayment').value = 'VISA • Active';
    document.getElementById('userModal').style.display = 'flex';
}
function openEditUserModal(id) {
    const u = state.users.find(x => x.id == id);
    if (!u) return;
    state.editingUserId = id;
    document.getElementById('userModalTitle').innerHTML = '<i class="fas fa-user-edit"></i> Edit User';
    document.getElementById('editUserId').value = id;
    document.getElementById('newName').value    = u.name       || '';
    document.getElementById('newEmail').value   = u.email      || '';
    document.getElementById('newRole').value    = u.role       || 'Customer';
    document.getElementById('newDept').value    = u.department || 'Sales';
    document.getElementById('newPayment').value = u.payment    || 'VISA • Active';
    document.getElementById('userModal').style.display = 'flex';
}
function closeUserModal() {
    document.getElementById('userModal').style.display = 'none';
    state.editingUserId = null;
}

async function saveUser() {
    const name    = document.getElementById('newName').value.trim();
    const email   = document.getElementById('newEmail').value.trim();
    const role    = document.getElementById('newRole').value;
    const dept    = document.getElementById('newDept').value;
    const payment = document.getElementById('newPayment').value;
    if (!name) return showToast('Name is required');
    if (!email) return showToast('Email is required');

    const payload = {
        name: name, email: email, role: role, department: dept, payment: payment,
        clickthrough: state.editingUserId
            ? (state.users.find(u => u.id == state.editingUserId)?.clickthrough || 0)
            : Math.floor(Math.random() * 60) + 10
    };
    if (state.editingUserId) payload.id = state.editingUserId;

    const data = await api('save_user', 'POST', payload);

    if (data.success && !data.fallback) {
        await loadSystemData();
        closeUserModal();
        renderCustomerTable();
        document.getElementById('statUsers').innerText = state.users.length;
        showToast(data.message);
    } else if (data.fallback) {
        if (state.editingUserId) {
            const idx = state.users.findIndex(u => u.id == state.editingUserId);
            if (idx > -1) Object.assign(state.users[idx], payload);
        } else {
            state.users.unshift({ id: Date.now(), ...payload });
        }
        persistLocal();
        closeUserModal();
        renderCustomerTable();
        document.getElementById('statUsers').innerText = state.users.length;
        showToast(state.editingUserId ? 'User updated' : 'User added');
    } else {
        showToast(data.message);
    }
}

async function removeUser(id) {
    if (!confirm('Permanently delete this user?')) return;

    const data = await api('delete_user', 'POST', { id: id });

    if (data.success && !data.fallback) {
        await loadSystemData();
        renderCustomerTable();
        document.getElementById('statUsers').innerText = state.users.length;
        showToast('User removed');
    } else if (data.fallback) {
        state.users = state.users.filter(u => u.id != id);
        persistLocal();
        renderCustomerTable();
        document.getElementById('statUsers').innerText = state.users.length;
        showToast('User removed');
    } else {
        showToast(data.message);
    }
}

// ──────────────────────────────────────────────
// DOCS & UTILITIES
// ──────────────────────────────────────────────
function showDoc(k) {
    document.getElementById('docDisplay').innerHTML = docsData[k];
    document.querySelectorAll('.doc-sidebar button').forEach(b => b.classList.remove('active-doc'));
    const btn = document.getElementById('btn-' + k);
    if (btn) btn.classList.add('active-doc');
}

function showToast(m) {
    const x = document.getElementById('toast');
    x.innerText = m;
    x.className = 'show';
    setTimeout(() => x.className = x.className.replace('show', ''), 3000);
}

// Close modals on backdrop click
window.onclick = function(e) {
    if (e.target.classList.contains('modal')) e.target.style.display = 'none';
};

// ──────────────────────────────────────────────
// DB CONFIG
// ──────────────────────────────────────────────
function openDbConfigModal() {
    document.getElementById('dbConfigModal').style.display = 'flex';
}
function closeDbConfigModal() {
    document.getElementById('dbConfigModal').style.display = 'none';
}
async function saveDbConfig() {
    const data = await api('update_db', 'POST', {
        host: document.getElementById('dbHost').value,
        name: document.getElementById('dbName').value,
        user: document.getElementById('dbUser').value,
        pass: document.getElementById('dbPass').value
    });
    if (data.success) {
        showToast(data.message);
        closeDbConfigModal();
    } else {
        showToast(data.message);
    }
}

// Init
showDoc('overview');
updateNav();
toggleRegFields();
</script>
</div> <!-- End main-content -->
</body>
</html>