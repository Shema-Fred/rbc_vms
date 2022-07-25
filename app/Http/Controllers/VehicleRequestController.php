<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleRequestController extends Controller
{

    public function checkVehicleAvailability($vehicleRequest)
    {
        $now = Carbon::now();
        $deadline = Carbon::parse($vehicleRequest->deadline);
        if ($vehicleRequest->vehicle && $now->gt($deadline)) {
            $vehicleRequest->vehicle_id = null;
            $vehicleRequest->status = 'expired';
            $vehicleRequest->save();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicleRequests = VehicleRequest::latest()->paginate(10);

        foreach ($vehicleRequests as $vehicleRequest) {
            $this->checkVehicleAvailability($vehicleRequest);
        }

        return view('vehicleRequest.index', compact('vehicleRequests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vehicleRequest.create');
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
            'destination' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        $user = request()->user();

        $vehicleRequest = new VehicleRequest();
        $vehicleRequest->user_id = $user->id;
        $vehicleRequest->description = $request->description;
        $vehicleRequest->destination = $request->destination;
        $vehicleRequest->days = $request->days;
        $vehicleRequest->save();

        return redirect()->route('vehicleRequest.index')->with('message', 'Vehicle requested successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VehicleRequest  $vehicleRequest
     * @return \Illuminate\Http\Response
     */
    public function show($vehicleRequest)
    {
        return redirect()->route('vehicleRequest.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VehicleRequest  $vehicleRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleRequest $vehicleRequest)
    {
        $vehicles = Vehicle::whereDoesntHave('vehicleRequests')->latest()->get();
        $drivers = User::where('role', 'driver')->latest()->get();

        return view('vehicleRequest.edit', compact('vehicleRequest', 'vehicles', 'drivers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VehicleRequest  $vehicleRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VehicleRequest $vehicleRequest)
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $deadline = null;
            $request->validate([
                'vehicle_id' => ['sometimes', 'required', 'integer', 'exists:vehicles,id'],
                'status' => ['required', 'string'],
            ]);
            if ($request->status == 'approved') {
                if ($vehicleRequest->destination == 'kigali') {
                    $deadline = Carbon::now()->addHours(2);
                } else {
                    $deadline = Carbon::now()->addDays($vehicleRequest->days ?? 0);
                }
            }
            $vehicleRequest->vehicle_id = $request->vehicle_id ?? $vehicleRequest->vehicle_id ?? null;
            $vehicleRequest->deadline = $deadline;
            $vehicleRequest->reason = $request->reason;
            $vehicleRequest->status = $request->status;
            $vehicleRequest->save();
            $vehicle = $vehicleRequest->vehicle()->get()->first();
            if ($request->vehicle_id && $request->driver_id) {
                $vehicle->driver_id = $request->driver_id ?? $vehicle->driver_id;
                $vehicle->save();
            }
            if ($request->status == 'rejected') {
                $this->reportCompleted($request, $vehicleRequest);
            }
        } else if ($user->hasRole('staff')) {
            $request->validate([
                'destination' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'max:255'],
            ]);

            $vehicleRequest->user_id = $user->id;
            $vehicleRequest->status = 'pending';
            $vehicleRequest->deadline = null;
            $vehicleRequest->days = $request->days;
            $vehicleRequest->description = $request->description;
            $vehicleRequest->destination = $request->destination;
            $vehicleRequest->save();
        } else {
            return redirect()->route('vehicleRequest.index')->with('message', 'You are not authorized to perform this action.');
        }


        return redirect()->route('vehicleRequest.index')->with('message', 'Vehicle Request updated successfully.');
    }

    public function reportCompleted(Request $request, VehicleRequest $vehicleRequest)
    {
        $user = Auth::user();
        if (!$user->hasRole('driver')) {
            $vehicleRequest->status = $request->status ?? 'expired';
            $vehicleRequest->vehicle_id = null;
            $vehicleRequest->save();
        } else {
            return redirect()->route('vehicleRequest.index')->with('message', 'You are not authorized to perform this action.');
        }

        return redirect()->route('vehicleRequest.index')->with('message', 'Vehicle Request updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VehicleRequest  $vehicleRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleRequest $vehicleRequest)
    {
        if (!$vehicleRequest) {
            return redirect()->route('vehicleRequest.index')->with('message', 'Vehicle Request not found.');
        }

        $vehicleRequest->delete();

        return redirect()->route('vehicleRequest.index')->with('message', 'Vehicle Request deleted successfully.');
    }
}
