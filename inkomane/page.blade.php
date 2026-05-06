<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INKOMANE | Advanced Support System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { text-align: left; padding: 14px; border-bottom: 2px solid var(--glass-border); color: var(--accent); font-size: 0.88rem; text-transform: uppercase; letter-spacing: 1px; }
        td { padding: 14px; border-bottom: 1px solid rgba(255,255,255,0.05); font-size: 0.88rem; }
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
    </style>
</head>
<body>

<nav>
    <div class="logo">INKOMANE</div>
    <div class="nav-links" id="navLinks"></div>
</nav>

<main>

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

<!-- ═══════════════ LOGIN ═══════════════ -->
<section id="login" class="view-section">
    <div class="center-box">
        <div class="glass-panel" style="text-align:center;">
            <h2 style="margin-bottom:6px;">Welcome Back</h2>
            <p style="color:var(--text-dim); margin-bottom:26px; font-size:0.9rem;">Log in to check your ticket status or access the admin panel.</p>

            <!-- Customer login -->
            <div style="background:rgba(0,0,0,0.25); border-radius:10px; padding:22px; margin-bottom:18px; text-align:left;">
                <p style="font-size:0.82rem; color:var(--text-dim); margin-bottom:10px; font-weight:500;">
                    <i class="fas fa-user" style="color:var(--accent); margin-right:5px;"></i> CUSTOMER — Check Your Status
                </p>
                <label style="font-size:0.82rem; color:var(--text-dim);">Email used during registration</label>
                <input type="email" id="loginEmail" placeholder="e.g. alice@email.com">
                <button class="btn-outline" style="width:100%" onclick="loginCustomer()">
                    <i class="fas fa-sign-in-alt"></i> View My Status
                </button>
            </div>

            <div style="display:flex; align-items:center; gap:10px; margin-bottom:18px;">
                <div style="flex:1; height:1px; background:var(--glass-border)"></div>
                <span style="color:var(--text-dim); font-size:0.78rem; letter-spacing:1px;">OR</span>
                <div style="flex:1; height:1px; background:var(--glass-border)"></div>
            </div>

            <button class="btn-primary" style="width:100%; margin-bottom:18px;" onclick="loginAdmin()">
                <i class="fas fa-user-shield"></i> Admin Login
            </button>

            <p style="font-size:0.85rem; color:var(--text-dim);">
                First time here? <a href="#" onclick="router('register')" style="color:var(--accent); font-weight:600;">Apply for Support →</a>
            </p>
        </div>
    </div>
</section>

