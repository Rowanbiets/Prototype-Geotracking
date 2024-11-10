<?php

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        Location::create([
            'user_id' => Auth::id(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'tracked_at' => now(),
        ]);

        return response()->json(['message' => 'Location saved successfully.'], 200);
    }
    public function index()
    {
        $locations = Location::where('user_id', Auth::id())->get();
        return response()->json($locations);
    }

}
