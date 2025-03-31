<?php
include "./common/head.inc.php";

$poi_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$poi_data = json_decode(file_get_contents("places.api.php?id=" . $poi_id), true);
?><div class="d-flex mrg">
    <div class="col-lg-6">
        <div class="p-5">
            <?php if ($poi_data['success'] && !empty($poi_data['message'])): ?>
                <h2><?php echo htmlspecialchars($poi_data['message']['poi_name']); ?></h2>
                <h5>Kategória: <?php echo htmlspecialchars($poi_data['message']['category_id']); ?></h5>
                <p><?php echo htmlspecialchars($poi_data['message']['poi_discription']); ?></p>
            <?php else: ?>
                <p>Nem található POI.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="p-5">
            <div class="justify-content-end">
                <img src="img/park.jpg" alt="POI kép" class="img-fluid">
            </div>
        </div>
    </div>
</div><div class="container mt-5">
    <div id="map" class="mapview"></div>
</div><script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script><script>
    <?php if ($poi_data['success'] && !empty($poi_data['message'])): ?>
        var coordinates = { 
            lat: <?php echo $poi_data['message']['latitude']; ?>, 
            lng: <?php echo $poi_data['message']['longitude']; ?> 
        };
    <?php else: ?>
        var coordinates = { lat: 47.60444864605358 , lng: 18.371659194861106 };
    <?php endif; ?>

    var map = L.map('map').setView([coordinates.lat, coordinates.lng], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap hozzájárulók'
    }).addTo(map);

    L.marker([coordinates.lat, coordinates.lng]).addTo(map)
        .bindPopup("<?php echo htmlspecialchars($poi_data['message']['poi_name'] ?? 'Kijelölt pont'); ?>")
        .openPopup();
</script><?php
include "./common/foot.inc.php";
?>

