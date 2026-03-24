<?php

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config/env.php';
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/helpers/api.php';
require_once __DIR__ . '/helpers/auth.php';
