<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

$redirectTarget = isset($_GET['redirect']) && is_string($_GET['redirect']) ? trim($_GET['redirect']) : '';

logout_user();

$_SESSION = [];

if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

session_destroy();

if ($redirectTarget === '') {
    $redirectTarget = app_url('login');
} elseif (preg_match('#^https?://#i', $redirectTarget) !== 1) {
    if (str_starts_with($redirectTarget, '/')) {
        $baseAppUrl = app_url('');
        $baseParts = parse_url($baseAppUrl);
        $scheme = $baseParts['scheme'] ?? 'http';
        $host = $baseParts['host'] ?? 'localhost';
        $port = isset($baseParts['port']) ? ':' . $baseParts['port'] : '';
        $redirectTarget = $scheme . '://' . $host . $port . $redirectTarget;
    } else {
        $redirectTarget = app_url(ltrim($redirectTarget, '/'));
    }
}

header('Location: ' . $redirectTarget);
exit;
