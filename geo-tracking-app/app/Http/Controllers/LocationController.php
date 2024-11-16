<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        // Validatie van de binnenkomende locatiegegevens
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Verkrijg de ingevoerde locatie van de gebruiker
        $userLatitude = $request->latitude;
        $userLongitude = $request->longitude;

        // Geofence coördinaten (bijvoorbeeld, een locatie in Brussel)
        $geofenceLatitude = 50.8503;
        $geofenceLongitude = 4.3517;
        $geofenceRadius = 1000;  // Straal van 1000 meter (1 km)

        // Bereken de afstand tussen de gebruiker en de geofence locatie
        $distance = $this->calculateDistance($geofenceLatitude, $geofenceLongitude, $userLatitude, $userLongitude);

        // Check of de gebruiker binnen de geofence is
        if ($distance <= $geofenceRadius) {
            // Gebruiker is binnen de geofence
            $location = new Location();
            $location->user_id = auth()->id();
            $location->latitude = $request->latitude;
            $location->longitude = $request->longitude;
            $location->save();

            return redirect()->route('home')->with('success', 'Home location saved within geofence!');
        } else {
            // Gebruiker is buiten de geofence
            return redirect()->route('home')->with('error', 'The location is outside the geofence.');
        }
    }

    // Haversine-formule om de afstand te berekenen
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;  // Aarde straal in meters

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDiff = $latTo - $latFrom;
        $lonDiff = $lonTo - $lonFrom;

        $a = sin($latDiff / 2) * sin($latDiff / 2) +
            cos($latFrom) * cos($latTo) *
            sin($lonDiff / 2) * sin($lonDiff / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;  // In meters
    }
}
