<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

require_auth();

if (!function_exists('court_form_array_is_list')) {
    function court_form_array_is_list(array $array): bool
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

function court_form_json_response(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($payload, JSON_UNESCAPED_SLASHES);
    exit;
}

function court_form_api_candidates(string $action): array
{
    return match ($action) {
        'me' => ['api/auth/me'],
        'courts' => ['api/courts'],
        'players' => ['api/users/booking-options'],
        'bookings' => ['api/bookings'],
        'create-booking' => ['api/bookings'],
        default => [],
    };
}

function court_form_api_request_first_success(string $method, array $endpoints, array $payload = [], ?string $token = null): array
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

function court_form_message_from_response(array $response, string $fallback): string
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

function court_form_extract_list(array $responseData): array
{
    if (court_form_array_is_list($responseData)) {
        return $responseData;
    }

    if (isset($responseData['items']) && is_array($responseData['items']) && court_form_array_is_list($responseData['items'])) {
        return $responseData['items'];
    }

    if (isset($responseData['data']) && is_array($responseData['data'])) {
        if (court_form_array_is_list($responseData['data'])) {
            return $responseData['data'];
        }

        if (isset($responseData['data']['items']) && is_array($responseData['data']['items']) && court_form_array_is_list($responseData['data']['items'])) {
            return $responseData['data']['items'];
        }
    }

    return [];
}

function court_form_normalize_player(array $player): array
{
    return [
        'id' => $player['id'] ?? null,
        'name' => (string) ($player['name'] ?? $player['username'] ?? 'User'),
        'cm_no' => (string) ($player['cm_no'] ?? $player['cmNo'] ?? ''),
        'fees_status' => (string) ($player['fees_status'] ?? $player['feesStatus'] ?? 'paid'),
        'can_book' => (string) ($player['can_book'] ?? $player['canBook'] ?? ''),
    ];
}

function court_form_create_player_summary(array $user): ?array
{
    $normalized = court_form_normalize_player($user);

    if ($normalized['name'] === '' || $normalized['name'] === 'User') {
        $normalized['name'] = auth_user_name();
    }

    if ($normalized['cm_no'] === '') {
        $normalized['cm_no'] = (string) ($user['cm_no'] ?? $user['cmNo'] ?? '');
    }

    if ($normalized['id'] === null || $normalized['id'] === '') {
        $normalized['id'] = '__self__';
    }

    if ($normalized['name'] === '') {
        return null;
    }

    return $normalized;
}

function court_form_extract_user(array $responseData): array
{
    $candidates = [
        $responseData['user'] ?? null,
        $responseData['data']['user'] ?? null,
        $responseData['data'] ?? null,
    ];

    foreach ($candidates as $candidate) {
        if (is_array($candidate)) {
            return $candidate;
        }
    }

    return [];
}

$token = auth_token();
$sessionUser = auth_user();
$currentUserSummary = court_form_create_player_summary($sessionUser);

if (isset($_GET['ajax'])) {
    if ($token === null || $token === '') {
        court_form_json_response(['success' => false, 'message' => 'Your session has expired. Please login again.'], 401);
    }

    $action = (string) $_GET['ajax'];

    if ($action === 'bootstrap') {
        $meResponse = court_form_api_request_first_success('GET', court_form_api_candidates('me'), [], $token);
        $courtsResponse = court_form_api_request_first_success('GET', court_form_api_candidates('courts'), [], $token);

        if ($meResponse['success']) {
            $liveUser = court_form_extract_user(is_array($meResponse['data']) ? $meResponse['data'] : []);

            if ($liveUser !== []) {
                $_SESSION['auth']['user'] = array_merge($sessionUser, $liveUser);
                $sessionUser = $_SESSION['auth']['user'];
                $currentUserSummary = court_form_create_player_summary($sessionUser);
            }
        }

        if (!$courtsResponse['success']) {
            court_form_json_response([
                'success' => false,
                'message' => court_form_message_from_response($courtsResponse, 'We could not load courts right now.'),
            ], max(400, (int) ($courtsResponse['status'] ?? 500)));
        }

        court_form_json_response([
            'success' => true,
            'courts' => court_form_extract_list(is_array($courtsResponse['data']) ? $courtsResponse['data'] : []),
            'players' => [],
            'currentUser' => $currentUserSummary,
            'apiBase' => rtrim(api_base_url(), '/'),
        ]);
    }

    if ($action === 'players') {
        $playersResponse = court_form_api_request_first_success('GET', court_form_api_candidates('players'), [], $token);

        if (in_array((int) ($playersResponse['status'] ?? 0), [401, 403], true)) {
            court_form_json_response([
                'success' => false,
                'message' => court_form_message_from_response($playersResponse, 'We could not load players right now.'),
            ], max(400, (int) ($playersResponse['status'] ?? 500)));
        }

        if (!$playersResponse['success']) {
            court_form_json_response([
                'success' => false,
                'message' => court_form_message_from_response($playersResponse, 'We could not load players right now.'),
            ], max(400, (int) ($playersResponse['status'] ?? 500)));
        }

        $players = array_map(
            static fn(array $player): array => court_form_normalize_player($player),
            array_values(array_filter(
                court_form_extract_list(is_array($playersResponse['data']) ? $playersResponse['data'] : []),
                static fn(mixed $player): bool => is_array($player)
            ))
        );

        foreach ($players as $player) {
            if (($player['id'] ?? null) === ($sessionUser['id'] ?? null)) {
                $_SESSION['auth']['user'] = array_merge($sessionUser, $player);
                $currentUserSummary = court_form_create_player_summary($_SESSION['auth']['user']);
                break;
            }
        }

        court_form_json_response([
            'success' => true,
            'players' => $players,
            'currentUser' => $currentUserSummary,
        ]);
    }

    if ($action === 'bookings') {
        $courtId = trim((string) ($_GET['courtId'] ?? ''));
        $date = trim((string) ($_GET['date'] ?? ''));

        if ($courtId === '' || $date === '') {
            court_form_json_response(['success' => false, 'message' => 'courtId and date required'], 400);
        }

        $bookingsResponse = court_form_api_request_first_success(
            'GET',
            court_form_api_candidates('bookings'),
            ['courtId' => $courtId, 'date' => $date],
            $token
        );

        if (in_array((int) ($bookingsResponse['status'] ?? 0), [401, 403], true)) {
            logout_user();
            court_form_json_response(['success' => false, 'message' => 'Your session has expired. Please login again.'], 401);
        }

        if (!$bookingsResponse['success']) {
            court_form_json_response([
                'success' => false,
                'message' => court_form_message_from_response($bookingsResponse, 'Failed to fetch bookings'),
            ], max(400, (int) ($bookingsResponse['status'] ?? 500)));
        }

        court_form_json_response([
            'success' => true,
            'bookings' => court_form_extract_list(is_array($bookingsResponse['data']) ? $bookingsResponse['data'] : []),
        ]);
    }

    if ($action === 'create-booking') {
        $rawPayload = file_get_contents('php://input');
        $decodedPayload = json_decode($rawPayload !== false ? $rawPayload : '', true);
        $payload = is_array($decodedPayload) ? $decodedPayload : $_POST;

        $createResponse = court_form_api_request_first_success(
            'POST',
            court_form_api_candidates('create-booking'),
            [
                'courtId' => (string) ($payload['courtId'] ?? ''),
                'bookingDate' => (string) ($payload['bookingDate'] ?? ''),
                'startTime' => (string) ($payload['startTime'] ?? ''),
                'endTime' => (string) ($payload['endTime'] ?? ''),
                'playerIds' => array_values(is_array($payload['playerIds'] ?? null) ? $payload['playerIds'] : []),
            ],
            $token
        );

        if (in_array((int) ($createResponse['status'] ?? 0), [401, 403], true)) {
            logout_user();
            court_form_json_response(['success' => false, 'message' => 'Your session has expired. Please login again.'], 401);
        }

        if (!$createResponse['success']) {
            court_form_json_response([
                'success' => false,
                'message' => court_form_message_from_response($createResponse, 'Booking failed'),
            ], max(400, (int) ($createResponse['status'] ?? 500)));
        }

        court_form_json_response([
            'success' => true,
            'message' => 'Your court booking has been created successfully.',
            'data' => $createResponse['data'],
        ], 201);
    }

    court_form_json_response(['success' => false, 'message' => 'Unknown action.'], 404);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Court Booking | NNGK</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" referrerpolicy="no-referrer" />
<link rel="icon" type="image/png" href="<?php echo htmlspecialchars(asset_url('assets/images/icon.png'), ENT_QUOTES, 'UTF-8'); ?>">
<link rel="stylesheet" href="assets/css/style.css">
<style>
body.page-court-form { font-family:'Poppins',sans-serif; background:#e9ecef; color:#212529; }
body.page-court-form .court-shell { padding:18px; max-width:1120px; }
body.page-court-form .court-box { background:#fff; border:1px solid #d8dee6; border-radius:10px; padding:16px; margin-bottom:14px; box-shadow:0 8px 24px rgba(15,23,42,.05); }
body.page-court-form h1 { margin:0 0 4px; font-size:22px; font-weight:700; }
body.page-court-form h2 { margin:0 0 10px; font-size:18px; font-weight:600; }
body.page-court-form h3 { margin:0 0 8px; font-size:14px; font-weight:600; color:#495057; }
body.page-court-form .muted { color:#6c757d; font-size:12.5px; }
body.page-court-form .top-actions { display:flex; justify-content:space-between; gap:12px; align-items:center; flex-wrap:wrap; }
body.page-court-form .layout { display:grid; grid-template-columns:320px 1fr; gap:14px; }
body.page-court-form .field, body.page-court-form input, body.page-court-form select, body.page-court-form button { font-family:'Poppins',sans-serif; }
body.page-court-form .field { width:100%; min-height:40px; border:1px solid #cfd6df; border-radius:8px; padding:8px 12px; font-size:13px; background:#fff; transition:border-color .2s ease, box-shadow .2s ease; box-sizing:border-box; }
body.page-court-form .field:focus { outline:none; border-color:#0d6efd; box-shadow:0 0 0 3px rgba(13,110,253,.12); }
body.page-court-form .btn { display:inline-flex; align-items:center; justify-content:center; gap:7px; min-height:36px; padding:0 13px; border-radius:6px; border:1px solid transparent; text-decoration:none; font-size:12px; font-weight:600; cursor:pointer; }
body.page-court-form .btn-primary { background:#0d6efd; border-color:#0d6efd; color:#fff; }
body.page-court-form .btn-secondary { background:#eef3f8; border-color:#d4dde7; color:#304255; }
body.page-court-form .btn-dark { background:#212529; border-color:#212529; color:#fff; }
body.page-court-form .btn-history { background:#2563eb; border-color:#2563eb; color:#ffffff; }
body.page-court-form .btn-add { background:#198754; border-color:#198754; color:#ffffff; }
body.page-court-form .btn-remove { background:#dc3545; border-color:#dc3545; color:#ffffff; }
body.page-court-form .btn-close-soft { background:#f59f00; border-color:#f59f00; color:#ffffff; }
body.page-court-form .btn:disabled { opacity:.65; cursor:not-allowed; }
body.page-court-form .court-list { display:flex; flex-direction:column; gap:8px; max-height:620px; overflow:auto; }
body.page-court-form .court-item { width:100%; text-align:left; border:1px solid #dde4ec; background:#fff; border-radius:8px; padding:10px; cursor:pointer; transition:border-color .2s ease, box-shadow .2s ease, background .2s ease; }
body.page-court-form .court-item:hover { border-color:#9bbdf4; box-shadow:0 6px 18px rgba(13,110,253,.08); }
body.page-court-form .court-item.active { border-color:#0d6efd; background:#eef5ff; box-shadow:0 6px 18px rgba(13,110,253,.1); }
body.page-court-form .court-item-title { font-size:13px; font-weight:600; color:#212529; }
body.page-court-form .court-item-wrap { display:flex; align-items:center; gap:10px; }
body.page-court-form .court-thumb { width:46px; height:46px; border-radius:6px; object-fit:cover; background:#e9ecef; border:1px solid #dee2e6; flex-shrink:0; cursor:pointer; }
body.page-court-form .court-field-row { display:grid; grid-template-columns:58px 1fr; gap:14px; align-items:center; }
body.page-court-form .court-preview { width:46px; height:46px; border-radius:6px; object-fit:cover; background:#e9ecef; border:1px solid #dee2e6; cursor:pointer; }
body.page-court-form .booking-top-grid { display:grid; grid-template-columns:1.2fr 1fr; gap:14px; align-items:start; }
body.page-court-form .field-card { border:1px solid #e5ebf2; border-radius:10px; padding:12px; background:linear-gradient(180deg,#ffffff 0%, #f9fbfd 100%); }
body.page-court-form .grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
body.page-court-form .chip-grid { display:flex; flex-wrap:wrap; gap:8px; }
body.page-court-form .chip { border:1px solid #d7dee7; background:#fff; color:#314355; border-radius:999px; padding:5px 8px; font-size:11px; line-height:1.2; cursor:pointer; min-height:30px; }
body.page-court-form .chip.active { background:#284b63; border-color:#284b63; color:#fff; }
body.page-court-form .chip.disabled { background:#edf1f5; color:#8a94a2; cursor:not-allowed; }
body.page-court-form .players-list { display:flex; flex-direction:column; gap:8px; }
body.page-court-form .player-row { display:flex; justify-content:space-between; align-items:center; gap:8px; border:1px solid #e3e9ef; border-radius:8px; padding:8px 10px; font-size:12px; background:#fcfdff; }
body.page-court-form .helper { margin-top:6px; font-size:11px; color:#6c757d; }
body.page-court-form .selection { border:1px solid #dce5ec; border-radius:10px; padding:14px; background:linear-gradient(180deg,#f8fbff 0%, #f3f8f7 100%); }
body.page-court-form .modal-backdrop { position:fixed; inset:0; background:rgba(0,0,0,.35); display:none; align-items:center; justify-content:center; padding:18px; }
body.page-court-form .modal-backdrop.show { display:flex; }
body.page-court-form .modal-card { width:100%; max-width:360px; max-height:58vh; overflow:auto; background:#fff; border-radius:8px; border:1px solid #dee2e6; padding:12px; }
body.page-court-form .player-option { width:100%; text-align:left; margin-bottom:6px; border:1px solid #dee2e6; background:#fff; border-radius:6px; padding:8px; cursor:pointer; }
body.page-court-form .player-option:last-child { margin-bottom:0; }
body.page-court-form .notice-backdrop { position:fixed; inset:0; background:rgba(15,23,42,.4); display:none; align-items:center; justify-content:center; padding:18px; z-index:1200; }
body.page-court-form .notice-backdrop.show { display:flex; }
body.page-court-form .notice-card { width:100%; max-width:340px; background:#fff; border:1px solid #dfe7ef; border-radius:12px; padding:20px; box-shadow:0 20px 44px rgba(15,23,42,.18); text-align:center; }
body.page-court-form .notice-icon { width:54px; height:54px; border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 12px; background:#eef3f8; font-size:22px; }
body.page-court-form .notice-title { margin:0 0 8px; font-size:16px; font-weight:700; }
body.page-court-form .notice-message { margin:0; font-size:13px; line-height:1.6; color:#667085; }
body.page-court-form .search-wrap { position:relative; margin-top:10px; }
body.page-court-form .search-wrap .field { padding-left:36px; }
body.page-court-form .search-icon { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#7a8695; font-size:13px; pointer-events:none; }
body.page-court-form .image-viewer-backdrop { position:fixed; inset:0; background:rgba(8,15,28,.92); display:none; align-items:center; justify-content:center; padding:24px; z-index:1250; backdrop-filter:blur(6px); }
body.page-court-form .image-viewer-backdrop.show { display:flex; }
body.page-court-form .image-viewer-card { width:100%; height:100%; display:flex; flex-direction:column; }
body.page-court-form .image-viewer-top { display:flex; justify-content:space-between; align-items:center; padding:10px 14px 18px; }
body.page-court-form .image-viewer-title { font-size:14px; font-weight:600; color:#f8fbff; letter-spacing:.2px; }
body.page-court-form .image-viewer-close { width:44px; height:44px; border-radius:999px; border:1px solid rgba(255,255,255,.16); background:rgba(255,255,255,.08); color:#ffffff; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; font-size:16px; transition:background .2s ease, transform .2s ease; }
body.page-court-form .image-viewer-close:hover { background:rgba(255,255,255,.16); transform:scale(1.04); }
body.page-court-form .image-viewer-frame { flex:1; min-height:0; display:flex; align-items:center; justify-content:center; padding:0 14px 20px; }
body.page-court-form .image-viewer-img { max-width:100%; max-height:100%; width:auto; height:auto; object-fit:contain; border-radius:14px; box-shadow:0 20px 60px rgba(0,0,0,.45); }
@media (max-width: 900px) { body.page-court-form .layout, body.page-court-form .grid-2, body.page-court-form .booking-top-grid { grid-template-columns:1fr; } body.page-court-form .court-shell { padding:12px; } body.page-court-form .court-field-row { grid-template-columns:1fr; } }
</style>
</head>
<body class="page-court-form">
<?php include 'sidebar.php'; ?>
<main class="app court-shell">
    <div class="court-box">
        <div class="top-actions">
            <div>
                <h1>Court Booking</h1>
            </div>
            <a href="<?php echo htmlspecialchars(app_url('court_history'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-history"><i class="fa-solid fa-clock-rotate-left"></i><span>View History</span></a>
        </div>
    </div>

    <div class="layout">
        <div class="court-box">
            <h2>Courts</h2>
            <div class="search-wrap">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input id="courtSearch" class="field" type="text" placeholder="Search court">
            </div>
            <div id="courtList" class="court-list" style="margin-top:12px;"></div>
        </div>

        <div class="court-box">
            <h2>Booking Form</h2>
            <div id="bookingContent" class="muted">Select a court first.</div>
        </div>
    </div>
</main>
<div id="playerModal" class="modal-backdrop">
    <div class="modal-card">
        <div class="top-actions" style="margin-bottom:12px;">
            <h2 style="margin:0;">Add Players</h2>
            <button type="button" id="closePlayerModal" class="btn btn-close-soft">Close</button>
        </div>
        <input id="playerSearch" class="field" type="text" placeholder="Search users">
        <div id="playerOptions" style="margin-top:12px;"></div>
    </div>
</div>
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
            <div id="imageViewerTitle" class="image-viewer-title">Court Preview</div>
            <button type="button" id="closeImageViewerModal" class="image-viewer-close" aria-label="Close image viewer">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="image-viewer-frame">
            <img id="imageViewerImg" class="image-viewer-img" src="" alt="Court image preview">
        </div>
    </div>
</div>
<script>
const MAX_BOOKING_PLAYERS = 4;
const DURATIONS = [30, 60, 90, 120, 150, 180, 210, 240];
const PAGE_ENDPOINT = window.location.pathname;
const state = {
  apiBase: '',
  courts: [],
  players: [],
  currentUser: <?php echo json_encode($currentUserSummary, JSON_UNESCAPED_SLASHES); ?>,
  selectedCourt: null,
  selectedDate: startOfDay(new Date()),
  visibleMonth: startOfMonth(startOfDay(new Date())),
  selectedDuration: 30,
  bookings: [],
  selectedSlot: null,
  selectedPlayers: [],
  courtSearch: '',
  playerSearch: '',
  submitting: false
};

const el = {
  courtSearch: document.getElementById('courtSearch'),
  courtList: document.getElementById('courtList'),
  bookingContent: document.getElementById('bookingContent'),
  playerModal: document.getElementById('playerModal'),
  closePlayerModal: document.getElementById('closePlayerModal'),
  playerSearch: document.getElementById('playerSearch'),
  playerOptions: document.getElementById('playerOptions'),
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
function addMonths(value, months) { return new Date(value.getFullYear(), value.getMonth() + months, 1); }
function isSameMonth(a, b) { return a.getFullYear() === b.getFullYear() && a.getMonth() === b.getMonth(); }
function formatMonthTitle(date) { return date.toLocaleString('en-US', { month: 'long', year: 'numeric' }); }
function formatDateKey(date) { return `${date.getFullYear()}-${String(date.getMonth()+1).padStart(2,'0')}-${String(date.getDate()).padStart(2,'0')}`; }
function formatDateLabel(date) { return `${date.toLocaleString('en-US',{ weekday:'short' })}, ${date.toLocaleString('en-US',{ month:'short' })} ${String(date.getDate()).padStart(2,'0')}`; }
function isPastDate(date) { return startOfDay(date) < startOfDay(new Date()); }
function timeLabel(minutes) { const h24 = Math.floor(minutes/60); const m = minutes % 60; const h = h24 % 12 || 12; const suffix = h24 % 24 >= 12 ? 'PM' : 'AM'; return `${h}:${String(m).padStart(2,'0')} ${suffix}`; }
function timeValue(minutes) { return `${String(Math.floor(minutes/60)).padStart(2,'0')}:${String(minutes%60).padStart(2,'0')}:00`; }
function overlaps(a1, a2, b1, b2) { return a1 < b2 && a2 > b1; }
function escapeHtml(value) { return String(value ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;'); }
function createPlayerSummary(user) {
  if (!user) return null;
  const name = user.name || user.username || 'User';
  if (!name) return null;
  return {
    id: user.id ?? '__self__',
    name,
    cm_no: user.cm_no || '',
    fees_status: user.fees_status || 'paid'
  };
}
function formatPlayerLine(player) { return `${player?.name || 'User'}${player?.cm_no ? ` • CM: ${player.cm_no}` : ''}`; }
function getFallbackCurrentUser() {
  const user = state.currentUser || {};
  return {
    id: user.id ?? '__self__',
    name: user.name || user.username || 'User',
    cm_no: user.cm_no || '',
    fees_status: user.fees_status || 'paid'
  };
}
function resetPlayersToSelf() {
  const fallbackUser = getFallbackCurrentUser();
  const me = createPlayerSummary(fallbackUser);
  state.selectedPlayers = me ? [me] : [];
}
function getCourtImageUrl(court) { return court?.picture ? `${state.apiBase}/uploads/courts/${String(court.picture).replace(/^\/+/, '')}` : 'assets/images/icon.png'; }

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

function clearAlert() {
  el.noticeModal.classList.remove('show');
}

function openImageViewer(src, altText = 'Court image') {
  el.imageViewerImg.src = src;
  el.imageViewerImg.alt = altText;
  el.imageViewerTitle.textContent = altText || 'Court Preview';
  el.imageViewerModal.classList.add('show');
}

function closeImageViewer() {
  el.imageViewerModal.classList.remove('show');
  el.imageViewerImg.src = '';
}

function getFilteredCourts() {
  const q = state.courtSearch.trim().toLowerCase();
  return q ? state.courts.filter(c => String(c.name || '').toLowerCase().includes(q)) : state.courts;
}

function getSelectablePlayers() {
  const q = state.playerSearch.trim().toLowerCase();
  return state.players.filter((player) => {
    if (state.selectedPlayers.some((selected) => String(selected.id) === String(player.id))) return false;
    return [player.name, player.cm_no].some((field) => String(field || '').toLowerCase().includes(q));
  });
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

function renderCourtList() {
  const courts = getFilteredCourts();
  if (!courts.length) {
    el.courtList.innerHTML = '<div class="muted" style="margin-top:12px;">No courts found.</div>';
    return;
  }

  el.courtList.innerHTML = courts.map((court) => `
    <button type="button" class="court-item ${state.selectedCourt && String(state.selectedCourt.id) === String(court.id) ? 'active' : ''}" data-court-id="${escapeHtml(court.id)}">
      <div class="court-item-wrap">
        <img class="court-thumb" data-preview-image="${escapeHtml(getCourtImageUrl(court))}" data-preview-alt="${escapeHtml(court.name || 'Court')}" src="${escapeHtml(getCourtImageUrl(court))}" alt="${escapeHtml(court.name || 'Court')}" onerror="this.onerror=null;this.src='assets/images/icon.png';">
        <div class="court-item-title">${escapeHtml(court.name || 'Court')}</div>
      </div>
    </button>
  `).join('');

  el.courtList.querySelectorAll('[data-court-id]').forEach((button) => {
    button.addEventListener('click', async () => {
      const court = state.courts.find((item) => String(item.id) === String(button.getAttribute('data-court-id')));
      if (!court) return;
      state.selectedCourt = court;
      state.selectedDate = startOfDay(new Date());
      state.visibleMonth = startOfMonth(state.selectedDate);
      state.selectedDuration = 30;
      state.selectedSlot = null;
      resetPlayersToSelf();
      clearAlert();
      renderCourtList();
      renderBookingForm();
      await loadBookings();
    });
  });

  el.courtList.querySelectorAll('[data-preview-image]').forEach((image) => {
    image.addEventListener('click', (event) => {
      event.preventDefault();
      event.stopPropagation();
      openImageViewer(image.getAttribute('data-preview-image'), image.getAttribute('data-preview-alt') || 'Court image');
    });
  });
}

function renderBookingForm() {
  if (!state.selectedCourt) {
    el.bookingContent.innerHTML = '<div class="muted">Select a court first.</div>';
    return;
  }

  const slotItems = getSlotItems();
  const selectedSummary = state.selectedSlot ? `${formatDateLabel(state.selectedDate)} | ${state.selectedSlot.label}` : 'Choose a date, duration, and available slot';
  const minDate = formatDateKey(new Date());

  el.bookingContent.innerHTML = `
    <div class="booking-top-grid">
      <div class="field-card">
        <h3>Court</h3>
        <div class="court-field-row">
          <img class="court-preview" id="selectedCourtPreview" src="${escapeHtml(getCourtImageUrl(state.selectedCourt))}" alt="${escapeHtml(state.selectedCourt.name || 'Court')}" onerror="this.onerror=null;this.src='assets/images/icon.png';">
          <input class="field" type="text" value="${escapeHtml(state.selectedCourt.name || '')}" disabled>
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

    <div class="field-card" style="margin-top:14px;">
      <h3>Players</h3>
      <div class="players-list">
        ${state.selectedPlayers.map((player, index) => `
          <div class="player-row">
            <span>${index + 1}. ${escapeHtml(formatPlayerLine(player))}</span>
            ${index === 0
              ? '<span class="muted">You</span>'
              : `<button type="button" class="btn btn-remove" data-remove-player="${escapeHtml(player.id)}">Remove</button>`}
          </div>
        `).join('')}
      </div>
      <div style="margin-top:10px;">
        <button type="button" class="btn btn-add" id="openPlayerModal" ${state.selectedPlayers.length >= MAX_BOOKING_PLAYERS ? 'disabled' : ''}>Add Player</button>
        <div class="helper">Maximum 4 players including you. Defaulters are not allowed.</div>
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

  document.querySelectorAll('[data-remove-player]').forEach((button) => {
    button.addEventListener('click', () => {
      const playerId = button.getAttribute('data-remove-player');
      state.selectedPlayers = state.selectedPlayers.filter((player) => String(player.id) !== String(playerId));
      if (!state.selectedPlayers.length) {
        resetPlayersToSelf();
      }
      renderBookingForm();
    });
  });

  document.getElementById('openPlayerModal').addEventListener('click', openPlayerModal);
  document.getElementById('bookNow').addEventListener('click', handleBookNow);
  document.getElementById('selectedCourtPreview').addEventListener('click', () => {
    openImageViewer(getCourtImageUrl(state.selectedCourt), state.selectedCourt?.name || 'Court image');
  });
}

function renderPlayerOptions() {
  const players = getSelectablePlayers();
  if (!players.length) {
    el.playerOptions.innerHTML = '<div class="muted">No more users available to add.</div>';
    return;
  }

  el.playerOptions.innerHTML = players.map((player) => `
    <button type="button" class="player-option" data-player-id="${escapeHtml(player.id)}">
      <div><strong>${escapeHtml(player.name)}</strong></div>
      <div class="muted">${player.cm_no ? `CM: ${escapeHtml(player.cm_no)}` : 'No CM number'}</div>
    </button>
  `).join('');

  el.playerOptions.querySelectorAll('[data-player-id]').forEach((button) => {
    button.addEventListener('click', () => {
      const player = state.players.find((item) => String(item.id) === String(button.getAttribute('data-player-id')));
      if (!player) return;
      if (String(player.id) === String(state.currentUser?.id) || String(player.id) === String(state.selectedPlayers[0]?.id)) return;
      if (String(player.fees_status || 'paid').toLowerCase() === 'defaulter') {
        showAlert('This user is defaulter. Select other user.', 'error', `${player.name} Cannot Be Added`);
        return;
      }
      if (state.selectedPlayers.length >= MAX_BOOKING_PLAYERS) {
        showAlert('Booking can have maximum 4 players including you', 'error', 'Limit Reached');
        return;
      }
      state.selectedPlayers = [...state.selectedPlayers, player];
      closePlayerModal();
      renderBookingForm();
    });
  });
}

function openPlayerModal() {
  loadPlayersAndOpenModal();
}

function closePlayerModal() {
  el.playerModal.classList.remove('show');
}

async function loadPlayersAndOpenModal() {
  try {
    clearAlert();
    state.playerSearch = '';
    el.playerSearch.value = '';
    el.playerOptions.innerHTML = '<div class="muted">Loading users...</div>';
    el.playerModal.classList.add('show');

    const data = await requestJson(`${PAGE_ENDPOINT}?ajax=players`);
    state.players = Array.isArray(data.players) ? data.players : [];
    state.currentUser = data.currentUser || state.currentUser;
    if (!state.selectedPlayers.length) {
      resetPlayersToSelf();
    }
    renderPlayerOptions();
  } catch (error) {
    if (error.status === 401) {
      window.location.href = 'login';
      return;
    }
    closePlayerModal();
    showAlert(error.message || 'We could not load players right now.', 'error', 'Players Unavailable');
  }
}

async function loadBootstrap() {
  try {
    clearAlert();
    el.courtList.innerHTML = '<div class="muted">Loading courts...</div>';
    const data = await requestJson(`${PAGE_ENDPOINT}?ajax=bootstrap`);
    state.apiBase = data.apiBase || '';
    state.courts = Array.isArray(data.courts) ? data.courts : [];
    state.players = [];
    state.currentUser = data.currentUser || state.currentUser;
    resetPlayersToSelf();
    renderCourtList();
    renderBookingForm();
  } catch (error) {
    if (error.status === 401) {
      window.location.href = 'login';
      return;
    }
    showAlert(error.message || 'Failed to load court form', 'error', 'Courts Unavailable');
    el.courtList.innerHTML = '<div class="muted">Could not load courts.</div>';
  }
}

async function loadBookings() {
  if (!state.selectedCourt) return;
  try {
    const params = new URLSearchParams({ ajax:'bookings', courtId:String(state.selectedCourt.id), date:formatDateKey(state.selectedDate) });
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
    showAlert(error.message || 'Failed to fetch bookings', 'error', 'Slots Unavailable');
  }
}

async function handleBookNow() {
  if (!state.selectedCourt || !state.selectedSlot || !state.selectedSlot.available) {
    showAlert('Please choose an available slot before booking.', 'error', 'Select Slot');
    return;
  }

  state.submitting = true;
  renderBookingForm();

  try {
    const data = await requestJson(`${PAGE_ENDPOINT}?ajax=create-booking`, {
      method: 'POST',
      body: JSON.stringify({
        courtId: state.selectedCourt.id,
        bookingDate: formatDateKey(state.selectedDate),
        startTime: timeValue(state.selectedSlot.start),
        endTime: timeValue(state.selectedSlot.end),
        playerIds: state.selectedPlayers.map((player) => player.id),
      }),
    });

    showAlert(data.message || 'Booking created successfully.', 'success', 'Booking Created');
    state.selectedSlot = null;
    resetPlayersToSelf();
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

el.courtSearch.addEventListener('input', (event) => {
  state.courtSearch = event.target.value || '';
  renderCourtList();
});

el.playerSearch.addEventListener('input', (event) => {
  state.playerSearch = event.target.value || '';
  renderPlayerOptions();
});

el.closePlayerModal.addEventListener('click', closePlayerModal);
el.playerModal.addEventListener('click', (event) => {
  if (event.target === el.playerModal) closePlayerModal();
});
el.closeNoticeModal.addEventListener('click', clearAlert);
el.noticeModal.addEventListener('click', (event) => {
  if (event.target === el.noticeModal) clearAlert();
});
el.closeImageViewerModal.addEventListener('click', closeImageViewer);
el.imageViewerModal.addEventListener('click', (event) => {
  if (event.target === el.imageViewerModal) closeImageViewer();
});

loadBootstrap();
</script>
</body>
</html>
