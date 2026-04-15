@extends('admin.layout')
@section('page-title', 'All Shipments')

@push('styles')
<style>
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
        flex-wrap: wrap;
        gap: 12px;
    }
    .panel-title {
        font-size: 14px; font-weight: 700; color: #0F172A;
        display: flex; align-items: center; gap: 8px;
    }
    .panel-title i { color: #1B4FD8; }

    /* search bar */
    .search-wrap {
        position: relative;
        width: 260px;
    }
    .search-wrap input {
        width: 100%;
        padding: 8px 12px 8px 34px;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        font-size: 13px;
        font-family: inherit;
        outline: none;
        background: #F8FAFC;
        color: #1E293B;
    }
    .search-wrap input:focus { border-color: #1B4FD8; background: #fff; }
    .search-wrap i {
        position: absolute; left: 11px; top: 50%;
        transform: translateY(-50%);
        color: #94A3B8; font-size: 12px;
    }

    /* filter buttons */
    .filter-tabs {
        display: flex; gap: 6px; flex-wrap: wrap;
        padding: 12px 20px;
        border-bottom: 1px solid #F1F5F9;
        background: #FAFBFF;
    }
    .filter-tab {
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        border: 1px solid #E2E8F0;
        color: #64748B;
        background: #fff;
        transition: all 0.15s;
    }
    .filter-tab:hover, .filter-tab.active {
        background: #1B4FD8;
        color: #fff;
        border-color: #1B4FD8;
    }

    /* table */
    .ship-table { width: 100%; border-collapse: collapse; }
    .ship-table thead tr {
        background: #F8FAFC;
        border-bottom: 2px solid #E2E8F0;
    }
    .ship-table th {
        padding: 11px 16px;
        font-size: 11px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.6px;
        color: #64748B; white-space: nowrap;
    }
    .ship-table td {
        padding: 13px 16px;
        border-bottom: 1px solid #F1F5F9;
        font-size: 13px;
        vertical-align: middle;
    }
    .ship-table tbody tr:last-child td { border-bottom: none; }
    .ship-table tbody tr:hover td { background: #FAFBFF; }

    .track-num {
        font-family: 'Courier New', monospace;
        font-weight: 700; color: #1B4FD8;
        font-size: 12px; background: #EEF3FF;
        padding: 3px 8px; border-radius: 4px;
    }
    .sbadge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px; border-radius: 20px;
        font-size: 11px; font-weight: 700; white-space: nowrap;
    }
    .sbadge-transit  { background: #EFF6FF; color: #1D4ED8; }
    .sbadge-hold     { background: #FEF2F2; color: #B91C1C; }
    .sbadge-delivered{ background: #F0FDF4; color: #15803D; }
    .sbadge-pending  { background: #FFFBEB; color: #B45309; }
    .sbadge-dot { width:6px; height:6px; border-radius:50%; display:inline-block; }
    .sbadge-transit .sbadge-dot   { background: #1D4ED8; }
    .sbadge-hold .sbadge-dot      { background: #B91C1C; }
    .sbadge-delivered .sbadge-dot { background: #15803D; }
    .sbadge-pending .sbadge-dot   { background: #B45309; }

    .prog-wrap { background:#F1F5F9; border-radius:20px; height:6px; width:70px; overflow:hidden; }
    .prog-fill  { height:100%; border-radius:20px; background: linear-gradient(90deg,#1B4FD8,#60A5FA); }

    .action-btn {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 12px; border-radius: 7px;
        font-size: 12px; font-weight: 600;
        text-decoration: none; transition: all 0.15s;
        border: 1px solid transparent;
    }
    .btn-edit   { background:#EFF6FF; color:#1D4ED8; border-color:#BFDBFE; }
    .btn-edit:hover   { background:#DBEAFE; color:#1E40AF; }
    .btn-del    { background:#FEF2F2; color:#B91C1C; border-color:#FECACA; }
    .btn-del:hover    { background:#FEE2E2; color:#991B1B; }
    .btn-view   { background:#F0FDF4; color:#15803D; border-color:#BBF7D0; }
    .btn-view:hover   { background:#DCFCE7; color:#166534; }

    .ship-thumb {
        width: 38px; height: 38px; border-radius: 8px;
        object-fit: cover; border: 1px solid #E2E8F0;
    }
    .ship-thumb-ph {
        width: 38px; height: 38px; border-radius: 8px;
        background: #F1F5F9; display: flex; align-items: center;
        justify-content: center; color: #CBD5E1; font-size: 14px;
        border: 1px solid #E2E8F0;
    }

    .btn-create {
        display: inline-flex; align-items: center; gap: 8px;
        background: #1B4FD8; color: #fff;
        padding: 9px 18px; border-radius: 9px;
        font-size: 13px; font-weight: 600;
        text-decoration: none; transition: background 0.15s;
    }
    .btn-create:hover { background: #1440b8; color: #fff; }

    .empty-state { text-align: center; padding: 50px 20px; color: #94A3B8; }
    .empty-state i { font-size: 44px; margin-bottom: 12px; color: #CBD5E1; }

    /* pagination */
    .pagination .page-link {
        border-radius: 7px !important;
        font-size: 13px;
        border-color: #E2E8F0;
        color: #1B4FD8;
        margin: 0 2px;
        font-family: inherit;
    }
    .pagination .page-item.active .page-link {
        background: #1B4FD8; border-color: #1B4FD8;
    }
</style>
@endpush

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 style="font-weight:800; font-size:20px; color:#0F172A; margin-bottom:2px;">All Shipments</h4>
        <p style="color:#64748B; font-size:12.5px; margin:0;">Manage and track all active shipments</p>
    </div>
    <a href="{{ route('admin.shipments.create') }}" class="btn-create">
        <i class="fas fa-plus"></i> New Shipment
    </a>
</div>

<div class="panel">
    <div class="panel-header">
        <div class="panel-title"><i class="fas fa-boxes-stacked"></i> Shipments ({{ $shipments->total() }})</div>
        <form method="GET" action="{{ route('admin.shipments') }}">
            <div class="search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Search tracking, name..." value="{{ request('search') }}">
            </div>
        </form>
    </div>

    {{-- FILTER TABS --}}
    <div class="filter-tabs">
        <a href="{{ route('admin.shipments') }}" class="filter-tab {{ !request('status') ? 'active' : '' }}">All</a>
        <a href="{{ route('admin.shipments', ['status'=>'In Transit']) }}" class="filter-tab {{ request('status') === 'In Transit' ? 'active' : '' }}">In Transit</a>
        <a href="{{ route('admin.shipments', ['status'=>'On Hold']) }}" class="filter-tab {{ request('status') === 'On Hold' ? 'active' : '' }}">On Hold</a>
        <a href="{{ route('admin.shipments', ['status'=>'Delivered']) }}" class="filter-tab {{ request('status') === 'Delivered' ? 'active' : '' }}">Delivered</a>
    </div>

    @if($shipments->count())
    <div style="overflow-x:auto;">
        <table class="ship-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Tracking #</th>
                    <th>Sender</th>
                    <th>Receiver</th>
                    <th>Route</th>
                    <th>Status</th>
                    <th>Progress</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($shipments as $i => $ship)
            <tr>
                <td style="color:#94A3B8; font-size:12px;">{{ $shipments->firstItem() + $i }}</td>
                <td>
                    @if($ship->product_image)
                        <img src="{{ asset('uploads/'.$ship->product_image) }}" class="ship-thumb">
                    @else
                        <div class="ship-thumb-ph"><i class="fas fa-box"></i></div>
                    @endif
                </td>
                <td><span class="track-num">{{ $ship->tracking_number }}</span></td>
                <td>
                    <div style="font-weight:600;">{{ $ship->sender_name }}</div>
                </td>
                <td>
                    <div style="font-weight:600;">{{ $ship->receiver_name }}</div>
                </td>
                <td>
                    <div style="font-size:12px; color:#64748B;">
                        <i class="fas fa-circle-dot" style="color:#1B4FD8; font-size:8px; margin-right:4px;"></i>{{ Str::limit($ship->origin, 20) }}
                    </div>
                    <div style="font-size:12px; color:#64748B; margin-top:2px;">
                        <i class="fas fa-location-dot" style="color:#DC2626; font-size:8px; margin-right:4px;"></i>{{ Str::limit($ship->destination, 20) }}
                    </div>
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
                    <div class="d-flex gap-1 flex-wrap">
                        <a href="/track/{{ $ship->tracking_number }}" target="_blank" class="action-btn btn-view">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.shipments.edit', $ship->id) }}" class="action-btn btn-edit">
                            <i class="fas fa-pen"></i> Edit
                        </a>
                        <a href="{{ route('admin.shipments.delete', $ship->id) }}"
                           class="action-btn btn-del"
                           onclick="return confirm('Are you sure you want to delete this shipment?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @if($shipments->hasPages())
    <div style="padding:16px 20px; border-top:1px solid #F1F5F9;">
        {{ $shipments->links() }}
    </div>
    @endif

    @else
    <div class="empty-state">
        <i class="fas fa-box-open"></i>
        <p style="font-weight:700; font-size:14px; color:#64748B; margin-bottom:6px;">No shipments found</p>
        <p style="font-size:12px; color:#94A3B8; margin-bottom:16px;">
            @if(request('search') || request('status'))
                Try adjusting your search or filters.
            @else
                Get started by creating your first shipment.
            @endif
        </p>
        <a href="{{ route('admin.shipments.create') }}" class="btn-create">
            <i class="fas fa-plus"></i> Create Shipment
        </a>
    </div>
    @endif
</div>

@endsection
