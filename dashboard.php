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

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="page-dashboard">

<?php include 'sidebar.php'; ?>

<main class="app style-dashboard-001">
<h1>Welcome to NNGK Dashboard</h1>
<p>Hello, <?php echo htmlspecialchars($userName, ENT_QUOTES, 'UTF-8'); ?>. You are logged in successfully.</p>

<div class="dashboard-container">

  <!-- Court Box -->
  <div class="col-lg-3 col-md-4 col-sm-6">
    <a href="#" class="wt-link">
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
    <a href="#" class="wt-link">
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
