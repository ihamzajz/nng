<?php

require_once __DIR__ . '/bootstrap.php';

$websiteCurrentPath = $_SERVER['REQUEST_URI'] ?? app_url('');
$websiteLogoutRedirect = urlencode((string) $websiteCurrentPath);
?>
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?php echo htmlspecialchars(app_url(''), ENT_QUOTES, 'UTF-8'); ?>">
            <img src="<?php echo htmlspecialchars(asset_url('assets/images/NNG.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="North Nazimabad Gymkhana">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo htmlspecialchars(app_url(''), ENT_QUOTES, 'UTF-8'); ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo htmlspecialchars(app_url('about'), ENT_QUOTES, 'UTF-8'); ?>">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Facilities</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo htmlspecialchars(app_url('feedback'), ENT_QUOTES, 'UTF-8'); ?>">Feedback</a>
                </li>
                <li class="nav-item ms-lg-2">
                    <a href="<?php echo htmlspecialchars(app_url('membership'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary">Membership</a>
                </li>
                <?php if (is_logged_in()): ?>
                    <li class="nav-item ms-lg-2">
                        <a href="<?php echo htmlspecialchars(app_url('dashboard'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary login-btn" style="background: #000046 !important; background: -webkit-linear-gradient(to right, #1CB5E0, #000046) !important; background: linear-gradient(to right, #1CB5E0, #000046) !important; border-color: transparent !important; color: #ffffff !important;">Dashboard</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a href="<?php echo htmlspecialchars(app_url('logout?redirect=' . $websiteLogoutRedirect), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary login-btn" style="background-color: #6c757d !important; border-color: #6c757d !important; color: #ffffff !important;">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item ms-lg-2">
                        <a href="<?php echo htmlspecialchars(app_url('login'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary login-btn" style="background-color: #6c757d !important; border-color: #6c757d !important; color: #ffffff !important;">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
