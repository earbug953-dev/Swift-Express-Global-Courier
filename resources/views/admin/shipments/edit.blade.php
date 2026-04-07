@extends('admin.layout')

@section('content')
<h2>Edit Shipment</h2>

<form action="{{ route('admin.shipments.update', $shipment->id) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label>Tracking Number</label>
        <input type="text" name="tracking_number" class="form-control" value="{{ $shipment->tracking_number }}">
    </div>

    <div class="mb-3">
        <label>Sender Name</label>
        <input type="text" name="sender_name" class="form-control" value="{{ $shipment->sender_name }}">
    </div>

    <div class="mb-3">
        <label>Receiver Name</label>
        <input type="text" name="receiver_name" class="form-control" value="{{ $shipment->receiver_name }}">
    </div>

    <div class="mb-3">
        <label>Origin</label>
        <input type="text" name="origin" class="form-control" value="{{ $shipment->origin }}">
    </div>

    <div class="mb-3">
        <label>Destination</label>
        <input type="text" name="destination" class="form-control" value="{{ $shipment->destination }}">
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option {{ $shipment->status == 'In Transit' ? 'selected' : '' }}>In Transit</option>
            <option {{ $shipment->status == 'On Hold' ? 'selected' : '' }}>On Hold</option>
            <option {{ $shipment->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Progress (%)</label>
        <input type="number" name="progress" class="form-control" value="{{ $shipment->progress }}">
    </div>

    <div class="mb-3">
        <label>Current Latitude</label>
        <input type="text" name="current_lat" class="form-control" value="{{ $shipment->current_lat }}">
    </div>

    <div class="mb-3">
        <label>Current Longitude</label>
        <input type="text" name="current_lng" class="form-control" value="{{ $shipment->current_lng }}">
    </div>
    <div class="mb-3">
    <label>Map Tile URL</label>
    <input type="text" name="map_tile_url" class="form-control" value="{{ $shipment->map_tile_url }}">
    <small class="text-muted">Paste any map tile URL here</small>
</div>

<div class="mb-3">
    <label>Description of Goods</label>
    <textarea name="goods_description" class="form-control" rows="3">{{ $shipment->goods_description }}</textarea>
</div>
    <div class="mb-3">
        <label>Map Movement</label>
        <select name="map_moving" class="form-control">
            <option value="1" {{ $shipment->map_moving ? 'selected' : '' }}>Moving</option>
            <option value="0" {{ !$shipment->map_moving ? 'selected' : '' }}>Paused</option>
        </select>
    </div>

    @if($shipment->product_image)
        <img src="{{ asset('uploads/'.$shipment->product_image) }}" width="120" class="mb-3">
    @endif

    <div class="mb-3">
        <label>Change Product Image</label>
        <input type="file" name="product_image" class="form-control">
    </div>

    <button class="btn btn-success">Update</button>
</form>
@endsection
