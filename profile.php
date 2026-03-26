<?php

require_once __DIR__ . '/bootstrap.php';

require_auth();

$token = auth_token() ?? '';
$sessionUser = auth_user();
$profile = $sessionUser;
$profileError = '';

$passwordError = '';
$passwordSuccess = '';

function profile_api_candidates(string $action): array
{
    if ($action === 'me') {
        return ['api/auth/me', 'auth/me', 'me'];
    }

    if ($action === 'change-password') {
        return ['api/auth/change-password', 'auth/change-password', 'change-password'];
    }

    return [];
}

function profile_api_request_first_success(string $method, array $endpoints, array $payload = [], ?string $token = null): array
{
    $lastResponse = [
        'success' => false,
        'status' => 0,
        'data' => null,
        'raw' => null,
        'error' => 'No API endpoint configured.',
        'endpoint' => null,
    ];

    foreach ($endpoints as $endpoint) {
        $response = api_request($method, $endpoint, $payload, [], $token);
        $response['endpoint'] = $endpoint;
        $lastResponse = $response;

        if ($response['success']) {
            return $response;
        }

        if (in_array((int) ($response['status'] ?? 0), [401, 403], true)) {
            return $response;
        }
    }

    return $lastResponse;
}

function profile_extract_user(?array $data): array
{
    if (!is_array($data)) {
        return [];
    }

    $possibleUsers = [
        $data['user'] ?? null,
        $data['data']['user'] ?? null,
        $data['data'] ?? null,
    ];

    foreach ($possibleUsers as $candidate) {
        if (is_array($candidate)) {
            return $candidate;
        }
    }

    return [];
}

function profile_message_from_response(array $response, string $fallback): string
{
    if (!empty($response['error']) && is_string($response['error'])) {
        return $response['error'];
    }

    $data = $response['data'] ?? null;

    if (is_array($data)) {
        foreach (['message', 'error'] as $key) {
            if (!empty($data[$key]) && is_string($data[$key])) {
                return $data[$key];
            }
        }

        if (isset($data['data']) && is_array($data['data'])) {
            foreach (['message', 'error'] as $key) {
                if (!empty($data['data'][$key]) && is_string($data['data'][$key])) {
                    return $data['data'][$key];
                }
            }
        }
    }

    return $fallback;
}

$meResponse = profile_api_request_first_success('GET', profile_api_candidates('me'), [], $token);

if ($meResponse['success']) {
    $apiUser = profile_extract_user(is_array($meResponse['data']) ? $meResponse['data'] : null);

    if ($apiUser !== []) {
        $profile = array_merge($sessionUser, $apiUser);
        $_SESSION['auth']['user'] = $profile;
    }
} elseif (in_array((int) ($meResponse['status'] ?? 0), [401, 403], true)) {
    logout_user();
    $_SESSION['auth_error'] = 'Your session has expired. Please login again.';
    redirect('login');
} elseif (!empty($meResponse['error']) || (int) ($meResponse['status'] ?? 0) >= 400) {
    $profileError = 'Could not refresh profile from API. Showing saved account data.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (string) ($_POST['action'] ?? '') === 'change_password') {
    $currentPassword = trim((string) ($_POST['current_password'] ?? ''));
    $newPassword = trim((string) ($_POST['new_password'] ?? ''));
    $confirmPassword = trim((string) ($_POST['confirm_password'] ?? ''));

    if ($currentPassword === '' || $newPassword === '' || $confirmPassword === '') {
        $passwordError = 'Please fill all password fields.';
    } elseif (strlen($newPassword) < 6) {
        $passwordError = 'New password must be at least 6 characters.';
    } elseif ($newPassword !== $confirmPassword) {
        $passwordError = 'New password and confirm password do not match.';
    } else {
        $changePasswordResponse = profile_api_request_first_success(
            'PUT',
            profile_api_candidates('change-password'),
            [
                'currentPassword' => $currentPassword,
                'newPassword' => $newPassword,
            ],
            $token
        );

        if ($changePasswordResponse['success']) {
            $passwordSuccess = profile_message_from_response($changePasswordResponse, 'Password changed successfully.');
        } elseif (in_array((int) ($changePasswordResponse['status'] ?? 0), [401, 403], true)) {
            logout_user();
            $_SESSION['auth_error'] = 'Your session has expired. Please login again.';
            redirect('login');
        } else {
            $passwordError = profile_message_from_response($changePasswordResponse, 'Could not change password.');
        }
    }
}

