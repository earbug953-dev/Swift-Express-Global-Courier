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
    <label>Map Movement</label>
    <select name="map_moving" class="form-control">
        <option value="1" {{ $shipment->map_moving ? 'selected' : '' }}>Moving</option>
        <option value="0" {{ !$shipment->map_moving ? 'selected' : '' }}>Paused</option>
    </select>
</div>
