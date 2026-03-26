<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Unauthorized | NNGK</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" referrerpolicy="no-referrer" />
<link rel="icon" type="image/png" href="<?php echo htmlspecialchars(asset_url('assets/images/icon.png'), ENT_QUOTES, 'UTF-8'); ?>">
<link rel="stylesheet" href="<?php echo htmlspecialchars(asset_url('assets/css/style.css'), ENT_QUOTES, 'UTF-8'); ?>">
<style>
body.page-unauthorized { margin:0; font-family:'Poppins',sans-serif; min-height:100vh; background:linear-gradient(180deg, #eef4fb 0%, #e8eef6 100%); color:#13233f; }
body.page-unauthorized .wrap { min-height:100vh; display:flex; align-items:center; justify-content:center; padding:24px; }
body.page-unauthorized .card { width:min(100%, 720px); background:#fff; border:1px solid #d8dee6; border-radius:10px; padding:24px; box-shadow:0 8px 24px rgba(15,23,42,.05); }
body.page-unauthorized .icon-box { width:58px; height:58px; border-radius:16px; display:flex; align-items:center; justify-content:center; background:#eef4ff; color:#2563eb; font-size:24px; }
body.page-unauthorized h1 { margin:14px 0 0; font-size:24px; font-weight:700; font-family:'Poppins',sans-serif; color:#212529; }
body.page-unauthorized .lead { margin:10px 0 0; color:#63718a; font-size:13px; line-height:1.8; max-width:560px; }
body.page-unauthorized .info-box { margin-top:18px; background:#f8fbff; border:1px solid #dce5ef; border-radius:10px; padding:14px; color:#5f6f86; font-size:12.5px; line-height:1.7; }
body.page-unauthorized .actions { margin-top:18px; display:flex; gap:10px; flex-wrap:wrap; }
body.page-unauthorized .btn { display:inline-flex; align-items:center; justify-content:center; gap:8px; min-height:42px; padding:0 15px; border-radius:8px; border:1px solid transparent; text-decoration:none; font-size:12px; font-weight:600; }
body.page-unauthorized .btn-login { color:#fff; background:#2b2d42; }
body.page-unauthorized .btn-home { color:#374151; background:#fff; border-color:#d8dee6; }
body.page-unauthorized .helper { margin-top:14px; color:#7b8797; font-size:12px; }
@media (max-width: 700px) {
    body.page-unauthorized .card { padding:18px; }
    body.page-unauthorized .actions { flex-direction:column; }
}
</style>
</head>
<body class="page-unauthorized">
<div class="wrap">
    <div class="card">
        <div class="icon-box"><i class="fa-solid fa-lock"></i></div>
        <h1>Unauthorized Access</h1>
        <p class="lead">You need to login before opening this page. Private member sections like dashboard, booking forms, history, and admin tools are not available to guests.</p>

        <div class="info-box">
            If you already have an account, go to login and continue from there. If you were only browsing the public website, you can return to the homepage.
        </div>

        <div class="actions">
            <a href="<?php echo htmlspecialchars(app_url('login'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-login"><i class="fa-solid fa-right-to-bracket"></i><span>Go To Login</span></a>
            <a href="<?php echo htmlspecialchars(app_url(''), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-home"><i class="fa-solid fa-house"></i><span>Back To Website</span></a>
        </div>

        <div class="helper">If you signed in recently and still reached this page, refresh the browser and try again.</div>
    </div>
</div>
</body>
</html>
