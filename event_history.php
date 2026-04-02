<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

require_auth();

if (!function_exists('event_history_array_is_list')) {
    function event_history_array_is_list(array $array): bool
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

function event_history_api_request_first_success(string $method, array $endpoints, array $payload = [], ?string $token = null): array
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

        if (in_array((int) ($response['status'] ?? 0), [400, 401, 403, 404, 422], true)) {
            return $response;
        }
    }

    return $lastResponse;
}

function event_history_message_from_response(array $response, string $fallback): string
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

function event_history_extract_list(array $responseData): array
{
    if (event_history_array_is_list($responseData)) {
        return $responseData;
    }

    if (isset($responseData['items']) && is_array($responseData['items']) && event_history_array_is_list($responseData['items'])) {
        return $responseData['items'];
    }

    if (isset($responseData['data']) && is_array($responseData['data'])) {
        if (event_history_array_is_list($responseData['data'])) {
            return $responseData['data'];
        }

        if (isset($responseData['data']['items']) && is_array($responseData['data']['items']) && event_history_array_is_list($responseData['data']['items'])) {
            return $responseData['data']['items'];
        }
    }

    return [];
}

function event_history_format_date(?string $value): string
{
    if ($value === null || trim($value) === '') {
        return '-';
    }

    $timestamp = strtotime($value);

    return $timestamp ? date('d M Y', $timestamp) : '-';
}

function event_history_format_time(?string $value): string
{
    if ($value === null || trim($value) === '') {
        return '-';
    }

    $timestamp = strtotime($value);

    return $timestamp ? date('g:i A', $timestamp) : '-';
}

function event_history_title(array $item): string
{
    foreach (['event_name', 'name', 'venue_name', 'title'] as $key) {
        if (!empty($item[$key]) && is_string($item[$key])) {
            return $item[$key];
        }
    }

    return 'Event Booking';
}

$token = auth_token();
$history = [];
$historyError = '';

