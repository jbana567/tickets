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
        }
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
        .wait-box { text-align: center; padding: 50px 20px; }
        .wait-icon { font-size: 4.5rem; color: var(--accent); margin-bottom: 22px; animation: pulse 2s ease-in-out infinite; display: block; }
        @keyframes pulse { 0%,100%{opacity:1;} 50%{opacity:0.35;} }
        .wait-box h2 { font-size: 1.7rem; margin-bottom: 14px; }
        .wait-box p  { color: var(--text-dim); font-size: 0.95rem; line-height: 1.65; max-width: 420px; margin: 0 auto 10px; }
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
        .app-badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; text-transform: uppercase; }
        .app-confirmed { background: rgba(46,204,113,0.15); color: var(--success); border: 1px solid var(--success); }
        .app-pending   { background: rgba(231,76,60,0.15);  color: var(--danger);  border: 1px solid var(--danger);  }
        .doc-container { display: grid; grid-template-columns: 240px 1fr; gap: 28px; }
        .doc-sidebar { background: rgba(0,0,0,0.2); padding: 20px; border-radius: 12px; border: 1px solid var(--glass-border); height: fit-content; }
        .doc-sidebar button { display: block; width: 100%; text-align: left; background: none; color: var(--text-dim); padding: 12px; margin-bottom: 4px; border-radius: 6px; border: none; }
        .doc-sidebar button:hover, .doc-sidebar button.active-doc { background: rgba(255,255,255,0.1); color: var(--accent); border-left: 3px solid var(--accent); }
        .doc-content h2 { color: var(--accent); border-bottom: 1px solid var(--glass-border); padding-bottom: 10px; margin-bottom: 18px; }
        .doc-content p  { line-height: 1.6; color: #ddd; margin-bottom: 14px; }
        .doc-content ul { margin-left: 20px; line-height: 1.7; color: #ddd; }
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
        .dashboard-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; flex-wrap: wrap; gap:10px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px,1fr)); gap: 18px; margin-bottom: 28px; }
        .stat-card  { text-align: center; border: 1px solid rgba(255,255,255,0.1); padding: 20px; border-radius: 12px; background: rgba(0,0,0,0.2); }
        .stat-num   { font-size: 2.4rem; font-weight: bold; color: var(--accent); margin-bottom: 5px; }
        .admin-layout { display: grid; grid-template-columns: 2.2fr 1fr; gap: 24px; }
        @media (max-width: 900px) { .admin-layout { grid-template-columns: 1fr; } .doc-container { grid-template-columns: 1fr; } }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; table-layout: fixed; }
        th { text-align: left; padding: 12px 10px; border-bottom: 2px solid var(--glass-border); color: var(--accent); font-size: 0.82rem; text-transform: uppercase; letter-spacing: 1px; }
        td { padding: 12px 10px; border-bottom: 1px solid rgba(255,255,255,0.05); font-size: 0.88rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        td b { white-space: normal; } 
        tr:hover { background: rgba(255,255,255,0.04); }
        .col-id { width: 60px; }
        .col-status { width: 120px; }
        .col-actions { width: 100px; }
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
        footer { 
            background: rgba(10,15,30,0.9); 
            backdrop-filter: blur(25px);
            border-top: 1px solid var(--glass-border); 
            padding: 60px 5% 30px;
            width: 100%;
            position: relative;
            z-index: 900;
            clear: both;
        }
        .footer-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px,1fr)); gap: 40px; margin-bottom: 40px; }
        .footer-col h3 { color: var(--accent); margin-bottom: 18px; font-size: 1rem; }
        .footer-col p, .footer-col li { color: var(--text-dim); line-height: 1.8; font-size: 0.88rem; }
        .footer-col ul { list-style: none; }
        .footer-col a { color: var(--text-dim); text-decoration: none; transition: 0.3s; }
        .footer-col a:hover { color: var(--accent); }
        .social-icons a { font-size: 1.4rem; margin-right: 14px; color: white; transition: 0.3s; }
        .social-icons a:hover { color: var(--accent); }
        .footer-bottom { text-align: center; padding-top: 18px; border-top: 1px solid rgba(255,255,255,0.05); font-size: 0.83rem; color: #777; }
        #toast { visibility: hidden; min-width: 250px; background: #333; color: #fff; text-align: center; border-radius: 4px; padding: 16px; position: fixed; z-index: 3000; left: 50%; bottom: 30px; transform: translateX(-50%); box-shadow: 0 4px 10px rgba(0,0,0,0.3); border-left: 5px solid var(--accent); }
        #toast.show { visibility: visible; animation: fadein 0.5s, fadeout 0.5s 2.5s; }
        @keyframes fadein  { from {bottom:0; opacity:0;} to {bottom:30px; opacity:1;} }
        @keyframes fadeout { from {bottom:30px; opacity:1;} to {bottom:0; opacity:0;} }
        .empty-state { text-align: center; padding: 38px; color: var(--text-dim); }
        .empty-state i { font-size: 2.8rem; margin-bottom: 14px; opacity: 0.35; display: block; }
        .customer-login-box { background: rgba(0,0,0,0.25); border-radius: 10px; padding: 22px; margin-bottom: 18px; text-align: left; border: 1px solid var(--glass-border); }
        .top-navbar { padding: 0 5%; background: rgba(10,15,30,0.85); backdrop-filter: blur(15px); border-bottom: 1px solid var(--glass-border); position: sticky; top: 0; z-index: 1100; height: 75px; width: 100%; transition: 0.3s; display: flex; align-items: center; justify-content: space-between; }
        .btn-dashboard-highlight { background: var(--accent) !important; color: #000 !important; font-weight: 700 !important; padding: 10px 22px !important; border-radius: 4px !important; display: flex; align-items: center; gap: 8px; box-shadow: 0 0 15px var(--accent); text-transform: uppercase; font-size: 0.85rem !important; }
        .sidebar { width: 260px; height: 100vh; position: fixed; left: 0; top: 0; background: rgba(15, 20, 35, 0.95); backdrop-filter: blur(25px); border-right: 1px solid var(--glass-border); display: flex; flex-direction: column; padding: 30px 0; z-index: 1000; box-shadow: 10px 0 30px rgba(0,0,0,0.3); transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .sidebar .logo { font-size: 1.8rem; font-weight: 800; color: var(--accent); padding: 0 30px; margin-bottom: 45px; letter-spacing: 2px; }
        .sidebar .nav-links { display: flex; flex-direction: column; gap: 4px; width: 100%; }
        .sidebar .nav-links button { text-align: left; padding: 14px 30px; background: none; border: none; color: #ccc; font-size: 0.95rem; cursor: pointer; transition: 0.2s; border-left: 4px solid transparent; display: flex; align-items: center; gap: 15px; border-radius: 0; }
        .sidebar .nav-links button:hover, .sidebar .nav-links button.active-nav { background: rgba(0,210,255,0.08); color: var(--accent); border-left-color: var(--accent); }
        .main-content { flex: 1; display: flex; flex-direction: column; min-height: 100vh; transition: 0.3s; }
        body.with-sidebar .main-content { margin-left: 260px; padding: 40px 5%; }
        body.with-sidebar .top-navbar { display: none; }
        body.no-sidebar .sidebar { transform: translateX(-260px); }
        body.no-sidebar .main-content { margin-left: 0; padding: 0; }
        .notif-sidebar { margin-top: auto; padding: 25px 30px; border-top: 1px solid var(--glass-border); position: relative; }
        .notif-badge-sidebar { background: var(--danger); color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.7rem; margin-left: 5px; min-width: 18px; text-align: center; }
        .notif-dot { position: absolute; top: 25px; left: 42px; width: 8px; height: 8px; background: var(--danger); border-radius: 50%; display: none; box-shadow: 0 0 8px var(--danger); }
        .notif-item { padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.05); font-size: 0.85rem; transition: 0.2s; border-radius: 6px; margin-bottom: 5px; }
        .notif-item.unread { border-left: 3px solid var(--accent); background: rgba(0,210,255,0.03); }
        .profile-bottom-sidebar { margin-top: auto; padding: 20px 30px; border-top: 1px solid var(--glass-border); display: flex; align-items: center; gap: 12px; cursor: pointer; }
        .profile-top-right { display: flex; align-items: center; gap: 15px; background: rgba(15, 20, 35, 0.6); padding: 8px 20px; border-radius: 40px; border: 1px solid var(--glass-border); backdrop-filter: blur(10px); }
        .dashboard-header-right { position: absolute; top: 30px; right: 5%; display: flex; align-items: center; gap: 20px; z-index: 100; }
    </style>
</head>
<body class="no-sidebar">
<nav class="top-navbar" id="topNav"><div class="logo">INKOMANE</div><div class="nav-links" id="topNavLinks"></div></nav>
<div class="sidebar" id="sideNav"><div class="logo">INKOMANE</div><div class="nav-links" id="sideNavLinks"></div><div id="sidebarProfile" class="profile-bottom-sidebar" style="display:none;" onclick="logout()"><div style="width:38px; height:38px; border-radius:50%; background:linear-gradient(45deg, var(--primary), var(--accent)); display:flex; align-items:center; justify-content:center; color:white;"><i class="fas fa-user"></i></div><div><p id="sidebarUserName" style="margin:0; font-weight:600; font-size:0.9rem;"></p><p id="sidebarUserRole" style="margin:0; font-size:0.75rem; color:var(--text-dim);"></p></div></div><div class="notif-sidebar" onclick="toggleNotifications()"><div id="notifDot" class="notif-dot"></div><button style="background:none; border:none; color:var(--accent); display:flex; align-items:center; gap:10px;"><i class="fas fa-bell"></i> <span>Notifications</span><span id="notifBadge" class="notif-badge-sidebar" style="display: none;">0</span></button><div id="notifDropdown" class="glass-panel" style="position: absolute; bottom: 80px; left: 20px; width: 280px; max-height: 400px; overflow-y: auto; display: none; z-index: 2001; padding: 15px;"><h4 style="margin-bottom: 10px; border-bottom: 1px solid var(--glass-border); padding-bottom: 5px;">Notifications</h4><div id="notifList"></div><button class="btn-configure" style="width: 100%; margin-top: 10px;" onclick="clearNotifications()">Clear All</button></div></div></div>
<div class="main-content"><div id="headerProfile" class="dashboard-header-right" style="display:none;"><div class="profile-top-right"><div><p id="headerUserName" style="margin:0; font-weight:600; font-size:0.85rem; color:white;"></p><p id="headerUserRole" style="margin:0; font-size:0.7rem; color:var(--accent); font-weight:bold;"></p></div><div style="width:35px; height:35px; border-radius:50%; background:var(--glass-border); display:flex; align-items:center; justify-content:center; border:1px solid var(--accent);"><i class="fas fa-user-shield" id="headerUserIcon"></i></div><button onclick="logout()" style="background:none; color:var(--danger);"><i class="fas fa-power-off"></i></button></div></div>
<section id="home" class="view-section active"><div style="text-align:center; margin-top:60px;"><h1 style="font-size:3.2rem; background:linear-gradient(to right,#fff,var(--accent)); background-clip:text; -webkit-text-fill-color:transparent;">Next-Gen Support Ticketing</h1><p style="color:var(--text-dim); font-size:1.15rem; max-width:760px; margin:20px auto 36px;">Experience streamlined support. Apply for a ticket, wait for agent assignment, then log back in to see your real-time confirmation status.</p><button class="btn-primary" onclick="router('login')">Get Started</button></div></section>
<section id="login" class="view-section"><div class="center-box"><div class="glass-panel" style="text-align:center;"><h2>Welcome Back</h2><div class="customer-login-box" style="padding: 30px;"><label>Email Address</label><input type="email" id="uniEmail" placeholder="e.g. alice@example.com"><label>Password</label><input type="password" id="uniPass" placeholder="••••••••"><button class="btn-primary" style="width:100%" onclick="unifiedLogin()">Login & Access</button></div><p style="font-size:0.85rem; color:var(--text-dim);">Forgot password? <a href="#" onclick="router('forgot-password')" style="color:var(--secondary);">Reset it here</a></p></div></div></section>
<section id="forgot-password" class="view-section"><div class="center-box"><div class="glass-panel" style="text-align:center;"><h2>Forgot Password</h2><div class="customer-login-box"><label>Email Address</label><input type="email" id="forgotEmail" placeholder="e.g. alice@example.com"><button class="btn-primary" style="width:100%" onclick="requestReset()">Send Reset Link</button></div></div></div></section>
<section id="reset-password" class="view-section"><div class="center-box"><div class="glass-panel" style="text-align:center;"><h2>Reset Password</h2><div class="customer-login-box"><label>Token</label><input type="text" id="resetToken" placeholder="Paste your token here"><label>New Password</label><input type="password" id="resetPass" placeholder="••••••••"><button class="btn-primary" style="width:100%" onclick="resetPassword()">Update Password</button></div></div></div></section>
<section id="admin-dashboard" class="view-section"><div class="dashboard-header"><h1>Dashboard</h1></div><div class="stats-grid"><div class="stat-card" style="background:#1e5128;"><p>Total Projects</p><div class="stat-num" id="statTickets">24</div></div><div class="stat-card"><p>Ended Projects</p><div class="stat-num" id="statConfirmed">10</div></div><div class="stat-card"><p>Running Projects</p><div class="stat-num" id="statPending">12</div></div><div class="stat-card"><p>Users</p><div class="stat-num" id="statUsers">2</div></div></div><div style="display:grid; grid-template-columns: 2fr 1fr; gap:25px;"><div class="glass-panel"><h3>Project Analytics</h3><div class="chart-box" id="categoryChart"></div></div><div class="glass-panel"><h3>Project Progress</h3><div style="text-align:center;"><svg width="150" height="150" viewBox="0 0 100 100"><circle cx="50" cy="50" r="45" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="10"/><circle cx="50" cy="50" r="45" fill="none" stroke="#1e5128" stroke-width="10" stroke-dasharray="282.7" stroke-dashoffset="166.8" stroke-linecap="round"/><text x="50" y="50" text-anchor="middle" dominant-baseline="middle" fill="white" font-size="20">41%</text></svg></div></div></div><div class="glass-panel" style="margin-top:25px;"><h3>System Activity Log</h3><div id="assignmentLog"></div></div></section>
<script>
// State and API helpers
const state = { currentUser: null, tickets: [], users: [], applications: [] };
async function api(a, m='POST', d={}) {
    try {
        let url = '/api?api=' + a;
        let o = { method: m, headers: { 'Accept': 'application/json' } };
        if (d instanceof FormData) o.body = d;
        else { o.headers['Content-Type'] = 'application/json'; if (m==='GET'&&Object.keys(d).length) url+='&'+new URLSearchParams(d).toString(); else if (m!=='GET') o.body = JSON.stringify(d); }
        const r = await fetch(url, o); return await r.json();
    } catch (e) { return { success: false, message: e.message }; }
}
async function loadSystemData() {
    const d = await api('get_data', 'GET');
    if (d.success) { state.users=d.users||[]; state.tickets=d.tickets||[]; state.applications=d.applications||[]; state.currentUser=d.auth||null; router(state.currentView||'home'); }
}
function router(v) {
    state.currentView = v;
    document.querySelectorAll('.view-section').forEach(e => e.classList.remove('active'));
    const t = document.getElementById(v); if (t) t.classList.add('active');
    if (['admin-dashboard'].includes(v)) { document.body.classList.add('with-sidebar'); document.body.classList.remove('no-sidebar'); syncDashboard(); }
    else { document.body.classList.add('no-sidebar'); document.body.classList.remove('with-sidebar'); }
}
async function unifiedLogin() {
    const e = document.getElementById('uniEmail').value; const p = document.getElementById('uniPass').value;
    const d = await api('login', 'POST', { email: e, password: p });
    if (d.success) { state.currentUser = d.user; await loadSystemData(); router(d.user.role === 'Admin' ? 'admin-dashboard' : 'home'); }
}
async function requestReset() {
    const e = document.getElementById('forgotEmail').value;
    const r = await api('forgot_password', 'POST', { email: e });
    if (r.success) { alert("Token: " + r.token); router('reset-password'); }
}
async function resetPassword() {
    const t = document.getElementById('resetToken').value; const p = document.getElementById('resetPass').value;
    const r = await api('reset_password', 'POST', { email: document.getElementById('forgotEmail').value, token: t, password: p });
    if (r.success) { alert("Success!"); router('login'); }
}
function syncDashboard() {
    document.getElementById('statUsers').innerText = state.users.length;
    document.getElementById('statTickets').innerText = state.tickets.length;
    renderAssignmentLog();
}
function renderAssignmentLog() {
    const l = document.getElementById('assignmentLog');
    l.innerHTML = state.tickets.slice(0, 5).map(t => `<div style="padding:10px; border-bottom:1px solid rgba(255,255,255,0.05);">Assigned ${t.id} to ${t.assigned_to}</div>`).join('');
}
loadSystemData();
</script>
</div>
<footer><div class="footer-bottom">&copy; 2026 INKOMANE</div></footer>
</body>
</html>