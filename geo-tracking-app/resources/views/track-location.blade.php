
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<form method="POST" action="/location">
    @csrf
    <label for="latitude">Latitude:</label>
    <input type="text" name="latitude" required>
    <label for="longitude">Longitude:</label>
    <input type="text" name="longitude" required>
    <button type="submit">Submit Location</button>
</form>

<div id="map" style="height: 500px;"></div>
<script>
    var map = L.map('map').setView([51.505, -0.09], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map);

    // Load user locations and display them
    fetch('/api/locations')
        .then(response => response.json())
        .then(data => {
            data.forEach(location => {
                L.marker([location.latitude, location.longitude]).addTo(map);
            });
        });
</script>
