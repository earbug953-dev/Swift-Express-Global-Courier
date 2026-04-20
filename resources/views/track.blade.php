<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking - {{ $shipment->tracking_number ?? 'SWF123456' }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
    <style>
        * { box-sizing: border-box; }

        body {
            background: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 13px;
            color: #333;
        }

        /* ─── TOP NAV ──────────────────────────────────────── */
        .top-nav {
            background: #fff;
            border-bottom: 1px solid #e0e0e0;
            padding: 8px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .top-nav .logo {
            font-size: 18px;
            font-weight: 800;
            color: #1a73e8;
            letter-spacing: -0.5px;
            text-decoration: none;
        }
        .top-nav .logo span { color: #333; }
        .top-nav .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .top-nav .nav-links a {
            font-size: 12px;
            color: #555;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
        }
        .top-nav .nav-links a:hover { background: #f5f5f5; }
        .top-nav .btn-track {
            background: #1a73e8;
            color: #fff !important;
            border-radius: 4px;
            padding: 5px 14px !important;
            font-size: 12px;
        }
        .top-nav .btn-login {
            border: 1px solid #1a73e8;
            color: #1a73e8 !important;
            border-radius: 4px;
            padding: 5px 14px !important;
            font-size: 12px;
        }
        .lang-select {
            font-size: 12px;
            color: #555;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ─── SHIPMENT STATUS BAR ───────────────────────────── */
        .status-bar {
            background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            padding: 14px 18px;
            margin-bottom: 14px;
        }
        .status-bar h5 {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 6px;
            color: #222;
        }
        .badge-on-hold {
            background: #fce4ec;
            color: #c62828;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            display: inline-block;
        }
        .badge-in-transit {
            background: #e3f2fd;
            color: #1565c0;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            display: inline-block;
        }
        .badge-delivered {
            background: #e8f5e9;
            color: #2e7d32;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            display: inline-block;
        }
        .notice-text {
            color: #c62828;
            font-size: 12px;
            font-weight: 600;
            margin-top: 4px;
        }
        .notice-text i { margin-right: 4px; }

        /* ─── PROGRESS BAR ──────────────────────────────────── */
        .progress-label {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #888;
            margin-bottom: 3px;
        }
        .dot-done {
    background: #28a745;
    border-color: #28a745;
}

.tag-success {
    background: #28a745;
    color: #fff;
}
        .progress-wrap .progress {
            height: 8px;
            border-radius: 10px;
            background: #e8e8e8;
        }
        .progress-wrap .progress-bar {
            background: linear-gradient(90deg, #1a73e8, #4fc3f7);
            border-radius: 10px;
        }
        .progress-pct {
            text-align: right;
            font-size: 11px;
            font-weight: 700;
            color: #1a73e8;
            margin-top: 2px;
        }

        /* ─── SECTION CARDS ─────────────────────────────────── */
        .section-card {
            background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            padding: 14px 16px;
            margin-bottom: 14px;
        }
        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: #222;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-title i {
            color: #1a73e8;
            font-size: 14px;
        }

        /* ─── TIMELINE ──────────────────────────────────────── */
        .timeline { position: relative; padding-left: 0; }

        .timeline-item {
            display: flex;
            gap: 12px;
            margin-bottom: 10px;
            position: relative;
        }

        .timeline-left {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 30px;
            flex-shrink: 0;
        }

        .timeline-dot {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            color: #fff;
            flex-shrink: 0;
            z-index: 2;
        }
        .dot-done    { background: #43a047; }
        .dot-active  { background: #1a73e8; }
        .dot-pending { background: #bdbdbd; }

        .timeline-line {
            width: 2px;
            flex: 1;
            background: #e0e0e0;
            min-height: 20px;
            margin-top: 2px;
        }
        .timeline-line.done { background: #43a047; }

        .timeline-content {
            flex: 1;
            background: #f8fafb;
            border: 1px solid #e5e5e5;
            border-radius: 7px;
            padding: 10px 12px;
            margin-bottom: 10px;
        }
        .timeline-content.active-item {
            border-color: #1a73e8;
            background: #f0f6ff;
        }
        .timeline-content .tl-title {
            font-weight: 700;
            font-size: 13px;
            color: #222;
            margin-bottom: 2px;
        }
        .timeline-content .tl-sub {
            font-size: 11.5px;
            color: #666;
            margin-bottom: 3px;
        }
        .timeline-content .tl-date {
            font-size: 11px;
            color: #999;
        }
        .tl-status-tag {
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 10px;
            font-weight: 600;
            display: inline-block;
            margin-left: 6px;
        }
        .tag-done    { background: #e8f5e9; color: #2e7d32; }
        .tag-active  { background: #e3f2fd; color: #1565c0; }
        .tag-pending { background: #f5f5f5; color: #9e9e9e; }

        /* ─── SIDEBAR MAP MINI ──────────────────────────────── */
        .mini-map-card {
            background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 14px;
        }
        .mini-map-card .map-label {
            padding: 8px 12px;
            background: #f9f9f9;
            font-size: 11px;
            color: #555;
            border-bottom: 1px solid #eee;
        }
        .mini-map-card iframe {
            width: 100%;
            height: 140px;
            border: none;
            display: block;
        }
        .mini-map-card .map-address {
            padding: 8px 12px;
            font-size: 11.5px;
            font-weight: 600;
            color: #333;
        }
        .mini-map-card .map-coords {
            padding: 0 12px 8px;
            font-size: 10.5px;
            color: #888;
        }

        /* ─── PACKAGE PHOTO ─────────────────────────────────── */
        .pkg-photo {
            width: 100%;
            border-radius: 6px;
            object-fit: cover;
            max-height: 160px;
        }
        .pkg-photo-caption {
            font-size: 11px;
            color: #888;
            margin-top: 5px;
            text-align: center;
        }

        /* ─── DETAILS TABLE ─────────────────────────────────── */
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 12px;
        }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { color: #888; font-weight: 500; }
        .detail-value { color: #222; font-weight: 600; text-align: right; max-width: 60%; word-break: break-word; }
        .detail-value a { color: #1a73e8; text-decoration: none; }
        .detail-value a:hover { text-decoration: underline; }

        /* ─── DELIVERY SCHEDULE ─────────────────────────────── */
        .schedule-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid #f5f5f5;
            font-size: 12px;
        }
        .schedule-row:last-child { border-bottom: none; }

        /* ─── SHIPMENT PARTIES ──────────────────────────────── */
        .party-card {
            background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            padding: 14px 16px;
        }
        .party-box {
            border: 1px solid #e5e5e5;
            border-radius: 7px;
            padding: 12px 14px;
            height: 100%;
        }
        .party-icon {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            margin-bottom: 8px;
        }
        .sender-icon   { background: #e3f2fd; color: #1565c0; }
        .receiver-icon { background: #fce4ec; color: #c62828; }
        .party-name {
            font-size: 13px;
            font-weight: 700;
            color: #222;
            margin-bottom: 8px;
        }
        .party-detail {
            font-size: 11.5px;
            color: #666;
            margin-bottom: 4px;
            display: flex;
            align-items: flex-start;
            gap: 6px;
        }
        .party-detail i {
            color: #1a73e8;
            font-size: 11px;
            margin-top: 2px;
            flex-shrink: 0;
        }

        /* ─── PACKAGE DESCRIPTION ───────────────────────────── */
        .desc-text {
            font-size: 12.5px;
            color: #555;
            line-height: 1.6;
        }

        /* ─── CURRENT LOCATION FULL MAP ─────────────────────── */
        .full-map iframe {
            width: 100%;
            height: 260px;
            border: none;
            border-radius: 6px;
        }
        .map-pin-label {
            font-size: 11.5px;
            color: #555;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .map-pin-label i { color: #1a73e8; }

        /* ─── URGENT NOTICE BOX ─────────────────────────────── */
        .urgent-box {
            background: #fff8e1;
            border: 1px solid #ffe082;
            border-left: 4px solid #f57c00;
            border-radius: 7px;
            padding: 14px 16px;
            margin-bottom: 14px;
        }
        .urgent-box h6 {
            color: #e65100;
            font-weight: 800;
            font-size: 13px;
            margin-bottom: 6px;
        }
        .urgent-box p {
            font-size: 12px;
            color: #555;
            margin-bottom: 8px;
        }
        .urgent-box .fee-amount {
            font-size: 16px;
            font-weight: 800;
            color: #c62828;
        }

        /* ─── RESPONSIVE ─────────────────────────────────────── */
        @media (max-width: 767px) {
            .top-nav .nav-links { display: none; }
            .top-nav .mobile-links { display: flex; gap: 6px; }
        }
    </style>
</head>
<body>

<!-- ════════════════════════════════════════════
     TOP NAVIGATION
═════════════════════════════════════════════ -->
<div class="top-nav">
    <div class="d-flex align-items-center gap-3">
        <span class="lang-select">
            <i class="fas fa-globe" style="font-size:12px"></i> English &nbsp;▾
        </span>
        <a href="/" class="logo">Swift Express Global Courier</a>
    </div>
    <div class="nav-links d-flex align-items-center gap-2">
        <a href="/"><i class="fas fa-search" style="font-size:11px"></i> &nbsp;TRACKING PROCEDURE</a>
    </div>
</div>

<!-- ════════════════════════════════════════════
     PAGE WRAPPER
═════════════════════════════════════════════ -->
<div class="container-fluid" style="max-width:1100px; padding: 18px 16px;">

    <!-- ── SHIPMENT STATUS ───────────────────────────────── -->
    <div class="status-bar">
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-2">
            <div>
                <h5>
                    Shipment Status
                    @php $status = $shipment->status ?? 'on_hold'; @endphp
                    @if($status === 'on_hold' || $status === 'On Hold')
                        <span class="badge-on-hold ms-2">ON HOLD</span>
                    @elseif($status === 'delivered')
                        <span class="badge-delivered ms-2">DELIVERED</span>
                    @else
                        <span class="badge-in-transit ms-2">{{ strtoupper($status) }}</span>
                    @endif
                </h5>
                @if($status === 'on_hold' || $status === 'On Hold')
                    <div class="notice-text">
                        <i class="fas fa-exclamation-triangle"></i>
                        Important Notice: Held at customs for inspection
                    </div>
                @endif
            </div>
            <div style="text-align:right">
                <div style="font-size:11px; color:#888;">Shipment Progress</div>
                <div style="font-size:13px; font-weight:800; color:#1a73e8;">
                    {{ $shipment->progress }}%
                </div>
            </div>
        </div>

        <!-- Progress bar -->
        <div class="progress-wrap mt-2">
            <div class="progress">
                <div class="progress-bar" style="width: {{ $shipment->progress }}%"></div>
            </div>
        </div>
    </div>

    <!-- ── URGENT NOTICE (On Hold only) ─────────────────── -->
      @if($status === 'on_hold' || $status === 'On Hold')
    <div class="urgent-box">
        <h6><i class="fas fa-exclamation-circle me-1"></i> URGENT NOTICE</h6>
        <p>
            <b>Action required:</b> A clearance fee is required to clear your package through customs and resume delivery, please complete the payment promptly to avoid delays.
        </p>
        <div class="mb-2">
            <span style="font-size:12px; color:#555;">CLEARANCE FEE:</span>
            <span class="fee-amount ms-2">$4,000.00</span>
        </div>
        {{-- <a href="{{ route('payment.checkout', $shipment->id) }}" class="btn btn-danger btn-sm fw-bold px-4">
            <i class="fas fa-credit-card me-1"></i> Pay Delivery Fee
        </a> --}}
    </div>
    @endif

    <!-- ── TWO-COLUMN LAYOUT ─────────────────────────────── -->
    <div class="row g-3">

        <!-- ════ LEFT COLUMN ════ -->
        <div class="col-lg-7">

            <!-- Shipment Timeline -->
            <div class="section-card">
                <div class="section-title">
                    <i class="fas fa-stream"></i> Shipment Timeline
                </div>
                <div class="timeline">


       @php
    $events = $shipment->events;
    $total = $events->count();
    $loop_i = 0;
@endphp
    @foreach($events as $event)
    @php
        $loop_i++;
        $isLast = ($loop_i === $total);
        // Force all events to show as pending
                    $lineClass = '';
        $contentClass = '';
        $isDone = !$event->pending; // done if pending = false
        
if ($isDone) {
    $dotClass = 'dot-done';     // green
    $tagClass = 'tag-success';  // green label
    $tagText = 'Completed';
} else {
    $dotClass = 'dot-pending';  // yellow/gray
    $tagClass = 'tag-pending';
    $tagText = 'current';
}
    @endphp
    <div class="timeline-item">
        <div class="timeline-left">
            <div class="timeline-dot {{ $dotClass }}">
                <i class="fas fa-circle" style="font-size:7px"></i>
            </div>
            @if(!$isLast)
            <div class="timeline-line {{ $lineClass }}"></div>
            @endif
        </div>
        <div class="timeline-content {{ $contentClass }}">
            <div class="tl-title">
                {{ $event->location ?? 'Unknown Location' }}
                <span class="tl-status-tag {{ $tagClass }}">{{ $tagText }}</span>
            </div>
            <div class="tl-sub">{{ $event->description ?? '' }}</div>
            <div class="tl-date">
                <i class="far fa-clock me-1"></i>
                {{ isset($event->occurred_at) ? \Carbon\Carbon::parse($event->occurred_at)->format('D, M d, Y – h:i A') : '' }}
            </div>
        </div>
    </div>
    @endforeach

                </div>
            </div>

            <!-- Current Location Map (Full) -->
            <div class="section-card">
                <div class="section-title">
                    <i class="fas fa-map-marker-alt"></i> Current Location Map
                </div>
                <div class="map-pin-label">
                    <i class="fas fa-circle" style="color:#1a73e8; font-size:8px"></i>
                    {{ $shipment->current_city ?? '#98146 115 SW 108th Street Burien Washington' }}
                </div>
                <div class="full-map">
                    <iframe
                        loading="lazy"
                        allowfullscreen
                        src="https://www.google.com/maps?q={{ $shipment->current_lat }},{{ $shipment->current_lng }}&z=14&output=embed">
                    </iframe>
                </div>
            </div>

            <!-- Shipment Parties -->
            <div class="section-card">
                <div class="section-title">
                    <i class="fas fa-users"></i> Shipment Parties
                </div>
                <div class="row g-3">
                    <!-- Sender -->
                    <div class="col-sm-6">
                        <div class="party-box">
                            <div class="party-icon sender-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="party-name">{{ $shipment->sender_name  }}</div>
                            <div class="party-detail">
                                <i class="fas fa-envelope"></i>
                                <span>{{ $shipment->sender_email ?? 'dr.williamsmakishealthpage@outlookcom' }}</span>
                            </div>
                            <div class="party-detail">
                                <i class="fas fa-phone"></i>
                                <span>{{ $shipment->sender_phone ?? '+1 (386) 260‑8546' }}</span>
                            </div>
                            <div class="party-detail">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>
                                    {{ $shipment->sender_address ?? '5970 Mullen Way, #36560, Edmonton, AB T6R0T4' }},
                                    {{ $shipment->sender_city ?? '' }},
                                    {{ $shipment->sender_country ?? 'Canada' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- Receiver -->
                    <div class="col-sm-6">
                        <div class="party-box">
                            <div class="party-icon receiver-icon">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <div class="party-name">{{ $shipment->receiver_name }}</div>
                            <div class="party-detail">
                                <i class="fas fa-envelope"></i>
                                <span>{{ $shipment->receiver_email ?? ' caudexkitty@hotmail.com' }}</span>
                            </div>
                            <div class="party-detail">
                                <i class="fas fa-phone"></i>
                                <span>{{ $shipment->receiver_phone }}</span>
                            </div>
                            <div class="party-detail">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>
                                    {{ $shipment->receiver_address ?? '#98146 115 SW 108th Street, Burien, Washington ' }},
                                    {{ $shipment->receiver_city ?? '' }},
                                    {{ $shipment->receiver_country ?? 'United States' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Package Description -->
            <div class="section-card">
                <div class="section-title">
                    <i class="fas fa-file-alt"></i> Package Description
                </div>
                <p class="desc-text">
                    {{ $shipment->description ?? $shipment->goods_description ?? 'DRILL, QUADRUPLET' }}
                </p>
            </div>

        </div>
        <!-- /LEFT COLUMN -->

        <!-- ════ RIGHT SIDEBAR ════ -->
        <div class="col-lg-5">

            <!-- Mini Map with Address -->
            <div class="mini-map-card">
                <div class="map-label">
                    <i class="fas fa-map-marker-alt me-1" style="color:#e53935"></i>
                    <strong>{{ $shipment->current_city ?? 'Aurora Laboratories' }}</strong>
                </div>
                <iframe
                    loading="lazy"
                    allowfullscreen
                    src="https://www.google.com/maps?q={{ $shipment->current_lat }},{{ $shipment->current_lng }}&z=14&output=embed">
                </iframe>
                <div class="map-address">
                    <i class="fas fa-map-marker-alt me-1" style="color:#e53935; font-size:11px"></i>
                    {{ $shipment->current_address ?? '#98146 115 SW 108th Street Burien Washington' }}
                </div>
                <div class="map-coords">
                    Last updated: {{ now()->format('M d, Y – h:i A') }}
                </div>
            </div>

            <!-- Package Photo -->
            @if(isset($shipment->product_image) && $shipment->product_image)
            <div class="section-card">
                <div class="section-title">
                    <i class="fas fa-camera"></i> Package Photo
                </div>
                <img src="{{ asset('uploads/' . $shipment->product_image) }}" class="pkg-photo">
                <div class="pkg-photo-caption">{{ $shipment->goods_description ?? 'PROTOCOL PACKAGE' }}</div>
            </div>
            @else
            <!-- Placeholder photo for demo -->
            <div class="section-card">
                <div class="section-title">
                    <i class="fas fa-camera"></i> Package Photo
                </div>
                <div style="background:#f5f5f5; border-radius:6px; height:130px; display:flex; align-items:center; justify-content:center;">
                    <div style="text-align:center; color:#bbb;">
                        <i class="fas fa-box-open" style="font-size:36px"></i>
                        <div style="font-size:11px; margin-top:6px;">Cargo present</div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Package Details -->
            <div class="section-card">
                <div class="section-title">
                    <i class="fas fa-cube"></i> Package Details
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tracking Number</span>
                    <span class="detail-value">
                        <a href="#">{{ $shipment->tracking_number }}</a>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Reference Number</span>
                    <span class="detail-value">{{ $shipment->reference ?? 'HardDR8pD1DCo' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Product Type</span>
                    <span class="detail-value">
                        {{ $shipment->package_type_label ?? ($shipment->package_type ?? 'PROTOCOL PACKAGE') }}
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Weight</span>
                    <span class="detail-value">{{ $shipment->weight ?? '10.542' }} kg</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Quantity</span>
                    <span class="detail-value">{{ $shipment->quantity ?? '1' }} Item(s)</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Shipping Mode</span>
                    <span class="detail-value">
                        {{ $shipment->service_type_label ?? ($shipment->service_type ?? 'Air Freight Forwarding') }}
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Courier Service</span>
                    <span class="detail-value">Swift Express Global Courier</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Payment Method</span>
                    <span class="detail-value">
                        <span style="background:#fff3e0; color:#e65100; font-size:11px; padding:2px 8px; border-radius:10px; font-weight:600;">
                            <i class="fas fa-coins me-1"></i>Other (payer)
                        </span>
                    </span>
                </div>
            </div>

            <!-- Delivery Schedule -->
            <div class="section-card">
                <div class="section-title">
                    <i class="fas fa-calendar-alt"></i> Delivery Schedule
                </div>
                <div class="schedule-row">
                    <span style="color:#888;">Order Date</span>
                    <span style="font-weight:600;">
                        {{ $shipment->created_at->format('Apr 8, Y') ?? 'Apr 8, 2026' }}
                    </span>
                </div>
                <div class="schedule-row">
                    <span style="color:#888;">Pickup Date</span>
                    <span style="font-weight:600;">
                        {{ $shipment->pickup_date->format('M d, Y') ?? 'Apr 8, 2026' }}
                    </span>
                </div>
                <div class="schedule-row">
                    <span style="color:#888;">Pickup Time</span>
                    <span style="font-weight:600;">
                        {{ $shipment->pickup_time ?? '15:00' }}
                    </span>

                </div>
                <div class="schedule-row">
                    <span style="color:#888;">Est. Delivery</span>
                    <span style="font-weight:600;">
                        {{ $shipment->estimated_delivery->format('M d, Y') ?? 'Apr 15, 2026' }}
                    </span>
                </div>
                <div class="schedule-row">
                    <span style="color:#888;">Transit Time</span>
                    <span style="font-weight:600;">{{ $shipment->transit_time ?? '3 days' }}</span>
                </div>
            </div>

        </div>
        <!-- /RIGHT SIDEBAR -->

    </div>
    <!-- /row -->

</div>
<!-- /container -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
