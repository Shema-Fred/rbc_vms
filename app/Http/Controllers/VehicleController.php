<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicles = Vehicle::with('vehicleRequests')->latest()->paginate(10);

        return view('vehicle.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $drivers = User::where('role', 'driver')->latest()->get();
        return view('vehicle.create', compact('drivers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'plate' => ['required', 'string', 'max:255'],
            'driver_id' => ['nullable', 'integer'],
        ]);

        $vehicle = new Vehicle();
        $vehicle->name = $request->name;
        $vehicle->plate = $request->plate;
        $vehicle->driver_id = $request->driver_id;
        $vehicle->save();

        return redirect()->route('vehicle.index')->with('message', 'Vehicle created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show($vehicle)
    {
        return view('vehicle.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        $drivers = User::where('role', 'driver')->latest()->get();
        return view('vehicle.edit', compact('vehicle', 'drivers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'plate' => ['required', 'string', 'max:255'],
            'driver_id' => ['nullable', 'integer'],
        ]);

        if (!$vehicle) {
            return redirect()->route('vehicle.index')->with('message', 'Vehicle not found.');
        }

        $vehicle->name = $request->name ?? $vehicle->name;
        $vehicle->plate = $request->plate ?? $vehicle->plate;
        $vehicle->driver_id = $request->driver_id ?? $vehicle->driver_id;
        $vehicle->save();

        return redirect()->route('vehicle.index')->with('message', 'Vehicle updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        if (!$vehicle) {
            return redirect()->route('vehicle.index')->with('message', 'Vehicle not found.');
        }

        $vehicle->delete();

        return redirect()->route('vehicle.index')->with('message', 'Vehicle deleted successfully.');
    }
}
