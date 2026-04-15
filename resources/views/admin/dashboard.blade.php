@extends('admin.layout')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    /* ── STAT CARDS ── */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    @media(max-width:991px){ .stat-grid { grid-template-columns: repeat(2,1fr); } }
    @media(max-width:576px){ .stat-grid { grid-template-columns: 1fr; } }

    .stat-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 14px;
        padding: 20px;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.08);
    }
    .stat-card::after {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 80px; height: 80px;
        border-radius: 0 14px 0 80px;
        opacity: 0.08;
    }
    .stat-card.blue::after   { background: #1B4FD8; }
    .stat-card.orange::after { background: #F97316; }
    .stat-card.green::after  { background: #16A34A; }
    .stat-card.red::after    { background: #DC2626; }

    .stat-icon {
        width: 42px; height: 42px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 17px;
        margin-bottom: 14px;
    }
    .stat-icon.blue   { background: #EEF3FF; color: #1B4FD8; }
    .stat-icon.orange { background: #FFF7ED; color: #F97316; }
    .stat-icon.green  { background: #F0FDF4; color: #16A34A; }
    .stat-icon.red    { background: #FEF2F2; color: #DC2626; }

    .stat-value {
        font-size: 30px;
        font-weight: 800;
        color: #0F172A;
        line-height: 1;
        margin-bottom: 4px;
    }
    .stat-label {
        font-size: 12px;
        color: #64748B;
        font-weight: 500;
    }
    .stat-trend {
        font-size: 11px;
        font-weight: 600;
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .stat-trend.up   { color: #16A34A; }
    .stat-trend.down { color: #DC2626; }

    /* ── SECTION CARD ── */
    .panel {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 14px;
        overflow: hidden;
    }
    .panel-header {
        padding: 16px 20px;
        border-bottom: 1px solid #F1F5F9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .panel-title {
        font-size: 14px;
        font-weight: 700;
        color: #0F172A;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .panel-title i { color: #1B4FD8; }
    .panel-body { padding: 0; }

    /* ── TABLE ── */
    .ship-table { width: 100%; border-collapse: collapse; }
    .ship-table thead tr {
        background: #F8FAFC;
        border-bottom: 1px solid #E2E8F0;
    }
    .ship-table th {
        padding: 10px 16px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #64748B;
        white-space: nowrap;
    }
    .ship-table td {
        padding: 12px 16px;
        border-bottom: 1px solid #F1F5F9;
        font-size: 13px;
        vertical-align: middle;
    }
    .ship-table tbody tr:last-child td { border-bottom: none; }
    .ship-table tbody tr:hover td { background: #FAFBFF; }

    .track-num {
        font-family: 'Courier New', monospace;
        font-weight: 700;
        color: #1B4FD8;
        font-size: 12px;
        background: #EEF3FF;
        padding: 3px 8px;
        border-radius: 4px;
    }

    /* STATUS BADGES */
    .sbadge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }
    .sbadge-transit  { background: #EFF6FF; color: #1D4ED8; }
    .sbadge-hold     { background: #FEF2F2; color: #B91C1C; }
    .sbadge-delivered{ background: #F0FDF4; color: #15803D; }
    .sbadge-pending  { background: #FFFBEB; color: #B45309; }
    .sbadge-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        display: inline-block;
    }
    .sbadge-transit .sbadge-dot  { background: #1D4ED8; }
    .sbadge-hold .sbadge-dot     { background: #B91C1C; }
    .sbadge-delivered .sbadge-dot{ background: #15803D; }
    .sbadge-pending .sbadge-dot  { background: #B45309; }

    /* PROGRESS BAR */
    .prog-wrap {
        background: #F1F5F9;
        border-radius: 20px;
        height: 6px;
        width: 80px;
        overflow: hidden;
    }
    .prog-fill {
        height: 100%;
        border-radius: 20px;
        background: linear-gradient(90deg, #1B4FD8, #60A5FA);
        transition: width 1s ease;
    }

    /* ACTION BTNS */
    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.15s;
        border: 1px solid transparent;
    }
    .btn-edit {
        background: #EFF6FF;
        color: #1D4ED8;
        border-color: #BFDBFE;
    }
    .btn-edit:hover { background: #DBEAFE; color: #1E40AF; }
    .btn-del {
        background: #FEF2F2;
        color: #B91C1C;
        border-color: #FECACA;
    }
    .btn-del:hover { background: #FEE2E2; color: #991B1B; }

    /* ── STATUS DONUT (CSS only) ── */
    .status-summary {
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 16px 20px;
    }
    .status-bar-row {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .status-bar-label {
        width: 100px;
        font-size: 12px;
        color: #64748B;
        font-weight: 500;
        flex-shrink: 0;
    }
    .status-bar-track {
        flex: 1;
        height: 8px;
        background: #F1F5F9;
        border-radius: 10px;
        overflow: hidden;
    }
    .status-bar-fill {
        height: 100%;
        border-radius: 10px;
    }
    .status-bar-count {
        font-size: 12px;
        font-weight: 700;
        color: #1E293B;
        width: 30px;
        text-align: right;
    }

    /* ── TWO COL BOTTOM ── */
    .bottom-grid {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 16px;
    }
    @media(max-width:991px){ .bottom-grid { grid-template-columns: 1fr; } }

    /* ── QUICK CREATE BTN ── */
    .btn-create {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #1B4FD8;
        color: #fff;
        padding: 9px 18px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.15s;
    }
    .btn-create:hover { background: #1440b8; color: #fff; }

    /* ── EMPTY STATE ── */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #94A3B8;
    }
    .empty-state i { font-size: 40px; margin-bottom: 12px; color: #CBD5E1; }

    /* ── THUMBNAIL ── */
    .ship-thumb {
        width: 36px; height: 36px;
        border-radius: 7px;
        object-fit: cover;
        border: 1px solid #E2E8F0;
    }
    .ship-thumb-ph {
        width: 36px; height: 36px;
        border-radius: 7px;
        background: #F1F5F9;
        display: flex; align-items: center; justify-content: center;
        color: #CBD5E1; font-size: 14px;
        border: 1px solid #E2E8F0;
    }
</style>
@endpush

@section('content')

{{-- PAGE HEADER --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 style="font-weight:800; font-size:20px; color:#0F172A; margin-bottom:2px;">Dashboard</h4>
        <p style="color:#64748B; font-size:12.5px; margin:0;">Welcome back! Here's what's happening with your shipments.</p>
    </div>
    <a href="{{ route('admin.shipments.create') }}" class="btn-create">
        <i class="fas fa-plus"></i> New Shipment
    </a>
</div>

{{-- STAT CARDS --}}
@php
    $total     = $total ?? \App\Models\Shipment::count();
    $inTransit = \App\Models\Shipment::where('status','In Transit')->count();
    $onHold    = \App\Models\Shipment::where('status','On Hold')->count();
    $delivered = \App\Models\Shipment::where('status','Delivered')->count();
@endphp
<div class="stat-grid">
    <div class="stat-card blue">
        <div class="stat-icon blue"><i class="fas fa-boxes-stacked"></i></div>
        <div class="stat-value">{{ $total }}</div>
        <div class="stat-label">Total Shipments</div>
        <div class="stat-trend up"><i class="fas fa-arrow-trend-up"></i> All time</div>
    </div>
    <div class="stat-card orange">
        <div class="stat-icon orange"><i class="fas fa-truck-moving"></i></div>
        <div class="stat-value">{{ $inTransit }}</div>
        <div class="stat-label">In Transit</div>
        <div class="stat-trend up"><i class="fas fa-circle-dot" style="font-size:8px"></i> Active</div>
    </div>
    <div class="stat-card red">
        <div class="stat-icon red"><i class="fas fa-circle-pause"></i></div>
        <div class="stat-value">{{ $onHold }}</div>
        <div class="stat-label">On Hold</div>
        <div class="stat-trend down"><i class="fas fa-exclamation-triangle"></i> Needs attention</div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon green"><i class="fas fa-circle-check"></i></div>
        <div class="stat-value">{{ $delivered }}</div>
        <div class="stat-label">Delivered</div>
        <div class="stat-trend up"><i class="fas fa-arrow-trend-up"></i> Completed</div>
    </div>
</div>

{{-- BOTTOM GRID --}}
<div class="bottom-grid">

    {{-- RECENT SHIPMENTS TABLE --}}
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">
                <i class="fas fa-clock-rotate-left"></i> Recent Shipments
            </div>
            <a href="{{ route('admin.shipments') }}" style="font-size:12px; color:#1B4FD8; text-decoration:none; font-weight:600;">
                View all <i class="fas fa-arrow-right" style="font-size:10px"></i>
            </a>
        </div>
        <div class="panel-body">
            @php $recent = \App\Models\Shipment::latest()->take(8)->get(); @endphp
            @if($recent->count())
            <table class="ship-table">
                <thead>
                    <tr>
                        <th>Tracking</th>
                        <th>Sender / Receiver</th>
                        <th>Status</th>
                        <th>Progress</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($recent as $ship)
                <tr>
                    <td>
                        <span class="track-num">{{ $ship->tracking_number }}</span>
                    </td>
                    <td>
                        <div style="font-weight:600; font-size:13px;">{{ $ship->receiver_name }}</div>
                        <div style="font-size:11px; color:#94A3B8;">from {{ $ship->sender_name }}</div>
                    </td>
                    <td>
                        @if($ship->status === 'In Transit')
                            <span class="sbadge sbadge-transit"><span class="sbadge-dot"></span>In Transit</span>
                        @elseif($ship->status === 'On Hold')
                            <span class="sbadge sbadge-hold"><span class="sbadge-dot"></span>On Hold</span>
                        @elseif($ship->status === 'Delivered')
                            <span class="sbadge sbadge-delivered"><span class="sbadge-dot"></span>Delivered</span>
                        @else
                            <span class="sbadge sbadge-pending"><span class="sbadge-dot"></span>{{ $ship->status }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="prog-wrap">
                                <div class="prog-fill" style="width:{{ $ship->progress }}%"></div>
                            </div>
                            <span style="font-size:11px; font-weight:700; color:#1B4FD8;">{{ $ship->progress }}%</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.shipments.edit', $ship->id) }}" class="action-btn btn-edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            <a href="{{ route('admin.shipments.delete', $ship->id) }}"
                               class="action-btn btn-del"
                               onclick="return confirm('Delete this shipment?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <p style="font-weight:600; color:#64748B;">No shipments yet</p>
                <a href="{{ route('admin.shipments.create') }}" class="btn-create" style="margin-top:8px; font-size:12px;">
                    <i class="fas fa-plus"></i> Create First Shipment
                </a>
            </div>
            @endif
        </div>
    </div>

    {{-- STATUS BREAKDOWN SIDEBAR --}}
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title"><i class="fas fa-chart-pie"></i> Status Breakdown</div>
        </div>
        <div class="status-summary">
            @php
                $total_count = max($total, 1);
                $rows = [
                    ['label'=>'In Transit',  'count'=>$inTransit,  'color'=>'#1D4ED8'],
                    ['label'=>'On Hold',     'count'=>$onHold,     'color'=>'#B91C1C'],
                    ['label'=>'Delivered',   'count'=>$delivered,  'color'=>'#15803D'],
                    ['label'=>'Other',       'count'=>max(0, $total - $inTransit - $onHold - $delivered), 'color'=>'#64748B'],
                ];
            @endphp
            @foreach($rows as $row)
            @php $pct = $total_count > 0 ? round(($row['count'] / $total_count) * 100) : 0; @endphp
            <div class="status-bar-row">
                <div class="status-bar-label">{{ $row['label'] }}</div>
                <div class="status-bar-track">
                    <div class="status-bar-fill" style="width:{{ $pct }}%; background:{{ $row['color'] }};"></div>
                </div>
                <div class="status-bar-count">{{ $row['count'] }}</div>
            </div>
            @endforeach
        </div>

        {{-- QUICK LINKS --}}
        <div style="padding:0 20px 20px; border-top:1px solid #F1F5F9; margin-top:4px; padding-top:16px;">
            <div style="font-size:12px; font-weight:700; color:#64748B; margin-bottom:10px; text-transform:uppercase; letter-spacing:0.6px;">Quick Actions</div>
            <div class="d-flex flex-column gap-2">
                <a href="{{ route('admin.shipments.create') }}" style="display:flex; align-items:center; gap:8px; text-decoration:none; color:#1B4FD8; font-size:12.5px; font-weight:600; padding:8px 12px; background:#EEF3FF; border-radius:8px;">
                    <i class="fas fa-plus-circle"></i> Create New Shipment
                </a>
                <a href="{{ route('admin.shipments') }}" style="display:flex; align-items:center; gap:8px; text-decoration:none; color:#15803D; font-size:12.5px; font-weight:600; padding:8px 12px; background:#F0FDF4; border-radius:8px;">
                    <i class="fas fa-list-ul"></i> View All Shipments
                </a>
                <a href="/" target="_blank" style="display:flex; align-items:center; gap:8px; text-decoration:none; color:#64748B; font-size:12.5px; font-weight:600; padding:8px 12px; background:#F8FAFC; border-radius:8px;">
                    <i class="fas fa-globe"></i> View Live Website
                </a>
            </div>
        </div>
    </div>

</div>

@endsection
