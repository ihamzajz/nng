<?php require_once __DIR__ . '/bootstrap.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HESCO - Login</title>
    <!-- <link rel="icon" type="image/svg+xml" href="assets/images/favicon.svg"> -->


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">






    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="page-login">
    <div class="bg-blur"></div>

    <div class="min-vh-100 d-flex align-items-center justify-content-center p-3">
        <div class="auth-card bg-white border w-100 style-login-001">
            <div class="row g-0">

                <!-- LEFT IMAGE (hidden on <=992px) -->
                <div class="col-lg-6 login-image-col">
                    <img src="assets/images/image1.jpg" alt="Company" class="img-fluid h-100 w-100 style-login-002">
                </div>

                <!-- RIGHT FORM -->
                <div class="col-lg-6">
                    <div class="p-4 p-lg-5">

                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center fw-bold style-login-003"
                               >
                                N
                            </div>
                            <div class="lh-sm">
                                <div class="fw-bold">NNGK</div>
                                <div class="text-secondary style-login-004">North Nazimabad Gymkhana</div>
                            </div>
                        </div>

                        <h4 class="fw-bold mb-3">Sign in</h4>

                        <?php $apiBaseUrl = api_base_url(); ?>

                        <form method="POST" autocomplete="off" novalidate>
                            <div class="mb-3">
                                <label for="login" class="form-label fw-semibold">Email or Username</label>
                                <input class="form-control" id="login" name="login" type="text"
                                    placeholder="Enter email or username" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password</label>

                                <!-- âœ… split input: left input + right 20% button -->
                                <div class="pw-split">
                                    <input class="form-control pw-input" id="password" name="password" type="password"
                                        placeholder="Enter password" required>
                                    <button type="button" class="pw-toggle" id="togglePw">Show</button>
                                </div>
                            </div>

                            <button class="btn btn-primary w-100" type="submit">Login</button>

                            <!-- fixed slot: no layout jump -->
                            <div class="msg-slot mt-2">
                                <small class="text-secondary">Backend API base URL: <?php echo htmlspecialchars($apiBaseUrl, ENT_QUOTES, 'UTF-8'); ?></small>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>

</html>