$name = (string) ($profile['name'] ?? $profile['username'] ?? 'User');
$username = (string) ($profile['username'] ?? '-');
$email = (string) ($profile['email'] ?? '-');
$cmNo = (string) ($profile['cm_no'] ?? $profile['cmNo'] ?? '-');
$role = (string) ($profile['role'] ?? $profile['userType'] ?? 'member');
$feesStatusRaw = strtolower((string) ($profile['fees_status'] ?? $profile['feesStatus'] ?? 'paid'));
$feesLabel = $feesStatusRaw !== '' ? ucfirst($feesStatusRaw) : 'Paid';
$canBookRaw = strtolower((string) ($profile['can_book'] ?? $profile['canBook'] ?? 'no'));
$canBook = $canBookRaw === 'yes' || $canBookRaw === 'true' || $canBookRaw === '1';
$isAdmin = in_array(strtolower($role), ['admin', 'superadmin'], true);
$userId = (string) ($profile['id'] ?? '-');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profile | NNGK</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" referrerpolicy="no-referrer" />
<link rel="icon" type="image/png" href="<?php echo htmlspecialchars(asset_url('assets/images/icon.png'), ENT_QUOTES, 'UTF-8'); ?>">
<link rel="stylesheet" href="assets/css/style.css">
<style>
body.page-profile {
    font-family: 'Poppins', sans-serif;
    background: #e9ecef;
    color: #212529;
}

body.page-profile .profile-shell {
    padding: 18px;
}

body.page-profile .profile-wrap {
    max-width: 900px;
}

body.page-profile .profile-box {
    background: #ffffff;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 14px;
}

body.page-profile h1 {
    margin: 0 0 4px;
    font-size: 22px;
    font-weight: 700;
}

body.page-profile h2 {
    margin: 0 0 10px;
    font-size: 18px;
    font-weight: 600;
}

body.page-profile .profile-text {
    margin: 0;
    color: #6c757d;
    font-size: 12.5px;
}

body.page-profile .alert-box {
    padding: 10px 12px;
    border-radius: 6px;
    margin-bottom: 12px;
    font-size: 12px;
}

body.page-profile .alert-box.error {
    background: #f8d7da;
    color: #842029;
    border: 1px solid #f5c2c7;
}

body.page-profile .alert-box.success {
    background: #d1e7dd;
    color: #0f5132;
    border: 1px solid #badbcc;
}

body.page-profile .profile-table {
    width: 100%;
    border-collapse: collapse;
}

body.page-profile .profile-table th,
body.page-profile .profile-table td {
    padding: 7px 8px;
    border-bottom: 1px solid #e9ecef;
    text-align: left;
    vertical-align: top;
    font-size: 11.5px;
}

body.page-profile .profile-table th {
    width: 160px;
    color: #495057;
    font-weight: 600;
}

body.page-profile .profile-table tr:last-child th,
body.page-profile .profile-table tr:last-child td {
    border-bottom: none;
}

body.page-profile .status-text {
    font-weight: 600;
}

body.page-profile .status-good {
    color: #198754;
}

body.page-profile .status-muted {
    color: #6c757d;
}

body.page-profile .form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

body.page-profile .form-group.full {
    grid-column: 1 / -1;
}

body.page-profile label {
    display: block;
    margin-bottom: 5px;
    font-size: 12px;
    font-weight: 600;
    color: #495057;
}

body.page-profile .input-wrap {
    position: relative;
    width: 100%;
}

body.page-profile input {
    box-sizing: border-box;
    width: 100%;
    min-height: 38px;
    border: 1px solid #ced4da;
    border-radius: 6px;
    padding: 8px 40px 8px 10px;
    font-size: 13px;
    background: #fff;
    font-family: 'Poppins', sans-serif;
    line-height: 1.3;
}

body.page-profile input::placeholder {
    font-family: 'Poppins', sans-serif;
    font-size: 12px;
    color: #6c757d;
}

body.page-profile input:focus {
    outline: none;
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
}

body.page-profile .toggle-btn {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    border: none;
    background: transparent;
    color: #6c757d;
    cursor: pointer;
    font-size: 12px;
}

