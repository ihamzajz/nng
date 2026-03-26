<?php

require_once __DIR__ . '/bootstrap.php';

require_auth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Event Booking | NNGK</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="page-dashboard">
<?php include 'sidebar.php'; ?>
<main class="app style-dashboard-001">
<h1>Event Booking</h1>
<p>Create and manage event bookings from this section.</p>
<div class="dashboard-container">
  <div class="col-lg-3 col-md-4 col-sm-6">
    <a href="event_history" class="wt-link">
      <div class="wt-card">
        <div class="wt-icon bg-green">
          <i class="fa-solid fa-clock-rotate-left"></i>
        </div>
        <h6 class="wt-title">View History</h6>
        <div class="wt-desc">Open your event booking history.</div>
      </div>
    </a>
  </div>
</div>
</main>
</body>
</html>
