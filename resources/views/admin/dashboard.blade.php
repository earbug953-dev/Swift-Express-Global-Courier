@extends('admin.layout')

@section('content')
<h2>Dashboard</h2>

<div class="card mt-4">
    <div class="card-body">
        <h4>Total Shipments: {{ $total }}</h4>
    </div>
</div>
@endsection
