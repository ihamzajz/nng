<?php

require_once __DIR__ . '/bootstrap.php';

if (is_logged_in()) {
    redirect('dashboard');
}

$appName = (string) config('app_name', 'NNGK');
$errorMessage = $_SESSION['auth_error'] ?? '';
$successMessage = $_SESSION['auth_success'] ?? '';
unset($_SESSION['auth_error'], $_SESSION['auth_success']);

$identifier = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim((string) ($_POST['login'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if ($identifier === '' || $password === '') {
        $errorMessage = 'Please enter your email/username and password.';
    } else {
        $apiResponse = api_request('POST', 'api/auth/login', [
            'identifier' => $identifier,
            'password' => $password,
        ]);

        if ($apiResponse['success']) {
            $responseData = is_array($apiResponse['data']) ? $apiResponse['data'] : [];
            $token = extract_auth_token($responseData);

            if ($token !== null) {
                $user = extract_auth_user($responseData, $identifier);
                login_user($user, $token);
                redirect('dashboard');
            }

            $errorMessage = 'Login response did not include a token.';
        } else {
            $errorMessage = extract_api_error_message($apiResponse);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($appName, ENT_QUOTES, 'UTF-8'); ?> - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo htmlspecialchars(asset_url('assets/images/icon.png'), ENT_QUOTES, 'UTF-8'); ?>">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="page-login">
    <div class="bg-blur"></div>

    <div class="min-vh-100 d-flex align-items-center justify-content-center p-3">
        <div class="w-100 d-flex flex-column align-items-center" style="max-width:980px;">
        <div class="auth-card bg-white border w-100 style-login-001">
            <div class="row g-0">
                <div class="col-lg-6 login-image-col">
                    <img src="assets/images/image1.jpg" alt="Company" class="img-fluid h-100 w-100 style-login-002">
                </div>

                <div class="col-lg-6">
                    <div class="p-4 p-lg-5">
                        <div class="text-center mb-3">
                            <a href="<?php echo htmlspecialchars(app_url(), ENT_QUOTES, 'UTF-8'); ?>" class="text-decoration-none fw-semibold">Go To Website</a>
                        </div>

                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center fw-bold style-login-003">
                                <?php echo htmlspecialchars(strtoupper(substr($appName, 0, 1)), ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                            <div class="lh-sm">
                                <div class="fw-bold"><?php echo htmlspecialchars($appName, ENT_QUOTES, 'UTF-8'); ?></div>
                                <div class="text-secondary style-login-004">North Nazimabad Gymkhana</div>
                            </div>
                        </div>

                        <h4 class="fw-bold mb-3">Sign in</h4>

                        <form method="POST" autocomplete="off" novalidate>
                            <div class="mb-3">
                                <label for="login" class="form-label fw-semibold">Email or Username</label>
                                <input class="form-control" id="login" name="login" type="text"
                                    placeholder="Enter email or username" value="<?php echo htmlspecialchars($identifier, ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <div class="pw-split">
                                    <input class="form-control pw-input" id="password" name="password" type="password"
                                        placeholder="Enter password" required>
                                    <button type="button" class="pw-toggle" id="togglePw">Show</button>
                                </div>
                            </div>

                            <button class="btn btn-primary w-100" type="submit">Login</button>

                            <div class="msg-slot mt-2">
                                <?php if ($successMessage !== ''): ?>
                                    <div class="alert alert-success mb-2 py-2" role="alert">
                                        <?php echo htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8'); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($errorMessage !== ''): ?>
                                    <div class="alert alert-danger mb-0 py-2" role="alert">
                                        <?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <p class="text-center mt-3 mb-0 text-secondary">
                                Don't have an account?
<a href="<?php echo htmlspecialchars(app_url('register'), ENT_QUOTES, 'UTF-8'); ?>" class="text-decoration-none fw-semibold">Create one</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>

</html>
