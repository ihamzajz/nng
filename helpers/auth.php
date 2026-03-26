<?php

declare(strict_types=1);

if (!function_exists('is_logged_in')) {
    function is_logged_in(): bool
    {
        return !empty($_SESSION['auth']['token']);
    }
}

if (!function_exists('auth_user')) {
    function auth_user(): array
    {
        $user = $_SESSION['auth']['user'] ?? [];

        return is_array($user) ? $user : [];
    }
}

if (!function_exists('auth_token')) {
    function auth_token(): ?string
    {
        $token = $_SESSION['auth']['token'] ?? null;

        return is_string($token) && $token !== '' ? $token : null;
    }
}

if (!function_exists('login_user')) {
    function login_user(array $user, string $token): void
    {
        $_SESSION['auth'] = [
            'user' => $user,
            'token' => $token,
        ];
    }
}

if (!function_exists('logout_user')) {
    function logout_user(): void
    {
        unset($_SESSION['auth']);
    }
}

if (!function_exists('redirect')) {
    function redirect(string $path): void
    {
        $target = preg_match('/^https?:\/\//i', $path) === 1 ? $path : app_url($path);
        header('Location: ' . $target);
        exit;
    }
}

if (!function_exists('require_auth')) {
    function require_auth(): void
    {
        if (!is_logged_in()) {
            redirect('unauthorized');
        }
    }
}

if (!function_exists('auth_is_admin')) {
    function auth_is_admin(): bool
    {
        $user = auth_user();

        foreach (['role', 'userType', 'user_type', 'type'] as $key) {
            if (!empty($user[$key]) && is_string($user[$key])) {
                $role = strtolower(trim($user[$key]));

                if (in_array($role, ['admin', 'superadmin'], true)) {
                    return true;
                }
            }
        }

        return false;
    }
}

if (!function_exists('require_admin')) {
    function require_admin(): void
    {
        require_auth();

        if (!auth_is_admin()) {
            redirect('unauthorized');
        }
    }
}

if (!function_exists('auth_user_name')) {
    function auth_user_name(): string
    {
        $user = auth_user();

        foreach (['name', 'username'] as $key) {
            if (!empty($user[$key]) && is_string($user[$key])) {
                return $user[$key];
            }
        }

        return 'User';
    }
}

if (!function_exists('auth_user_email')) {
    function auth_user_email(): string
    {
        $user = auth_user();

        return !empty($user['email']) && is_string($user['email']) ? $user['email'] : '';
    }
}

if (!function_exists('auth_user_role')) {
    function auth_user_role(): string
    {
        $user = auth_user();

        foreach (['role', 'userType'] as $key) {
            if (!empty($user[$key]) && is_string($user[$key])) {
                return ucfirst($user[$key]);
            }
        }

        return 'Member';
    }
}

if (!function_exists('auth_user_initial')) {
    function auth_user_initial(): string
    {
        $name = trim(auth_user_name());

        return $name !== '' ? strtoupper(substr($name, 0, 1)) : 'U';
    }
}

if (!function_exists('extract_auth_token')) {
    function extract_auth_token(array $responseData): ?string
    {
        $possibleTokens = [
            $responseData['token'] ?? null,
            $responseData['accessToken'] ?? null,
            $responseData['jwt'] ?? null,
        ];

        if (isset($responseData['data']) && is_array($responseData['data'])) {
            $possibleTokens[] = $responseData['data']['token'] ?? null;
            $possibleTokens[] = $responseData['data']['accessToken'] ?? null;
            $possibleTokens[] = $responseData['data']['jwt'] ?? null;
        }

        foreach ($possibleTokens as $token) {
            if (is_string($token) && trim($token) !== '') {
                return $token;
            }
        }

        return null;
    }
}

if (!function_exists('extract_auth_user')) {
    function extract_auth_user(array $responseData, string $identifier = ''): array
    {
        $flatUserKeys = ['id', 'name', 'username', 'email', 'cm_no', 'role', 'status', 'can_book', 'fees_status'];
        $flatUser = [];

        foreach ($flatUserKeys as $key) {
            if (array_key_exists($key, $responseData)) {
                $flatUser[$key] = $responseData[$key];
            }
        }

        $possibleUsers = [
            $flatUser !== [] ? $flatUser : null,
            $responseData['user'] ?? null,
        ];

        if (isset($responseData['data']) && is_array($responseData['data'])) {
            if (isset($responseData['data']['user']) && is_array($responseData['data']['user'])) {
                $possibleUsers[] = $responseData['data']['user'];
            } else {
                $nestedFlatUser = [];

                foreach ($flatUserKeys as $key) {
                    if (array_key_exists($key, $responseData['data'])) {
                        $nestedFlatUser[$key] = $responseData['data'][$key];
                    }
                }

                $possibleUsers[] = $nestedFlatUser !== [] ? $nestedFlatUser : null;
            }
        }

        foreach ($possibleUsers as $candidate) {
            if (is_array($candidate) && $candidate !== []) {
                return $candidate;
            }
        }

        return [
            'name' => $identifier !== '' ? $identifier : 'User',
            'username' => $identifier,
            'email' => filter_var($identifier, FILTER_VALIDATE_EMAIL) ? $identifier : '',
        ];
    }
}

if (!function_exists('extract_api_error_message')) {
    function extract_api_error_message(array $apiResponse): string
    {
        if (!empty($apiResponse['error']) && is_string($apiResponse['error'])) {
            return $apiResponse['error'];
        }

        $data = $apiResponse['data'] ?? null;

        if (is_array($data)) {
            foreach (['message', 'error'] as $key) {
                if (!empty($data[$key]) && is_string($data[$key])) {
                    return $data[$key];
                }
            }
        }

        $status = (int) ($apiResponse['status'] ?? 0);

        if ($status === 401) {
            return 'Invalid username/email or password.';
        }

        return 'Login failed. Please try again.';
    }
}
