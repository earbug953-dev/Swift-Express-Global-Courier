<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function track(Request $request)
    {
        $shipment = Shipment::where('tracking_number', $request->tracking_number)->first();

        if (!$shipment) {
            return back()->with('error', 'Tracking number not found');
        }

        return view('track', compact('shipment'));
    }

    // API endpoint for auto map movement
    public function liveLocation($tracking)
{
    $shipment = Shipment::where('tracking_number', $tracking)->first();

    return response()->json([
        'lat' => $shipment->current_lat,
        'lng' => $shipment->current_lng,
        'moving' => $shipment->map_moving
    ]);
}

}
