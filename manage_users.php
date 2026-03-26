<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

require_auth();

if (!function_exists('manage_users_array_is_list')) {
    function manage_users_array_is_list(array $array): bool
    {
        $expectedKey = 0;

        foreach ($array as $key => $_value) {
            if ($key !== $expectedKey) {
                return false;
            }

            $expectedKey++;
        }

        return true;
    }
}

function manage_users_json_response(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($payload, JSON_UNESCAPED_SLASHES);
    exit;
}

function manage_users_api_request_first_success(string $method, array $endpoints, array $payload = [], ?string $token = null): array
{
    $lastResponse = [
        'success' => false,
        'status' => 0,
        'data' => null,
        'raw' => null,
        'error' => 'No API endpoint configured.',
    ];

    foreach ($endpoints as $endpoint) {
        $response = api_request($method, $endpoint, $payload, [], $token);
        $lastResponse = $response;

        if ($response['success']) {
            return $response;
        }

        if (in_array((int) ($response['status'] ?? 0), [400, 401, 403, 404, 409, 422], true)) {
            return $response;
        }
    }

    return $lastResponse;
}

function manage_users_message_from_response(array $response, string $fallback): string
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
    }

    if (!empty($response['raw']) && is_string($response['raw'])) {
        return trim($response['raw']);
    }

    return $fallback;
}

function manage_users_extract_list(array $responseData): array
{
    if (manage_users_array_is_list($responseData)) {
        return $responseData;
    }

    if (isset($responseData['items']) && is_array($responseData['items']) && manage_users_array_is_list($responseData['items'])) {
        return $responseData['items'];
    }

    if (isset($responseData['data']) && is_array($responseData['data'])) {
        if (manage_users_array_is_list($responseData['data'])) {
            return $responseData['data'];
        }

        if (isset($responseData['data']['items']) && is_array($responseData['data']['items']) && manage_users_array_is_list($responseData['data']['items'])) {
            return $responseData['data']['items'];
        }
    }

    return [];
}

function manage_users_paginate(array $items, int $page, int $perPage): array
{
    $total = count($items);
    $totalPages = max(1, (int) ceil($total / $perPage));
    $page = max(1, min($page, $totalPages));
    $offset = ($page - 1) * $perPage;

    return [
        'items' => array_slice($items, $offset, $perPage),
        'total' => $total,
        'page' => $page,
        'per_page' => $perPage,
        'total_pages' => $totalPages,
    ];
}

$token = auth_token();

