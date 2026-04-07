<!DOCTYPE html>
<html>
<head>
    <title>Tracking - {{ $shipment->tracking_number }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        /* HEADER */
        .header {
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
            color: white;
            padding: 35px 20px;
            border-radius: 0 0 25px 25px;
            text-align: center;
        }

        .header h3 {
            font-weight: 700;
        }

        /* CARD */
        .card-box {
            background: #fff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }

        /* STATUS BADGE */
        .status-badge {
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            background: #e7f1ff;
            color: #0d6efd;
            font-weight: 600;
        }

        .status-hold {
            background: #ffe5e5;
            color: red;
        }

        /* TIMELINE */
        .timeline {
            position: relative;
            margin-left: 10px;
        }

        .timeline::before {
            content: "";
            position: absolute;
            left: 10px;
            top: 0;
            width: 3px;
            height: 100%;
            background: #0d6efd;
        }

        .timeline-item {
            position: relative;
            padding-left: 35px;
            margin-bottom: 25px;
        }

        .timeline-item::before {
            content: "";
            position: absolute;
            left: 0;
            top: 5px;
            width: 20px;
            height: 20px;
            background: #0d6efd;
            border-radius: 50%;
        }

        .timeline-item h6 {
            margin: 0;
            font-weight: 600;
        }

        /* PROGRESS */
        .progress {
            height: 20px;
            border-radius: 10px;
        }

        /* IMAGE */
        .product-img {
            max-height: 250px;
            border-radius: 10px;
            object-fit: cover;
        }

        iframe {
            border-radius: 10px;
        }

        /* MOBILE FIXES */
        @media (max-width: 576px) {
            .header h3 {
                font-size: 22px;
            }
            .header h5 {
                font-size: 16px;
            }
            .product-img {
                max-height: 200px;
            }
        }
    </style>
</head>

<body>

<div class="header">
    <h3>Tracking Shipment</h3>
    <h5>#{{ $shipment->tracking_number }}</h5>
</div>

<div class="container mt-4">

    <!-- STATUS -->
    <div class="card-box d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h5 class="mb-1">Current Status</h5>
            <span class="status-badge @if($shipment->status == 'On Hold') status-hold @endif">
                {{ $shipment->status }}
            </span>
        </div>

        @if($shipment->status == "On Hold")
            <span class="text-danger fw-bold mt-2 mt-md-0">⚠ Shipment On Hold</span>
        @endif
    </div>

    <!-- PRODUCT IMAGE -->
    @if($shipment->product_image)
    <div class="card-box text-center">
        <img src="{{ asset('uploads/'.$shipment->product_image) }}" class="product-img shadow img-fluid">
    </div>
    @endif

    <!-- GOODS DESCRIPTION -->
    @if($shipment->goods_description)
    <div class="card-box">
        <h5>Goods Description</h5>
        <p class="text-muted">{{ $shipment->goods_description }}</p>
    </div>
    @endif

    <!-- PROGRESS -->
    <div class="card-box">
        <h6>Shipment Progress</h6>
        <div class="progress mt-2">
            <div class="progress-bar bg-success"
                 style="width: {{ $shipment->progress }}%">
                {{ $shipment->progress }}%
            </div>
        </div>
    </div>

    <!-- TIMELINE -->
    <div class="card-box">
        <h5 class="mb-3">Shipment History</h5>

        <div class="timeline">
            @foreach($shipment->updates as $update)
            <div class="timeline-item">
                <h6>{{ $update->location }}</h6>
                <p class="mb-1 text-muted">{{ $update->description }}</p>
                <small class="text-muted">
                    {{ $update->created_at->format('D, M d, Y - h:i A') }}
                </small>
            </div>
            @endforeach
        </div>
    </div>

    <!-- MAP -->
    <div class="card-box">
        <h5 class="mb-3">Current Location</h5>

        <iframe
            width="100%"
            height="350"
            loading="lazy"
            allowfullscreen
            src="https://www.google.com/maps?q={{ $shipment->current_lat }},{{ $shipment->current_lng }}&z=15&output=embed">
        </iframe>
    </div>

</div>

</body>
</html>
