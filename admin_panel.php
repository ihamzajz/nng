<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

require_auth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel | NNGK</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="<?php echo htmlspecialchars(asset_url('assets/css/style.css'), ENT_QUOTES, 'UTF-8'); ?>">
<style>
body.page-admin-panel { font-family:'Poppins',sans-serif; background:linear-gradient(180deg, #edf3fb 0%, #e8eef6 100%); color:#212529; }
body.page-admin-panel .panel-shell { padding:20px; max-width:1140px; }
body.page-admin-panel .panel-box { background:#fff; border:1px solid #d8dee6; border-radius:10px; padding:16px; margin-bottom:14px; box-shadow:0 8px 24px rgba(15,23,42,.05); }
body.page-admin-panel h1 { margin:0; font-size:22px; font-weight:700; color:#212529; }
body.page-admin-panel .panel-sub { margin-top:6px; color:#63718a; font-size:12.5px; }
body.page-admin-panel .tool-grid { display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:14px; }
body.page-admin-panel .tool-card { display:block; text-decoration:none; background:linear-gradient(180deg,#ffffff 0%, #fbfdff 100%); border:1px solid #dce5ef; border-radius:16px; padding:18px; box-shadow:0 12px 24px rgba(15,23,42,.05); transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease; }
body.page-admin-panel .tool-card:hover { transform:translateY(-2px); border-color:#bfd2f2; box-shadow:0 18px 30px rgba(15,23,42,.08); }
body.page-admin-panel .tool-icon { width:44px; height:44px; border-radius:14px; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg, #dbeafe, #e9f7ef); color:#2563eb; border:1px solid #cfe1ff; font-size:18px; }
body.page-admin-panel .tool-title { margin:12px 0 0; color:#13233f; font-size:15px; font-weight:700; }
body.page-admin-panel .tool-copy { margin:5px 0 0; color:#6b7280; font-size:12px; line-height:1.6; }
@media (max-width: 900px) {
    body.page-admin-panel .tool-grid { grid-template-columns:1fr; }
    body.page-admin-panel .panel-shell { padding:12px; }
}
</style>
</head>
<body class="page-admin-panel">
<?php include 'sidebar.php'; ?>
<main class="app panel-shell">
    <div class="panel-box">
        <h1>Admin Panel</h1>
    </div>

    <div class="tool-grid">
        <a href="<?php echo htmlspecialchars(app_url('manage_users'), ENT_QUOTES, 'UTF-8'); ?>" class="tool-card">
            <div class="tool-icon"><i class="fa-solid fa-users-gear"></i></div>
            <div class="tool-title">Manage Users</div>
            <div class="tool-copy">Create, edit, and remove user accounts with booking access and fee status controls.</div>
        </a>
    </div>
</main>
</body>
</html>
