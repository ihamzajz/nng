<?php

declare(strict_types=1);

$GLOBALS['app_config'] = [
    'app_name' => env('APP_NAME', 'NNGK'),
    'app_url' => rtrim((string) env('APP_URL', 'http://localhost/nng'), '/'),
    'api' => rtrim((string) env('API', env('API_BASE_URL', 'http://localhost:5000')), '/'),
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

if (!function_exists('app_url')) {
    function app_url(string $path = ''): string
    {
        $baseUrl = rtrim((string) config('app_url', 'http://localhost/nng'), '/');
        $trimmedPath = trim($path);

        if ($trimmedPath === '' || $trimmedPath === 'index' || $trimmedPath === 'index.php') {
            return $baseUrl;
        }

        if (preg_match('/^https?:\/\//i', $trimmedPath) === 1) {
            return $trimmedPath;
        }

        $path = ltrim($trimmedPath, '/');

        return $baseUrl . '/' . $path;
    }
}

if (!function_exists('asset_url')) {
    function asset_url(string $path = ''): string
    {
        return app_url($path);
    }
}