<!-- ═══════════════ REGISTER / APPLY ═══════════════ -->
<section id="register" class="view-section">
    <div class="center-box" style="max-width:530px;">
        <div class="glass-panel">
            <h2 style="margin-bottom:5px;"><i class="fas fa-paper-plane"></i> Apply for Support</h2>
            <p style="color:var(--text-dim); font-size:0.88rem; margin-bottom:22px;">
                Tell us who you are and describe your issue. An agent will be assigned — log back in to see your confirmation.
            </p>

            <p style="font-size:0.82rem; color:var(--text-dim); margin-bottom:3px; text-align:left;">Full Name *</p>
            <input type="text"  id="regName"    placeholder="e.g. Alice Smith">

            <p style="font-size:0.82rem; color:var(--text-dim); margin-bottom:3px; text-align:left;">Email Address * <span style="font-size:0.75rem;">(you'll use this to log back in)</span></p>
            <input type="email" id="regEmail"   placeholder="e.g. alice@email.com">

            <p style="font-size:0.82rem; color:var(--text-dim); margin-bottom:3px; text-align:left;">Department</p>
            <select id="regDept">
                <option value="Sales">Sales Department</option>
                <option value="Technical">Technical Support</option>
                <option value="Billing">Billing Accounts</option>
            </select>

            <p style="font-size:0.82rem; color:var(--text-dim); margin-bottom:6px; text-align:left;">Issue Category — rotate the cube and click a face</p>
            <div class="scene">
                <div class="cube" id="regCube">
                    <div class="cube-face front"  onclick="setRegCat('Hardware')">Hardware</div>
                    <div class="cube-face back"   onclick="setRegCat('Software')">Software</div>
                    <div class="cube-face right"  onclick="setRegCat('Network')">Network</div>
                    <div class="cube-face left"   onclick="setRegCat('Account')">Account</div>
                    <div class="cube-face top"    onclick="setRegCat('Access')">Access</div>
                    <div class="cube-face bottom" onclick="setRegCat('Other')">Other</div>
                </div>
            </div>
            <p style="text-align:center; margin-bottom:6px; font-size:0.88rem;">
                Selected: <strong id="regSelectedCat" style="color:var(--accent);">Hardware</strong>
            </p>
            <div style="display:flex; gap:8px; justify-content:center; margin-bottom:18px;">
                <button class="btn-outline" style="padding:7px 18px;" onclick="rotateRegCube(-1)">&#8592; Left</button>
                <button class="btn-outline" style="padding:7px 18px;" onclick="rotateRegCube(1)">Right &#8594;</button>
            </div>

            <p style="font-size:0.82rem; color:var(--text-dim); margin-bottom:3px; text-align:left;">Issue Subject *</p>
            <input type="text" id="regSubject" placeholder="Brief one-line description of your problem">

            <p style="font-size:0.82rem; color:var(--text-dim); margin-bottom:3px; text-align:left;">Additional Details</p>
            <textarea id="regDesc" rows="3" placeholder="Any extra context that will help the agent..."></textarea>

            <button class="btn-primary" style="width:100%; font-size:0.98rem; padding:13px;" onclick="submitApplication()">
                <i class="fas fa-paper-plane"></i>&nbsp; Submit Application
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

<!-- ═══════════════ ADMIN OVERVIEW ═══════════════ -->
<section id="admin-dashboard" class="view-section">
    <div class="dashboard-header">
        <h1>Admin Overview</h1>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <button class="btn-configure" onclick="router('applications-queue')"><i class="fas fa-inbox"></i> Applications Queue</button>
            <button class="btn-primary"   onclick="router('customer-management')">Customers <i class="fas fa-arrow-right"></i></button>
        </div>
    </div>
    <div class="stats-grid">
        <div class="stat-card"><div class="stat-num" id="statUsers">0</div><div>Registered Users</div></div>
        <div class="stat-card"><div class="stat-num" id="statTickets">0</div><div>Tickets</div></div>
        <div class="stat-card"><div class="stat-num" id="statPending">0</div><div>Pending Apps</div></div>
        <div class="stat-card"><div class="stat-num" id="statConfirmed">0</div><div>Confirmed Apps</div></div>
    </div>
    <div class="admin-layout">
        <div style="grid-column:span 2;">
            <div class="glass-panel">
                <h3><i class="fas fa-ticket-alt"></i> Ticket Table</h3>
                <table id="adminTicketTable">
                    <thead><tr><th>ID</th><th>Subject</th><th>Applicant</th><th>Priority</th><th>Status</th><th>Action</th></tr></thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <div>
            <div class="glass-panel">
                <h3>Site Progress</h3>
                <div class="chart-box">
                    <div class="bar" style="height:60%;"><div class="bar-value">60%</div><div class="bar-label">Resolved</div></div>
                    <div class="bar" style="height:25%;"><div class="bar-value">25%</div><div class="bar-label">Pending</div></div>
                    <div class="bar" style="height:15%;"><div class="bar-value">15%</div><div class="bar-label">Critical</div></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════ APPLICATIONS QUEUE (Admin) ═══════════════ -->
<section id="applications-queue" class="view-section">
    <div class="dashboard-header">
        <h1><i class="fas fa-inbox"></i> Applications Queue</h1>
        <button class="btn-outline" onclick="router('admin-dashboard')">&#8592; Back to Overview</button>
    </div>
    <div class="glass-panel">
        <table id="appsTable">
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
            <h2>Your Customers</h2>
            <div class="customer-actions">
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
            <option value="Support Agent">Support Agent</option>
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
        <button class="btn-primary" style="width:100%" onclick="saveTicketConfig()">Update Ticket</button>
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
          <iframe class="map-frame" src="https://maps.google.com/maps?q=Cape+Town+Science+Centre&t=&z=15&ie=UTF8&iwloc=&output=embed"  class="map-frame"  title="map"></iframe>
        </div>
    </div>
    <div class="footer-bottom">&copy; 2024 INKOMANE Project. All Rights Reserved.</div>
</footer>

<div id="toast">Message</div>

<script>
// ──────────────────────────────────────────────
// DOCS DATA
// ──────────────────────────────────────────────
const docsData = {
    overview:        '<h2>System Overview</h2><p>INKOMANE is an application-based support ticketing system. Users apply for support, admins confirm via a queue, and applicants see colour-coded confirmation status on their next login.</p>',
    functional:      '<h2>Functional Requirements</h2><ul><li>Application-based ticket submission with 3D category cube</li><li>Instant wait page after applying</li><li>Admin Applications Queue with one-click confirm</li><li>Customer status page: green = confirmed, red = pending</li><li>Full User & Ticket CRUD for admins</li></ul>',
    'non-functional':'<h2>Non-Functional</h2><p>Fast, Secure, and Scalable with graceful fallback when the backend API is unavailable.</p>'
};

// ──────────────────────────────────────────────
// STATE  — applications are persisted in localStorage
// ──────────────────────────────────────────────
const state = {
    currentUser:     null,
    regCubeRot:      0,
    regSelectedCat:  'Hardware',
    editingTicketId: null,
    editingUserId:   null,
    nextUserId:      10,
    nextAppId:       100,

    // Load saved applications from localStorage (persists across page refreshes)
    applications: JSON.parse(localStorage.getItem('inkomane_apps') || '[]'),

    users: [
        { id:1, name:'Alice Smith',  email:'alice@demo.com',   role:'Customer',      department:'Sales',     payment:'VISA • Active', clickthrough:40 },
        { id:2, name:'Bob Jones',    email:'bob@demo.com',     role:'Support Agent', department:'Technical', payment:'MC • Expiring',  clickthrough:10 },
        { id:3, name:'Charlie Doe',  email:'charlie@demo.com', role:'Customer',      department:'Billing',   payment:'VISA • Active', clickthrough:65 }
    ],

    tickets: [
        { id:101, subject:'Login Failure',  status:'Open',        priority:'High',   category:'Account',  applicant:'Alice Smith' },
        { id:102, subject:'Printer Jam',    status:'Resolved',    priority:'Medium', category:'Hardware', applicant:'Bob Jones'   },
        { id:103, subject:'Billing Error',  status:'In Progress', priority:'High',   category:'Billing',  applicant:'Charlie Doe' },
        { id:104, subject:'WiFi Drop',      status:'Open',        priority:'Low',    category:'Network',  applicant:'—'           }
    ]
};

function saveApps() {
    localStorage.setItem('inkomane_apps', JSON.stringify(state.applications));
}

// ──────────────────────────────────────────────
// API HELPER
// ──────────────────────────────────────────────
const API = 'http://127.0.0.1:8000/api';
async function apiFetch(path, options = {}) {
    const res = await fetch(API + path, { headers: {'Content-Type':'application/json'}, ...options });
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    return res.status === 204 ? null : res.json();
}

// ──────────────────────────────────────────────
// ROUTER
// ──────────────────────────────────────────────
function router(view) {
    document.querySelectorAll('.view-section').forEach(el => el.classList.remove('active'));
    document.getElementById(view).classList.add('active');
    updateNav();
    if (view === 'admin-dashboard')     syncDashboard();
    if (view === 'customer-management') loadUsers();
    if (view === 'applications-queue')  renderAppsTable();
    if (view === 'customer-status')     renderCustomerStatus();
}

function updateNav() {
    const nav = document.getElementById('navLinks');
    let links = `<button onclick="router('home')">Home</button>
                 <button onclick="router('docs')">Docs</button>`;
    if (state.currentUser) {
        if (state.currentUser.role === 'Admin') {
            links += `<button onclick="router('admin-dashboard')">Overview</button>
                      <button onclick="router('applications-queue')">Applications</button>
                      <button onclick="router('customer-management')">Customers</button>`;
        } else {
            links += `<button onclick="router('customer-status')">My Status</button>`;
        }
        links += `<button onclick="logout()" style="color:var(--danger)">Logout</button>`;
    } else {
        links += `<button onclick="router('login')">Login</button>
                  <button class="btn-primary" style="margin-left:12px; padding:7px 16px; font-size:0.88rem;" onclick="router('register')">Apply Now</button>`;
    }
    nav.innerHTML = links;
}

// ──────────────────────────────────────────────
// AUTH
// ──────────────────────────────────────────────
function loginAdmin() {
    state.currentUser = { name:'Admin User', role:'Admin' };
    showToast('Welcome, Admin!');
    router('admin-dashboard');
}

function loginCustomer() {
    const email = document.getElementById('loginEmail').value.trim().toLowerCase();
    if (!email) return showToast('Please enter your email address');

    const app = state.applications.find(a => a.email.toLowerCase() === email);
    if (!app) {
        showToast('No application found. Please register first.');
        return;
    }
    state.currentUser = { name: app.name, role:'Customer', email: app.email };
    showToast('Welcome back, ' + app.name + '!');
    router('customer-status');
}

function logout() {
    state.currentUser = null;
    document.getElementById('loginEmail').value = '';
    router('home');
}

// ──────────────────────────────────────────────
// REGISTER / APPLY
// ──────────────────────────────────────────────
function rotateRegCube(d) {
    state.regCubeRot += d * 90;
    document.getElementById('regCube').style.transform = `rotateY(${state.regCubeRot}deg)`;
}
function setRegCat(c) {
    state.regSelectedCat = c;
    document.getElementById('regSelectedCat').innerText = c;
}

function submitApplication() {
    const name    = document.getElementById('regName').value.trim();
    const email   = document.getElementById('regEmail').value.trim();
    const dept    = document.getElementById('regDept').value;
    const subject = document.getElementById('regSubject').value.trim();
    const desc    = document.getElementById('regDesc').value.trim();

    if (!name)    return showToast('Full name is required');
    if (!email)   return showToast('Email address is required');
    if (!subject) return showToast('Issue subject is required');

    // Block duplicate emails
    if (state.applications.find(a => a.email.toLowerCase() === email.toLowerCase())) {
        showToast('An application with this email already exists. Log in to check status.');
        return;
    }

    const app = {
        id:          state.nextAppId++,
        name, email, department: dept,
        category:    state.regSelectedCat,
        subject, description: desc,
        status:      'pending',   // 'pending' | 'confirmed'
        submittedAt: new Date().toLocaleDateString('en-GB', { day:'2-digit', month:'short', year:'numeric' })
    };

    state.applications.push(app);
    saveApps();

    // Fire-and-forget backend sync
    apiFetch('/applications', { method:'POST', body: JSON.stringify(app) }).catch(() => {});

    // Reset form
    ['regName','regEmail','regSubject','regDesc'].forEach(id => document.getElementById(id).value = '');
    state.regCubeRot = 0;
    state.regSelectedCat = 'Hardware';
    document.getElementById('regCube').style.transform = 'rotateY(0deg)';
    document.getElementById('regSelectedCat').innerText = 'Hardware';

    // Go to wait page
    document.getElementById('waitName').innerText = name;
    router('wait-page');
}

// ──────────────────────────────────────────────
// CUSTOMER STATUS PAGE
// ──────────────────────────────────────────────
function renderCustomerStatus() {
    if (!state.currentUser) return;

    const email = state.currentUser.email.toLowerCase();
    const apps  = state.applications.filter(a => a.email.toLowerCase() === email);

    const banner  = document.getElementById('customerStatusBanner');
    const cardsEl = document.getElementById('customerApplicationCards');

    if (!apps.length) {
        banner.innerHTML  = '';
        cardsEl.innerHTML = '<div class="empty-state"><i class="fas fa-inbox"></i><p>No applications found for your email.</p></div>';
        return;
    }

    const confirmed = apps.every(a => a.status === 'confirmed');

    // ── Banner: GREEN if confirmed, RED if any are still pending ──
    banner.innerHTML = confirmed
        ? `<div class="status-banner confirmed">
               <div class="s-icon"><i class="fas fa-check-circle"></i></div>
               <div class="s-body">
                   <h3>&#127881; Application Confirmed!</h3>
                   <p>Great news, <strong>${state.currentUser.name}</strong>! Your support request has been confirmed and an agent has been assigned to assist you. Please expect a follow-up soon.</p>
               </div>
           </div>`
        : `<div class="status-banner pending">
               <div class="s-icon"><i class="fas fa-clock"></i></div>
               <div class="s-body">
                   <h3>&#8987; Awaiting Confirmation</h3>
                   <p>Hi <strong>${state.currentUser.name}</strong>, your application is currently under review. An agent will be assigned shortly. Check back later — this page updates automatically when you log in.</p>
               </div>
           </div>`;

    // ── Application cards ──
    cardsEl.innerHTML = apps.map(a => `
        <div class="applied-card">
            <div class="ac-left">
                <h4><i class="fas fa-tag" style="color:var(--accent); margin-right:6px;"></i>${a.subject}</h4>
                <p>
                    <i class="fas fa-cube"     style="margin-right:3px;"></i>${a.category}&nbsp;&nbsp;
                    <i class="fas fa-building" style="margin-right:3px;"></i>${a.department}&nbsp;&nbsp;
                    <i class="fas fa-calendar" style="margin-right:3px;"></i>${a.submittedAt}
                </p>
            </div>
            <span class="applied-pill ${a.status === 'confirmed' ? 'pill-confirmed' : 'pill-pending'}">
                <i class="fas ${a.status === 'confirmed' ? 'fa-check' : 'fa-hourglass-half'}"></i>
                ${a.status === 'confirmed' ? 'Confirmed' : 'Pending'}
            </span>
        </div>`).join('');
}

// ──────────────────────────────────────────────
// ADMIN — APPLICATIONS QUEUE
// ──────────────────────────────────────────────
function renderAppsTable() {
    const tbody = document.getElementById('appsTableBody');
    if (!state.applications.length) {
        tbody.innerHTML = `<tr><td colspan="7"><div class="empty-state"><i class="fas fa-inbox"></i><p>No applications yet.</p></div></td></tr>`;
        return;
    }
    tbody.innerHTML = state.applications.map(a => `
        <tr>
            <td><b>${a.name}</b></td>
            <td style="color:var(--text-dim)">${a.email}</td>
            <td><span class="category-tag">${a.category}</span></td>
            <td>${a.subject}</td>
            <td style="color:var(--text-dim); font-size:0.82rem;">${a.submittedAt}</td>
            <td>
                <span class="app-badge ${a.status === 'confirmed' ? 'app-confirmed' : 'app-pending'}">
                    <i class="fas ${a.status === 'confirmed' ? 'fa-check' : 'fa-clock'}"></i>
                    ${a.status === 'confirmed' ? 'Confirmed' : 'Pending'}
                </span>
            </td>
            <td>
                ${a.status === 'pending'
                    ? `<button class="btn-success" style="padding:6px 14px; font-size:0.82rem;" onclick="confirmApp(${a.id})">
                           <i class="fas fa-check"></i> Confirm
                       </button>`
                    : `<span style="color:var(--text-dim); font-size:0.82rem;"><i class="fas fa-check-double"></i> Done</span>`
                }
            </td>
        </tr>`).join('');

    syncDashboard();
}

function confirmApp(id) {
    const app = state.applications.find(a => a.id === id);
    if (!app) return;
    app.status = 'confirmed';
    saveApps();
    renderAppsTable();
    showToast(`✔ ${app.name}'s application confirmed!`);
    apiFetch(`/applications/${id}`, { method:'PUT', body: JSON.stringify({ status:'confirmed' }) }).catch(() => {});
}

// ──────────────────────────────────────────────
// ADMIN — DASHBOARD
// ──────────────────────────────────────────────
function syncDashboard() {
    document.getElementById('statUsers').innerText     = state.users.length;
    document.getElementById('statTickets').innerText   = state.tickets.length;
    document.getElementById('statPending').innerText   = state.applications.filter(a => a.status === 'pending').length;
    document.getElementById('statConfirmed').innerText = state.applications.filter(a => a.status === 'confirmed').length;
    renderAdminTicketTable();
}

// ──────────────────────────────────────────────
// TICKETS — ADMIN TABLE
// ──────────────────────────────────────────────
function renderAdminTicketTable() {
    const tbody = document.querySelector('#adminTicketTable tbody');
    if (!state.tickets.length) {
        tbody.innerHTML = `<tr><td colspan="6"><div class="empty-state"><i class="fas fa-inbox"></i><p>No tickets.</p></div></td></tr>`;
        return;
    }
    tbody.innerHTML = state.tickets.map(t => {
        const sc = t.status === 'Open' ? 'var(--success)' : t.status === 'Resolved' ? 'var(--danger)' : 'var(--warning)';
        const pc = t.priority === 'High' ? 'var(--danger)' : t.priority === 'Medium' ? 'var(--warning)' : 'var(--success)';
        return `<tr>
            <td>#${t.id}</td>
            <td>${t.subject}</td>
            <td style="color:var(--text-dim)">${t.applicant || '—'}</td>
            <td style="color:${pc}">${t.priority}</td>
            <td style="color:${sc}">${t.status}</td>
            <td><button class="btn-configure" onclick="openTicketConfig(${t.id})"><i class="fas fa-edit"></i> Edit</button></td>
        </tr>`;
    }).join('');
}

function openTicketConfig(id) {
    const t = state.tickets.find(x => x.id === id);
    if (!t) return;
    state.editingTicketId = id;
    document.getElementById('configTicketId').innerText = `Editing Ticket #${id}`;
    document.getElementById('configSubject').value  = t.subject;
    document.getElementById('configStatus').value   = t.status;
    document.getElementById('configPriority').value = t.priority;
    document.getElementById('ticketConfigModal').style.display = 'flex';
}
function closeTicketConfig() {
    document.getElementById('ticketConfigModal').style.display = 'none';
    state.editingTicketId = null;
}
async function saveTicketConfig() {
    const t = state.tickets.find(x => x.id === state.editingTicketId);
    if (!t) return;
    const updated = {
        subject:  document.getElementById('configSubject').value.trim(),
        status:   document.getElementById('configStatus').value,
        priority: document.getElementById('configPriority').value
    };
    Object.assign(t, updated);
    renderAdminTicketTable();
    closeTicketConfig();
    showToast('Ticket updated');
    apiFetch(`/tickets/${state.editingTicketId}`, { method:'PUT', body: JSON.stringify(updated) }).catch(() => {});
}

// ──────────────────────────────────────────────
// USERS — CRUD
// ──────────────────────────────────────────────
async function loadUsers() {
    try { state.users = await apiFetch('/users'); } catch (e) { /* use seed */ }
    renderCustomerTable();
    document.getElementById('statUsers').innerText = state.users.length;
}

function renderCustomerTable(list) {
    const tbody = document.getElementById('customerTableBody');
    const users = list || state.users;
    if (!users.length) {
        tbody.innerHTML = `<tr><td colspan="7"><div class="empty-state"><i class="fas fa-users-slash"></i><p>No users found.</p></div></td></tr>`;
        return;
    }
    tbody.innerHTML = users.map(u => {
        const ct       = u.clickthrough || 0;
        const payClass = (u.payment || '').includes('Expiring') ? 'warning' : '';
        return `<tr>
            <td><b>${u.name}</b></td>
            <td style="color:var(--text-dim)">${u.email || '—'}</td>
            <td><span class="category-tag">${u.department || '—'}</span></td>
            <td>${u.role || 'Customer'}</td>
            <td><span class="payment-badge ${payClass}">
                ${payClass ? '<i class="fas fa-exclamation-triangle"></i>' : '<i class="fas fa-check-circle" style="color:var(--success)"></i>'}
                ${u.payment || '—'}
            </span></td>
            <td>
                <div style="display:flex;align-items:center;gap:7px;">
                    <div class="clickthrough-container"><div class="clickthrough-bar" style="width:${ct}%"></div></div>
                    <span style="font-size:0.8rem">${ct}%</span>
                </div>
            </td>
            <td>
                <div class="action-btns">
                    <button class="btn-icon btn-warning" title="Edit"   onclick="openEditUserModal(${u.id})"><i class="fas fa-pencil-alt"></i></button>
                    <button class="btn-icon btn-danger"  title="Delete" onclick="removeUser(${u.id})"><i class="fas fa-trash"></i></button>
                </div>
            </td>
        </tr>`;
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
    ['editUserId','newName','newEmail'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('newRole').value    = 'Customer';
    document.getElementById('newDept').value    = 'Sales';
    document.getElementById('newPayment').value = 'VISA • Active';
    document.getElementById('userModal').style.display = 'flex';
}
function openEditUserModal(id) {
    const u = state.users.find(x => x.id === id);
    if (!u) return;
    state.editingUserId = id;
    document.getElementById('userModalTitle').innerHTML = '<i class="fas fa-user-edit"></i> Edit User';
    document.getElementById('editUserId').value  = id;
    document.getElementById('newName').value     = u.name       || '';
    document.getElementById('newEmail').value    = u.email      || '';
    document.getElementById('newRole').value     = u.role       || 'Customer';
    document.getElementById('newDept').value     = u.department || 'Sales';
    document.getElementById('newPayment').value  = u.payment    || 'VISA • Active';
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
    if (!name)  return showToast('Name is required');
    if (!email) return showToast('Email is required');
    const isEdit  = !!state.editingUserId;
    const payload = { name, email, role, department: dept, payment,
        clickthrough: isEdit
            ? (state.users.find(u => u.id === state.editingUserId)?.clickthrough || 0)
            : Math.floor(Math.random() * 60) + 10
    };
    if (isEdit) {
        const idx = state.users.findIndex(u => u.id === state.editingUserId);
        if (idx > -1) state.users[idx] = { ...state.users[idx], ...payload };
        showToast('User updated');
        apiFetch(`/users/${state.editingUserId}`, { method:'PUT', body: JSON.stringify(payload) }).catch(() => {});
    } else {
        const nu = { id: state.nextUserId++, ...payload };
        state.users.unshift(nu);
        showToast('User added');
        apiFetch('/users', { method:'POST', body: JSON.stringify(payload) })
            .then(d => { if (d?.id) nu.id = d.id; }).catch(() => {});
    }
    closeUserModal();
    renderCustomerTable();
    document.getElementById('statUsers').innerText = state.users.length;
}
function removeUser(id) {
    if (!confirm('Remove this user?')) return;
    state.users = state.users.filter(u => u.id !== id);
    renderCustomerTable();
    document.getElementById('statUsers').innerText = state.users.length;
    showToast('User removed');
    apiFetch(`/users/${id}`, { method:'DELETE' }).catch(() => {});
}

// ──────────────────────────────────────────────
// DOCS
// ──────────────────────────────────────────────
function showDoc(k) {
    document.getElementById('docDisplay').innerHTML = docsData[k];
    document.querySelectorAll('.doc-sidebar button').forEach(b => b.classList.remove('active-doc'));
    document.getElementById('btn-' + k).classList.add('active-doc');
}

// ──────────────────────────────────────────────
// TOAST
// ──────────────────────────────────────────────
function showToast(m) {
    const x = document.getElementById('toast');
    x.innerText = m;
    x.className = 'show';
    setTimeout(() => x.className = x.className.replace('show',''), 3000);
}

window.onclick = e => { if (e.target.classList.contains('modal')) e.target.style.display = 'none'; };

// ──────────────────────────────────────────────
// INIT
// ──────────────────────────────────────────────
showDoc('overview');
updateNav();
</script>
</body>
</html>