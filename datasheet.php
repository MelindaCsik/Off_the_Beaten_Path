<?php
include "./common/head.inc.php";

// Get POI ID from URL
$poi_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch POI Data from API using cURL
$api_url = "https://banki13.komarom.net/2024/off-the-beaten-path/api/places.api.php?id=" . $poi_id; // Change to actual URL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Decode API response
$poi_data = ($http_code === 200) ? json_decode($response, true) : null;

// Ensure data is available
$poi = $poi_data['success'] && !empty($poi_data['message']) ? $poi_data['message'] : null;

// Default coordinates (if POI is not found or lacks coordinates)
$latitude = $poi['latitude'] ?? 47.60444864605358;
$longitude = $poi['longitude'] ?? 18.371659194861106;
?>

<div class="d-flex mrg">
    <!-- POI Details -->
    <div class="col-lg-6">
        <div class="p-5">
            <?php if ($poi): ?>
                <h2><?= htmlspecialchars($poi['poi_name']) ?></h2>
                <h5>Kategória: <?= htmlspecialchars($poi['category_id']) ?></h5>
                <p><?= htmlspecialchars($poi['poi_discription']) ?></p>
            <?php else: ?>
                <p>Nem található POI.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- POI Image -->
    <div class="col-lg-6">
        <div class="p-5">
            <div class="justify-content-end">
                <img src="img/park.jpg" alt="POI kép" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- Map Container -->
<div class="container mt-5">
    <div id="map" class="mapview" style="height: 400px;"></div>
</div>

<!-- Load Leaflet Map -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var coordinates = { 
        lat: <?= json_encode($latitude) ?>, 
        lng: <?= json_encode($longitude) ?> 
    };

    var map = L.map('map').setView([coordinates.lat, coordinates.lng], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap hozzájárulók'
    }).addTo(map);

    L.marker([coordinates.lat, coordinates.lng]).addTo(map)
        .bindPopup("<?= htmlspecialchars($poi['poi_name'] ?? 'Kijelölt pont') ?>")
        .openPopup();
</script>

<?php include "./common/foot.inc.php"; ?>
