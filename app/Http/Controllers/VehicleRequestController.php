<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicleRequests = VehicleRequest::latest()->paginate(10);

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

        return view('vehicleRequest.edit', compact('vehicleRequest', 'vehicles'));
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
            $request->validate([
                'vehicle_id' => ['sometimes', 'required', 'integer', 'exists:vehicles,id'],
                'status' => ['required', 'string'],
                'deadline' => ['required', 'date_format:d-m-Y H:i'],
            ]);
            $vehicleRequest->vehicle_id = $request->vehicle_id ?? $vehicleRequest->vehicle_id ?? null;
            $vehicleRequest->deadline = $request->deadline;
            $vehicleRequest->status = $request->status;
            $vehicleRequest->save();
        } else if ($user->hasRole('staff')) {
            $request->validate([
                'destination' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'max:255'],
            ]);

            $vehicleRequest->user_id = $user->id;
            $vehicleRequest->description = $request->description;
            $vehicleRequest->destination = $request->destination;
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
