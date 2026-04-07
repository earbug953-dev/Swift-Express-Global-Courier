<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;


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

    public function index()
    {
        $shipments = Shipment::latest()->paginate(10);
        return view('admin.shipments.index', compact('shipments'));
    }

    public function create()
    {
        return view('admin.shipments.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('product_image')) {
            $imageName = time().'.'.$request->product_image->extension();
            $request->product_image->move(public_path('uploads'), $imageName);
            $data['product_image'] = $imageName;
            $data['goods_description'] = $request->goods_description;
        }

        if ($request->google_link) {
    if (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', $request->google_link, $matches)) {
        $data['current_lat'] = $matches[1];
        $data['current_lng'] = $matches[2];
    }
}

        Shipment::create($data);

        return redirect()->route('admin.shipments')->with('success', 'Shipment created successfully');
    }

    public function edit($id)
    {
        $shipment = Shipment::findOrFail($id);
        return view('admin.shipments.edit', compact('shipment'));
    }

    public function update(Request $request, $id)
    {
        $shipment = Shipment::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('product_image')) {
            $imageName = time().'.'.$request->product_image->extension();
            $request->product_image->move(public_path('uploads'), $imageName);
            $data['product_image'] = $imageName;
            $data['map_tile_url'] = $request->map_tile_url;
            $data['goods_description'] = $request->goods_description;
        }
        if ($request->google_link) {
    // Extract coordinates from Google Maps link
    if (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', $request->google_link, $matches)) {
        $data['current_lat'] = $matches[1];
        $data['current_lng'] = $matches[2];
    }
}

        $data['map_moving'] = $request->map_moving ? 1 : 0;

        $shipment->update($data);

        return redirect()->route('admin.shipments')->with('success', 'Shipment updated successfully');
    }

    public function delete($id)
    {
        Shipment::findOrFail($id)->delete();
        return back()->with('success', 'Shipment deleted');
    }
}
