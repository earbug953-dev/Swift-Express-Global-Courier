@extends('admin.layout')

@section('content')
<h2>Create Shipment</h2>

<form action="{{ route('admin.shipments.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label>Tracking Number</label>
        <input type="text" name="tracking_number" class="form-control">
    </div>

    <div class="mb-3">
        <label>Sender Name</label>
        <input type="text" name="sender_name" class="form-control">
    </div>

    <div class="mb-3">
        <label>Receiver Name</label>
        <input type="text" name="receiver_name" class="form-control">
    </div>

    <div class="mb-3">
        <label>Origin</label>
        <input type="text" name="origin" class="form-control">
    </div>

    <div class="mb-3">
        <label>Destination</label>
        <input type="text" name="destination" class="form-control">
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option>In Transit</option>
            <option>On Hold</option>
            <option>Delivered</option>
        </select>
    </div>
   <div class="mb-3">
    <label>Google Maps Link</label>
    <input type="text" name="google_link" class="form-control" value="{{ $shipment->google_link ?? '' }}" placeholder="Paste Google Maps link here">
</div>

<div class="mb-3">
    <label>Description of Goods</label>
    <textarea name="goods_description" class="form-control" rows="3"></textarea>
</div>
    <div class="mb-3">
        <label>Progress (%)</label>
        <input type="number" name="progress" class="form-control" value="10">
    </div>

    <div class="mb-3">
        <label>Product Image</label>
        <input type="file" name="product_image" class="form-control">
    </div>

    <button class="btn btn-success">Save</button>
</form>
@endsection
