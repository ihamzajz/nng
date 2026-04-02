<?php

declare(strict_types=1);

if (!function_exists('detect_app_url')) {
    function detect_app_url(): string
    {
        $https = $_SERVER['HTTPS'] ?? '';
        $forwardedProto = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '';
        $isSecure = ($https !== '' && strtolower((string) $https) !== 'off') || strtolower((string) $forwardedProto) === 'https';

        $scheme = $isSecure ? 'https' : 'http';
        $host = trim((string) ($_SERVER['HTTP_X_FORWARDED_HOST'] ?? $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost'));
        $port = (int) ($_SERVER['SERVER_PORT'] ?? 0);
        $scriptName = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? ''));
        $basePath = trim(str_replace('\\', '/', dirname($scriptName)), '/.');

        if ($host === '') {
            $host = 'localhost';
        }

        if (strpos($host, ':') === false && $port > 0) {
            $isDefaultPort = ($scheme === 'http' && $port === 80) || ($scheme === 'https' && $port === 443);

            if (!$isDefaultPort) {
                $host .= ':' . $port;
            }
        }

        $baseUrl = $scheme . '://' . $host;

        return $basePath === '' ? $baseUrl : $baseUrl . '/' . $basePath;
    }
}

$GLOBALS['app_config'] = [
    'app_name' => env('APP_NAME', 'NNGK'),
    'app_url' => rtrim((string) env('APP_URL', detect_app_url()), '/'),
    'api' => rtrim((string) env('API', env('API_BASE_URL', 'https://api.jamtechsolutionz.com')), '/'),
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
        $baseUrl = rtrim((string) config('app_url', detect_app_url()), '/');
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
