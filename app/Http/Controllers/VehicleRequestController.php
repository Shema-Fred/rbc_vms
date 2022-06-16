<?php

namespace App\Http\Controllers;

use App\Models\VehicleRequest;
use Illuminate\Http\Request;

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

        return view('vehicleRequests.index', compact('vehicleRequests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vehicleRequests.create');
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
            'user_id' => ['required', 'integer'],
            'destination' => ['required', 'date'],
        ]);

        $vehicleRequest = new VehicleRequest();
        $vehicleRequest->user_id = $request->user_id;
        $vehicleRequest->destination = $request->destination;
        $vehicleRequest->save();

        return redirect()->route('vehicleRequests.index')->with('message', 'Vehicle Request created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VehicleRequest  $vehicleRequest
     * @return \Illuminate\Http\Response
     */
    public function show($vehicleRequest)
    {
        return redirect()->route('vehicleRequests.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VehicleRequest  $vehicleRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleRequest $vehicleRequest)
    {
        return view('vehicleRequests.edit', compact('vehicleRequest'));
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
        $request->validate([
            'vehicle_id' => ['required', 'integer'],
            'deadline' => ['required', 'date'],
            'status' => ['required', 'string'],
        ]);

        $vehicleRequest->vehicle_id = $request->vehicle_id;
        $vehicleRequest->deadline = $request->deadline;
        $vehicleRequest->status = $request->status;
        $vehicleRequest->save();

        return redirect()->route('vehicleRequests.index')->with('message', 'Vehicle Request updated successfully.');
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
            return redirect()->route('vehicleRequests.index')->with('message', 'Vehicle Request not found.');
        }

        $vehicleRequest->delete();

        return redirect()->route('vehicleRequests.index')->with('message', 'Vehicle Request deleted successfully.');
    }
}
