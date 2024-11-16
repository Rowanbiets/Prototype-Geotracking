<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                    <br><br>

                    <!-- Mapbox Map -->
                    <div id="map" style="height: 500px; width: 100%;"></div>

                    <form action="{{ route('location.store') }}" method="POST">
                        @csrf
                        <input type="hidden" id="latitude" name="latitude" required>
                        <input type="hidden" id="longitude" name="longitude" required>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Location</button>
                    </form>
                    <button type="button" id="removeMarker" class="bg-red-500 text-white px-4 py-2 rounded mt-4">Remove Marker</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.css" rel="stylesheet">

    <script>
        mapboxgl.accessToken = 'pk.eyJ1Ijoicm93YW5iaWV0cyIsImEiOiJjbTNlOWNpN2swYTEzMm1zOGJjOXQzemg0In0.8VU4-i9oySi0jhvn88r88Q';

        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [-73.97, 40.77],
            zoom: 12
        });

        // Geofence settings
        const geofenceCenter = [-73.97, 40.77]; // Center of the geofence
        const geofenceRadius = 500; // Radius in meters
        let insideGeofence = false; // Track if the user is within the geofence

        // Calculate distance between two coordinates in meters
        function calculateDistance(coord1, coord2) {
            const R = 6371e3; // Earth radius in meters
            const lat1 = coord1[1] * (Math.PI / 180);
            const lat2 = coord2[1] * (Math.PI / 180);
            const deltaLat = (coord2[1] - coord1[1]) * (Math.PI / 180);
            const deltaLng = (coord2[0] - coord1[0]) * (Math.PI / 180);

            const a = Math.sin(deltaLat / 2) * Math.sin(deltaLat / 2) +
                Math.cos(lat1) * Math.cos(lat2) *
                Math.sin(deltaLng / 2) * Math.sin(deltaLng / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            return R * c; // Distance in meters
        }

        // Watch user location
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition(function(position) {
                const userLocation = [position.coords.longitude, position.coords.latitude];

                // Check if user is inside the geofence
                const distance = calculateDistance(userLocation, geofenceCenter);

                if (distance <= geofenceRadius && !insideGeofence) {
                    insideGeofence = true;
                    alert('You have entered the geofence!');
                } else if (distance > geofenceRadius && insideGeofence) {
                    insideGeofence = false;
                    alert('You have exited the geofence!');
                }

                // Update the map and marker with the user's location
                map.flyTo({ center: userLocation, zoom: 14 });
                const userMarker = new mapboxgl.Marker()
                    .setLngLat(userLocation)
                    .addTo(map);
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }

        // Geofence visualization
        map.on('load', function () {
            map.addSource('geofence', {
                'type': 'geojson',
                'data': {
                    'type': 'Feature',
                    'geometry': {
                        'type': 'Point',
                        'coordinates': geofenceCenter
                    }
                }
            });

            map.addLayer({
                'id': 'geofence-layer',
                'type': 'circle',
                'source': 'geofence',
                'paint': {
                    'circle-radius': {
                        'base': 1.5,
                        'stops': [
                            [12, geofenceRadius / 2], // Adjusts circle radius to zoom level
                            [22, geofenceRadius]
                        ]
                    },
                    'circle-color': '#FF0000',
                    'circle-opacity': 0.2
                }
            });
        });
    </script>


@if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
</x-app-layout>
