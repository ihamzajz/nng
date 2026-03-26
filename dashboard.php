<?php

require_once __DIR__ . '/bootstrap.php';

require_auth();

$userName = auth_user_name();
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NNGK Dashboard</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" referrerpolicy="no-referrer" />
<link rel="icon" type="image/png" href="<?php echo htmlspecialchars(asset_url('assets/images/icon.png'), ENT_QUOTES, 'UTF-8'); ?>">
<link rel="stylesheet" href="assets/css/style.css">

<style>
  body.page-dashboard {
    font-family: 'Poppins', sans-serif;
    background: #f5f7fb;
    color: #1f2937;
  }

  .style-dashboard-001 {
    padding: 32px;
  }

  .style-dashboard-001 h1 {
    margin: 0 0 24px;
    font-size: 28px;
    font-weight: 700;
    color: #111827;
  }

  .dashboard-container {
    display: flex;
    flex-wrap: wrap;
    gap: 24px;
  }

  .col-lg-3,
  .col-md-4,
  .col-sm-6 {
    width: 100%;
    max-width: 320px;
  }

  .wt-link {
    text-decoration: none;
    color: inherit;
    display: block;
  }

  .wt-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
    transition: transform 0.2s ease, box-shadow 0.2s ease;

    display: flex;
    flex-direction: column;
    gap: 6px; /* 👈 controls spacing perfectly */
  }

  .wt-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(15, 23, 42, 0.12);
  }

  .wt-icon {
    width: 64px;
    height: 64px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
  }

  .wt-icon i {
    font-size: 28px;
    color: #ffffff;
    display: block;
    line-height: 1;
  }

  .bg-blue {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
  }

  .bg-green {
    background: linear-gradient(135deg, #10b981, #059669);
  }

  .wt-title {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #111827;
    line-height: 1.2;
  }

  .wt-desc {
    margin-top: 4px;
    font-size: 14px;
    line-height: 1.5;
    color: #6b7280;
  }

  @media (max-width: 768px) {
    .style-dashboard-001 {
      padding: 20px;
    }

    .dashboard-container {
      gap: 18px;
    }

    .col-lg-3,
    .col-md-4,
    .col-sm-6 {
      max-width: 100%;
    }
  }
</style>
</head>

<body class="page-dashboard">

<?php include 'sidebar.php'; ?>

<main class="app style-dashboard-001">
  <h1>Welcome to NNGK Dashboard</h1>

  <div class="dashboard-container">

    <!-- Court Box -->
    <div class="col-lg-3 col-md-4 col-sm-6">
<a href="<?php echo htmlspecialchars(app_url('court_form'), ENT_QUOTES, 'UTF-8'); ?>" class="wt-link">
        <div class="wt-card">
          <div class="wt-icon bg-blue">
            <i class="fa-solid fa-gavel"></i>
          </div>
          <h6 class="wt-title">Court</h6>
          <div class="wt-desc">
            Manage court bookings and history.
          </div>
        </div>
      </a>
    </div>

    <!-- Event Box -->
    <div class="col-lg-3 col-md-4 col-sm-6">
<a href="<?php echo htmlspecialchars(app_url('event_form'), ENT_QUOTES, 'UTF-8'); ?>" class="wt-link">
        <div class="wt-card">
          <div class="wt-icon bg-green">
            <i class="fa-solid fa-calendar-days"></i>
          </div>
          <h6 class="wt-title">Event</h6>
          <div class="wt-desc">
            Manage event bookings and history.
          </div>
        </div>
      </a>
    </div>

  </div>
</main>

<script src="assets/js/main.js"></script>
</body>
</html>