body.page-profile .action-row {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 12px;
}

body.page-profile .btn-simple {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    min-height: 36px;
    padding: 0 13px;
    border-radius: 6px;
    border: 1px solid transparent;
    text-decoration: none;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    font-family: 'Poppins', sans-serif;
}

body.page-profile .btn-simple i {
    font-size: 12px;
}

body.page-profile .btn-primary-simple {
    background: #0d6efd;
    border-color: #0d6efd;
    color: #fff;
}

body.page-profile .btn-secondary-simple {
    background: #6c757d;
    border-color: #6c757d;
    color: #fff;
}

body.page-profile .btn-danger-simple {
    background: #dc3545;
    border-color: #dc3545;
    color: #fff;
}

body.page-profile .btn-bootstrap-dark {
    background: #212529;
    border-color: #212529;
    color: #fff;
}

@media (max-width: 768px) {
    body.page-profile .profile-shell {
        padding: 12px;
    }

    body.page-profile .profile-box {
        padding: 12px;
    }

    body.page-profile .profile-table th,
    body.page-profile .profile-table td {
        display: block;
        width: 100%;
        padding: 8px 0;
    }

    body.page-profile .form-grid {
        grid-template-columns: 1fr;
    }
}
</style>
</head>
<body class="page-profile">
<?php include 'sidebar.php'; ?>

<main class="app profile-shell">
    <div class="profile-wrap">
        <div class="profile-box">
            <h1>My Profile</h1>
            <p class="profile-text">View your account information and change your password.</p>
        </div>

        <?php if ($profileError !== ''): ?>
            <div class="alert-box error"><?php echo htmlspecialchars($profileError, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <div class="profile-box">
            <h2>Account Details</h2>
            <table class="profile-table">
                <tr>
                    <th>Name</th>
                    <td><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td><?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <tr>
                    <th>CM No</th>
                    <td><?php echo htmlspecialchars($cmNo, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td><?php echo htmlspecialchars($role, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <tr>
                    <th>Fees Status</th>
                    <td class="status-text <?php echo $feesStatusRaw === 'paid' ? 'status-good' : 'status-muted'; ?>">
                        <?php echo htmlspecialchars($feesLabel, ENT_QUOTES, 'UTF-8'); ?>
                    </td>
                </tr>
                <tr>
                    <th>Booking Access</th>
                    <td><?php echo $canBook ? 'Yes' : 'No'; ?></td>
                </tr>
                <tr>
                    <th>User ID</th>
                    <td><?php echo htmlspecialchars($userId, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            </table>
        </div>

        <div class="profile-box">
            <h2>Change Password</h2>

            <?php if ($passwordError !== ''): ?>
                <div class="alert-box error"><?php echo htmlspecialchars($passwordError, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <?php if ($passwordSuccess !== ''): ?>
                <div class="alert-box success"><?php echo htmlspecialchars($passwordSuccess, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <form method="POST">
                <input type="hidden" name="action" value="change_password">

                <div class="form-grid">
                    <div class="form-group full">
                        <label for="current_password">Current Password</label>
                        <div class="input-wrap">
                            <input type="password" id="current_password" name="current_password" placeholder="Enter current password">
                            <button type="button" class="toggle-btn" data-target="current_password">Show</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <div class="input-wrap">
                            <input type="password" id="new_password" name="new_password" placeholder="Enter new password">
                            <button type="button" class="toggle-btn" data-target="new_password">Show</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <div class="input-wrap">
                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password">
                            <button type="button" class="toggle-btn" data-target="confirm_password">Show</button>
                        </div>
                    </div>
                </div>

                <div class="action-row">
                    <button type="submit" class="btn-simple btn-primary-simple"><i class="fa-solid fa-key"></i><span>Update Password</span></button>
                </div>
            </form>
        </div>

    </div>
</main>

<script>
document.querySelectorAll('.toggle-btn').forEach(function (button) {
    button.addEventListener('click', function () {
        const targetId = this.getAttribute('data-target');
        const input = document.getElementById(targetId);

        if (!input) {
            return;
        }

        if (input.type === 'password') {
            input.type = 'text';
            this.textContent = 'Hide';
        } else {
            input.type = 'password';
            this.textContent = 'Show';
        }
    });
});
</script>
</body>
</html>
