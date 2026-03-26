<?php

require_once __DIR__ . '/bootstrap.php';

if (is_logged_in()) {
    redirect('dashboard');
}

$appName = (string) config('app_name', 'NNGK');
$errorMessage = '';
$name = '';
$username = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string) ($_POST['name'] ?? ''));
    $username = trim((string) ($_POST['username'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if ($name === '' || $username === '' || $email === '' || $password === '') {
        $errorMessage = 'Please fill all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = 'Please enter a valid email address.';
    } else {
        $apiResponse = api_request('POST', 'api/auth/register', [
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'password' => $password,
        ]);

        if ($apiResponse['success']) {
            $_SESSION['auth_success'] = 'Registration successful. Please login with your new account.';
            redirect('login');
        }

        $errorMessage = extract_api_error_message($apiResponse);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($appName, ENT_QUOTES, 'UTF-8'); ?> - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="page-register page-login">
    <div class="bg-blur"></div>

    <div class="min-vh-100 d-flex align-items-center justify-content-center p-3">
        <div class="auth-card bg-white border w-100 style-login-001">
            <div class="row g-0">
                <div class="col-lg-6 login-image-col">
                    <img src="assets/images/image1.jpg" alt="Company" class="img-fluid h-100 w-100 style-login-002">
                </div>

                <div class="col-lg-6">
                    <div class="p-4 p-lg-5">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center fw-bold style-login-003">
                                <?php echo htmlspecialchars(strtoupper(substr($appName, 0, 1)), ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                            <div class="lh-sm">
                                <div class="fw-bold"><?php echo htmlspecialchars($appName, ENT_QUOTES, 'UTF-8'); ?></div>
                                <div class="text-secondary style-login-004">North Nazimabad Gymkhana</div>
                            </div>
                        </div>

                        <h4 class="fw-bold mb-3">Create account</h4>

                        <form method="POST" autocomplete="off" novalidate>
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Full Name</label>
                                <input class="form-control" id="name" name="name" type="text"
                                    placeholder="Enter your full name" value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label fw-semibold">Username</label>
                                <input class="form-control" id="username" name="username" type="text"
                                    placeholder="Choose a username" value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input class="form-control" id="email" name="email" type="email"
                                    placeholder="Enter your email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <div class="pw-split">
                                    <input class="form-control pw-input" id="password" name="password" type="password"
                                        placeholder="Create password" required>
                                    <button type="button" class="pw-toggle" id="togglePw">Show</button>
                                </div>
                            </div>

                            <button class="btn btn-primary w-100" type="submit">Register</button>

                            <div class="msg-slot mt-2">
                                <?php if ($errorMessage !== ''): ?>
                                    <div class="alert alert-danger mb-0 py-2" role="alert">
                                        <?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <p class="text-center mt-3 mb-0 text-secondary">
                                Already have an account?
<a href="<?php echo htmlspecialchars(app_url('login'), ENT_QUOTES, 'UTF-8'); ?>" class="text-decoration-none fw-semibold">Login here</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>

</html>
