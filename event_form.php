<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

require_auth();

if (!function_exists('event_form_array_is_list')) {
    function event_form_array_is_list(array $array): bool
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

function event_form_json_response(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($payload, JSON_UNESCAPED_SLASHES);
    exit;
}

function event_form_api_request_first_success(string $method, array $endpoints, array $payload = [], ?string $token = null): array
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

function event_form_message_from_response(array $response, string $fallback): string
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

function event_form_extract_list(array $responseData): array
{
    if (event_form_array_is_list($responseData)) {
        return $responseData;
    }

    if (isset($responseData['items']) && is_array($responseData['items']) && event_form_array_is_list($responseData['items'])) {
        return $responseData['items'];
    }

    if (isset($responseData['data']) && is_array($responseData['data'])) {
        if (event_form_array_is_list($responseData['data'])) {
            return $responseData['data'];
        }

        if (isset($responseData['data']['items']) && is_array($responseData['data']['items']) && event_form_array_is_list($responseData['data']['items'])) {
            return $responseData['data']['items'];
        }
    }

    return [];
}

$token = auth_token();

if (isset($_GET['ajax'])) {
    if ($token === null || $token === '') {
        event_form_json_response(['success' => false, 'message' => 'Your session has expired. Please login again.'], 401);
    }

    $action = (string) $_GET['ajax'];

    if ($action === 'bootstrap') {
        $eventsResponse = event_form_api_request_first_success('GET', ['api/events'], [], $token);

        if (!$eventsResponse['success']) {
            event_form_json_response([
                'success' => false,
                'message' => event_form_message_from_response($eventsResponse, 'We could not load venues right now.'),
            ], max(400, (int) ($eventsResponse['status'] ?? 500)));
        }

        event_form_json_response([
            'success' => true,
            'events' => event_form_extract_list(is_array($eventsResponse['data']) ? $eventsResponse['data'] : []),
            'apiBase' => rtrim(api_base_url(), '/'),
        ]);
    }

    if ($action === 'bookings') {
        $eventId = trim((string) ($_GET['eventId'] ?? ''));
        $date = trim((string) ($_GET['date'] ?? ''));

        if ($eventId === '' || $date === '') {
            event_form_json_response(['success' => false, 'message' => 'eventId and date required'], 400);
        }

        $bookingsResponse = event_form_api_request_first_success('GET', ['api/event-bookings'], [
            'eventId' => $eventId,
            'date' => $date,
        ], $token);

        if (in_array((int) ($bookingsResponse['status'] ?? 0), [401, 403], true)) {
            logout_user();
            event_form_json_response(['success' => false, 'message' => 'Your session has expired. Please login again.'], 401);
        }

        if (!$bookingsResponse['success']) {
            event_form_json_response([
                'success' => false,
                'message' => event_form_message_from_response($bookingsResponse, 'Failed to fetch event bookings'),
            ], max(400, (int) ($bookingsResponse['status'] ?? 500)));
        }

        event_form_json_response([
            'success' => true,
            'bookings' => event_form_extract_list(is_array($bookingsResponse['data']) ? $bookingsResponse['data'] : []),
        ]);
    }

    if ($action === 'create-booking') {
        $rawPayload = file_get_contents('php://input');
        $decodedPayload = json_decode($rawPayload !== false ? $rawPayload : '', true);
        $payload = is_array($decodedPayload) ? $decodedPayload : $_POST;

        $createResponse = event_form_api_request_first_success('POST', ['api/event-bookings'], [
            'eventId' => (string) ($payload['eventId'] ?? ''),
            'bookingDate' => (string) ($payload['bookingDate'] ?? ''),
            'startTime' => (string) ($payload['startTime'] ?? ''),
            'endTime' => (string) ($payload['endTime'] ?? ''),
        ], $token);

        if (in_array((int) ($createResponse['status'] ?? 0), [401, 403], true)) {
            logout_user();
            event_form_json_response(['success' => false, 'message' => 'Your session has expired. Please login again.'], 401);
        }

        if (!$createResponse['success']) {
            event_form_json_response([
                'success' => false,
                'message' => event_form_message_from_response($createResponse, 'Booking failed'),
            ], max(400, (int) ($createResponse['status'] ?? 500)));
        }

        event_form_json_response([
            'success' => true,
            'message' => 'Your venue booking has been created successfully.',
            'data' => $createResponse['data'],
        ], 201);
    }

    event_form_json_response(['success' => false, 'message' => 'Unknown action.'], 404);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Event Booking | NNGK</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" referrerpolicy="no-referrer" />
<link rel="icon" type="image/png" href="<?php echo htmlspecialchars(asset_url('assets/images/icon.png'), ENT_QUOTES, 'UTF-8'); ?>">
<link rel="stylesheet" href="<?php echo htmlspecialchars(asset_url('assets/css/style.css'), ENT_QUOTES, 'UTF-8'); ?>">
<style>
body.page-event-form { font-family:'Poppins',sans-serif; background:#e9ecef; color:#212529; }
body.page-event-form .event-shell { padding:18px; max-width:1120px; }
body.page-event-form .event-box { background:#fff; border:1px solid #d8dee6; border-radius:10px; padding:16px; margin-bottom:14px; box-shadow:0 8px 24px rgba(15,23,42,.05); }
body.page-event-form h1 { margin:0 0 4px; font-size:22px; font-weight:700; }
body.page-event-form h2 { margin:0 0 10px; font-size:18px; font-weight:600; }
body.page-event-form h3 { margin:0 0 8px; font-size:14px; font-weight:600; color:#495057; }
body.page-event-form .muted { color:#6c757d; font-size:12.5px; }
body.page-event-form .top-actions { display:flex; justify-content:space-between; gap:12px; align-items:center; flex-wrap:wrap; }
body.page-event-form .layout { display:grid; grid-template-columns:320px 1fr; gap:14px; }
body.page-event-form .field, body.page-event-form input, body.page-event-form button { font-family:'Poppins',sans-serif; }
body.page-event-form .field { width:100%; min-height:40px; border:1px solid #cfd6df; border-radius:8px; padding:8px 12px; font-size:13px; background:#fff; transition:border-color .2s ease, box-shadow .2s ease; box-sizing:border-box; }
body.page-event-form .field:focus { outline:none; border-color:#0d6efd; box-shadow:0 0 0 3px rgba(13,110,253,.12); }
body.page-event-form .btn { display:inline-flex; align-items:center; justify-content:center; gap:7px; min-height:36px; padding:0 13px; border-radius:6px; border:1px solid transparent; text-decoration:none; font-size:12px; font-weight:600; cursor:pointer; }
body.page-event-form .btn-primary { background:#0d6efd; border-color:#0d6efd; color:#fff; }
body.page-event-form .btn-dark { background:#212529; border-color:#212529; color:#fff; }
body.page-event-form .btn-history { background:#2563eb; border-color:#2563eb; color:#ffffff; }
body.page-event-form .btn-close-soft { background:#f59f00; border-color:#f59f00; color:#ffffff; }
body.page-event-form .btn:disabled { opacity:.65; cursor:not-allowed; }
body.page-event-form .search-wrap { position:relative; margin-top:10px; }
body.page-event-form .search-wrap .field { padding-left:36px; }
body.page-event-form .search-icon { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#7a8695; font-size:13px; pointer-events:none; }
body.page-event-form .event-list { display:flex; flex-direction:column; gap:8px; max-height:620px; overflow:auto; }
body.page-event-form .event-item { width:100%; text-align:left; border:1px solid #dde4ec; background:#fff; border-radius:8px; padding:10px; cursor:pointer; transition:border-color .2s ease, box-shadow .2s ease, background .2s ease; }
body.page-event-form .event-item:hover { border-color:#9bbdf4; box-shadow:0 6px 18px rgba(13,110,253,.08); }
body.page-event-form .event-item.active { border-color:#0d6efd; background:#eef5ff; box-shadow:0 6px 18px rgba(13,110,253,.1); }
body.page-event-form .event-item-wrap { display:flex; align-items:center; gap:10px; }
body.page-event-form .event-thumb { width:46px; height:46px; border-radius:6px; object-fit:cover; background:#e9ecef; border:1px solid #dee2e6; flex-shrink:0; cursor:pointer; }
body.page-event-form .event-item-title { font-size:13px; font-weight:600; color:#212529; }
body.page-event-form .booking-top-grid { display:grid; grid-template-columns:1.2fr 1fr; gap:14px; align-items:start; }
body.page-event-form .field-card { border:1px solid #e5ebf2; border-radius:10px; padding:12px; background:linear-gradient(180deg,#ffffff 0%, #f9fbfd 100%); }
body.page-event-form .event-field-row { display:grid; grid-template-columns:58px 1fr; gap:14px; align-items:center; }
body.page-event-form .event-preview { width:46px; height:46px; border-radius:6px; object-fit:cover; background:#e9ecef; border:1px solid #dee2e6; cursor:pointer; }
body.page-event-form .chip-grid { display:flex; flex-wrap:wrap; gap:8px; }
body.page-event-form .chip { border:1px solid #d7dee7; background:#fff; color:#314355; border-radius:999px; padding:5px 8px; font-size:11px; line-height:1.2; cursor:pointer; min-height:30px; }
body.page-event-form .chip.active { background:#284b63; border-color:#284b63; color:#fff; }
body.page-event-form .chip.disabled { background:#edf1f5; color:#8a94a2; cursor:not-allowed; }
body.page-event-form .selection { border:1px solid #dce5ec; border-radius:10px; padding:14px; background:linear-gradient(180deg,#f8fbff 0%, #f3f8f7 100%); }
body.page-event-form .notice-backdrop { position:fixed; inset:0; background:rgba(15,23,42,.4); display:none; align-items:center; justify-content:center; padding:18px; z-index:1200; }
body.page-event-form .notice-backdrop.show { display:flex; }
body.page-event-form .notice-card { width:100%; max-width:340px; background:#fff; border:1px solid #dfe7ef; border-radius:12px; padding:20px; box-shadow:0 20px 44px rgba(15,23,42,.18); text-align:center; }
body.page-event-form .notice-icon { width:54px; height:54px; border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 12px; background:#eef3f8; font-size:22px; }
body.page-event-form .notice-title { margin:0 0 8px; font-size:16px; font-weight:700; }
body.page-event-form .notice-message { margin:0; font-size:13px; line-height:1.6; color:#667085; }
body.page-event-form .image-viewer-backdrop { position:fixed; inset:0; background:rgba(8,15,28,.92); display:none; align-items:center; justify-content:center; padding:24px; z-index:1250; backdrop-filter:blur(6px); }
body.page-event-form .image-viewer-backdrop.show { display:flex; }
body.page-event-form .image-viewer-card { width:100%; height:100%; display:flex; flex-direction:column; }
body.page-event-form .image-viewer-top { display:flex; justify-content:space-between; align-items:center; padding:10px 14px 18px; }
body.page-event-form .image-viewer-title { font-size:14px; font-weight:600; color:#f8fbff; letter-spacing:.2px; }
body.page-event-form .image-viewer-close { width:44px; height:44px; border-radius:999px; border:1px solid rgba(255,255,255,.16); background:rgba(255,255,255,.08); color:#ffffff; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; font-size:16px; transition:background .2s ease, transform .2s ease; }
body.page-event-form .image-viewer-close:hover { background:rgba(255,255,255,.16); transform:scale(1.04); }
body.page-event-form .image-viewer-frame { flex:1; min-height:0; display:flex; align-items:center; justify-content:center; padding:0 14px 20px; }
body.page-event-form .image-viewer-img { max-width:100%; max-height:100%; width:auto; height:auto; object-fit:contain; border-radius:14px; box-shadow:0 20px 60px rgba(0,0,0,.45); }
@media (max-width: 900px) { body.page-event-form .layout, body.page-event-form .booking-top-grid { grid-template-columns:1fr; } body.page-event-form .event-shell { padding:12px; } body.page-event-form .event-field-row { grid-template-columns:1fr; } }
</style>
</head>
<body class="page-event-form">
<?php include 'sidebar.php'; ?>
<main class="app event-shell">
    <div class="event-box">
        <div class="top-actions">
            <div><h1>Event Booking</h1></div>
            <a href="<?php echo htmlspecialchars(app_url('event_history'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-history"><i class="fa-solid fa-clock-rotate-left"></i><span>View History</span></a>
        </div>
    </div>

    <div class="layout">
        <div class="event-box">
            <h2>Events</h2>
            <div class="search-wrap">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input id="eventSearch" class="field" type="text" placeholder="Search event">
            </div>
            <div id="eventList" class="event-list" style="margin-top:12px;"></div>
        </div>

        <div class="event-box">
            <h2>Booking Form</h2>
            <div id="bookingContent" class="muted">Select an event first.</div>
        </div>
    </div>
</main>

<div id="noticeModal" class="notice-backdrop">
    <div class="notice-card">
        <div id="noticeIcon" class="notice-icon"></div>
        <h3 id="noticeTitle" class="notice-title"></h3>
        <p id="noticeMessage" class="notice-message"></p>
        <div style="margin-top:16px;">
            <button type="button" id="closeNoticeModal" class="btn btn-primary">OK</button>
        </div>
    </div>
</div>

<div id="imageViewerModal" class="image-viewer-backdrop">
    <div class="image-viewer-card">
        <div class="image-viewer-top">
            <div id="imageViewerTitle" class="image-viewer-title">Event Preview</div>
            <button type="button" id="closeImageViewerModal" class="image-viewer-close" aria-label="Close image viewer"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="image-viewer-frame">
            <img id="imageViewerImg" class="image-viewer-img" src="" alt="Event image preview">
        </div>
    </div>
</div>

<script>
const DURATIONS = [30, 60, 90, 120, 150, 180, 210, 240];
const PAGE_ENDPOINT = window.location.pathname;
const state = {
  apiBase: '',
  events: [],
  selectedEvent: null,
  selectedDate: startOfDay(new Date()),
  visibleMonth: startOfMonth(startOfDay(new Date())),
  selectedDuration: 30,
  bookings: [],
  selectedSlot: null,
  eventSearch: '',
  submitting: false
};

const el = {
  eventSearch: document.getElementById('eventSearch'),
  eventList: document.getElementById('eventList'),
  bookingContent: document.getElementById('bookingContent'),
  noticeModal: document.getElementById('noticeModal'),
  noticeIcon: document.getElementById('noticeIcon'),
  noticeTitle: document.getElementById('noticeTitle'),
  noticeMessage: document.getElementById('noticeMessage'),
  closeNoticeModal: document.getElementById('closeNoticeModal'),
  imageViewerModal: document.getElementById('imageViewerModal'),
  imageViewerImg: document.getElementById('imageViewerImg'),
  imageViewerTitle: document.getElementById('imageViewerTitle'),
  closeImageViewerModal: document.getElementById('closeImageViewerModal'),
};

function startOfDay(value) { const d = new Date(value); d.setHours(0,0,0,0); return d; }
function startOfMonth(value) { return new Date(value.getFullYear(), value.getMonth(), 1); }
function formatDateKey(date) { return `${date.getFullYear()}-${String(date.getMonth()+1).padStart(2,'0')}-${String(date.getDate()).padStart(2,'0')}`; }
function formatDateLabel(date) { return `${date.toLocaleString('en-US',{ weekday:'short' })}, ${date.toLocaleString('en-US',{ month:'short' })} ${String(date.getDate()).padStart(2,'0')}`; }
function timeLabel(minutes) { const h24 = Math.floor(minutes/60); const m = minutes % 60; const h = h24 % 12 || 12; const suffix = h24 % 24 >= 12 ? 'PM' : 'AM'; return `${h}:${String(m).padStart(2,'0')} ${suffix}`; }
function timeValue(minutes) { return `${String(Math.floor(minutes/60)).padStart(2,'0')}:${String(minutes%60).padStart(2,'0')}:00`; }
function overlaps(a1, a2, b1, b2) { return a1 < b2 && a2 > b1; }
function escapeHtml(value) { return String(value ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;'); }
function getEventImageUrl(item) { return item?.picture ? `${state.apiBase}/uploads/events/${String(item.picture).replace(/^\/+/, '')}` : <?php echo json_encode(asset_url('assets/images/icon.png')); ?>; }

async function requestJson(url, options = {}) {
  const response = await fetch(url, {
    credentials: 'same-origin',
    headers: { Accept: 'application/json', ...(options.body ? { 'Content-Type': 'application/json' } : {}) },
    ...options,
  });

  const raw = await response.text();
  let data = null;
  try { data = raw ? JSON.parse(raw) : null; } catch (e) { data = null; }

  if (!response.ok || !data?.success) {
    const message = data?.message || raw || `Request failed with status ${response.status}`;
    const err = new Error(message);
    err.status = response.status;
    throw err;
  }

  return data;
}

function showAlert(message, type = 'error', title = '') {
  const success = type === 'success';
  el.noticeIcon.innerHTML = success
    ? '<i class="fa-solid fa-circle-check" style="color:#198754;"></i>'
    : '<i class="fa-solid fa-circle-exclamation" style="color:#d64d4d;"></i>';
  el.noticeTitle.textContent = title || (success ? 'Success' : 'Notice');
  el.noticeMessage.textContent = message;
  el.noticeModal.classList.add('show');
}

function clearAlert() { el.noticeModal.classList.remove('show'); }
function openImageViewer(src, altText = 'Event image') { el.imageViewerImg.src = src; el.imageViewerImg.alt = altText; el.imageViewerTitle.textContent = altText || 'Event Preview'; el.imageViewerModal.classList.add('show'); }
function closeImageViewer() { el.imageViewerModal.classList.remove('show'); el.imageViewerImg.src = ''; }

function getFilteredEvents() {
  const q = state.eventSearch.trim().toLowerCase();
  return q ? state.events.filter((item) => String(item.name || '').toLowerCase().includes(q)) : state.events;
}

function getSlotItems() {
  const ranges = state.bookings.map((booking) => {
    const [sh, sm] = String(booking.start_time).split(':').map(Number);
    const [eh, em] = String(booking.end_time).split(':').map(Number);
    return { start: sh * 60 + sm, end: eh * 60 + em };
  });

  const items = [];
  for (let start = 0; start < 1440; start += 30) {
    const end = start + state.selectedDuration;
    items.push({
      key: `${start}-${state.selectedDuration}`,
      start,
      end,
      label: timeLabel(start),
      available: !ranges.some((booking) => overlaps(start, end, booking.start, booking.end))
    });
  }
  return items;
}

function renderEventList() {
  const items = getFilteredEvents();
  if (!items.length) {
    el.eventList.innerHTML = '<div class="muted" style="margin-top:12px;">No events found.</div>';
    return;
  }

  el.eventList.innerHTML = items.map((item) => `
    <button type="button" class="event-item ${state.selectedEvent && String(state.selectedEvent.id) === String(item.id) ? 'active' : ''}" data-event-id="${escapeHtml(item.id)}">
      <div class="event-item-wrap">
        <img class="event-thumb" data-preview-image="${escapeHtml(getEventImageUrl(item))}" data-preview-alt="${escapeHtml(item.name || 'Event')}" src="${escapeHtml(getEventImageUrl(item))}" alt="${escapeHtml(item.name || 'Event')}" onerror="this.onerror=null;this.src=<?php echo htmlspecialchars(json_encode(asset_url('assets/images/icon.png')), ENT_QUOTES, 'UTF-8'); ?>;">
        <div class="event-item-title">${escapeHtml(item.name || 'Event')}</div>
      </div>
    </button>
  `).join('');

  el.eventList.querySelectorAll('[data-event-id]').forEach((button) => {
    button.addEventListener('click', async () => {
      const item = state.events.find((row) => String(row.id) === String(button.getAttribute('data-event-id')));
      if (!item) return;
      state.selectedEvent = item;
      state.selectedDate = startOfDay(new Date());
      state.visibleMonth = startOfMonth(state.selectedDate);
      state.selectedDuration = 30;
      state.selectedSlot = null;
      clearAlert();
      renderEventList();
      renderBookingForm();
      await loadBookings();
    });
  });

  el.eventList.querySelectorAll('[data-preview-image]').forEach((image) => {
    image.addEventListener('click', (event) => {
      event.preventDefault();
      event.stopPropagation();
      openImageViewer(image.getAttribute('data-preview-image'), image.getAttribute('data-preview-alt') || 'Event image');
    });
  });
}

function renderBookingForm() {
  if (!state.selectedEvent) {
    el.bookingContent.innerHTML = '<div class="muted">Select an event first.</div>';
    return;
  }

  const slotItems = getSlotItems();
  const selectedSummary = state.selectedSlot ? `${formatDateLabel(state.selectedDate)} | ${state.selectedSlot.label}` : 'Choose a date, duration, and available slot';
  const minDate = formatDateKey(new Date());

  el.bookingContent.innerHTML = `
    <div class="booking-top-grid">
      <div class="field-card">
        <h3>Event</h3>
        <div class="event-field-row">
          <img class="event-preview" id="selectedEventPreview" src="${escapeHtml(getEventImageUrl(state.selectedEvent))}" alt="${escapeHtml(state.selectedEvent.name || 'Event')}" onerror="this.onerror=null;this.src=<?php echo htmlspecialchars(json_encode(asset_url('assets/images/icon.png')), ENT_QUOTES, 'UTF-8'); ?>;">
          <input class="field" type="text" value="${escapeHtml(state.selectedEvent.name || '')}" disabled>
        </div>
      </div>
      <div class="field-card">
        <h3>Date</h3>
        <input id="bookingDateInput" class="field" type="date" min="${escapeHtml(minDate)}" value="${escapeHtml(formatDateKey(state.selectedDate))}">
      </div>
    </div>

    <div class="field-card" style="margin-top:14px;">
      <h3>Duration</h3>
      <div class="chip-grid">
        ${DURATIONS.map((duration) => `<button type="button" class="chip ${duration === state.selectedDuration ? 'active' : ''}" data-duration="${duration}">${duration} min</button>`).join('')}
      </div>
    </div>

    <div class="field-card" style="margin-top:14px;">
      <h3>Slots</h3>
      <div class="chip-grid">
        ${slotItems.map((slot) => `<button type="button" class="chip ${state.selectedSlot?.key === slot.key ? 'active' : ''} ${slot.available ? '' : 'disabled'}" data-slot="${slot.key}" ${slot.available ? '' : 'disabled'}>${escapeHtml(slot.label)}</button>`).join('')}
      </div>
    </div>

    <div class="selection" style="margin-top:16px;">
      <h3>Selected Slot</h3>
      <div class="muted" style="font-size:13px;">${escapeHtml(selectedSummary)}</div>
      <div style="margin-top:12px;">
        <button type="button" class="btn btn-dark" id="bookNow" ${state.selectedSlot && !state.submitting ? '' : 'disabled'}>${state.submitting ? 'Booking...' : 'Book Now'}</button>
      </div>
    </div>
  `;

  document.getElementById('bookingDateInput').addEventListener('change', async (event) => {
    const picked = event.target.value;
    if (!picked) return;
    state.selectedDate = startOfDay(new Date(`${picked}T00:00:00`));
    state.visibleMonth = startOfMonth(state.selectedDate);
    state.selectedSlot = null;
    renderBookingForm();
    await loadBookings();
  });

  document.querySelectorAll('[data-duration]').forEach((button) => {
    button.addEventListener('click', () => {
      state.selectedDuration = Number(button.getAttribute('data-duration'));
      state.selectedSlot = null;
      renderBookingForm();
    });
  });

  document.querySelectorAll('[data-slot]').forEach((button) => {
    button.addEventListener('click', () => {
      const slot = getSlotItems().find((item) => item.key === button.getAttribute('data-slot'));
      if (!slot || !slot.available) return;
      state.selectedSlot = slot;
      renderBookingForm();
    });
  });

  document.getElementById('bookNow').addEventListener('click', handleBookNow);
  document.getElementById('selectedEventPreview').addEventListener('click', () => {
    openImageViewer(getEventImageUrl(state.selectedEvent), state.selectedEvent?.name || 'Event image');
  });
}

async function loadBootstrap() {
  try {
    clearAlert();
    el.eventList.innerHTML = '<div class="muted">Loading events...</div>';
    const data = await requestJson(`${PAGE_ENDPOINT}?ajax=bootstrap`);
    state.apiBase = data.apiBase || '';
    state.events = Array.isArray(data.events) ? data.events : [];
    renderEventList();
    renderBookingForm();
  } catch (error) {
    if (error.status === 401) {
      window.location.href = 'login';
      return;
    }
    showAlert(error.message || 'Failed to load event form', 'error', 'Events Unavailable');
    el.eventList.innerHTML = '<div class="muted">Could not load events.</div>';
  }
}

async function loadBookings() {
  if (!state.selectedEvent) return;
  try {
    const params = new URLSearchParams({ ajax:'bookings', eventId:String(state.selectedEvent.id), date:formatDateKey(state.selectedDate) });
    const data = await requestJson(`${PAGE_ENDPOINT}?${params.toString()}`);
    state.bookings = Array.isArray(data.bookings) ? data.bookings : [];
    renderBookingForm();
  } catch (error) {
    if (error.status === 401) {
      window.location.href = 'login';
      return;
    }
    state.bookings = [];
    renderBookingForm();
    showAlert(error.message || 'Failed to fetch event bookings', 'error', 'Slots Unavailable');
  }
}

async function handleBookNow() {
  if (!state.selectedEvent || !state.selectedSlot || !state.selectedSlot.available) {
    showAlert('Please choose an available slot before booking.', 'error', 'Select Slot');
    return;
  }

  state.submitting = true;
  renderBookingForm();

  try {
    const data = await requestJson(`${PAGE_ENDPOINT}?ajax=create-booking`, {
      method: 'POST',
      body: JSON.stringify({
        eventId: state.selectedEvent.id,
        bookingDate: formatDateKey(state.selectedDate),
        startTime: timeValue(state.selectedSlot.start),
        endTime: timeValue(state.selectedSlot.end),
      }),
    });

    showAlert(data.message || 'Booking created successfully.', 'success', 'Booking Created');
    state.selectedSlot = null;
    await loadBookings();
  } catch (error) {
    if (error.status === 401) {
      window.location.href = 'login';
      return;
    }
    showAlert(error.message || 'Booking failed', 'error', 'Booking Failed');
  } finally {
    state.submitting = false;
    renderBookingForm();
  }
}

el.eventSearch.addEventListener('input', (event) => {
  state.eventSearch = event.target.value || '';
  renderEventList();
});
el.closeNoticeModal.addEventListener('click', clearAlert);
el.noticeModal.addEventListener('click', (event) => { if (event.target === el.noticeModal) clearAlert(); });
el.closeImageViewerModal.addEventListener('click', closeImageViewer);
el.imageViewerModal.addEventListener('click', (event) => { if (event.target === el.imageViewerModal) closeImageViewer(); });

loadBootstrap();
</script>
</body>
</html>