if (isset($_GET['ajax'])) {
    if ($token === null || $token === '') {
        manage_users_json_response(['success' => false, 'message' => 'Your session has expired. Please login again.'], 401);
    }

    $action = (string) $_GET['ajax'];

    if ($action === 'bootstrap') {
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $perPage = 50;
        $search = strtolower(trim((string) ($_GET['search'] ?? '')));
        $response = manage_users_api_request_first_success('GET', ['api/users'], [], $token);

        if (!$response['success']) {
            manage_users_json_response([
                'success' => false,
                'message' => manage_users_message_from_response($response, 'Failed to load users.'),
            ], (int) ($response['status'] ?: 500));
        }

        $users = array_values(array_filter(
            manage_users_extract_list(is_array($response['data']) ? $response['data'] : []),
            static fn(mixed $item): bool => is_array($item)
        ));

        if ($search !== '') {
            $users = array_values(array_filter($users, static function (array $user) use ($search): bool {
                foreach (['name', 'username', 'email', 'cm_no', 'role'] as $field) {
                    if (str_contains(strtolower((string) ($user[$field] ?? '')), $search)) {
                        return true;
                    }
                }

                return false;
            }));
        }

        $pagination = manage_users_paginate($users, $page, $perPage);

        manage_users_json_response([
            'success' => true,
            'users' => $pagination['items'],
            'pagination' => [
                'page' => $pagination['page'],
                'per_page' => $pagination['per_page'],
                'total' => $pagination['total'],
                'total_pages' => $pagination['total_pages'],
            ],
        ]);
    }

    if ($action === 'save-user') {
        $input = json_decode(file_get_contents('php://input') ?: '{}', true);
        $payload = is_array($input) ? $input : [];
        $userId = isset($payload['id']) ? (int) $payload['id'] : 0;
        unset($payload['id']);

        $method = $userId > 0 ? 'PUT' : 'POST';
        $endpoint = $userId > 0 ? 'api/users/' . $userId : 'api/users';

        $response = manage_users_api_request_first_success($method, [$endpoint], $payload, $token);

        if (!$response['success']) {
            manage_users_json_response([
                'success' => false,
                'message' => manage_users_message_from_response($response, $userId > 0 ? 'Failed to update user.' : 'Failed to create user.'),
            ], (int) ($response['status'] ?: 500));
        }

        manage_users_json_response([
            'success' => true,
            'message' => $userId > 0 ? 'User updated successfully.' : 'User created successfully.',
            'user' => is_array($response['data']) ? $response['data'] : [],
        ]);
    }

    if ($action === 'delete-user') {
        $userId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        if ($userId <= 0) {
            manage_users_json_response(['success' => false, 'message' => 'Invalid user selected.'], 400);
        }

        $response = manage_users_api_request_first_success('DELETE', ['api/users/' . $userId], [], $token);

        if (!$response['success']) {
            manage_users_json_response([
                'success' => false,
                'message' => manage_users_message_from_response($response, 'Failed to delete user.'),
            ], (int) ($response['status'] ?: 500));
        }

        manage_users_json_response([
            'success' => true,
            'message' => 'User deleted successfully.',
        ]);
    }

    manage_users_json_response(['success' => false, 'message' => 'Invalid request.'], 400);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Users | NNGK</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="<?php echo htmlspecialchars(asset_url('assets/css/style.css'), ENT_QUOTES, 'UTF-8'); ?>">
<style>
body.page-manage-users { font-family:'Poppins',sans-serif; background:#eef3f8; color:#212529; }
body.page-manage-users .manage-shell { padding:20px; max-width:1280px; }
body.page-manage-users .manage-box { background:#fff; border:1px solid #d9e1ea; border-radius:10px; padding:18px; margin-bottom:14px; box-shadow:0 8px 24px rgba(15,23,42,.04); }
body.page-manage-users h1 { margin:0; font-size:24px; font-weight:700; color:#1f2937; }
body.page-manage-users .page-copy { margin-top:6px; color:#6b7280; font-size:13px; }
body.page-manage-users .top-actions { display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap; }
body.page-manage-users .toolbar { display:grid; grid-template-columns:minmax(280px, 420px) auto auto; gap:12px; align-items:center; }
body.page-manage-users .search-wrap { height:44px; border-radius:8px; background:#fff; border:1px solid #d4dce6; padding:0 14px; display:flex; align-items:center; gap:10px; }
body.page-manage-users .search-wrap i { color:#8a95a7; }
body.page-manage-users .search-input { width:100%; border:0; outline:none; background:transparent; color:#111827; font-size:14px; font-family:'Poppins',sans-serif; }
body.page-manage-users .result-count { color:#6b7280; font-size:12px; justify-self:end; }
body.page-manage-users .btn { display:inline-flex; align-items:center; justify-content:center; gap:7px; min-height:42px; padding:0 14px; border-radius:8px; border:1px solid transparent; text-decoration:none; font-size:12px; font-weight:600; cursor:pointer; font-family:'Poppins',sans-serif; }
body.page-manage-users .btn-add { background:#198754; color:#fff; }
body.page-manage-users .btn-muted { background:#6c757d; color:#fff; }
body.page-manage-users .btn-save { background:#198754; color:#fff; }
body.page-manage-users .btn-danger { background:#dc3545; color:#fff; }
body.page-manage-users .btn-edit { background:#0d6efd; color:#fff; }
body.page-manage-users .btn-close { background:#f6bd60; color:#3a2a11; }
body.page-manage-users .btn:disabled { opacity:.7; cursor:not-allowed; }
body.page-manage-users .table-shell { overflow:auto; border:1px solid #d9e1ea; border-radius:10px; background:#fff; }
body.page-manage-users .user-table { width:100%; border-collapse:collapse; min-width:860px; }
body.page-manage-users .user-table thead th { background:#f8fafc; color:#475569; font-size:12px; font-weight:600; text-align:left; padding:12px 14px; border-bottom:1px solid #d9e1ea; white-space:nowrap; }
body.page-manage-users .user-table tbody td { padding:14px; border-bottom:1px solid #edf1f5; vertical-align:top; font-size:12px; color:#1f2937; }
body.page-manage-users .user-table tbody tr:hover { background:#fbfdff; }
body.page-manage-users .user-table tbody tr:last-child td { border-bottom:0; }
body.page-manage-users .col-actions { width:96px; }
body.page-manage-users .cell-name { min-width:200px; }
body.page-manage-users .primary-text { font-size:13px; font-weight:600; color:#0f172a; }
body.page-manage-users .secondary-text { margin-top:3px; color:#6b7280; font-size:11px; }
body.page-manage-users .stack-text { display:flex; flex-direction:column; gap:3px; }
body.page-manage-users .badge { display:inline-flex; align-items:center; justify-content:center; min-height:24px; padding:0 10px; border-radius:999px; font-size:10px; font-weight:600; border:1px solid transparent; white-space:nowrap; }
body.page-manage-users .badge.role { background:#f3f4f6; color:#374151; border-color:#e5e7eb; }
body.page-manage-users .badge.status-active { background:#ecfdf3; color:#166534; border-color:#d1fadf; }
body.page-manage-users .badge.status-inactive { background:#f3f4f6; color:#4b5563; border-color:#e5e7eb; }
body.page-manage-users .badge.book-yes { background:#eff6ff; color:#1d4ed8; border-color:#dbeafe; }
body.page-manage-users .badge.book-no { background:#f3f4f6; color:#4b5563; border-color:#e5e7eb; }
body.page-manage-users .badge.fees-paid { background:#f3f4f6; color:#374151; border-color:#e5e7eb; }
body.page-manage-users .badge.fees-defaulter { background:#fef2f2; color:#b91c1c; border-color:#fecaca; }
body.page-manage-users .table-actions { display:flex; gap:8px; }
body.page-manage-users .action-btn { width:34px; height:34px; border-radius:8px; border:1px solid transparent; cursor:pointer; font-family:'Poppins',sans-serif; display:inline-flex; align-items:center; justify-content:center; }
body.page-manage-users .action-btn.edit { background:#ecfdf3; color:#198754; border-color:#cfe9db; }
body.page-manage-users .action-btn.delete { background:#fef2f2; color:#dc2626; border-color:#fecaca; }
body.page-manage-users .empty-box { background:#fff; border:1px dashed #cfd8e3; border-radius:10px; padding:36px 20px; text-align:center; color:#66758f; }
body.page-manage-users .empty-box i { font-size:30px; color:#7b8497; }
body.page-manage-users .empty-title { margin-top:10px; color:#102a56; font-weight:700; }
body.page-manage-users .pagination-bar { display:flex; justify-content:space-between; align-items:center; gap:12px; margin-top:14px; flex-wrap:wrap; }
body.page-manage-users .pagination-copy { color:#6b7280; font-size:12px; }
body.page-manage-users .pagination-actions { display:flex; gap:8px; align-items:center; }
body.page-manage-users .page-btn { min-width:38px; height:38px; border-radius:8px; border:1px solid #d6dde6; background:#fff; color:#374151; font-size:12px; font-weight:600; cursor:pointer; }
body.page-manage-users .page-btn:disabled { opacity:.5; cursor:not-allowed; }
body.page-manage-users .page-number { min-width:38px; height:38px; border-radius:8px; border:1px solid #d6dde6; background:#f8fafc; color:#111827; display:inline-flex; align-items:center; justify-content:center; font-size:12px; font-weight:600; padding:0 10px; }
body.page-manage-users .overlay { position:fixed; inset:0; background:rgba(15,23,42,.45); display:none; align-items:center; justify-content:center; padding:16px; z-index:1200; }
body.page-manage-users .overlay.show { display:flex; }
body.page-manage-users .modal-card { width:min(100%, 880px); max-height:86vh; overflow:hidden; background:#fff; border-radius:12px; border:1px solid #d9e1ea; box-shadow:0 24px 60px rgba(15,23,42,.18); display:flex; flex-direction:column; }
body.page-manage-users .notice-card { width:min(100%, 380px); background:#fff; border-radius:14px; border:1px solid #d9e1ea; padding:22px 20px; text-align:center; box-shadow:0 24px 60px rgba(15,23,42,.18); }
body.page-manage-users .modal-head { display:flex; justify-content:space-between; align-items:flex-start; gap:12px; padding:18px 20px 12px; border-bottom:1px solid #edf1f5; }
body.page-manage-users .modal-title { margin:0; font-size:18px; font-weight:700; color:#111827; }
body.page-manage-users .modal-hint { margin-top:4px; color:#6b7280; font-size:12px; }
body.page-manage-users .modal-body { padding:18px 20px 10px; overflow:auto; }
body.page-manage-users .modal-actions { display:flex; justify-content:flex-end; gap:10px; padding:14px 20px 20px; border-top:1px solid #edf1f5; }
body.page-manage-users .field-grid { display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:14px; }
body.page-manage-users .field.full { grid-column:1 / -1; }
body.page-manage-users .field-label { display:block; margin:0 0 6px; color:#374151; font-weight:600; font-size:12px; }
body.page-manage-users .input, body.page-manage-users .select { width:100%; border:1px solid #d6dde6; border-radius:8px; padding:10px 12px; background:#fff; color:#111827; font-family:'Poppins',sans-serif; font-size:13px; outline:none; }
body.page-manage-users .input:focus, body.page-manage-users .select:focus, body.page-manage-users .search-input:focus { border-color:#9ec5fe; box-shadow:0 0 0 3px rgba(13,110,253,.10); }
body.page-manage-users .notice-icon { width:52px; height:52px; border-radius:16px; background:#f8faff; display:flex; align-items:center; justify-content:center; margin:0 auto; }
body.page-manage-users .notice-title { margin:14px 0 0; color:#13233f; font-size:15px; font-weight:700; }
body.page-manage-users .notice-text { margin:8px 0 0; color:#6b7280; font-size:12.5px; line-height:1.55; }
body.page-manage-users .notice-actions { margin-top:18px; display:flex; justify-content:center; gap:10px; }
@media (max-width: 900px) {
    body.page-manage-users .manage-shell { padding:12px; }
    body.page-manage-users .toolbar { grid-template-columns:1fr; }
    body.page-manage-users .result-count { justify-self:start; }
    body.page-manage-users .field-grid { grid-template-columns:1fr; }
    body.page-manage-users .modal-actions { flex-direction:column; }
    body.page-manage-users .table-shell { border-radius:8px; }
    body.page-manage-users .user-table { min-width:760px; }
    body.page-manage-users .pagination-bar { align-items:flex-start; }
}
</style>
</head>
<body class="page-manage-users">
<?php include 'sidebar.php'; ?>
<main class="app manage-shell">
    <div class="manage-box">
        <div class="top-actions">
            <div>
                <h1>Manage Users</h1>
            </div>
            <button type="button" class="btn btn-add" id="openCreateBtn"><i class="fa-solid fa-plus"></i><span>Add User</span></button>
        </div>
    </div>

    <div class="manage-box">
        <div class="toolbar">
            <div class="search-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="searchInput" class="search-input" placeholder="Search users">
            </div>
            <div class="result-count" id="resultCount">0 records</div>
            <a href="<?php echo htmlspecialchars(app_url('admin_panel'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-muted"><i class="fa-solid fa-arrow-left"></i><span>Back</span></a>
        </div>
    </div>

    <div id="userList"></div>
    <div class="pagination-bar">
        <div class="pagination-copy" id="paginationCopy">Showing 0 of 0</div>
        <div class="pagination-actions">
            <button type="button" class="page-btn" id="prevPageBtn"><i class="fa-solid fa-chevron-left"></i></button>
            <span class="page-number" id="pageNumber">1 / 1</span>
            <button type="button" class="page-btn" id="nextPageBtn"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
    </div>
</main>

<div id="userModal" class="overlay" aria-hidden="true">
    <div class="modal-card">
        <div class="modal-head">
            <div>
                <h2 class="modal-title" id="modalTitle">Add User</h2>
                <div class="modal-hint" id="modalHint">Create a new user account.</div>
            </div>
            <button type="button" class="btn btn-close" id="closeModalBtn">Close</button>
        </div>
        <div class="modal-body">
            <div class="field-grid">
                <div class="field">
                    <label class="field-label" for="nameInput">Name</label>
                    <input class="input" id="nameInput" type="text" placeholder="Full name">
                </div>
                <div class="field">
                    <label class="field-label" for="usernameInput">Username</label>
                    <input class="input" id="usernameInput" type="text" placeholder="Username">
                </div>
                <div class="field">
                    <label class="field-label" for="emailInput">Email</label>
                    <input class="input" id="emailInput" type="email" placeholder="Email">
                </div>
                <div class="field">
                    <label class="field-label" for="cmNoInput">CM No</label>
                    <input class="input" id="cmNoInput" type="text" placeholder="CM No">
                </div>
                <div class="field full">
                    <label class="field-label" for="passwordInput" id="passwordLabel">Password</label>
                    <input class="input" id="passwordInput" type="password" placeholder="Password">
                </div>
                <div class="field">
                    <label class="field-label" for="roleInput">Role</label>
                    <select class="select" id="roleInput">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                        <option value="superadmin">Superadmin</option>
                    </select>
                </div>
                <div class="field">
                    <label class="field-label" for="statusInput">Status</label>
                    <select class="select" id="statusInput">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="field">
                    <label class="field-label" for="canBookInput">Can Book</label>
                    <select class="select" id="canBookInput">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <div class="field">
                    <label class="field-label" for="feesStatusInput">Fees Status</label>
                    <select class="select" id="feesStatusInput">
                        <option value="paid">Paid</option>
                        <option value="defaulter">Defaulter</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-actions">
            <button type="button" class="btn btn-muted" id="cancelModalBtn">Cancel</button>
            <button type="button" class="btn btn-save" id="saveUserBtn">Save</button>
        </div>
    </div>
</div>

<div id="noticeModal" class="overlay" aria-hidden="true">
    <div class="notice-card">
        <div class="notice-icon" id="noticeIcon"><i class="fa-solid fa-circle-info"></i></div>
        <h3 class="notice-title" id="noticeTitle">Notice</h3>
        <p class="notice-text" id="noticeText">Message</p>
        <div class="notice-actions" id="noticeActions">
            <button type="button" class="btn btn-muted" id="noticeOkBtn">OK</button>
        </div>
    </div>
</div>

<script>
const state = {
  users: [],
  editingUserId: null,
  saving: false,
  page: 1,
  perPage: 50,
  total: 0,
  totalPages: 1,
  search: '',
};

const elements = {
  userList: document.getElementById('userList'),
  resultCount: document.getElementById('resultCount'),
  paginationCopy: document.getElementById('paginationCopy'),
  pageNumber: document.getElementById('pageNumber'),
  prevPageBtn: document.getElementById('prevPageBtn'),
  nextPageBtn: document.getElementById('nextPageBtn'),
  searchInput: document.getElementById('searchInput'),
  openCreateBtn: document.getElementById('openCreateBtn'),
  userModal: document.getElementById('userModal'),
  closeModalBtn: document.getElementById('closeModalBtn'),
  cancelModalBtn: document.getElementById('cancelModalBtn'),
  saveUserBtn: document.getElementById('saveUserBtn'),
  modalTitle: document.getElementById('modalTitle'),
  modalHint: document.getElementById('modalHint'),
  passwordLabel: document.getElementById('passwordLabel'),
  noticeModal: document.getElementById('noticeModal'),
  noticeTitle: document.getElementById('noticeTitle'),
  noticeText: document.getElementById('noticeText'),
  noticeIcon: document.getElementById('noticeIcon'),
  noticeActions: document.getElementById('noticeActions'),
  noticeOkBtn: document.getElementById('noticeOkBtn'),
  fields: {
    name: document.getElementById('nameInput'),
    username: document.getElementById('usernameInput'),
    email: document.getElementById('emailInput'),
    cm_no: document.getElementById('cmNoInput'),
    password: document.getElementById('passwordInput'),
    role: document.getElementById('roleInput'),
    status: document.getElementById('statusInput'),
    can_book: document.getElementById('canBookInput'),
    fees_status: document.getElementById('feesStatusInput'),
  },
};

const ajaxBase = `${window.location.pathname}`;

function escapeHtml(value) {
  return String(value ?? '')
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}

function showNotice(title, text, type = 'info', actions = null) {
  elements.noticeTitle.textContent = title;
  elements.noticeText.textContent = text;

  const iconMap = {
    info: '<i class="fa-solid fa-circle-info" style="color:#2563eb;"></i>',
    success: '<i class="fa-solid fa-circle-check" style="color:#198754;"></i>',
    error: '<i class="fa-solid fa-circle-exclamation" style="color:#dc3545;"></i>',
    confirm: '<i class="fa-solid fa-triangle-exclamation" style="color:#f59e0b;"></i>',
  };

  elements.noticeIcon.innerHTML = iconMap[type] || iconMap.info;

  if (actions) {
    elements.noticeActions.innerHTML = actions;
    elements.noticeActions.querySelectorAll('[data-close-notice]').forEach((button) => {
      button.addEventListener('click', hideNotice);
    });
  } else {
    elements.noticeActions.innerHTML = '<button type="button" class="btn btn-muted" id="noticeOkInline">OK</button>';
    document.getElementById('noticeOkInline').addEventListener('click', hideNotice);
  }

  elements.noticeModal.classList.add('show');
}

function hideNotice() {
  elements.noticeModal.classList.remove('show');
}

function openModal(editingUser = null) {
  state.editingUserId = editingUser ? Number(editingUser.id) : null;
  elements.modalTitle.textContent = editingUser ? 'Edit User' : 'Add User';
  elements.modalHint.textContent = editingUser ? 'Update user access and account settings.' : 'Create a new user account.';
  elements.passwordLabel.textContent = editingUser ? 'Password (leave blank to keep same)' : 'Password';
  elements.saveUserBtn.textContent = editingUser ? 'Update' : 'Save';

  const values = editingUser || {
    name: '',
    username: '',
    email: '',
    cm_no: '',
    password: '',
    role: 'user',
    status: 'inactive',
    can_book: 'no',
    fees_status: 'paid',
  };

  Object.keys(elements.fields).forEach((key) => {
    elements.fields[key].value = values[key] ?? '';
  });

  elements.userModal.classList.add('show');
}

function closeModal() {
  elements.userModal.classList.remove('show');
  state.editingUserId = null;
}

function badgeClass(prefix, value) {
  return `${prefix}-${String(value || '').toLowerCase()}`;
}

function renderPagination() {
  const total = state.total;
  const start = total === 0 ? 0 : ((state.page - 1) * state.perPage) + 1;
  const end = total === 0 ? 0 : Math.min(state.page * state.perPage, total);

  elements.resultCount.textContent = `${total} record${total === 1 ? '' : 's'}`;
  elements.paginationCopy.textContent = `Showing ${start}-${end} of ${total}`;
  elements.pageNumber.textContent = `${state.page} / ${state.totalPages}`;
  elements.prevPageBtn.disabled = state.page <= 1;
  elements.nextPageBtn.disabled = state.page >= state.totalPages;
}

function renderUsers() {
  renderPagination();

  if (!state.users.length) {
    elements.userList.innerHTML = `
      <div class="empty-box">
        <i class="fa-solid fa-users"></i>
        <div class="empty-title">No users found.</div>
        <div style="margin-top:6px;">Tap Add User to create your first user.</div>
      </div>
    `;
    return;
  }

  elements.userList.innerHTML = `
    <div class="table-shell">
      <table class="user-table">
        <thead>
          <tr>
            <th class="col-actions">Actions</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>CM No</th>
            <th>Status</th>
            <th>Can Book</th>
            <th>Fees</th>
          </tr>
        </thead>
        <tbody>
          ${state.users.map((user) => `
            <tr>
              <td>
                <div class="table-actions">
                  <button type="button" class="action-btn edit" data-edit="${Number(user.id)}" title="Edit user" aria-label="Edit user">
                    <i class="fa-solid fa-pen"></i>
                  </button>
                  <button type="button" class="action-btn delete" data-delete="${Number(user.id)}" title="Delete user" aria-label="Delete user">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </div>
              </td>
              <td class="cell-name">
                <div class="primary-text">${escapeHtml(user.name || 'User')}</div>
                <div class="secondary-text">@${escapeHtml(user.username || '-')}</div>
              </td>
              <td>
                <div class="stack-text">
                  <span>${escapeHtml(user.email || '-')}</span>
                </div>
              </td>
              <td><span class="badge role">${escapeHtml(user.role || '-')}</span></td>
              <td>${escapeHtml(user.cm_no || '-')}</td>
              <td><span class="badge ${badgeClass('status', user.status || 'inactive')}">${escapeHtml(user.status || '-')}</span></td>
              <td><span class="badge ${badgeClass('book', user.can_book || 'no')}">${escapeHtml(user.can_book || '-')}</span></td>
              <td><span class="badge ${badgeClass('fees', user.fees_status || 'paid')}">${escapeHtml(user.fees_status || '-')}</span></td>
            </tr>
          `).join('')}
        </tbody>
      </table>
    </div>
  `;

  elements.userList.querySelectorAll('[data-edit]').forEach((button) => {
    button.addEventListener('click', () => {
      const userId = Number(button.getAttribute('data-edit'));
      openModal(state.users.find((item) => Number(item.id) === userId) || null);
    });
  });

  elements.userList.querySelectorAll('[data-delete]').forEach((button) => {
    button.addEventListener('click', () => confirmDelete(Number(button.getAttribute('data-delete'))));
  });
}

let searchTimeout = null;

function queueSearch() {
  window.clearTimeout(searchTimeout);
  searchTimeout = window.setTimeout(() => {
    state.search = elements.searchInput.value.trim();
    state.page = 1;
    loadUsers();
  }, 250);
}

async function requestJson(url, options = {}) {
  const response = await fetch(url, {
    credentials: 'same-origin',
    ...options,
    headers: {
      'Content-Type': 'application/json',
      ...(options.headers || {}),
    },
  });

  const data = await response.json().catch(() => ({}));

  if (!response.ok || data.success === false) {
    throw new Error(data.message || 'Something went wrong.');
  }

  return data;
}

async function loadUsers() {
  elements.userList.innerHTML = '<div class="empty-box"><i class="fa-solid fa-spinner fa-spin"></i><div class="empty-title">Loading users...</div></div>';

  try {
    const params = new URLSearchParams({
      ajax: 'bootstrap',
      page: String(state.page),
      search: state.search,
    });
    const data = await requestJson(`${ajaxBase}?${params.toString()}`);
    state.users = Array.isArray(data.users) ? data.users : [];
    state.page = Number(data.pagination?.page || 1);
    state.perPage = Number(data.pagination?.per_page || 50);
    state.total = Number(data.pagination?.total || 0);
    state.totalPages = Number(data.pagination?.total_pages || 1);
    renderUsers();
  } catch (error) {
    if (/permission|forbidden|unauthorized|admin/i.test(String(error.message || ''))) {
      elements.userList.innerHTML = '<div class="empty-box"><i class="fa-solid fa-lock"></i><div class="empty-title">Access denied.</div><div style="margin-top:6px;">You do not have permission to manage users.</div></div>';
      elements.resultCount.textContent = '0 records';
      elements.paginationCopy.textContent = 'Showing 0-0 of 0';
      elements.pageNumber.textContent = '1 / 1';
      elements.prevPageBtn.disabled = true;
      elements.nextPageBtn.disabled = true;
      return;
    }

    showNotice('Users Unavailable', error.message || 'Failed to load users.', 'error');
    state.users = [];
    state.total = 0;
    state.totalPages = 1;
    renderUsers();
  }
}

function collectPayload() {
  return {
    id: state.editingUserId,
    name: elements.fields.name.value.trim(),
    username: elements.fields.username.value.trim(),
    email: elements.fields.email.value.trim(),
    cm_no: elements.fields.cm_no.value.trim(),
    password: elements.fields.password.value.trim(),
    role: elements.fields.role.value,
    status: elements.fields.status.value,
    can_book: elements.fields.can_book.value,
    fees_status: elements.fields.fees_status.value,
  };
}

function validatePayload(payload) {
  if (!payload.name || !payload.username || !payload.email) {
    showNotice('Validation', 'Name, username, and email are required.', 'error');
    return false;
  }

  if (!state.editingUserId && !payload.password) {
    showNotice('Validation', 'Password is required for new user.', 'error');
    return false;
  }

  return true;
}

async function saveUser() {
  if (state.saving) return;

  const payload = collectPayload();

  if (!validatePayload(payload)) return;

  state.saving = true;
  elements.saveUserBtn.disabled = true;
  elements.saveUserBtn.textContent = state.editingUserId ? 'Updating...' : 'Saving...';

  try {
    await requestJson(`${ajaxBase}?ajax=save-user`, {
      method: 'POST',
      body: JSON.stringify(payload),
    });

    closeModal();
    await loadUsers();
    showNotice('Success', state.editingUserId ? 'User updated successfully.' : 'User created successfully.', 'success');
  } catch (error) {
    showNotice('Save Failed', error.message || 'Failed to save user.', 'error');
  } finally {
    state.saving = false;
    elements.saveUserBtn.disabled = false;
    elements.saveUserBtn.textContent = state.editingUserId ? 'Update' : 'Save';
  }
}

function confirmDelete(userId) {
  const user = state.users.find((item) => Number(item.id) === userId);
  showNotice(
    'Delete User',
    `Delete ${user?.name || 'this user'}?`,
    'confirm',
    `
      <button type="button" class="btn btn-muted" data-close-notice>Cancel</button>
      <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
    `
  );

  document.getElementById('confirmDeleteBtn').addEventListener('click', async () => {
    hideNotice();

    try {
      await requestJson(`${ajaxBase}?ajax=delete-user&id=${encodeURIComponent(userId)}`, {
        method: 'POST',
      });
      await loadUsers();
      showNotice('Deleted', 'User deleted successfully.', 'success');
    } catch (error) {
      showNotice('Delete Failed', error.message || 'Failed to delete user.', 'error');
    }
  }, { once: true });
}

elements.searchInput.addEventListener('input', queueSearch);
elements.openCreateBtn.addEventListener('click', () => openModal());
elements.closeModalBtn.addEventListener('click', closeModal);
elements.cancelModalBtn.addEventListener('click', closeModal);
elements.saveUserBtn.addEventListener('click', saveUser);
elements.noticeOkBtn.addEventListener('click', hideNotice);
elements.prevPageBtn.addEventListener('click', () => {
  if (state.page > 1) {
    state.page -= 1;
    loadUsers();
  }
});
elements.nextPageBtn.addEventListener('click', () => {
  if (state.page < state.totalPages) {
    state.page += 1;
    loadUsers();
  }
});
elements.userModal.addEventListener('click', (event) => {
  if (event.target === elements.userModal) closeModal();
});
elements.noticeModal.addEventListener('click', (event) => {
  if (event.target === elements.noticeModal) hideNotice();
});

loadUsers();
</script>
</body>
</html>
