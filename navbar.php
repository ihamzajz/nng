<?php

require_once __DIR__ . '/bootstrap.php';

$websiteCurrentPath = $_SERVER['REQUEST_URI'] ?? app_url('');
$websiteLogoutRedirect = urlencode((string) $websiteCurrentPath);
$websiteRequestPath = parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH) ?: '';
$websiteBasePath = parse_url((string) config('app_url', ''), PHP_URL_PATH) ?: '';

if ($websiteBasePath !== '' && str_starts_with($websiteRequestPath, $websiteBasePath)) {
    $websiteRequestPath = substr($websiteRequestPath, strlen($websiteBasePath));
}

$websiteCurrentPage = trim(strtolower($websiteRequestPath), '/');
$websiteCurrentPage = $websiteCurrentPage === '' ? 'home' : $websiteCurrentPage;

if (!function_exists('website_nav_is_active')) {
    function website_nav_is_active(array $matches, string $currentPage): bool
    {
        return in_array($currentPage, $matches, true);
    }
}
?>
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?php echo htmlspecialchars(app_url(''), ENT_QUOTES, 'UTF-8'); ?>">
            <img src="<?php echo htmlspecialchars(asset_url('assets/images/NNG.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="North Nazimabad Gymkhana">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link <?php echo website_nav_is_active(['home', 'index', 'index.php'], $websiteCurrentPage) ? 'active' : ''; ?>" href="<?php echo htmlspecialchars(app_url(''), ENT_QUOTES, 'UTF-8'); ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo website_nav_is_active(['about', 'about.php'], $websiteCurrentPage) ? 'active' : ''; ?>" href="<?php echo htmlspecialchars(app_url('about'), ENT_QUOTES, 'UTF-8'); ?>">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo website_nav_is_active(['facilllities', 'facilllities.php'], $websiteCurrentPage) ? 'active' : ''; ?>" href="<?php echo htmlspecialchars(app_url('facilllities'), ENT_QUOTES, 'UTF-8'); ?>">Facilities</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo website_nav_is_active(['feedback', 'feedback.php'], $websiteCurrentPage) ? 'active' : ''; ?>" href="<?php echo htmlspecialchars(app_url('feedback'), ENT_QUOTES, 'UTF-8'); ?>">Feedback</a>
                </li>
                <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                    <a href="<?php echo htmlspecialchars(app_url('membership'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary-custom <?php echo website_nav_is_active(['membership', 'membership.php'], $websiteCurrentPage) ? 'active' : ''; ?>">Membership</a>
                </li>
                <?php if (is_logged_in()): ?>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a href="<?php echo htmlspecialchars(app_url('dashboard'), ENT_QUOTES, 'UTF-8'); ?>" class="btn auth-btn auth-btn-dark">Dashboard</a>
                    </li>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a href="<?php echo htmlspecialchars(app_url('logout?redirect=' . $websiteLogoutRedirect), ENT_QUOTES, 'UTF-8'); ?>" class="btn auth-btn auth-btn-muted">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a href="<?php echo htmlspecialchars(app_url('login'), ENT_QUOTES, 'UTF-8'); ?>" class="btn auth-btn auth-btn-muted">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
