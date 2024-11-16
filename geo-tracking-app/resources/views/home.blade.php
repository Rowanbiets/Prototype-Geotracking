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

                    <!-- Button to remove marker -->
                    <button type="button" id="removeMarker" class="bg-red-500 text-white px-4 py-2 rounded mt-4">Remove Marker</button>

                    <!-- Message Area -->
                    <div id="message" class="mt-4"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@turf/turf"></script> <!-- Include Turf.js -->
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.css" rel="stylesheet">

    <script>
        mapboxgl.accessToken = 'pk.eyJ1Ijoicm93YW5iaWV0cyIsImEiOiJjbTNlOWNpN2swYTEzMm1zOGJjOXQzemg0In0.8VU4-i9oySi0jhvn88r88Q';

        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [4.3517, 50.8503], // Coordinates for Brussels
            zoom: 12
        });

        let destinationMarker;
        const destinationCoords = [4.3517, 50.8503];  // Coordinates for Brussels
        const geofenceRadius = 352;  // Radius in meters (352 meters)

        // Create a message area to show alerts
        const messageArea = document.getElementById('message');

        map.on('load', function () {
            // Create a polygon geofence using Turf.js (steps = 64 makes it smooth)
            const geofencePolygon = turf.circle(turf.point(destinationCoords), geofenceRadius, { steps: 64, units: 'meters' });

            // Add the polygon to the map as a 'fill' layer
            map.addLayer({
                'id': 'geofence',
                'type': 'fill',
                'source': {
                    'type': 'geojson',
                    'data': geofencePolygon
                },
                'paint': {
                    'fill-color': '#FF0000',   // Color of the polygon
                    'fill-opacity': 0.2        // Transparency of the polygon
                }
            });

            // Add destination marker
            destinationMarker = new mapboxgl.Marker({ color: 'red' })
                .setLngLat(destinationCoords)
                .addTo(map);

            // Create and add a user marker (blue) and make it draggable
            let userMarker = new mapboxgl.Marker({ color: 'blue' })
                .setLngLat(destinationCoords)
                .addTo(map)
                .setDraggable(true); // Enable dragging

            // When the user moves the marker, update the position and check the geofence
            userMarker.on('dragend', function() {
                const userCoords = userMarker.getLngLat();

                // Check if the user is inside the geofence polygon
                const userPoint = turf.point([userCoords.lng, userCoords.lat]);
                const isInside = turf.booleanPointInPolygon(userPoint, geofencePolygon);

                // Show messages based on whether the user is inside or outside the geofence
                if (isInside) {
                    messageArea.innerHTML = "<span style='color: green;'>You are nearby the destination!</span>";
                } else {
                    messageArea.innerHTML = "<span style='color: red;'>You are outside the geofence!</span>";
                }

                // Update form hidden inputs with the user's new location
                document.getElementById('latitude').value = userCoords.lat;
                document.getElementById('longitude').value = userCoords.lng;
            });

            // Track user's current location
            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(function(position) {
                    const userCoords = [position.coords.longitude, position.coords.latitude];

                    // Move the blue user marker based on current location
                    userMarker.setLngLat(userCoords);

                    // Check if the user is inside the geofence polygon
                    const userPoint = turf.point(userCoords);
                    const isInside = turf.booleanPointInPolygon(userPoint, geofencePolygon);

                    // Show messages based on whether the user is inside or outside the geofence
                    if (isInside) {
                        messageArea.innerHTML = "<span style='color: green;'>You are nearby the destination!</span>";
                    } else {
                        messageArea.innerHTML = "<span style='color: red;'>You are outside the geofence!</span>";
                    }

                    // Update form hidden inputs with the user's location
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                });
            }

            // Remove marker when the remove button is clicked
            document.getElementById('removeMarker').addEventListener('click', function() {
                userMarker.remove();  // Remove the user marker
                messageArea.innerHTML = "";  // Clear the message area
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
