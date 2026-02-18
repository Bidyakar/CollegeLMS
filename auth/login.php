<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $redirect = ($_SESSION['role'] === 'admin') ? 'admin/dashboard.php' : 'student/dashboard.php';
    header("Location: $redirect"); exit;
}
$hour = date('G');
$greeting = $hour >= 5 && $hour < 12 ? "Good Morning" : ($hour >= 12 && $hour < 17 ? "Good Afternoon" : ($hour >= 17 && $hour < 22 ? "Good Evening" : "Welcome"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login – KCMIT Library</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DM Sans', sans-serif; background: #F3F4F6; min-height: 100vh; overflow-x: hidden; }
    h1, h2 { font-family: 'Playfair Display', serif; }

    .bg-canvas {
      position: fixed; inset: 0; z-index: 0;
      background: linear-gradient(145deg, #f0f0f0, #e8e8e8 50%, #f5f5f5);
    }
    .bg-canvas::before {
      content: ''; position: absolute; inset: 0;
      background:
        radial-gradient(circle at 20% 20%, rgba(220,38,38,.07) 0%, transparent 55%),
        radial-gradient(circle at 80% 80%, rgba(37,99,235,.07) 0%, transparent 55%);
    }

    /* floating books */
    .fb { position: fixed; pointer-events: none; z-index: 1; }
    .book {
      width: var(--w,44px); height: var(--h,60px);
      background: var(--c,#DC2626);
      border-radius: 2px 5px 5px 2px;
      position: relative;
      box-shadow: -3px 4px 12px rgba(0,0,0,.2), inset -5px 0 10px rgba(0,0,0,.15);
      transform: rotate(var(--r,0deg));
    }
    .book::before { content:''; position:absolute; left:0; top:0; bottom:0; width:8px; background:rgba(0,0,0,.22); border-radius:2px 0 0 2px; }
    .book::after  { content:''; position:absolute; left:12px; right:6px; top:30%; height:1.5px; background:rgba(255,255,255,.2); box-shadow:0 8px 0 rgba(255,255,255,.12); }

    @keyframes b1{0%,100%{transform:translateY(0) rotate(var(--r,0deg))} 50%{transform:translateY(-13px) rotate(var(--r,0deg))}}
    @keyframes b2{0%,100%{transform:translateY(0) rotate(var(--r,0deg))} 50%{transform:translateY(-8px)  rotate(var(--r,0deg))}}
    @keyframes b3{0%,100%{transform:translateY(0) rotate(var(--r,0deg))} 50%{transform:translateY(-17px) rotate(var(--r,0deg))}}
    .a1{animation:b1 5s ease-in-out infinite}
    .a2{animation:b2 7s ease-in-out 1s infinite}
    .a3{animation:b3 6s ease-in-out 2s infinite}
    .a4{animation:b1 8s ease-in-out 3s infinite}
    .a5{animation:b2 5.5s ease-in-out .5s infinite}

    /* layout */
    .page {
      position: relative; z-index: 10;
      min-height: 100vh;
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      padding: clamp(2rem,5vw,3.5rem) clamp(1rem,4vw,2rem);
      gap: clamp(1.75rem,3.5vw,2.5rem);
    }

    /* header */
    .hdr { text-align:center; animation: up .6s ease both; }
    .logo {
      width: clamp(64px,10vw,88px); height: clamp(64px,10vw,88px);
      background: #111827; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 1.25rem;
      box-shadow: 0 8px 28px rgba(0,0,0,.22);
      border: 3px solid #fff;
    }
    .logo i { color:#fff; font-size:clamp(1.4rem,3vw,2rem); }
    .logo small { display:block; color:#9CA3AF; font-size:9px; font-weight:700; letter-spacing:.05em; margin-top:2px; }
    .hdr h1 { font-size:clamp(2rem,5vw,3.25rem); color:#111827; line-height:1.1; }
    .hdr p  { color:#6B7280; font-size:clamp(.875rem,2vw,1.05rem); margin-top:.5rem; }

    /* cards */
    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(min(100%,300px),1fr));
      gap: clamp(1rem,2.5vw,1.5rem);
      width:100%; max-width:720px;
    }
    .card {
      background:#fff; border-radius:20px; border:2px solid #E5E7EB;
      padding: clamp(1.5rem,3.5vw,2.25rem);
      text-decoration:none;
      display:flex; flex-direction:column; gap:1.1rem;
      transition: transform .25s, box-shadow .25s, border-color .25s;
      animation: up .6s ease both; position:relative; overflow:hidden;
    }
    .card::before {
      content:''; position:absolute; top:0; left:0; right:0; height:4px;
      background:var(--ac,#DC2626);
      transform:scaleX(0); transform-origin:left; transition:transform .3s ease;
    }
    .card:hover { transform:translateY(-6px); box-shadow:0 20px 48px rgba(0,0,0,.11); border-color:transparent; }
    .card:hover::before { transform:scaleX(1); }

    .card-icon {
      width:clamp(50px,7vw,64px); height:clamp(50px,7vw,64px);
      border-radius:14px; display:flex; align-items:center; justify-content:center;
      font-size:clamp(1.3rem,2.5vw,1.6rem);
      transition: background .25s, color .25s;
    }
    .blue .card-icon { background:#EFF6FF; color:#2563EB; --ac:#2563EB; }
    .red  .card-icon { background:#FEF2F2; color:#DC2626; --ac:#DC2626; }
    .blue:hover .card-icon { background:#2563EB; color:#fff; }
    .red:hover  .card-icon { background:#DC2626; color:#fff; }

    .card h2 { font-size:clamp(1.1rem,2.2vw,1.35rem); color:#111827; }
    .card p  { font-size:.85rem; color:#6B7280; line-height:1.6; }

    .feats { display:grid; grid-template-columns:1fr 1fr; gap:.45rem; }
    .feat {
      display:flex; align-items:center; gap:.45rem;
      font-size:.78rem; color:#374151;
      padding:.45rem .7rem; border-radius:8px;
    }
    .feat i { font-size:.72rem; flex-shrink:0; }
    .blue .feat { background:#EFF6FF; } .blue .feat i { color:#2563EB; }
    .red  .feat { background:#FEF2F2; } .red  .feat i { color:#DC2626;  }

    .cta {
      display:flex; align-items:center; justify-content:space-between;
      padding-top:.875rem; border-top:1px solid #F3F4F6;
      font-size:.85rem; font-weight:600;
    }
    .blue .cta-lbl { color:#2563EB; } .red .cta-lbl { color:#DC2626; }
    .cta-lbl { display:flex; align-items:center; gap:.35rem; }
    .cta-lbl i { transition:transform .2s; }
    .card:hover .cta-lbl i { transform:translateX(4px); }
    .cta-badge { font-size:.7rem; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:#9CA3AF; display:flex; align-items:center; gap:.3rem; }

    /* stats */
    .stats {
      display:flex; flex-wrap:wrap; gap:clamp(.75rem,2vw,1rem);
      justify-content:center; width:100%; max-width:720px;
      animation: up .6s .15s ease both;
    }
    .stat {
      background:#fff; border:1px solid #E5E7EB; border-radius:14px;
      padding:.8rem 1.1rem;
      display:flex; align-items:center; gap:.8rem;
      flex:1 1 160px; min-width:140px;
    }
    .sico { width:38px; height:38px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .sico.bl{background:#EFF6FF;color:#2563EB} .sico.rd{background:#FEF2F2;color:#DC2626} .sico.dk{background:#111827;color:#fff}
    .snum { font-family:'Playfair Display',serif; font-size:1.2rem; color:#111827; line-height:1; }
    .slbl { font-size:.72rem; color:#6B7280; margin-top:2px; }

    /* footer */
    .foot { text-align:center; animation:up .6s .25s ease both; }
    .foot a { display:inline-flex; align-items:center; gap:.4rem; color:#6B7280; font-size:.875rem; text-decoration:none; font-weight:600; transition:color .2s; }
    .foot a:hover { color:#111827; }
    .foot-links { display:flex; flex-wrap:wrap; justify-content:center; gap:.4rem 1.25rem; margin-top:.75rem; }
    .foot-links a { font-weight:400; font-size:.78rem; }

    @keyframes up { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:translateY(0)} }

    @media(max-width:420px) {
      .feats { grid-template-columns:1fr; }
      .stat  { flex:1 1 130px; }
    }
  </style>
</head>
<body>
<div class="bg-white"></div>

<!-- Scattered floating books -->
<div class="fb a1" style="top:4%;left:3%;opacity:.17"><div class="book" style="--w:44px;--h:60px;--c:#DC2626;--r:-14deg"></div></div>
<div class="fb a3" style="top:13%;left:9%;opacity:.12"><div class="book" style="--w:34px;--h:48px;--c:#1F2937;--r:20deg"></div></div>
<div class="fb a2" style="top:5%;left:20%;opacity:.13"><div class="book" style="--w:50px;--h:66px;--c:#2563EB;--r:-6deg"></div></div>
<div class="fb a2" style="top:3%;right:4%;opacity:.16"><div class="book" style="--w:46px;--h:62px;--c:#1F2937;--r:16deg"></div></div>
<div class="fb a4" style="top:12%;right:12%;opacity:.12"><div class="book" style="--w:38px;--h:54px;--c:#DC2626;--r:-22deg"></div></div>
<div class="fb a1" style="top:7%;right:23%;opacity:.11"><div class="book" style="--w:32px;--h:46px;--c:#065F46;--r:10deg"></div></div>
<div class="fb a5" style="top:36%;left:1%;opacity:.13"><div class="book" style="--w:40px;--h:56px;--c:#7C3AED;--r:-18deg"></div></div>
<div class="fb a3" style="top:52%;left:4%;opacity:.09"><div class="book" style="--w:28px;--h:40px;--c:#DC2626;--r:30deg"></div></div>
<div class="fb a2" style="top:38%;right:2%;opacity:.13"><div class="book" style="--w:44px;--h:60px;--c:#B45309;--r:24deg"></div></div>
<div class="fb a5" style="top:56%;right:6%;opacity:.09"><div class="book" style="--w:30px;--h:42px;--c:#1F2937;--r:-30deg"></div></div>
<div class="fb a3" style="bottom:3%;left:2%;opacity:.17"><div class="book" style="--w:48px;--h:66px;--c:#2563EB;--r:18deg"></div></div>
<div class="fb a1" style="bottom:12%;left:11%;opacity:.12"><div class="book" style="--w:36px;--h:50px;--c:#DC2626;--r:-12deg"></div></div>
<div class="fb a4" style="bottom:5%;left:21%;opacity:.10"><div class="book" style="--w:42px;--h:58px;--c:#1F2937;--r:25deg"></div></div>
<div class="fb a2" style="bottom:4%;right:3%;opacity:.16"><div class="book" style="--w:46px;--h:64px;--c:#DC2626;--r:-20deg"></div></div>
<div class="fb a5" style="bottom:13%;right:12%;opacity:.12"><div class="book" style="--w:34px;--h:48px;--c:#065F46;--r:14deg"></div></div>
<div class="fb a3" style="bottom:7%;right:23%;opacity:.10"><div class="book" style="--w:40px;--h:56px;--c:#1F2937;--r:-8deg"></div></div>
<div class="fb a4" style="top:23%;left:29%;opacity:.07"><div class="book" style="--w:26px;--h:38px;--c:#DC2626;--r:42deg"></div></div>
<div class="fb a1" style="top:29%;right:29%;opacity:.07"><div class="book" style="--w:26px;--h:38px;--c:#2563EB;--r:-38deg"></div></div>

<div class="page">
  <div class="hdr">
    <div class="logo">
      <div style="text-align:center">
        <i class="fas fa-book-open"></i>
        <small>KCMIT</small>
      </div>
    </div>
    <h1><?php echo $greeting; ?>!</h1>
    <p>Select your portal to access the KCMIT Library System</p>
  </div>

  <div class="cards">
    <a href="student-login.php" class="card blue" style="animation-delay:.1s">
      <div class="card-icon"><i class="fas fa-user-graduate"></i></div>
      <div>
        <h2>Student Portal</h2>
        <p style="margin-top:.3rem">Access borrowed books, library history, and digital resources.</p>
      </div>
      <div class="feats">
        <div class="feat"><i class="fas fa-book"></i>Browse Books</div>
        <div class="feat"><i class="fas fa-history"></i>View History</div>
        <div class="feat"><i class="fas fa-file-pdf"></i>E-Resources</div>
        <div class="feat"><i class="fas fa-bell"></i>Notifications</div>
      </div>
      <div class="cta">
        <span class="cta-lbl">Student Login <i class="fas fa-arrow-right"></i></span>
        <span class="cta-badge" style="color:#2563EB">Sign Up</span>
      </div>
    </a>

    <a href="staff-login.php" class="card red" style="animation-delay:.18s">
      <div class="card-icon"><i class="fas fa-user-shield"></i></div>
      <div>
        <h2>Staff Portal</h2>
        <p style="margin-top:.3rem">Administrative access for librarians and faculty members.</p>
      </div>
      <div class="feats">
        <div class="feat"><i class="fas fa-boxes"></i>Manage Books</div>
        <div class="feat"><i class="fas fa-exchange-alt"></i>Transactions</div>
        <div class="feat"><i class="fas fa-chart-bar"></i>Reports</div>
        <div class="feat"><i class="fas fa-users-cog"></i>User Mgmt</div>
      </div>
      <div class="cta">
        <span class="cta-lbl">Staff Login <i class="fas fa-arrow-right"></i></span>
        <span class="cta-badge"><i class="fas fa-lock"></i> Secure</span>
      </div>
    </a>
  </div>

  <div class="stats">
    <div class="stat"><div class="sico bl"><i class="fas fa-book"></i></div><div><div class="snum">50,000+</div><div class="slbl">Books Available</div></div></div>
    <div class="stat"><div class="sico rd"><i class="fas fa-users"></i></div><div><div class="snum">15,000+</div><div class="slbl">Active Members</div></div></div>
    <div class="stat"><div class="sico dk"><i class="fas fa-clock"></i></div><div><div class="snum">24/7</div><div class="slbl">Digital Access</div></div></div>
  </div>

  <div class="foot">
    <a href="index.php"><i class="fas fa-home"></i> Back to Homepage</a>
    <div class="foot-links">
      <a href="#"><i class="fas fa-question-circle"></i> Need Help?</a>
      <a href="#"><i class="fas fa-headset"></i> Support</a>
      <a href="#"><i class="fas fa-clock"></i> Library Hours</a>
    </div>
  </div>
</div>
</body>
</html>