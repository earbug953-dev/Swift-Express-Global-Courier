@extends('admin.layout')
@section('page-title', 'Create Shipment')

@push('styles')
<style>
    .form-panel {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 14px;
        overflow: hidden;
        max-width: 900px;
    }
    .form-panel-header {
        padding: 18px 24px;
        border-bottom: 1px solid #F1F5F9;
        display: flex; align-items: center; gap: 10px;
    }
    .form-panel-header .icon {
        width: 36px; height: 36px;
        background: #EEF3FF; color: #1B4FD8;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 15px;
    }
    .form-panel-header h5 {
        font-size: 15px; font-weight: 700;
        color: #0F172A; margin: 0;
    }
    .form-panel-header p {
        font-size: 12px; color: #64748B; margin: 0;
    }
    .form-body { padding: 24px; }

    /* Section dividers */
    .form-section {
        margin-bottom: 28px;
    }
    .form-section-title {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94A3B8;
        margin-bottom: 14px;
        padding-bottom: 8px;
        border-bottom: 1px solid #F1F5F9;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .form-section-title i { color: #1B4FD8; }

    /* Inputs */
    .fl {
        display: flex; flex-direction: column; gap: 4px;
        margin-bottom: 14px;
    }
    .fl label {
        font-size: 12px; font-weight: 600; color: #475569;
    }
    .fl label span { color: #DC2626; margin-left: 2px; }
    .fl input, .fl select, .fl textarea {
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        padding: 9px 12px;
        font-size: 13px;
        font-family: inherit;
        color: #1E293B;
        background: #FAFBFF;
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
        width: 100%;
    }
    .fl input:focus, .fl select:focus, .fl textarea:focus {
        border-color: #1B4FD8;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(27,79,216,0.08);
    }
    .fl .help { font-size: 11px; color: #94A3B8; }
    .fl .err { font-size: 11px; color: #DC2626; font-weight: 600; }

    /* Cols */
    .row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; }
    @media(max-width:640px){ .row-2, .row-3 { grid-template-columns: 1fr; } }

    /* Submit btns */
    .form-footer {
        padding: 16px 24px;
        background: #F8FAFC;
        border-top: 1px solid #F1F5F9;
        display: flex; gap: 10px; align-items: center;
    }
    .btn-submit {
        display: inline-flex; align-items: center; gap: 8px;
        background: #1B4FD8; color: #fff;
        padding: 10px 22px; border-radius: 9px;
        font-size: 13px; font-weight: 600;
        border: none; cursor: pointer;
        transition: background 0.15s; font-family: inherit;
    }
    .btn-submit:hover { background: #1440b8; }
    .btn-cancel {
        display: inline-flex; align-items: center; gap: 8px;
        background: #fff; color: #64748B;
        padding: 10px 22px; border-radius: 9px;
        font-size: 13px; font-weight: 600;
        border: 1px solid #E2E8F0; cursor: pointer;
        text-decoration: none; transition: all 0.15s;
    }
    .btn-cancel:hover { background: #F1F5F9; color: #1E293B; }

    /* Status select colours */
    select option[value="In Transit"] { color: #1D4ED8; }
    select option[value="On Hold"]    { color: #B91C1C; }
    select option[value="Delivered"]  { color: #15803D; }

    /* Image preview */
    .img-preview-wrap { position: relative; display: inline-block; }
    .img-preview {
        max-width: 140px; max-height: 100px;
        border-radius: 8px; object-fit: cover;
        border: 1px solid #E2E8F0;
        display: none;
        margin-top: 8px;
    }

    /* Map link helper */
    .map-helper {
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 11.5px;
        color: #166534;
        display: flex; gap: 7px; align-items: flex-start;
        margin-top: 6px;
    }
    .map-helper i { margin-top: 1px; flex-shrink: 0; }
</style>
@endpush

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.shipments') }}" style="color:#64748B; text-decoration:none; font-size:13px;">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
    <h4 style="font-weight:800; font-size:20px; color:#0F172A; margin:0;">Create New Shipment</h4>
</div>

@if($errors->any())
<div class="alert alert-danger d-flex gap-2 align-items-start mb-4" style="border-radius:10px;">
    <i class="fas fa-circle-exclamation mt-1"></i>
    <div>
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<div class="form-panel">
    <div class="form-panel-header">
        <div class="icon"><i class="fas fa-box-archive"></i></div>
        <div>
            <h5>New Shipment</h5>
            <p>Fill in all details. Tracking number is auto-generated if left blank.</p>
        </div>
    </div>

    <form action="{{ route('admin.shipments.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-body">

            {{-- BASIC INFO --}}
            <div class="form-section">
                <div class="form-section-title"><i class="fas fa-info-circle"></i> Shipment Info</div>
                <div class="row-2">
                    <div class="fl">
                        <label>Tracking Number <span>*</span></label>
                        <input type="text" name="tracking_number" value="{{ old('tracking_number') }}"
                               placeholder="e.g. SWF-2026-00123">
                        <span class="help">Leave blank to auto-generate</span>
                        @error('tracking_number') <span class="err">{{ $message }}</span> @enderror
                    </div>
                    <div class="fl">
                        <label>Status <span>*</span></label>
                        <select name="status">
                            <option value="In Transit"  {{ old('status') == 'In Transit'  ? 'selected' : '' }}>In Transit</option>
                            <option value="On Hold"     {{ old('status') == 'On Hold'     ? 'selected' : '' }}>On Hold</option>
                            <option value="Delivered"   {{ old('status') == 'Delivered'   ? 'selected' : '' }}>Delivered</option>
                        </select>
                    </div>
                </div>
                <div class="row-2">
                    <div class="fl">
                        <label>Origin <span>*</span></label>
                        <input type="text" name="origin" value="{{ old('origin') }}"
                               placeholder="e.g. Edmonton, AB, Canada">
                        @error('origin') <span class="err">{{ $message }}</span> @enderror
                    </div>
                    <div class="fl">
                        <label>Destination <span>*</span></label>
                        <input type="text" name="destination" value="{{ old('destination') }}"
                               placeholder="e.g. Aurora, CO, United States">
                        @error('destination') <span class="err">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="row-2">
                    <div class="fl">
                        <label>Progress (%)</label>
                        <input type="number" name="progress" value="{{ old('progress', 10) }}"
                               min="0" max="100" placeholder="10">
                    </div>
                </div>
            </div>

            {{-- SENDER --}}
            <div class="form-section">
                <div class="form-section-title"><i class="fas fa-user"></i> Sender Details</div>
                <div class="row-2">
                    <div class="fl">
                        <label>Sender Name <span>*</span></label>
                        <input type="text" name="sender_name" value="{{ old('sender_name') }}" placeholder="Full name">
                        @error('sender_name') <span class="err">{{ $message }}</span> @enderror
                    </div>
                    <div class="fl">
                        <label>Sender Email</label>
                        <input type="email" name="sender_email" value="{{ old('sender_email') }}" placeholder="email@example.com">
                    </div>
                </div>
                <div class="row-2">
                    <div class="fl">
                        <label>Sender Phone</label>
                        <input type="text" name="sender_phone" value="{{ old('sender_phone') }}" placeholder="+1 (555) 000-0000">
                    </div>
                    <div class="fl">
                        <label>Sender Address</label>
                        <input type="text" name="sender_address" value="{{ old('sender_address') }}" placeholder="Street address">
                    </div>
                </div>
            </div>

            {{-- RECEIVER --}}
            <div class="form-section">
                <div class="form-section-title"><i class="fas fa-user-check"></i> Receiver Details</div>
                <div class="row-2">
                    <div class="fl">
                        <label>Receiver Name <span>*</span></label>
                        <input type="text" name="receiver_name" value="{{ old('receiver_name') }}" placeholder="Full name">
                        @error('receiver_name') <span class="err">{{ $message }}</span> @enderror
                    </div>
                    <div class="fl">
                        <label>Receiver Email</label>
                        <input type="email" name="receiver_email" value="{{ old('receiver_email') }}" placeholder="email@example.com">
                    </div>
                </div>
                <div class="row-2">
                    <div class="fl">
                        <label>Receiver Phone</label>
                        <input type="text" name="receiver_phone" value="{{ old('receiver_phone') }}" placeholder="+1 (555) 000-0000">
                    </div>
                    <div class="fl">
                        <label>Receiver Address</label>
                        <input type="text" name="receiver_address" value="{{ old('receiver_address') }}" placeholder="Street address">
                    </div>
                </div>
            </div>

            {{-- MAP & LOCATION --}}
            <div class="form-section">
                <div class="form-section-title"><i class="fas fa-map-location-dot"></i> Map & Location</div>
                <div class="fl">
                    <label>Google Maps Link</label>
                    <input type="text" name="google_link" value="{{ old('google_link') }}"
                           placeholder="Paste a Google Maps link — coordinates extracted automatically">
                    <div class="map-helper">
                        <i class="fas fa-lightbulb"></i>
                        <span>Open Google Maps, right-click the location, copy the coordinates link. Paste it here — latitude & longitude are extracted automatically.</span>
                    </div>
                </div>
                <div class="row-2">
                    <div class="fl">
                        <label>Current Latitude</label>
                        <input type="text" name="current_lat" id="lat_field"
                               value="{{ old('current_lat', '39.8561') }}"
                               placeholder="39.8561">
                        <span class="help">Auto-filled from Google Maps link above</span>
                    </div>
                    <div class="fl">
                        <label>Current Longitude</label>
                        <input type="text" name="current_lng" id="lng_field"
                               value="{{ old('current_lng', '-104.6737') }}"
                               placeholder="-104.6737">
                    </div>
                </div>
                <div class="fl">
                    <label>Map Moving</label>
                    <select name="map_moving">
                        <option value="1">Moving</option>
                        <option value="0">Paused</option>
                    </select>
                </div>
                <div class="fl">
                    <label>Map Tile URL</label>
                    <input type="text" name="map_tile_url"
                           value="{{ old('map_tile_url', 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png') }}"
                           placeholder="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png">
                    <span class="help">Leave as default for standard OpenStreetMap tiles</span>
                </div>
            </div>

            {{-- TIMELINE UPDATES --}}
            <div class="form-section">
                <div class="form-section-title"><i class="fas fa-stream"></i> Timeline Events</div>
                <div id="updates-wrap">
                    <div class="update-row row-2 mb-3" style="align-items:start;">
                        <div class="fl" style="margin:0;">
                            <label>Location</label>
                            <input type="text" name="updates[0][location]"
                                   placeholder="e.g. Edmonton International Airport">
                        </div>
                        <div class="fl" style="margin:0;">
                            <label>Description</label>
                            <input type="text" name="updates[0][description]"
                                   placeholder="e.g. Package picked up">
                        </div>
                        <div class="fl" style="margin:0;">
                            <label>Status</label>
                            <select name="updates[0][status]">
                                <option value="In Transit">In Transit</option>
                                <option value="On Hold">On Hold</option>
                                <option value="Delivered">Delivered</option>
                            </select>
                        </div>
                        <div class="fl" style="margin:0;">
                            <label>Pending</label>
                            <select name="updates[0][pending]">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                        <div class="fl" style="margin:0;">
                            <label>Occurred At</label>
                            <input type="datetime-local" name="updates[0][occurred_at]" value="{{ old('updates.0.occurred_at') }}">
                        </div>
                        
                    </div>
                </div>
                <button type="button" onclick="addUpdateRow()" style="background:none; border:1px dashed #CBD5E1; border-radius:8px; padding:8px 16px; color:#64748B; font-size:12px; cursor:pointer; font-family:inherit; margin-top:4px;">
                    <i class="fas fa-plus me-1"></i> Add Another Event
                </button>
            </div>

            {{-- GOODS & PACKAGE --}}
            <div class="form-section">
                <div class="form-section-title"><i class="fas fa-cube"></i> Package Details</div>
                <div class="fl">
                    <label>Description of Goods</label>
                    <textarea name="goods_description" rows="3"
                              placeholder="e.g. DRILL, QUADRUPLET — Electronics equipment">{{ old('goods_description') }}</textarea>
                </div>
                <div class="fl">
                    <label>Product Image</label>
                    <input type="file" name="product_image" accept="image/*" onchange="previewImage(this)">
                    <div class="img-preview-wrap">
                        <img id="img_preview" class="img-preview" src="" alt="Preview">
                    </div>
                </div>
                <div class="fl">
                    <label>Reference Code</label>
                    <input type="text" name="reference" value="{{ old('reference') }}" placeholder="e.g. PO-45678">
                </div>
                <div class="row-3">
                    <div class="fl">
                        <label>Package Type</label>
                        <input type="text" name="package_type" value="{{ old('package_type') }}" placeholder="e.g. Box, Pallet, Envelope">
                    </div>
                    <div class="fl">
                        <label>Weight</label>
                        <input type="text" name="weight" value="{{ old('weight') }}" placeholder="e.g. 15 kg">
                    </div>
                    <div class="fl">
                        <label>Quantity</label>
                        <input type="number" name="quantity" value="{{ old('quantity') }}" min="1" placeholder="e.g. 3">
                    </div>
                    <div class="fl">
                        <label>Estimated Delivery Date</label>
                        <input type="date" name="estimated_delivery" value="{{ old('estimated_delivery') }}">
                    </div>
                    <div class="fl">
                        <label>Pickup Date</label>
                        <input type="date" name="pickup_date" value="{{ old('pickup_date') }}">
                    </div>
                    <div class="fl">
                        <label>Pickup Time</label>
                        <input type="time" name="pickup_time" value="{{ old('pickup_time') }}">
                    </div>
                    <div class="fl">
                        <label>Transit Time</label>
                        <input type="text" name="transit_time" value="{{ old('transit_time') }}" placeholder="e.g. 3 days">
                    </div>

                </div>
                <div class="fl">
                    <label>Service Type</label>
                    <input type="text" name="service_type" value="{{ old('service_type') }}" placeholder="e.g. Express, Standard">
                </div>

            </div>

        </div>

        <div class="form-footer">
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Create Shipment
            </button>
            <a href="{{ route('admin.shipments') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
// Auto-extract coordinates from Google Maps link
document.querySelector('input[name="google_link"]').addEventListener('input', function() {
    const val = this.value;
    const match = val.match(/@(-?\d+\.\d+),(-?\d+\.\d+)/);
    if (match) {
        document.getElementById('lat_field').value = match[1];
        document.getElementById('lng_field').value = match[2];
    }
});

// Image preview
function previewImage(input) {
    const preview = document.getElementById('img_preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Add timeline event rows
let updateIdx = 1;
function addUpdateRow() {
    const wrap = document.getElementById('updates-wrap');
    const div = document.createElement('div');
    div.className = 'update-row row-2 mb-3';
    div.style.alignItems = 'start';
    div.innerHTML = `
        <div class="fl" style="margin:0;">
            <label>Location</label>
            <input type="text" name="updates[${updateIdx}][location]" placeholder="e.g. Denver International Airport">
        </div>
        <div class="fl" style="margin:0;">
            <label>Description</label>
            <input type="text" name="updates[${updateIdx}][description]" placeholder="e.g. Package in transit">
        </div>
    `;
    wrap.appendChild(div);
    updateIdx++;
}
</script>
@endpush
