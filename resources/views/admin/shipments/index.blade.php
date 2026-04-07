@extends('admin.layout')

@section('content')
<h2>All Shipments</h2>

<a href="{{ route('admin.shipments.create') }}" class="btn btn-primary mb-3">Create Shipment</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tracking #</th>
            <th>Receiver</th>
            <th>Status</th>
            <th>Progress</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($shipments as $ship)
        <tr>
            <td>{{ $ship->tracking_number }}</td>
            <td>{{ $ship->receiver_name }}</td>
            <td>{{ $ship->status }}</td>
            <td>{{ $ship->progress }}%</td>
            <td>
                @if($ship->product_image)
                    <img src="{{ asset('uploads/'.$ship->product_image) }}" width="60">
                @endif
            </td>
            <td>
                <a href="{{ route('admin.shipments.edit', $ship->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <a href="{{ route('admin.shipments.delete', $ship->id) }}" class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $shipments->links() }}
@endsection
