<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Your Home Location</title>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.js"></script>
    <style>
        #map {
            width: 100%;
            height: 400px;
        }
    </style>
</head>
<body>
<h1>Set Your Home Location</h1>

<div id="map"></div>

<form action="{{ route('location.store') }}" method="POST">
    @csrf
    <input type="hidden" id="latitude" name="latitude" required>
    <input type="hidden" id="longitude" name="longitude" required>
    <button type="submit">Save Location</button>
</form>

<script>
    mapboxgl.accessToken = 'pk.eyJ1Ijoicm93YW5iaWV0cyIsImEiOiJjbTNlOWNpN2swYTEzMm1zOGJjOXQzemg0In0.8VU4-i9oySi0jhvn88r88Q';
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [-0.1276, 51.5074], // Default center (London)
        zoom: 12
    });

    const marker = new mapboxgl.Marker({ draggable: true })
        .setLngLat([-0.1276, 51.5074])
        .addTo(map);

    marker.on('dragend', function() {
        const lngLat = marker.getLngLat();
        document.getElementById('latitude').value = lngLat.lat;
        document.getElementById('longitude').value = lngLat.lng;
    });
</script>
</body>
</html>
