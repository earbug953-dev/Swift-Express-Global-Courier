@extends('admin.layout')
@section('page-title', 'Edit Shipment')

@push('styles')
<style>
    .form-panel {
        background: #fff; border: 1px solid #E2E8F0;
        border-radius: 14px; overflow: hidden; max-width: 900px;
    }
    .form-panel-header {
        padding: 18px 24px; border-bottom: 1px solid #F1F5F9;
        display: flex; align-items: center; gap: 10px;
    }
    .form-panel-header .icon {
        width: 36px; height: 36px;
        background: #EEF3FF; color: #1B4FD8;
        border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 15px;
    }
    .form-panel-header h5 { font-size: 15px; font-weight: 700; color: #0F172A; margin: 0; }
    .form-panel-header p  { font-size: 12px; color: #64748B; margin: 0; }

    .form-body { padding: 24px; }
    .form-section { margin-bottom: 28px; }
    .form-section-title {
        font-size: 11px; font-weight: 800; text-transform: uppercase;
        letter-spacing: 1px; color: #94A3B8; margin-bottom: 14px;
        padding-bottom: 8px; border-bottom: 1px solid #F1F5F9;
        display: flex; align-items: center; gap: 7px;
    }
    .form-section-title i { color: #1B4FD8; }

    .fl { display: flex; flex-direction: column; gap: 4px; margin-bottom: 14px; }
    .fl label { font-size: 12px; font-weight: 600; color: #475569; }
    .fl label span { color: #DC2626; margin-left: 2px; }
    .fl input, .fl select, .fl textarea {
        border: 1px solid #E2E8F0; border-radius: 8px;
        padding: 9px 12px; font-size: 13px; font-family: inherit;
        color: #1E293B; background: #FAFBFF; outline: none;
        transition: border-color 0.15s, box-shadow 0.15s; width: 100%;
    }
    .fl input:focus, .fl select:focus, .fl textarea:focus {
        border-color: #1B4FD8; background: #fff;
        box-shadow: 0 0 0 3px rgba(27,79,216,0.08);
    }
    .fl .help { font-size: 11px; color: #94A3B8; }
    .fl .err  { font-size: 11px; color: #DC2626; font-weight: 600; }

    .row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; }
    @media(max-width:640px){ .row-2, .row-3 { grid-template-columns: 1fr; } }

    .form-footer {
        padding: 16px 24px; background: #F8FAFC;
        border-top: 1px solid #F1F5F9;
        display: flex; gap: 10px; align-items: center;
    }
    .btn-submit {
        display: inline-flex; align-items: center; gap: 8px;
        background: #1B4FD8; color: #fff; padding: 10px 22px; border-radius: 9px;
        font-size: 13px; font-weight: 600; border: none; cursor: pointer;
        transition: background 0.15s; font-family: inherit;
    }
    .btn-submit:hover { background: #1440b8; }
    .btn-cancel {
        display: inline-flex; align-items: center; gap: 8px;
        background: #fff; color: #64748B; padding: 10px 22px; border-radius: 9px;
        font-size: 13px; font-weight: 600; border: 1px solid #E2E8F0;
        cursor: pointer; text-decoration: none; transition: all 0.15s;
    }
    .btn-cancel:hover { background: #F1F5F9; color: #1E293B; }

    /* Tracking number read-only pill */
    .tracking-pill {
        display: inline-flex; align-items: center; gap: 8px;
        background: #EEF3FF; border: 1px solid #BFDBFE;
        border-radius: 8px; padding: 8px 14px; margin-bottom: 16px;
    }
    .tracking-pill .num {
        font-family: 'Courier New', monospace;
        font-size: 15px; font-weight: 800; color: #1D4ED8;
    }
    .tracking-pill a {
        font-size: 11px; color: #1D4ED8; text-decoration: none;
        background: #fff; border: 1px solid #BFDBFE;
        padding: 3px 8px; border-radius: 5px; font-weight: 600;
    }
    .tracking-pill a:hover { background: #DBEAFE; }

    /* Current image preview */
    .current-img-wrap {
        display: flex; align-items: flex-start; gap: 12px;
        background: #F8FAFC; border: 1px solid #E2E8F0;
        border-radius: 8px; padding: 12px; margin-bottom: 10px;
    }
    .current-img-wrap img {
        width: 80px; height: 60px; border-radius: 6px;
        object-fit: cover; border: 1px solid #E2E8F0;
    }
    .current-img-wrap .meta { font-size: 12px; color: #64748B; }
    .current-img-wrap .meta strong { color: #0F172A; font-size: 13px; display: block; margin-bottom: 2px; }

    /* Map helper */
    .map-helper {
        background: #F0FDF4; border: 1px solid #BBF7D0; border-radius: 8px;
        padding: 8px 12px; font-size: 11.5px; color: #166534;
        display: flex; gap: 7px; align-items: flex-start; margin-top: 6px;
    }
    .map-helper i { margin-top: 1px; flex-shrink: 0; }

    /* Timeline event list */
    .event-item {
        background: #F8FAFC; border: 1px solid #E2E8F0;
        border-radius: 9px; padding: 12px 14px; margin-bottom: 10px;
        position: relative;
    }
    .event-item .event-num {
        font-size: 10px; font-weight: 800; color: #1B4FD8;
        text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;
    }
    .btn-rm-event {
        position: absolute; top: 10px; right: 12px;
        background: #FEF2F2; border: 1px solid #FECACA;
        color: #B91C1C; border-radius: 6px;
        font-size: 11px; padding: 3px 8px; cursor: pointer; font-family: inherit;
    }
    .btn-rm-event:hover { background: #FEE2E2; }
</style>
@endpush

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.shipments') }}" style="color:#64748B; text-decoration:none; font-size:13px;">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
    <h4 style="font-weight:800; font-size:20px; color:#0F172A; margin:0;">Edit Shipment</h4>
</div>

{{-- Tracking pill + quick view link --}}
<div class="tracking-pill mb-4">
    <i class="fas fa-barcode" style="color:#1B4FD8;"></i>
    <span class="num">{{ $shipment->tracking_number }}</span>
    <a href="/track/{{ $shipment->tracking_number }}" target="_blank">
        <i class="fas fa-eye me-1"></i> Live View
    </a>
</div>

@if($errors->any())
<div class="alert alert-danger d-flex gap-2 align-items-start mb-4" style="border-radius:10px;">
    <i class="fas fa-circle-exclamation mt-1"></i>
    <div>
        <strong>Please fix the following:</strong>
        <ul class="mb-0 mt-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
</div>
@endif

<div class="form-panel">
    <div class="form-panel-header">
        <div class="icon"><i class="fas fa-pen-to-square"></i></div>
        <div>
            <h5>Edit: {{ $shipment->tracking_number }}</h5>
            <p>Update shipment details, status, map position, and timeline.</p>
        </div>
    </div>

    <form action="{{ route('admin.shipments.update', $shipment->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-body">

            {{-- BASIC INFO --}}
            <div class="form-section">
                <div class="form-section-title"><i class="fas fa-info-circle"></i> Shipment Info</div>
                <div class="row-2">
                    <div class="fl">
                        <label>Tracking Number</label>
                        <input type="text" name="tracking_number" value="{{ $shipment->tracking_number }}">
                    </div>
                    <div class="fl">
                        <label>Status <span>*</span></label>
                        <select name="status">
                            <option value="In Transit"  {{ $shipment->status == 'In Transit'  ? 'selected' : '' }}>In Transit</option>
                            <option value="On Hold"     {{ $shipment->status == 'On Hold'     ? 'selected' : '' }}>On Hold</option>
                            <option value="Delivered"   {{ $shipment->status == 'Delivered'   ? 'selected' : '' }}>Delivered</option>
                        </select>
                    </div>
                </div>
                <div class="row-2">
                    <div class="fl">
                        <label>Origin</label>
                        <input type="text" name="origin" value="{{ $shipment->origin }}" placeholder="e.g. Edmonton, AB, Canada">
                    </div>
                    <div class="fl">
                        <label>Destination</label>
                        <input type="text" name="destination" value="{{ $shipment->destination }}" placeholder="e.g. Aurora, CO, USA">
                    </div>
                </div>
                <div class="row-2">
                    <div class="fl">
                        <label>Progress (%)</label>
                        <input type="number" name="progress" value="{{ $shipment->progress }}" min="0" max="100">
                    </div>
                </div>
            </div>

            {{-- SENDER --}}
            <div class="form-section">
                <div class="form-section-title"><i class="fas fa-user"></i> Sender Details</div>
                <div class="row-2">
                    <div class="fl">
                        <label>Sender Name</label>
                        <input type="text" name="sender_name" value="{{ $shipment->sender_name }}">
                    </div>
                    <div class="fl">
                        <label>Sender Email</label>
                        <input type="email" name="sender_email" value="{{ $shipment->sender_email ?? '' }}">
                    </div>
                </div>
                <div class="row-2">
                    <div class="fl">
                        <label>Sender Phone</label>
                        <input type="text" name="sender_phone" value="{{ $shipment->sender_phone ?? '' }}">
                    </div>
                    <div class="fl">
                        <label>Sender Address</label>
                        <input type="text" name="sender_address" value="{{ $shipment->sender_address ?? '' }}">
                    </div>
                </div>
            </div>

            {{-- RECEIVER --}}
            <div class="form-section">
                <div class="form-section-title"><i class="fas fa-user-check"></i> Receiver Details</div>
                <div class="row-2">
                    <div class="fl">
                        <label>Receiver Name</label>
                        <input type="text" name="receiver_name" value="{{ $shipment->receiver_name }}">
                    </div>
                    <div class="fl">
                        <label>Receiver Email</label>
                        <input type="email" name="receiver_email" value="{{ $shipment->receiver_email ?? '' }}">
                    </div>
                </div>
                <div class="row-2">
                    <div class="fl">
                        <label>Receiver Phone</label>
                        <input type="text" name="receiver_phone" value="{{ $shipment->receiver_phone ?? '' }}">
                    </div>
                    <div class="fl">
                        <label>Receiver Address</label>
                        <input type="text" name="receiver_address" value="{{ $shipment->receiver_address ?? '' }}">
                    </div>
                </div>
            </div>

            {{-- MAP & LOCATION --}}
            <div class="form-section">
                <div class="form-section-title"><i class="fas fa-map-location-dot"></i> Map & Location</div>
                <div class="fl">
                    <label>Google Maps Link</label>
                    <input type="text" name="google_link" id="google_link_field"
                           value="{{ $shipment->google_link ?? '' }}"
                           placeholder="Paste Google Maps link — auto-extracts coordinates">
                    <div class="map-helper">
                        <i class="fas fa-lightbulb"></i>
                        <span>Paste a Google Maps link and coordinates will auto-fill below. You can also type them manually.</span>
                    </div>
                </div>
                <div class="row-2">
                    <div class="fl">
                        <label>Current Latitude</label>
                        <input type="text" name="current_lat" id="lat_field"
                               value="{{ $shipment->current_lat }}">
                    </div>
                    <div class="fl">
                        <label>Current Longitude</label>
                        <input type="text" name="current_lng" id="lng_field"
                               value="{{ $shipment->current_lng }}">
                    </div>
                </div>
                <div class="row-2">
                    <div class="fl">
                        <label>Map Moving</label>
                        <select name="map_moving">
                            <option value="1" {{ $shipment->map_moving ? 'selected' : '' }}>Moving</option>
                            <option value="0" {{ !$shipment->map_moving ? 'selected' : '' }}>Paused</option>
                        </select>
                    </div>
                    <div class="fl">
                        <label>Map Tile URL</label>
                        <input type="text" name="map_tile_url" value="{{ $shipment->map_tile_url }}">
                        <span class="help">Custom tile layer for the tracking map</span>
                    </div>
                </div>
            </div>

            {{-- TIMELINE EVENTS --}}
            <div class="form-section">
                <div class="form-section-title"><i class="fas fa-stream"></i> Timeline Events</div>
                <div id="events-wrap">
                @foreach($shipment->updates as $i => $upd)
                <div class="event-item" id="event-{{ $i }}">
                    <div class="event-num">Event {{ $i + 1 }}</div>
                    <button type="button" class="btn-rm-event" onclick="removeEvent({{ $i }})">
                        <i class="fas fa-times"></i> Remove
                    </button>
                    <div class="row-2">
                        <div class="fl" style="margin:0;">
                            <label>Location</label>
                            <input type="text" name="updates[{{ $i }}][id]" value="{{ $upd->id }}" style="display:none;">
                            <input type="text" name="updates[{{ $i }}][location]" value="{{ $upd->location }}"
                                   placeholder="e.g. Denver International Airport">
                        </div>
                        <div class="fl" style="margin:0;">
                            <label>Description</label>
                            <input type="text" name="updates[{{ $i }}][description]" value="{{ $upd->description }}"
                                   placeholder="e.g. Package in transit">
                        </div>
                    </div>
                </div>
                @endforeach
                </div>

                <div id="new-events-wrap"></div>

                <button type="button" onclick="addEvent()" style="background:none; border:1px dashed #CBD5E1; border-radius:8px; padding:8px 16px; color:#64748B; font-size:12px; cursor:pointer; font-family:inherit; margin-top:4px;">
                    <i class="fas fa-plus me-1"></i> Add Event
                </button>
            </div>

            {{-- GOODS & IMAGE --}}
            <div class="form-section">
                <div class="form-section-title"><i class="fas fa-cube"></i> Package Details</div>
                <div class="fl">
                    <label>Description of Goods</label>
                    <textarea name="goods_description" rows="3">{{ $shipment->goods_description }}</textarea>
                </div>

                @if($shipment->product_image)
                <div class="current-img-wrap">
                    <img src="{{ asset('uploads/'.$shipment->product_image) }}" alt="Package">
                    <div class="meta">
                        <strong>Current Image</strong>
                        Upload a new image below to replace it.
                    </div>
                </div>
                @endif

                <div class="fl">
                    <label>{{ $shipment->product_image ? 'Replace Image' : 'Product Image' }}</label>
                    <input type="file" name="product_image" accept="image/*" onchange="previewImg(this)">
                    <img id="new_preview" style="display:none; margin-top:8px; max-width:140px; border-radius:8px; border:1px solid #E2E8F0;" alt="Preview">
                </div>
            </div>

        </div>

        <div class="form-footer">
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Update Shipment
            </button>
            <a href="{{ route('admin.shipments') }}" class="btn-cancel">Cancel</a>
            <a href="{{ route('admin.shipments.delete', $shipment->id) }}"
               onclick="return confirm('Delete this shipment permanently?')"
               style="margin-left:auto; display:inline-flex; align-items:center; gap:6px; color:#B91C1C; font-size:12.5px; text-decoration:none; font-weight:600;">
                <i class="fas fa-trash"></i> Delete Shipment
            </a>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
// Auto-extract coordinates from Google Maps link
document.getElementById('google_link_field').addEventListener('input', function() {
    const match = this.value.match(/@(-?\d+\.\d+),(-?\d+\.\d+)/);
    if (match) {
        document.getElementById('lat_field').value = match[1];
        document.getElementById('lng_field').value = match[2];
    }
});

// Image preview
function previewImg(input) {
    const preview = document.getElementById('new_preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}

// Remove existing event
function removeEvent(i) {
    const el = document.getElementById('event-' + i);
    if (el) el.remove();
}

// Add new event
let newEvtIdx = 100;
function addEvent() {
    const wrap = document.getElementById('new-events-wrap');
    const div = document.createElement('div');
    div.className = 'event-item';
    div.id = 'new-event-' + newEvtIdx;
    div.innerHTML = `
        <div class="event-num">New Event</div>
        <button type="button" class="btn-rm-event" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i> Remove
        </button>
        <div class="row-2">
            <div class="fl" style="margin:0;">
                <label>Location</label>
                <input type="text" name="new_updates[${newEvtIdx}][location]"
                       placeholder="e.g. Denver International Airport">
            </div>
            <div class="fl" style="margin:0;">
                <label>Description</label>
                <input type="text" name="new_updates[${newEvtIdx}][description]"
                       placeholder="e.g. Package in transit">
            </div>
        </div>
    `;
    wrap.appendChild(div);
    newEvtIdx++;
}
</script>
@endpush
