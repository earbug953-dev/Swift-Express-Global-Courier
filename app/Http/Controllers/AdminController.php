<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\ShipmentUpdate;

class AdminController extends Controller
{
    public function dashboard()
    {
        $total = Shipment::count();
        return view('admin.dashboard', compact('total'));
    }

    public function index(Request $request)
    {
        $query = Shipment::latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by tracking number, sender, or receiver name
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('tracking_number', 'like', "%{$s}%")
                  ->orWhere('sender_name',   'like', "%{$s}%")
                  ->orWhere('receiver_name', 'like', "%{$s}%");
            });
        }

        $shipments = $query->paginate(10)->withQueryString();

        return view('admin.shipments.index', compact('shipments'));
    }

    public function create()
    {
        return view('admin.shipments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sender_name'   => 'required|string',
            'receiver_name' => 'required|string',
            'origin'        => 'required|string',
            'destination'   => 'required|string',
            'status'        => 'required|string',
            'estimated_delivery' => 'nullable|date',
            'pickup_date' => 'nullable|date',
            'pickup_time' => 'nullable|string',
            'transit_time' => 'nullable|string',
            'reference' => 'nullable|string',
            'package_type' => 'nullable|string',
            'weight' => 'nullable|string',
            'quantity' => 'nullable|integer',
            'service_type' => 'nullable|string',

        ]);

        $data = $request->except(['_token', 'product_image', 'updates']);

        // Handle image upload
        if ($request->hasFile('product_image')) {
            $imageName = time() . '.' . $request->product_image->extension();
            $request->product_image->move(public_path('uploads'), $imageName);
            $data['product_image'] = $imageName;
        }

        // Auto-extract lat/lng from Google Maps link
        if ($request->filled('google_link')) {
            if (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', $request->google_link, $matches)) {
                $data['current_lat'] = $matches[1];
                $data['current_lng'] = $matches[2];
            }
        }

        $data['map_moving'] = $request->has('map_moving') ? (int)$request->map_moving : 1;

        // Auto-generate tracking number if blank
        if (empty($data['tracking_number'])) {
            $data['tracking_number'] = 'SWF-' . strtoupper(\Illuminate\Support\Str::random(4)) . '-' . date('y') . rand(1000, 9999);
        }

        $shipment = Shipment::create($data);

        // Save timeline events
        if ($request->has('updates')) {
            foreach ($request->updates as $update) {
                if (!empty($update['location'])) {
                    ShipmentUpdate::create([
                        'shipment_id' => $shipment->id,
                        'location'    => $update['location'],
                        'description' => $update['description'] ?? '',
                        'occurred_at' => now(),
                        'status' => $update['status'],
                        'pending' => $update['pending'] ?? false,
                    ]);
                }
            }
        }

        return redirect()->route('admin.shipments')
            ->with('success', 'Shipment created! Tracking: ' . $shipment->tracking_number);
    }

    public function edit($id)
    {
        $shipment = Shipment::with('updates')->findOrFail($id);
        return view('admin.shipments.edit', compact('shipment'));
    }

    public function update(Request $request, $id)
    {
        $shipment = Shipment::findOrFail($id);

        $data = $request->except(['_token', 'product_image', 'updates', 'new_updates']);

        // Handle image upload
        if ($request->hasFile('product_image')) {
            // Delete old image if exists
            if ($shipment->product_image && file_exists(public_path('uploads/' . $shipment->product_image))) {
                unlink(public_path('uploads/' . $shipment->product_image));
            }
            $imageName = time() . '.' . $request->product_image->extension();
            $request->product_image->move(public_path('uploads'), $imageName);
            $data['product_image'] = $imageName;
        }

        // Auto-extract lat/lng from Google Maps link
        if ($request->filled('google_link')) {
            if (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', $request->google_link, $matches)) {
                $data['current_lat'] = $matches[1];
                $data['current_lng'] = $matches[2];
            }
        }

        $data['map_moving'] = $request->has('map_moving') ? (int)$request->map_moving : 0;

        $shipment->update($data);

        // Update existing timeline events
        if ($request->has('updates')) {
            foreach ($request->updates as $upd) {
                if (!empty($upd['id']) && !empty($upd['location'])) {
                    ShipmentUpdate::where('id', $upd['id'])->update([
                        'location'    => $upd['location'],
                        'description' => $upd['description'] ?? '',
                        'occurred_at' => now(),
                        'status' => $upd['status'] ?? 'Pending',
                        'pending' => $upd['pending'] ?? false,
                    ]);
                }
            }
        }

        // Add new timeline events
        if ($request->has('new_updates')) {
            foreach ($request->new_updates as $newUpd) {
                if (!empty($newUpd['location'])) {
                    ShipmentUpdate::create([
                        'shipment_id' => $shipment->id,
                        'location'    => $newUpd['location'],
                        'description' => $newUpd['description'] ?? '',
                        'occurred_at' => now(),
                        'status' => $newUpd['status'] ?? 'Pending',
                        'pending' => $newUpd['pending'] ?? false,

                    ]);
                }
            }
        }

        return redirect()->route('admin.shipments')
            ->with('success', 'Shipment updated successfully.');
    }

    public function delete($id)
    {
        $shipment = Shipment::findOrFail($id);

        // Delete image file
        if ($shipment->product_image && file_exists(public_path('uploads/' . $shipment->product_image))) {
            unlink(public_path('uploads/' . $shipment->product_image));
        }

        $shipment->updates()->delete();
        $shipment->delete();

        return redirect()->route('admin.shipments')
            ->with('success', 'Shipment deleted successfully.');
    }
}
