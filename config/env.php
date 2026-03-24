<?php

declare(strict_types=1);

if (!function_exists('load_env')) {
    function load_env(string $filePath): void
    {
        if (!is_file($filePath)) {
            return;
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if ($lines === false) {
            return;
        }

        foreach ($lines as $line) {
            $trimmedLine = trim($line);

            if ($trimmedLine === '' || strpos($trimmedLine, '#') === 0) {
                continue;
            }

            $separatorPosition = strpos($trimmedLine, '=');

            if ($separatorPosition === false) {
                continue;
            }

            $key = trim(substr($trimmedLine, 0, $separatorPosition));
            $value = trim(substr($trimmedLine, $separatorPosition + 1));

            if ($key === '') {
                continue;
            }

            $value = trim($value, "\"'");

            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;

            if (getenv($key) === false) {
                putenv($key . '=' . $value);
            }
        }
    }
}

if (!function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

        if ($value === false || $value === null || $value === '') {
            return $default;
        }

        return $value;
    }
}

load_env(dirname(__DIR__) . '/.env');
