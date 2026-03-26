<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

require_admin();

if (!function_exists('manage_event_array_is_list')) {
    function manage_event_array_is_list(array $array): bool
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

function manage_event_json_response(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($payload, JSON_UNESCAPED_SLASHES);
    exit;
}

function manage_event_message_from_response(array $response, string $fallback): string
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

function manage_event_extract_list(array $responseData): array
{
    if (manage_event_array_is_list($responseData)) {
        return $responseData;
    }

    if (isset($responseData['items']) && is_array($responseData['items']) && manage_event_array_is_list($responseData['items'])) {
        return $responseData['items'];
    }

    if (isset($responseData['data']) && is_array($responseData['data'])) {
        if (manage_event_array_is_list($responseData['data'])) {
            return $responseData['data'];
        }

        if (isset($responseData['data']['items']) && is_array($responseData['data']['items']) && manage_event_array_is_list($responseData['data']['items'])) {
            return $responseData['data']['items'];
        }
    }

    return [];
}

function manage_event_api_request_first_success(string $method, array $endpoints, array $payload = [], ?string $token = null): array
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

function manage_event_api_multipart_request(string $method, string $endpoint, array $fields = [], array $file = [], ?string $token = null): array
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
            $file['name'] ?: ('event-' . time() . '.jpg')
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
        $response = manage_event_api_request_first_success('GET', ['api/events'], [], $token);

        if (!$response['success']) {
            manage_event_json_response([
                'success' => false,
                'message' => manage_event_message_from_response($response, 'Failed to load venues.'),
            ], (int) ($response['status'] ?: 500));
        }

        manage_event_json_response([
            'success' => true,
            'events' => manage_event_extract_list(is_array($response['data']) ? $response['data'] : []),
            'apiBase' => rtrim((string) config('api', ''), '/'),
        ]);
    }

    if ($action === 'save-event') {
        $eventId = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        $name = trim((string) ($_POST['name'] ?? ''));

        if ($name === '') {
            manage_event_json_response(['success' => false, 'message' => 'Venue name is required.'], 400);
        }

        $method = $eventId > 0 ? 'PUT' : 'POST';
        $endpoint = $eventId > 0 ? 'api/events/' . $eventId : 'api/events';

        $response = manage_event_api_multipart_request($method, $endpoint, ['name' => $name], $_FILES['picture'] ?? [], $token);

        if (!$response['success']) {
            manage_event_json_response([
                'success' => false,
                'message' => manage_event_message_from_response($response, $eventId > 0 ? 'Failed to update venue.' : 'Failed to create venue.'),
            ], (int) ($response['status'] ?: 500));
        }

        manage_event_json_response([
            'success' => true,
            'message' => $eventId > 0 ? 'Venue updated successfully.' : 'Venue created successfully.',
            'event' => is_array($response['data']) ? $response['data'] : [],
        ]);
    }

    if ($action === 'delete-event') {
        $eventId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        if ($eventId <= 0) {
            manage_event_json_response(['success' => false, 'message' => 'Invalid venue selected.'], 400);
        }

        $response = manage_event_api_request_first_success('DELETE', ['api/events/' . $eventId], [], $token);

        if (!$response['success']) {
            manage_event_json_response([
                'success' => false,
                'message' => manage_event_message_from_response($response, 'Failed to delete venue.'),
            ], (int) ($response['status'] ?: 500));
        }

        manage_event_json_response([
            'success' => true,
            'message' => 'Venue deleted successfully.',
        ]);
    }

    manage_event_json_response(['success' => false, 'message' => 'Invalid request.'], 400);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Events | NNGK</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" referrerpolicy="no-referrer" />
