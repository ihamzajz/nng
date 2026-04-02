<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

require_admin();

if (!function_exists('manage_court_array_is_list')) {
    function manage_court_array_is_list(array $array): bool
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

function manage_court_json_response(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($payload, JSON_UNESCAPED_SLASHES);
    exit;
}

function manage_court_message_from_response(array $response, string $fallback): string
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

function manage_court_extract_list(array $responseData): array
{
    if (manage_court_array_is_list($responseData)) {
        return $responseData;
    }

    if (isset($responseData['items']) && is_array($responseData['items']) && manage_court_array_is_list($responseData['items'])) {
        return $responseData['items'];
    }

    if (isset($responseData['data']) && is_array($responseData['data'])) {
        if (manage_court_array_is_list($responseData['data'])) {
            return $responseData['data'];
        }

        if (isset($responseData['data']['items']) && is_array($responseData['data']['items']) && manage_court_array_is_list($responseData['data']['items'])) {
            return $responseData['data']['items'];
        }
    }

    return [];
}

function manage_court_api_request_first_success(string $method, array $endpoints, array $payload = [], ?string $token = null): array
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

function manage_court_api_multipart_request(string $method, string $endpoint, array $fields = [], array $file = [], ?string $token = null): array
{
    $curl = curl_init();
    $requestHeaders = ['Accept: application/json'];

    if ($token !== null && $token !== '') {
        $requestHeaders[] = 'Authorization: Bearer ' . $token;
    }

    $postFields = $fields;

    if (!empty($file['tmp_name']) && is_uploaded_file($file['tmp_name'])) {
        $postFields['picture'] = new CURLFile(
            $file['tmp_name'],
            $file['type'] ?: 'image/jpeg',
            $file['name'] ?: ('court-' . time() . '.jpg')
        );
    }

    curl_setopt_array($curl, [
        CURLOPT_URL => api($endpoint),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => strtoupper($method),
        CURLOPT_HTTPHEADER => $requestHeaders,
        CURLOPT_POSTFIELDS => $postFields,
        CURLOPT_TIMEOUT => (int) config('api_timeout', 30),
    ]);

    $responseBody = curl_exec($curl);
    $statusCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curlError = curl_error($curl);
    curl_close($curl);

    $decodedBody = null;

    if (is_string($responseBody) && $responseBody !== '') {
        $decodedBody = json_decode($responseBody, true);
    }

    return [
        'success' => $curlError === '' && $statusCode >= 200 && $statusCode < 300,
        'status' => $statusCode,
        'data' => $decodedBody,
        'raw' => is_string($responseBody) ? $responseBody : null,
        'error' => $curlError !== '' ? $curlError : null,
    ];
}

$token = auth_token();

if (isset($_GET['ajax'])) {
    $action = (string) $_GET['ajax'];

    if ($action === 'bootstrap') {
        $response = manage_court_api_request_first_success('GET', ['api/courts'], [], $token);

        if (!$response['success']) {
            manage_court_json_response([
                'success' => false,
                'message' => manage_court_message_from_response($response, 'Failed to load courts.'),
            ], (int) ($response['status'] ?: 500));
        }

        manage_court_json_response([
            'success' => true,
            'courts' => manage_court_extract_list(is_array($response['data']) ? $response['data'] : []),
            'apiBase' => rtrim((string) config('api', ''), '/'),
        ]);
    }

    if ($action === 'save-court') {
        $courtId = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        $name = trim((string) ($_POST['name'] ?? ''));

        if ($name === '') {
            manage_court_json_response(['success' => false, 'message' => 'Court name is required.'], 400);
        }

        $method = $courtId > 0 ? 'PUT' : 'POST';
        $endpoint = $courtId > 0 ? 'api/courts/' . $courtId : 'api/courts';

        $response = manage_court_api_multipart_request($method, $endpoint, ['name' => $name], $_FILES['picture'] ?? [], $token);

        if (!$response['success']) {
            manage_court_json_response([
                'success' => false,
                'message' => manage_court_message_from_response($response, $courtId > 0 ? 'Failed to update court.' : 'Failed to create court.'),
            ], (int) ($response['status'] ?: 500));
        }

        manage_court_json_response([
            'success' => true,
            'message' => $courtId > 0 ? 'Court updated successfully.' : 'Court created successfully.',
            'court' => is_array($response['data']) ? $response['data'] : [],
        ]);
    }

    if ($action === 'delete-court') {
        $courtId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        if ($courtId <= 0) {
            manage_court_json_response(['success' => false, 'message' => 'Invalid court selected.'], 400);
        }

        $response = manage_court_api_request_first_success('DELETE', ['api/courts/' . $courtId], [], $token);

        if (!$response['success']) {
            manage_court_json_response([
                'success' => false,
                'message' => manage_court_message_from_response($response, 'Failed to delete court.'),
            ], (int) ($response['status'] ?: 500));
        }

        manage_court_json_response([
            'success' => true,
            'message' => 'Court deleted successfully.',
        ]);
    }

    manage_court_json_response(['success' => false, 'message' => 'Invalid request.'], 400);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Courts | NNGK</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" referrerpolicy="no-referrer" />
<link rel="icon" type="image/png" href="<?php echo htmlspecialchars(asset_url('assets/images/icon.png'), ENT_QUOTES, 'UTF-8'); ?>">
<link rel="stylesheet" href="<?php echo htmlspecialchars(asset_url('assets/css/style.css'), ENT_QUOTES, 'UTF-8'); ?>">
<style>
body.page-manage-court { font-family:'Poppins',sans-serif; background:#eef3f8; color:#212529; }
body.page-manage-court .manage-shell { padding:20px; max-width:1280px; }
body.page-manage-court .manage-box { background:#fff; border:1px solid #d9e1ea; border-radius:10px; padding:18px; margin-bottom:14px; box-shadow:0 8px 24px rgba(15,23,42,.04); }
body.page-manage-court h1 { margin:0; font-size:24px; font-weight:700; color:#1f2937; }
body.page-manage-court .toolbar { display:grid; grid-template-columns:minmax(280px, 420px) auto auto; gap:12px; align-items:center; }
body.page-manage-court .search-wrap { height:44px; border-radius:8px; background:#fff; border:1px solid #d4dce6; padding:0 14px; display:flex; align-items:center; gap:10px; }
body.page-manage-court .search-wrap i { color:#8a95a7; }
body.page-manage-court .search-input { width:100%; border:0; outline:none; background:transparent; color:#111827; font-size:14px; font-family:'Poppins',sans-serif; }
body.page-manage-court .result-count { color:#6b7280; font-size:12px; justify-self:end; }
body.page-manage-court .btn { display:inline-flex; align-items:center; justify-content:center; gap:7px; min-height:42px; padding:0 14px; border-radius:8px; border:1px solid transparent; text-decoration:none; font-size:12px; font-weight:600; cursor:pointer; font-family:'Poppins',sans-serif; }
body.page-manage-court .btn-add { background:#198754; color:#fff; }
body.page-manage-court .btn-muted { background:#6c757d; color:#fff; }
body.page-manage-court .btn-save { background:#198754; color:#fff; }
body.page-manage-court .btn-danger { background:#dc3545; color:#fff; }
body.page-manage-court .btn-close { background:#f6bd60; color:#3a2a11; }
body.page-manage-court .table-shell { overflow:auto; border:1px solid #d9e1ea; border-radius:10px; background:#fff; }
body.page-manage-court .court-table { width:100%; border-collapse:collapse; min-width:860px; }
body.page-manage-court .court-table thead th { background:#f8fafc; color:#475569; font-size:12px; font-weight:600; text-align:left; padding:12px 14px; border-bottom:1px solid #d9e1ea; white-space:nowrap; }
body.page-manage-court .court-table tbody td { padding:14px; border-bottom:1px solid #edf1f5; vertical-align:middle; font-size:12px; color:#1f2937; }
body.page-manage-court .court-table tbody tr:hover { background:#fbfdff; }
body.page-manage-court .court-table tbody tr:last-child td { border-bottom:0; }
body.page-manage-court .thumb { width:116px; height:72px; border-radius:10px; object-fit:cover; background:#eef2ff; border:1px solid #e5e7eb; }
body.page-manage-court .thumb-placeholder { width:116px; height:72px; border-radius:10px; background:#f8fafc; border:1px dashed #d4dce6; display:flex; align-items:center; justify-content:center; color:#6b7280; font-size:11px; }
body.page-manage-court .court-name { font-size:13px; font-weight:600; color:#0f172a; }
body.page-manage-court .action-wrap { display:flex; gap:8px; }
body.page-manage-court .icon-btn { width:34px; height:34px; border-radius:8px; border:1px solid transparent; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; }
body.page-manage-court .icon-btn.edit { background:#ecfdf3; color:#198754; border-color:#cfe9db; }
body.page-manage-court .icon-btn.delete { background:#fef2f2; color:#dc2626; border-color:#fecaca; }
body.page-manage-court .empty-box { background:#fff; border:1px dashed #cfd8e3; border-radius:10px; padding:36px 20px; text-align:center; color:#66758f; }
body.page-manage-court .empty-box i { font-size:30px; color:#7b8497; }
body.page-manage-court .empty-title { margin-top:10px; color:#102a56; font-weight:700; }
body.page-manage-court .overlay { position:fixed; inset:0; background:rgba(15,23,42,.45); display:none; align-items:center; justify-content:center; padding:16px; z-index:1200; }
body.page-manage-court .overlay.show { display:flex; }
body.page-manage-court .modal-card { width:min(100%, 760px); background:#fff; border-radius:12px; border:1px solid #d9e1ea; box-shadow:0 24px 60px rgba(15,23,42,.18); overflow:hidden; }
body.page-manage-court .notice-card { width:min(100%, 380px); background:#fff; border-radius:14px; border:1px solid #d9e1ea; padding:22px 20px; text-align:center; box-shadow:0 24px 60px rgba(15,23,42,.18); }
body.page-manage-court .modal-head { display:flex; justify-content:space-between; align-items:flex-start; gap:12px; padding:18px 20px 12px; border-bottom:1px solid #edf1f5; }
body.page-manage-court .modal-title { margin:0; font-size:18px; font-weight:700; color:#111827; }
body.page-manage-court .modal-hint { margin-top:4px; color:#6b7280; font-size:12px; }
body.page-manage-court .modal-body { padding:18px 20px 10px; }
body.page-manage-court .modal-actions { display:flex; justify-content:flex-end; gap:10px; padding:14px 20px 20px; border-top:1px solid #edf1f5; }
body.page-manage-court .field-label { display:block; margin:0 0 6px; color:#374151; font-weight:600; font-size:12px; }
body.page-manage-court .input { width:100%; border:1px solid #d6dde6; border-radius:8px; padding:10px 12px; background:#fff; color:#111827; font-family:'Poppins',sans-serif; font-size:13px; outline:none; }
body.page-manage-court .input:focus, body.page-manage-court .search-input:focus { border-color:#9ec5fe; box-shadow:0 0 0 3px rgba(13,110,253,.10); }
body.page-manage-court .pick-btn { margin-top:12px; }
body.page-manage-court .preview-wrap { margin-top:14px; }
body.page-manage-court .preview { width:100%; max-height:220px; object-fit:cover; border-radius:10px; border:1px solid #e5e7eb; background:#eef2ff; }
body.page-manage-court .preview-placeholder { width:100%; height:180px; border-radius:10px; background:#f8fafc; border:1px dashed #d4dce6; display:flex; align-items:center; justify-content:center; color:#6b7280; font-size:12px; }
body.page-manage-court .notice-icon { width:52px; height:52px; border-radius:16px; background:#f8faff; display:flex; align-items:center; justify-content:center; margin:0 auto; }
body.page-manage-court .notice-title { margin:14px 0 0; color:#13233f; font-size:15px; font-weight:700; }
body.page-manage-court .notice-text { margin:8px 0 0; color:#6b7280; font-size:12.5px; line-height:1.55; }
body.page-manage-court .notice-actions { margin-top:18px; display:flex; justify-content:center; gap:10px; }
@media (max-width: 900px) {
    body.page-manage-court .manage-shell { padding:12px; }
    body.page-manage-court .toolbar { grid-template-columns:1fr; }
    body.page-manage-court .result-count { justify-self:start; }
    body.page-manage-court .modal-actions { flex-direction:column; }
    body.page-manage-court .court-table { min-width:700px; }
}
</style>
</head>
<body class="page-manage-court">
<?php include 'sidebar.php'; ?>
<main class="app manage-shell">
    <div class="manage-box">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
            <h1>Manage Courts</h1>
            <button type="button" class="btn btn-add" id="openCreateBtn"><i class="fa-solid fa-plus"></i><span>Add Court</span></button>
        </div>
    </div>

    <div class="manage-box">
        <div class="toolbar">
            <div class="search-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="searchInput" class="search-input" placeholder="Search courts">
            </div>
            <div class="result-count" id="resultCount">0 records</div>
            <a href="<?php echo htmlspecialchars(app_url('admin_panel'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-muted"><i class="fa-solid fa-arrow-left"></i><span>Back</span></a>
        </div>
    </div>

    <div id="courtList"></div>
</main>

<div id="courtModal" class="overlay" aria-hidden="true">
    <div class="modal-card">
        <div class="modal-head">
            <div>
                <h2 class="modal-title" id="modalTitle">Add Court</h2>
                <div class="modal-hint" id="modalHint">Give it a name and optional image.</div>
            </div>
            <button type="button" class="btn btn-close" id="closeModalBtn">Close</button>
        </div>
        <div class="modal-body">
            <label class="field-label" for="nameInput">Court Name</label>
            <input class="input" id="nameInput" type="text" placeholder="e.g. Center Court">

            <div class="pick-btn">
                <button type="button" class="btn btn-muted" id="pickImageBtn"><i class="fa-solid fa-image"></i><span>Pick Image</span></button>
                <input type="file" id="imageInput" accept="image/png,image/jpeg,image/jpg" hidden>
            </div>

            <div class="preview-wrap" id="previewWrap">
                <div class="preview-placeholder">No image selected</div>
            </div>
        </div>
        <div class="modal-actions">
            <button type="button" class="btn btn-muted" id="cancelModalBtn">Cancel</button>
            <button type="button" class="btn btn-save" id="saveCourtBtn">Save</button>
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
  courts: [],
  filteredCourts: [],
  editingCourtId: null,
  editingCourtPicture: '',
  saving: false,
  selectedFile: null,
  apiBase: '',
};

const elements = {
  courtList: document.getElementById('courtList'),
  resultCount: document.getElementById('resultCount'),
  searchInput: document.getElementById('searchInput'),
  openCreateBtn: document.getElementById('openCreateBtn'),
  courtModal: document.getElementById('courtModal'),
  closeModalBtn: document.getElementById('closeModalBtn'),
  cancelModalBtn: document.getElementById('cancelModalBtn'),
  saveCourtBtn: document.getElementById('saveCourtBtn'),
  modalTitle: document.getElementById('modalTitle'),
  modalHint: document.getElementById('modalHint'),
  nameInput: document.getElementById('nameInput'),
  pickImageBtn: document.getElementById('pickImageBtn'),
  imageInput: document.getElementById('imageInput'),
  previewWrap: document.getElementById('previewWrap'),
  noticeModal: document.getElementById('noticeModal'),
  noticeTitle: document.getElementById('noticeTitle'),
  noticeText: document.getElementById('noticeText'),
  noticeIcon: document.getElementById('noticeIcon'),
  noticeActions: document.getElementById('noticeActions'),
  noticeOkBtn: document.getElementById('noticeOkBtn'),
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

function courtImageUrl(filename) {
  if (!filename) return '';
  if (!state.apiBase) return <?php echo json_encode(asset_url('assets/images/icon.png')); ?>;
  return `${state.apiBase}/uploads/courts/${String(filename).replace(/^\/+/, '')}?v=${Date.now()}`;
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

function renderPreview() {
  if (state.selectedFile) {
    const src = URL.createObjectURL(state.selectedFile);
    elements.previewWrap.innerHTML = `<img src="${src}" alt="Preview" class="preview">`;
    return;
  }

  if (state.editingCourtPicture) {
    elements.previewWrap.innerHTML = `<img src="${courtImageUrl(state.editingCourtPicture)}" alt="Court" class="preview">`;
    return;
  }

  elements.previewWrap.innerHTML = '<div class="preview-placeholder">No image selected</div>';
}

function openModal(court = null) {
  state.editingCourtId = court ? Number(court.id) : null;
  state.editingCourtPicture = court?.picture || '';
  state.selectedFile = null;
  elements.nameInput.value = court?.name || '';
  elements.modalTitle.textContent = court ? 'Edit Court' : 'Add Court';
  elements.modalHint.textContent = court ? 'Update name and/or image.' : 'Give it a name and optional image.';
  elements.saveCourtBtn.textContent = court ? 'Update' : 'Save';
  renderPreview();
  elements.courtModal.classList.add('show');
}

function closeModal() {
  elements.courtModal.classList.remove('show');
  state.editingCourtId = null;
  state.editingCourtPicture = '';
  state.selectedFile = null;
  elements.nameInput.value = '';
  elements.imageInput.value = '';
  renderPreview();
}

function filterCourts() {
  const searchValue = elements.searchInput.value.trim().toLowerCase();
  state.filteredCourts = state.courts.filter((court) => {
    if (!searchValue) return true;
    return String(court.name || '').toLowerCase().includes(searchValue);
  });
  renderCourts();
}

function renderCourts() {
  elements.resultCount.textContent = `${state.filteredCourts.length} record${state.filteredCourts.length === 1 ? '' : 's'}`;

  if (!state.filteredCourts.length) {
    elements.courtList.innerHTML = `
      <div class="empty-box">
        <i class="fa-solid fa-table-cells-large"></i>
        <div class="empty-title">No courts found.</div>
        <div style="margin-top:6px;">Tap Add Court to create your first court.</div>
      </div>
    `;
    return;
  }

  elements.courtList.innerHTML = `
    <div class="table-shell">
      <table class="court-table">
        <thead>
          <tr>
            <th>Actions</th>
            <th>Image</th>
            <th>Court Name</th>
          </tr>
        </thead>
        <tbody>
          ${state.filteredCourts.map((court) => `
            <tr>
              <td>
                <div class="action-wrap">
                  <button type="button" class="icon-btn edit" data-edit="${Number(court.id)}" title="Edit court" aria-label="Edit court">
                    <i class="fa-solid fa-pen"></i>
                  </button>
                  <button type="button" class="icon-btn delete" data-delete="${Number(court.id)}" title="Delete court" aria-label="Delete court">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </div>
              </td>
              <td>
                ${court.picture
                  ? `<img src="${courtImageUrl(court.picture)}" alt="${escapeHtml(court.name || 'Court')}" class="thumb">`
                  : '<div class="thumb-placeholder">No Image</div>'}
              </td>
              <td><div class="court-name">${escapeHtml(court.name || 'Court')}</div></td>
            </tr>
          `).join('')}
        </tbody>
      </table>
    </div>
  `;

  elements.courtList.querySelectorAll('[data-edit]').forEach((button) => {
    button.addEventListener('click', () => {
      const courtId = Number(button.getAttribute('data-edit'));
      openModal(state.courts.find((item) => Number(item.id) === courtId) || null);
    });
  });

  elements.courtList.querySelectorAll('[data-delete]').forEach((button) => {
    button.addEventListener('click', () => confirmDelete(Number(button.getAttribute('data-delete'))));
  });
}

async function requestJson(url, options = {}) {
  const response = await fetch(url, {
    credentials: 'same-origin',
    ...options,
  });

  const data = await response.json().catch(() => ({}));

  if (!response.ok || data.success === false) {
    throw new Error(data.message || 'Something went wrong.');
  }

  return data;
}

async function loadCourts() {
  elements.courtList.innerHTML = '<div class="empty-box"><i class="fa-solid fa-spinner fa-spin"></i><div class="empty-title">Loading courts...</div></div>';

  try {
    const data = await requestJson(`${ajaxBase}?ajax=bootstrap`);
    state.courts = Array.isArray(data.courts) ? data.courts : [];
    state.apiBase = String(data.apiBase || '');
    filterCourts();
  } catch (error) {
    showNotice('Courts Unavailable', error.message || 'Failed to load courts.', 'error');
    state.courts = [];
    filterCourts();
  }
}

async function saveCourt() {
  const name = elements.nameInput.value.trim();

  if (!name) {
    showNotice('Validation', 'Court name is required.', 'error');
    return;
  }

  state.saving = true;
  elements.saveCourtBtn.disabled = true;
  elements.saveCourtBtn.textContent = state.editingCourtId ? 'Updating...' : 'Saving...';

  try {
    const formData = new FormData();
    formData.append('name', name);
    if (state.editingCourtId) {
      formData.append('id', String(state.editingCourtId));
    }
    if (state.selectedFile) {
      formData.append('picture', state.selectedFile);
    }

    await fetch(`${ajaxBase}?ajax=save-court`, {
      method: 'POST',
      body: formData,
      credentials: 'same-origin',
    }).then(async (response) => {
      const data = await response.json().catch(() => ({}));
      if (!response.ok || data.success === false) {
        throw new Error(data.message || 'Failed to save court.');
      }
    });

    closeModal();
    await loadCourts();
    showNotice('Success', state.editingCourtId ? 'Court updated successfully.' : 'Court created successfully.', 'success');
  } catch (error) {
    showNotice('Save Failed', error.message || 'Failed to save court.', 'error');
  } finally {
    state.saving = false;
    elements.saveCourtBtn.disabled = false;
    elements.saveCourtBtn.textContent = state.editingCourtId ? 'Update' : 'Save';
  }
}

function confirmDelete(courtId) {
  const court = state.courts.find((item) => Number(item.id) === courtId);
  showNotice(
    'Delete Court',
    `Delete ${court?.name || 'this court'}?`,
    'confirm',
    `
      <button type="button" class="btn btn-muted" data-close-notice>Cancel</button>
      <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
    `
  );

  document.getElementById('confirmDeleteBtn').addEventListener('click', async () => {
    hideNotice();

    try {
      await requestJson(`${ajaxBase}?ajax=delete-court&id=${encodeURIComponent(courtId)}`, {
        method: 'POST',
      });
      await loadCourts();
      showNotice('Deleted', 'Court deleted successfully.', 'success');
    } catch (error) {
      showNotice('Delete Failed', error.message || 'Failed to delete court.', 'error');
    }
  }, { once: true });
}

elements.searchInput.addEventListener('input', filterCourts);
elements.openCreateBtn.addEventListener('click', () => openModal());
elements.closeModalBtn.addEventListener('click', closeModal);
elements.cancelModalBtn.addEventListener('click', closeModal);
elements.pickImageBtn.addEventListener('click', () => elements.imageInput.click());
elements.imageInput.addEventListener('change', () => {
  state.selectedFile = elements.imageInput.files && elements.imageInput.files[0] ? elements.imageInput.files[0] : null;
  renderPreview();
});
elements.saveCourtBtn.addEventListener('click', saveCourt);
elements.noticeOkBtn.addEventListener('click', hideNotice);
elements.courtModal.addEventListener('click', (event) => {
  if (event.target === elements.courtModal) closeModal();
});
elements.noticeModal.addEventListener('click', (event) => {
  if (event.target === elements.noticeModal) hideNotice();
});

loadCourts();
</script>
</body>
</html>
