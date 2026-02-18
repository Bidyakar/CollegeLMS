<?php
session_start();

// Redirect if already logged in as staff/admin
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    header("Location: ../admin/dashboard.php"); exit;
}

require_once '../config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Please enter both username and password.';
    } else {
        // Query the users table
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user) {
            // Support both plain-text and hashed passwords
            $passwordValid = password_verify($password, $user['password'])
                          || $user['password'] === $password; // fallback for plain-text

            if ($passwordValid) {
                session_regenerate_id(true);
                $_SESSION['user_id']  = $user['user_id'];
                $_SESSION['role']     = 'admin';
                $_SESSION['name']     = $user['firstname'] . ' ' . $user['lastname'];
                $_SESSION['username'] = $user['username'];
                header('Location: ../admin/dashboard.php'); exit;
            } else {
                $error = 'Invalid username or password.';
            }
        } else {
            $error = 'Invalid username or password.';
        }
    }
}

$hour = date('G');
$greeting = $hour >= 5 && $hour < 12 ? "Good Morning"
          : ($hour >= 12 && $hour < 17 ? "Good Afternoon"
          : ($hour >= 17 && $hour < 22 ? "Good Evening" : "Welcome"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff Login – KCMIT Library</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DM Sans', sans-serif; min-height: 100vh; overflow-x: hidden; }
    h1, h2 { font-family: 'Playfair Display', serif; }

    /* Staff panel on RIGHT, form on LEFT */
    .layout { display: grid; grid-template-columns: 1fr 1fr; min-height: 100vh; }
    @media(max-width:768px) { .layout { grid-template-columns: 1fr; } .panel-right-deco { display: none; } }

    /* ── Right decorative panel (red) ── */
    .panel-right-deco {
      background: linear-gradient(155deg, #7f1d1d 0%, #B91C1C 55%, #DC2626 100%);
      position: relative; overflow: hidden; order: 2;
      display: flex; flex-direction: column; align-items: center; justify-content: center;
      padding: 3rem 2.5rem;
    }
    .panel-right-deco::before {
      content: ''; position: absolute; inset: 0;
      background:
        radial-gradient(circle at 70% 30%, rgba(255,255,255,.07) 0%, transparent 50%),
        radial-gradient(circle at 30% 80%, rgba(255,255,255,.05) 0%, transparent 40%);
    }
    .panel-right-deco::after {
      content: ''; position: absolute; top: -60px; left: -60px;
      width: 220px; height: 220px;
      border: 2px solid rgba(255,255,255,.1); border-radius: 50%;
    }

    /* floating books */
    .fb { position: absolute; pointer-events: none; }
    .pbook {
      width: var(--w,40px); height: var(--h,56px);
      background: var(--c,rgba(255,255,255,.15));
      border-radius: 2px 5px 5px 2px; position: relative;
      box-shadow: -2px 3px 10px rgba(0,0,0,.2), inset -4px 0 8px rgba(0,0,0,.1);
      transform: rotate(var(--r,0deg));
    }
    .pbook::before { content:''; position:absolute; left:0; top:0; bottom:0; width:7px; background:rgba(0,0,0,.18); border-radius:2px 0 0 2px; }
    .pbook::after  { content:''; position:absolute; left:10px; right:5px; top:30%; height:1.5px; background:rgba(255,255,255,.2); box-shadow:0 7px 0 rgba(255,255,255,.12); }

    @keyframes b1{0%,100%{transform:translateY(0) rotate(var(--r,0deg))} 50%{transform:translateY(-12px) rotate(var(--r,0deg))}}
    @keyframes b2{0%,100%{transform:translateY(0) rotate(var(--r,0deg))} 50%{transform:translateY(-8px)  rotate(var(--r,0deg))}}
    @keyframes b3{0%,100%{transform:translateY(0) rotate(var(--r,0deg))} 50%{transform:translateY(-16px) rotate(var(--r,0deg))}}
    .a1{animation:b1 5s ease-in-out infinite} .a2{animation:b2 7s ease-in-out 1s infinite}
    .a3{animation:b3 6s ease-in-out 2s infinite} .a4{animation:b1 8s ease-in-out 3s infinite}
    .a5{animation:b2 5.5s ease-in-out .5s infinite}

    .panel-info { position: relative; z-index: 2; text-align: center; color: #fff; }
    .panel-logo {
      width: 80px; height: 80px; background: rgba(255,255,255,.15);
      border-radius: 50%; display: flex; align-items: center; justify-content: center;
      margin: 0 auto 1.5rem; border: 2px solid rgba(255,255,255,.3); backdrop-filter: blur(8px);
    }
    .panel-logo i { font-size: 1.8rem; color: #fff; }
    .panel-info h2 { font-size: clamp(1.6rem,3vw,2.2rem); margin-bottom: .75rem; }
    .panel-info p  { font-size: .9rem; color: rgba(255,255,255,.75); line-height: 1.7; max-width: 280px; margin: 0 auto; }

    .panel-features { margin-top: 2rem; display: flex; flex-direction: column; gap: .6rem; position: relative; z-index: 2; width: 100%; max-width: 280px; }
    .pf {
      background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.18);
      border-radius: 10px; padding: .6rem 1rem;
      display: flex; align-items: center; gap: .7rem;
      color: #fff; font-size: .82rem; backdrop-filter: blur(6px);
    }
    .pf i { color: rgba(255,255,255,.8); width: 14px; text-align: center; }

    /* ── Left form panel ── */
    .panel-left-form {
      background: #F9FAFB; order: 1;
      display: flex; align-items: center; justify-content: center;
      padding: clamp(2rem,5vw,3rem) clamp(1.25rem,4vw,2rem);
    }
    .form-box { width: 100%; max-width: 420px; animation: up .5s ease both; }

    .mobile-hdr { display: none; text-align: center; margin-bottom: 2rem; }
    .mobile-logo {
      width: 64px; height: 64px; background: #DC2626;
      border-radius: 50%; display: flex; align-items: center; justify-content: center;
      margin: 0 auto 1rem; box-shadow: 0 6px 20px rgba(220,38,38,.35);
    }
    .mobile-logo i { color: #fff; font-size: 1.5rem; }
    @media(max-width:768px) { .mobile-hdr { display: block; } }

    /* form card */
    .card {
      background: #fff; border-radius: 20px;
      box-shadow: 0 4px 24px rgba(0,0,0,.07); border: 1px solid #E5E7EB;
      padding: clamp(1.5rem,4vw,2.25rem);
    }
    .secure-badge {
      display: inline-flex; align-items: center; gap: .4rem;
      background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA;
      border-radius: 20px; padding: .3rem .75rem;
      font-size: .72rem; font-weight: 700; letter-spacing: .04em; text-transform: uppercase;
      margin-bottom: 1.25rem;
    }
    .card-title { font-family:'Playfair Display',serif; font-size:clamp(1.2rem,2.5vw,1.5rem); color:#111827; margin-bottom:.3rem; }
    .card-sub   { font-size:.82rem; color:#6B7280; margin-bottom:1.5rem; }

    .err {
      background:#FEF2F2; border-left:3px solid #DC2626; border-radius:8px;
      padding:.7rem 1rem; display:flex; align-items:center; gap:.6rem;
      font-size:.82rem; color:#B91C1C; margin-bottom:1.25rem;
    }

    .field { margin-bottom:1.1rem; }
    .field label { display:block; font-size:.8rem; font-weight:600; color:#374151; margin-bottom:.4rem; }
    .field label i { margin-right:.4rem; color:#DC2626; }
    .field input {
      width:100%; padding:.75rem 1rem;
      border:1.5px solid #E5E7EB; border-radius:10px;
      font-family:inherit; font-size:.9rem; color:#111827; background:#F9FAFB;
      transition: border-color .2s, background .2s, box-shadow .2s; outline: none;
    }
    .field input:focus { border-color:#DC2626; background:#fff; box-shadow:0 0 0 3px rgba(220,38,38,.1); }

    .row { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem; font-size:.8rem; }
    .row label { display:flex; align-items:center; gap:.4rem; color:#374151; cursor:pointer; }
    .row input[type=checkbox] { accent-color:#DC2626; }
    .row a { color:#DC2626; font-weight:600; text-decoration:none; }
    .row a:hover { text-decoration:underline; }

    .btn {
      width:100%; padding:.85rem; border:none; border-radius:10px;
      background:#DC2626; color:#fff; font-family:inherit;
      font-size:.95rem; font-weight:600; cursor:pointer;
      display:flex; align-items:center; justify-content:center; gap:.5rem;
      transition: background .2s, transform .15s, box-shadow .2s;
      box-shadow: 0 4px 14px rgba(220,38,38,.35);
    }
    .btn:hover { background:#B91C1C; transform:translateY(-1px); box-shadow:0 6px 20px rgba(220,38,38,.4); }
    .btn:active { transform:translateY(0); }

    .notice {
      margin-top:.85rem; padding:.7rem 1rem;
      background:#FFFBEB; border:1px solid #FDE68A; border-radius:10px;
      display:flex; align-items:flex-start; gap:.6rem;
      font-size:.75rem; color:#92400E; line-height:1.5;
    }
    .notice i { color:#D97706; margin-top:1px; flex-shrink:0; }

    .back { display:flex; align-items:center; justify-content:center; gap:.4rem; margin-top:1.25rem; font-size:.8rem; color:#9CA3AF; text-decoration:none; transition:color .2s; }
    .back:hover { color:#374151; }

    .tiles { display:grid; grid-template-columns:repeat(3,1fr); gap:.6rem; margin-top:1.25rem; }
    .tile { background:#fff; border:1px solid #E5E7EB; border-radius:12px; padding:.7rem .5rem; text-align:center; }
    .tile i { color:#DC2626; font-size:1.1rem; display:block; margin-bottom:.3rem; }
    .tile span { font-size:.7rem; color:#6B7280; font-weight:600; }

    @keyframes up { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)} }
  </style>
</head>
<body>
<div class="layout">

  <!-- Left: Form -->
  <div class="panel-left-form">
    <div class="form-box">

      <div class="mobile-hdr">
        <div class="mobile-logo"><i class="fas fa-user-shield"></i></div>
        <h1 style="font-size:1.6rem;color:#111827"><?php echo $greeting; ?>!</h1>
        <p style="font-size:.85rem;color:#6B7280;margin-top:.3rem">KCMIT Library — Staff Portal</p>
      </div>

      <div class="card">
        <div><span class="secure-badge"><i class="fas fa-shield-alt"></i> Authorized Access Only</span></div>
        <div class="card-title">Staff Login</div>
        <div class="card-sub">Enter your staff credentials to proceed</div>

        <?php if ($error): ?>
          <div class="err"><i class="fas fa-exclamation-circle"></i><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" autocomplete="on">
          <div class="field">
            <label for="username"><i class="fas fa-user"></i>Username</label>
            <input type="text" id="username" name="username"
                   placeholder="Enter your username"
                   value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                   required autocomplete="username">
          </div>
          <div class="field">
            <label for="password"><i class="fas fa-lock"></i>Password</label>
            <input type="password" id="password" name="password"
                   placeholder="Enter your password"
                   required autocomplete="current-password">
          </div>
          <div class="row">
            <label><input type="checkbox" name="remember"> Remember me</label>
            <a href="#">Forgot password?</a>
          </div>
          <button type="submit" class="btn"><i class="fas fa-sign-in-alt"></i> Login to Portal</button>
        </form>

        <div class="notice">
          <i class="fas fa-exclamation-triangle"></i>
          <span><strong>Warning:</strong> Unauthorized access attempts are logged and monitored by the system administrator.</span>
        </div>
      </div>

      <a href="login.php" class="back"><i class="fas fa-arrow-left"></i> Back to Portal Selection</a>

      <div class="tiles">
        <div class="tile"><i class="fas fa-boxes"></i><span>Manage Books</span></div>
        <div class="tile"><i class="fas fa-exchange-alt"></i><span>Transactions</span></div>
        <div class="tile"><i class="fas fa-chart-bar"></i><span>Reports</span></div>
      </div>
    </div>
  </div>

  <!-- Right: Decorative -->
  <div class="panel-right-deco">
    <div class="fb a1" style="top:5%;right:5%;opacity:.4"><div class="pbook" style="--w:38px;--h:52px;--c:rgba(255,255,255,.2);--r:16deg"></div></div>
    <div class="fb a3" style="top:15%;right:18%;opacity:.3"><div class="pbook" style="--w:30px;--h:42px;--c:rgba(255,255,255,.15);--r:-22deg"></div></div>
    <div class="fb a2" style="top:8%;left:8%;opacity:.35"><div class="pbook" style="--w:42px;--h:58px;--c:rgba(255,255,255,.18);--r:-14deg"></div></div>
    <div class="fb a5" style="top:30%;right:3%;opacity:.25"><div class="pbook" style="--w:34px;--h:48px;--c:rgba(255,255,255,.15);--r:24deg"></div></div>
    <div class="fb a4" style="top:28%;left:5%;opacity:.3"><div class="pbook" style="--w:28px;--h:40px;--c:rgba(255,255,255,.18);--r:-30deg"></div></div>
    <div class="fb a1" style="bottom:18%;right:8%;opacity:.3"><div class="pbook" style="--w:36px;--h:50px;--c:rgba(255,255,255,.15);--r:-18deg"></div></div>
    <div class="fb a3" style="bottom:8%;right:20%;opacity:.25"><div class="pbook" style="--w:44px;--h:60px;--c:rgba(255,255,255,.12);--r:12deg"></div></div>
    <div class="fb a2" style="bottom:12%;left:6%;opacity:.3"><div class="pbook" style="--w:32px;--h:46px;--c:rgba(255,255,255,.18);--r:20deg"></div></div>
    <div class="fb a5" style="bottom:28%;left:10%;opacity:.2"><div class="pbook" style="--w:26px;--h:38px;--c:rgba(255,255,255,.12);--r:-35deg"></div></div>

    <div class="panel-info">
      <div class="panel-logo"><i class="fas fa-user-shield"></i></div>
      <h2><?php echo $greeting; ?>!</h2>
      <p>Administrative access for KCMIT Library staff, librarians, and faculty</p>
    </div>
    <div class="panel-features">
      <div class="pf"><i class="fas fa-boxes"></i> Manage book inventory</div>
      <div class="pf"><i class="fas fa-exchange-alt"></i> Handle borrow/return transactions</div>
      <div class="pf"><i class="fas fa-chart-bar"></i> Generate reports & analytics</div>
      <div class="pf"><i class="fas fa-users-cog"></i> Manage student accounts</div>
    </div>
  </div>

</div>
</body>
</html>