<link rel="icon" type="image/png" href="<?php echo htmlspecialchars(asset_url('assets/images/icon.png'), ENT_QUOTES, 'UTF-8'); ?>">
<link rel="stylesheet" href="<?php echo htmlspecialchars(asset_url('assets/css/style.css'), ENT_QUOTES, 'UTF-8'); ?>">
<style>
body.page-manage-event { font-family:'Poppins',sans-serif; background:#eef3f8; color:#212529; }
body.page-manage-event .manage-shell { padding:20px; max-width:1280px; }
body.page-manage-event .manage-box { background:#fff; border:1px solid #d9e1ea; border-radius:10px; padding:18px; margin-bottom:14px; box-shadow:0 8px 24px rgba(15,23,42,.04); }
body.page-manage-event h1 { margin:0; font-size:24px; font-weight:700; color:#1f2937; }
body.page-manage-event .toolbar { display:grid; grid-template-columns:minmax(280px, 420px) auto auto; gap:12px; align-items:center; }
body.page-manage-event .search-wrap { height:44px; border-radius:8px; background:#fff; border:1px solid #d4dce6; padding:0 14px; display:flex; align-items:center; gap:10px; }
body.page-manage-event .search-wrap i { color:#8a95a7; }
body.page-manage-event .search-input { width:100%; border:0; outline:none; background:transparent; color:#111827; font-size:14px; font-family:'Poppins',sans-serif; }
body.page-manage-event .result-count { color:#6b7280; font-size:12px; justify-self:end; }
body.page-manage-event .btn { display:inline-flex; align-items:center; justify-content:center; gap:7px; min-height:42px; padding:0 14px; border-radius:8px; border:1px solid transparent; text-decoration:none; font-size:12px; font-weight:600; cursor:pointer; font-family:'Poppins',sans-serif; }
body.page-manage-event .btn-add { background:#198754; color:#fff; }
body.page-manage-event .btn-muted { background:#6c757d; color:#fff; }
body.page-manage-event .btn-save { background:#198754; color:#fff; }
body.page-manage-event .btn-danger { background:#dc3545; color:#fff; }
body.page-manage-event .btn-close { background:#f6bd60; color:#3a2a11; }
body.page-manage-event .table-shell { overflow:auto; border:1px solid #d9e1ea; border-radius:10px; background:#fff; }
body.page-manage-event .event-table { width:100%; border-collapse:collapse; min-width:860px; }
body.page-manage-event .event-table thead th { background:#f8fafc; color:#475569; font-size:12px; font-weight:600; text-align:left; padding:12px 14px; border-bottom:1px solid #d9e1ea; white-space:nowrap; }
body.page-manage-event .event-table tbody td { padding:14px; border-bottom:1px solid #edf1f5; vertical-align:middle; font-size:12px; color:#1f2937; }
body.page-manage-event .event-table tbody tr:hover { background:#fbfdff; }
body.page-manage-event .event-table tbody tr:last-child td { border-bottom:0; }
body.page-manage-event .thumb { width:116px; height:72px; border-radius:10px; object-fit:cover; background:#eef2ff; border:1px solid #e5e7eb; }
body.page-manage-event .thumb-placeholder { width:116px; height:72px; border-radius:10px; background:#f8fafc; border:1px dashed #d4dce6; display:flex; align-items:center; justify-content:center; color:#6b7280; font-size:11px; }
body.page-manage-event .event-name { font-size:13px; font-weight:600; color:#0f172a; }
body.page-manage-event .action-wrap { display:flex; gap:8px; }
body.page-manage-event .icon-btn { width:34px; height:34px; border-radius:8px; border:1px solid transparent; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; }
body.page-manage-event .icon-btn.edit { background:#ecfdf3; color:#198754; border-color:#cfe9db; }
body.page-manage-event .icon-btn.delete { background:#fef2f2; color:#dc2626; border-color:#fecaca; }
body.page-manage-event .empty-box { background:#fff; border:1px dashed #cfd8e3; border-radius:10px; padding:36px 20px; text-align:center; color:#66758f; }
body.page-manage-event .empty-box i { font-size:30px; color:#7b8497; }
body.page-manage-event .empty-title { margin-top:10px; color:#102a56; font-weight:700; }
body.page-manage-event .overlay { position:fixed; inset:0; background:rgba(15,23,42,.45); display:none; align-items:center; justify-content:center; padding:16px; z-index:1200; }
body.page-manage-event .overlay.show { display:flex; }
body.page-manage-event .modal-card { width:min(100%, 760px); background:#fff; border-radius:12px; border:1px solid #d9e1ea; box-shadow:0 24px 60px rgba(15,23,42,.18); overflow:hidden; }
body.page-manage-event .notice-card { width:min(100%, 380px); background:#fff; border-radius:14px; border:1px solid #d9e1ea; padding:22px 20px; text-align:center; box-shadow:0 24px 60px rgba(15,23,42,.18); }
body.page-manage-event .modal-head { display:flex; justify-content:space-between; align-items:flex-start; gap:12px; padding:18px 20px 12px; border-bottom:1px solid #edf1f5; }
body.page-manage-event .modal-title { margin:0; font-size:18px; font-weight:700; color:#111827; }
body.page-manage-event .modal-hint { margin-top:4px; color:#6b7280; font-size:12px; }
body.page-manage-event .modal-body { padding:18px 20px 10px; }
body.page-manage-event .modal-actions { display:flex; justify-content:flex-end; gap:10px; padding:14px 20px 20px; border-top:1px solid #edf1f5; }
body.page-manage-event .field-label { display:block; margin:0 0 6px; color:#374151; font-weight:600; font-size:12px; }
body.page-manage-event .input { width:100%; border:1px solid #d6dde6; border-radius:8px; padding:10px 12px; background:#fff; color:#111827; font-family:'Poppins',sans-serif; font-size:13px; outline:none; }
body.page-manage-event .input:focus, body.page-manage-event .search-input:focus { border-color:#9ec5fe; box-shadow:0 0 0 3px rgba(13,110,253,.10); }
body.page-manage-event .pick-btn { margin-top:12px; }
body.page-manage-event .preview-wrap { margin-top:14px; }
body.page-manage-event .preview { width:100%; max-height:220px; object-fit:cover; border-radius:10px; border:1px solid #e5e7eb; background:#eef2ff; }
body.page-manage-event .preview-placeholder { width:100%; height:180px; border-radius:10px; background:#f8fafc; border:1px dashed #d4dce6; display:flex; align-items:center; justify-content:center; color:#6b7280; font-size:12px; }
body.page-manage-event .notice-icon { width:52px; height:52px; border-radius:16px; background:#f8faff; display:flex; align-items:center; justify-content:center; margin:0 auto; }
body.page-manage-event .notice-title { margin:14px 0 0; color:#13233f; font-size:15px; font-weight:700; }
body.page-manage-event .notice-text { margin:8px 0 0; color:#6b7280; font-size:12.5px; line-height:1.55; }
body.page-manage-event .notice-actions { margin-top:18px; display:flex; justify-content:center; gap:10px; }
@media (max-width: 900px) {
    body.page-manage-event .manage-shell { padding:12px; }
    body.page-manage-event .toolbar { grid-template-columns:1fr; }
    body.page-manage-event .result-count { justify-self:start; }
    body.page-manage-event .modal-actions { flex-direction:column; }
    body.page-manage-event .event-table { min-width:700px; }
}
</style>
</head>
<body class="page-manage-event">
<?php include 'sidebar.php'; ?>
<main class="app manage-shell">
    <div class="manage-box">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
            <h1>Manage Events</h1>
            <button type="button" class="btn btn-add" id="openCreateBtn"><i class="fa-solid fa-plus"></i><span>Add Venue</span></button>
        </div>
    </div>

    <div class="manage-box">
        <div class="toolbar">
            <div class="search-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="searchInput" class="search-input" placeholder="Search venues">
            </div>
            <div class="result-count" id="resultCount">0 records</div>
            <a href="<?php echo htmlspecialchars(app_url('admin_panel'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-muted"><i class="fa-solid fa-arrow-left"></i><span>Back</span></a>
        </div>
    </div>

    <div id="eventList"></div>
</main>

<div id="eventModal" class="overlay" aria-hidden="true">
    <div class="modal-card">
        <div class="modal-head">
            <div>
                <h2 class="modal-title" id="modalTitle">Add Venue</h2>
                <div class="modal-hint" id="modalHint">Give it a name and optional image.</div>
            </div>
            <button type="button" class="btn btn-close" id="closeModalBtn">Close</button>
        </div>
        <div class="modal-body">
            <label class="field-label" for="nameInput">Venue Name</label>
            <input class="input" id="nameInput" type="text" placeholder="e.g. Banquet Hall">

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
            <button type="button" class="btn btn-save" id="saveEventBtn">Save</button>
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
  events: [],
  filteredEvents: [],
  editingEventId: null,
  editingEventPicture: '',
  saving: false,
  selectedFile: null,
  apiBase: '',
};

const elements = {
  eventList: document.getElementById('eventList'),
  resultCount: document.getElementById('resultCount'),
  searchInput: document.getElementById('searchInput'),
  openCreateBtn: document.getElementById('openCreateBtn'),
  eventModal: document.getElementById('eventModal'),
  closeModalBtn: document.getElementById('closeModalBtn'),
  cancelModalBtn: document.getElementById('cancelModalBtn'),
  saveEventBtn: document.getElementById('saveEventBtn'),
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

function eventImageUrl(filename) {
  if (!filename) return '';
  if (!state.apiBase) return 'assets/images/icon.png';
  return `${state.apiBase}/uploads/events/${String(filename).replace(/^\/+/, '')}?v=${Date.now()}`;
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

  if (state.editingEventPicture) {
    elements.previewWrap.innerHTML = `<img src="${eventImageUrl(state.editingEventPicture)}" alt="Venue" class="preview">`;
    return;
  }

  elements.previewWrap.innerHTML = '<div class="preview-placeholder">No image selected</div>';
}

function openModal(eventItem = null) {
  state.editingEventId = eventItem ? Number(eventItem.id) : null;
  state.editingEventPicture = eventItem?.picture || '';
  state.selectedFile = null;
  elements.nameInput.value = eventItem?.name || '';
  elements.modalTitle.textContent = eventItem ? 'Edit Venue' : 'Add Venue';
  elements.modalHint.textContent = eventItem ? 'Update name and/or image.' : 'Give it a name and optional image.';
  elements.saveEventBtn.textContent = eventItem ? 'Update' : 'Save';
  renderPreview();
  elements.eventModal.classList.add('show');
}

function closeModal() {
  elements.eventModal.classList.remove('show');
  state.editingEventId = null;
  state.editingEventPicture = '';
  state.selectedFile = null;
  elements.nameInput.value = '';
  elements.imageInput.value = '';
  renderPreview();
}

function filterEvents() {
  const searchValue = elements.searchInput.value.trim().toLowerCase();
  state.filteredEvents = state.events.filter((eventItem) => {
    if (!searchValue) return true;
    return String(eventItem.name || '').toLowerCase().includes(searchValue);
  });
  renderEvents();
}

function renderEvents() {
  elements.resultCount.textContent = `${state.filteredEvents.length} record${state.filteredEvents.length === 1 ? '' : 's'}`;

  if (!state.filteredEvents.length) {
    elements.eventList.innerHTML = `
      <div class="empty-box">
        <i class="fa-solid fa-calendar-days"></i>
        <div class="empty-title">No venues found.</div>
        <div style="margin-top:6px;">Tap Add Venue to create your first venue.</div>
      </div>
    `;
    return;
  }

  elements.eventList.innerHTML = `
    <div class="table-shell">
      <table class="event-table">
        <thead>
          <tr>
            <th>Actions</th>
            <th>Image</th>
            <th>Venue Name</th>
          </tr>
        </thead>
        <tbody>
          ${state.filteredEvents.map((eventItem) => `
            <tr>
              <td>
                <div class="action-wrap">
                  <button type="button" class="icon-btn edit" data-edit="${Number(eventItem.id)}" title="Edit venue" aria-label="Edit venue">
                    <i class="fa-solid fa-pen"></i>
                  </button>
                  <button type="button" class="icon-btn delete" data-delete="${Number(eventItem.id)}" title="Delete venue" aria-label="Delete venue">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </div>
              </td>
              <td>
                ${eventItem.picture
                  ? `<img src="${eventImageUrl(eventItem.picture)}" alt="${escapeHtml(eventItem.name || 'Venue')}" class="thumb">`
                  : '<div class="thumb-placeholder">No Image</div>'}
              </td>
              <td><div class="event-name">${escapeHtml(eventItem.name || 'Venue')}</div></td>
            </tr>
          `).join('')}
        </tbody>
      </table>
    </div>
  `;

  elements.eventList.querySelectorAll('[data-edit]').forEach((button) => {
    button.addEventListener('click', () => {
      const eventId = Number(button.getAttribute('data-edit'));
      openModal(state.events.find((item) => Number(item.id) === eventId) || null);
    });
  });

  elements.eventList.querySelectorAll('[data-delete]').forEach((button) => {
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

async function loadEvents() {
  elements.eventList.innerHTML = '<div class="empty-box"><i class="fa-solid fa-spinner fa-spin"></i><div class="empty-title">Loading venues...</div></div>';

  try {
    const data = await requestJson(`${ajaxBase}?ajax=bootstrap`);
    state.events = Array.isArray(data.events) ? data.events : [];
    state.apiBase = String(data.apiBase || '');
    filterEvents();
  } catch (error) {
    showNotice('Venues Unavailable', error.message || 'Failed to load venues.', 'error');
    state.events = [];
    filterEvents();
  }
}

async function saveEvent() {
  const name = elements.nameInput.value.trim();

  if (!name) {
    showNotice('Validation', 'Venue name is required.', 'error');
    return;
  }

  state.saving = true;
  elements.saveEventBtn.disabled = true;
  elements.saveEventBtn.textContent = state.editingEventId ? 'Updating...' : 'Saving...';

  try {
    const formData = new FormData();
    formData.append('name', name);
    if (state.editingEventId) {
      formData.append('id', String(state.editingEventId));
    }
    if (state.selectedFile) {
      formData.append('picture', state.selectedFile);
    }

    await fetch(`${ajaxBase}?ajax=save-event`, {
      method: 'POST',
      body: formData,
      credentials: 'same-origin',
    }).then(async (response) => {
      const data = await response.json().catch(() => ({}));
      if (!response.ok || data.success === false) {
        throw new Error(data.message || 'Failed to save venue.');
      }
    });

    closeModal();
    await loadEvents();
    showNotice('Success', state.editingEventId ? 'Venue updated successfully.' : 'Venue created successfully.', 'success');
  } catch (error) {
    showNotice('Save Failed', error.message || 'Failed to save venue.', 'error');
  } finally {
    state.saving = false;
    elements.saveEventBtn.disabled = false;
    elements.saveEventBtn.textContent = state.editingEventId ? 'Update' : 'Save';
  }
}

function confirmDelete(eventId) {
  const eventItem = state.events.find((item) => Number(item.id) === eventId);
  showNotice(
    'Delete Venue',
    `Delete ${eventItem?.name || 'this venue'}?`,
    'confirm',
    `
      <button type="button" class="btn btn-muted" data-close-notice>Cancel</button>
      <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
    `
  );

  document.getElementById('confirmDeleteBtn').addEventListener('click', async () => {
    hideNotice();

    try {
      await requestJson(`${ajaxBase}?ajax=delete-event&id=${encodeURIComponent(eventId)}`, {
        method: 'POST',
      });
      await loadEvents();
      showNotice('Deleted', 'Venue deleted successfully.', 'success');
    } catch (error) {
      showNotice('Delete Failed', error.message || 'Failed to delete venue.', 'error');
    }
  }, { once: true });
}

elements.searchInput.addEventListener('input', filterEvents);
elements.openCreateBtn.addEventListener('click', () => openModal());
elements.closeModalBtn.addEventListener('click', closeModal);
elements.cancelModalBtn.addEventListener('click', closeModal);
elements.pickImageBtn.addEventListener('click', () => elements.imageInput.click());
elements.imageInput.addEventListener('change', () => {
  state.selectedFile = elements.imageInput.files && elements.imageInput.files[0] ? elements.imageInput.files[0] : null;
  renderPreview();
});
elements.saveEventBtn.addEventListener('click', saveEvent);
elements.noticeOkBtn.addEventListener('click', hideNotice);
elements.eventModal.addEventListener('click', (event) => {
  if (event.target === elements.eventModal) closeModal();
});
elements.noticeModal.addEventListener('click', (event) => {
  if (event.target === elements.noticeModal) hideNotice();
});

loadEvents();
</script>
</body>
</html>