if ($token !== null && $token !== '') {
    $historyResponse = event_history_api_request_first_success('GET', ['api/event-bookings/my'], [], $token);

    if ($historyResponse['success']) {
        $history = array_values(array_filter(
            event_history_extract_list(is_array($historyResponse['data']) ? $historyResponse['data'] : []),
            static fn(mixed $item): bool => is_array($item)
        ));
    } elseif (in_array((int) ($historyResponse['status'] ?? 0), [401, 403], true)) {
        logout_user();
        $_SESSION['auth_error'] = 'Your session has expired. Please login again.';
        redirect('login');
    } else {
        $historyError = event_history_message_from_response($historyResponse, 'Could not load your event booking history.');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Event History | NNGK</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" referrerpolicy="no-referrer" />
<link rel="icon" type="image/png" href="<?php echo htmlspecialchars(asset_url('assets/images/icon.png'), ENT_QUOTES, 'UTF-8'); ?>">
<link rel="stylesheet" href="<?php echo htmlspecialchars(asset_url('assets/css/style.css'), ENT_QUOTES, 'UTF-8'); ?>">
<style>
body.page-event-history { font-family:'Poppins',sans-serif; background:
radial-gradient(circle at top left, rgba(14,165,233,.08), transparent 30%),
linear-gradient(180deg, #edf4fb 0%, #e8eef6 100%); color:#212529; }
body.page-event-history .history-shell { padding:20px; max-width:1140px; }
body.page-event-history .history-box { background:#fff; border:1px solid #d8dee6; border-radius:10px; padding:16px; margin-bottom:14px; box-shadow:0 8px 24px rgba(15,23,42,.05); }
body.page-event-history h1 { margin:0 0 4px; font-size:22px; font-weight:700; font-family:'Poppins',sans-serif; color:#212529; }
body.page-event-history .muted { color:#63718a; font-size:12.5px; }
body.page-event-history .top-actions { display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap; }
body.page-event-history .btn { display:inline-flex; align-items:center; justify-content:center; gap:7px; min-height:36px; padding:0 13px; border-radius:6px; border:1px solid transparent; text-decoration:none; font-size:12px; font-weight:600; cursor:pointer; font-family:'Poppins',sans-serif; }
body.page-event-history .btn-primary { background:#2563eb; border-color:#2563eb; color:#ffffff; box-shadow:none; }
body.page-event-history .alert-box { padding:12px 14px; border-radius:12px; margin-bottom:16px; font-size:12px; background:#fff3f3; color:#842029; border:1px solid #f2c8cd; box-shadow:0 10px 22px rgba(132,32,41,.06); }
body.page-event-history .history-list { display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:12px; }
body.page-event-history .history-card { background:linear-gradient(180deg,#ffffff 0%, #fbfdff 100%); border:1px solid #dce5ef; border-radius:16px; padding:12px; box-shadow:0 12px 24px rgba(15,23,42,.05); }
body.page-event-history .card-header { display:flex; justify-content:space-between; align-items:flex-start; gap:10px; }
body.page-event-history .title-wrap { display:flex; align-items:center; gap:10px; flex:1; }
body.page-event-history .title-icon { width:34px; height:34px; border-radius:11px; background:linear-gradient(135deg, #dbeafe, #e0f2fe); color:#0284c7; display:flex; align-items:center; justify-content:center; flex-shrink:0; border:1px solid #cae7fb; font-size:13px; }
body.page-event-history .card-title { margin:0; font-size:13px; font-weight:800; font-family:'Plus Jakarta Sans',sans-serif; color:#13233f; }
body.page-event-history .card-id { margin-top:2px; font-size:10px; color:#7a879a; }
body.page-event-history .chip { display:inline-flex; align-items:center; justify-content:center; min-height:24px; padding:0 9px; border-radius:999px; font-size:9px; font-weight:800; letter-spacing:.35px; font-family:'Plus Jakarta Sans',sans-serif; }
body.page-event-history .status-approved { background:#eaf8f1; color:#1f9d62; }
body.page-event-history .status-pending { background:#fff6de; color:#c98600; }
body.page-event-history .status-rejected { background:#fdecec; color:#d64d4d; }
body.page-event-history .status-cancelled { background:#f4f5f7; color:#667085; }
body.page-event-history .status-default { background:#eef2ff; color:#2b2d42; }
body.page-event-history .payment-paid { background:#eaf8f1; color:#1f9d62; }
body.page-event-history .payment-unpaid { background:#fdecec; color:#d64d4d; }
body.page-event-history .payment-default { background:#eef2ff; color:#2b2d42; }
body.page-event-history .info-grid { margin-top:10px; display:grid; grid-template-columns:1fr 1fr; gap:8px; }
body.page-event-history .info-item { display:flex; gap:8px; align-items:center; border:1px solid #d9e0e8; border-radius:10px; padding:8px; background:linear-gradient(180deg, #fbfdff 0%, #f7fafe 100%); }
body.page-event-history .info-icon { width:28px; height:28px; border-radius:9px; background:linear-gradient(135deg, #dbeafe, #e9f7ef); color:#2b2d42; display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:12px; }
body.page-event-history .info-label { font-size:9px; color:#6b7280; }
body.page-event-history .info-value { margin-top:1px; font-size:10.5px; color:#13233f; font-weight:700; }
body.page-event-history .footer-row { margin-top:10px; padding-top:10px; border-top:1px dashed #dbe4ee; display:flex; justify-content:space-between; align-items:center; gap:10px; flex-wrap:wrap; }
body.page-event-history .note-box { margin-top:10px; border-radius:10px; background:linear-gradient(180deg, #edf5ff 0%, #e5f0ff 100%); border:1px solid #c7ddff; padding:9px; }
body.page-event-history .note-label { font-size:10px; color:#13233f; font-weight:800; font-family:'Plus Jakarta Sans',sans-serif; }
body.page-event-history .note-text { margin-top:3px; font-size:10.5px; line-height:1.5; color:#5b6f9e; }
body.page-event-history .empty-card { border-radius:20px; background:linear-gradient(180deg,#ffffff 0%, #fbfdff 100%); border:1px solid #dce5ef; padding:28px 20px; text-align:center; box-shadow:0 16px 34px rgba(15,23,42,.05); }
body.page-event-history .empty-icon { width:62px; height:62px; border-radius:20px; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,#dbeafe,#e0f2fe); color:#0284c7; margin:0 auto 14px; }
body.page-event-history .empty-title { margin:0; font-size:18px; font-weight:800; font-family:'Plus Jakarta Sans',sans-serif; color:#13233f; }
body.page-event-history .empty-text { margin:6px auto 0; max-width:420px; font-size:12px; line-height:1.7; color:#6b7280; }
body.page-event-history .empty-action { margin-top:14px; }
@media (max-width: 768px) {
    body.page-event-history .history-shell { padding:12px; }
    body.page-event-history h1 { font-size:25px; }
    body.page-event-history .history-list { grid-template-columns:1fr; }
    body.page-event-history .info-grid { grid-template-columns:1fr; }
}
</style>
</head>
<body class="page-event-history">
<?php include 'sidebar.php'; ?>
<main class="app history-shell">
    <div class="history-box">
        <div class="top-actions">
            <div>
                <h1>Event Booking History</h1>
            </div>
            <a href="<?php echo htmlspecialchars(app_url('event_form'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary"><i class="fa-solid fa-plus"></i><span>New Booking</span></a>
        </div>
    </div>

    <?php if ($historyError !== ''): ?>
        <div class="alert-box"><?php echo htmlspecialchars($historyError, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <?php if ($history !== []): ?>
        <div class="history-list">
            <?php foreach ($history as $item): ?>
                <?php
                $bookingStatus = strtoupper((string) ($item['booking_status'] ?? 'PENDING'));
                $paymentStatus = strtoupper((string) ($item['payment_status'] ?? 'UNPAID'));

                $statusClass = match ($bookingStatus) {
                    'APPROVED' => 'status-approved',
                    'PENDING' => 'status-pending',
                    'REJECTED' => 'status-rejected',
                    'CANCELLED' => 'status-cancelled',
                    default => 'status-default',
                };

                $paymentClass = match ($paymentStatus) {
                    'PAID' => 'payment-paid',
                    'UNPAID' => 'payment-unpaid',
                    default => 'payment-default',
                };
                ?>
                <div class="history-card">
                    <div class="card-header">
                        <div class="title-wrap">
                            <div class="title-icon">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                            <div>
                                <p class="card-title"><?php echo htmlspecialchars(event_history_title($item), ENT_QUOTES, 'UTF-8'); ?></p>
                                <div class="card-id">Request #<?php echo htmlspecialchars((string) ($item['id'] ?? '-'), ENT_QUOTES, 'UTF-8'); ?></div>
                            </div>
                        </div>
                        <span class="chip <?php echo $statusClass; ?>"><?php echo htmlspecialchars($bookingStatus, ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>

                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-icon"><i class="fa-solid fa-calendar-days"></i></div>
                            <div>
                                <div class="info-label">Date</div>
                                <div class="info-value"><?php echo htmlspecialchars(event_history_format_date((string) ($item['booking_date'] ?? '')), ENT_QUOTES, 'UTF-8'); ?></div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon"><i class="fa-regular fa-clock"></i></div>
                            <div>
                                <div class="info-label">Time</div>
                                <div class="info-value">
                                    <?php
                                    echo htmlspecialchars(
                                        event_history_format_time((string) ($item['start_time'] ?? '')) . ' - ' . event_history_format_time((string) ($item['end_time'] ?? '')),
                                        ENT_QUOTES,
                                        'UTF-8'
                                    );
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="footer-row">
                        <span class="chip <?php echo $paymentClass; ?>"><?php echo htmlspecialchars($paymentStatus, ENT_QUOTES, 'UTF-8'); ?></span>
                        <span class="muted">Created <?php echo htmlspecialchars(event_history_format_date((string) ($item['created_at'] ?? '')), ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>

                    <?php if (!empty($item['admin_note']) && is_string($item['admin_note'])): ?>
                        <div class="note-box">
                            <div class="note-label">Admin Note</div>
                            <div class="note-text"><?php echo nl2br(htmlspecialchars($item['admin_note'], ENT_QUOTES, 'UTF-8')); ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-card">
            <div class="empty-icon"><i class="fa-solid fa-calendar-check"></i></div>
            <p class="empty-title">No event requests yet</p>
            <p class="empty-text">Your event booking requests will appear here once you submit them.</p>
            <div class="empty-action">
                <a href="<?php echo htmlspecialchars(app_url('event_form'), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary">Open Booking Center</a>
            </div>
        </div>
    <?php endif; ?>
</main>
</body>
</html>
