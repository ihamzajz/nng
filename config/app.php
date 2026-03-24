<?php

declare(strict_types=1);

$GLOBALS['app_config'] = [
    'app_env' => env('APP_ENV', 'local'),
    'app_url' => rtrim((string) env('APP_URL', 'http://localhost/nng'), '/'),
    'api_base_url' => rtrim((string) env('API_BASE_URL', 'https://api.abc.com'), '/'),
    'api_timeout' => (int) env('API_TIMEOUT', 30),
];

if (!function_exists('config')) {
    function config(?string $key = null, mixed $default = null): mixed
    {
        $config = $GLOBALS['app_config'] ?? [];

        if ($key === null) {
            return $config;
        }

        return $config[$key] ?? $default;
    }
}
