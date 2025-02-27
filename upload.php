<?php
include "./common/head.inc.php";
?>

<div class="d-flex">
    <div class="col-lg-6">
        <div class="p-5">
            <h2>Bejegyzés feltöltése</h2>
            <form>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="uploadTitle" placeholder="Felhasználónév">
                    <label for="uploadTitle">Hely/Épület/Szobor neve</label>
                </div>
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Leírás" id="description"></textarea>
                    <label for="description">Leírás</label>
                </div>
            </form>
            <form id="uploadForm" enctype="multipart/form-data">
                <div class="mb-3 mt-3">
                    <label for="imgUpload" class="form-label">Válasszd ki a feltölteni kivánt képeket:</label>
                    <input type="file" class="form-control" id="imgUpload" multiple>
                </div>
            <button type="submit" class="btn" onclick="">Feltöltés</button>
    </form>

    <div class="mt-3">
        <h5>Kiválasztott képek:</h5>
        <ul id="fileList" class="list-group"></ul>
    </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="p-5">
            <div class="justify-content-end"> 
                <button  class="btn uploadbtn" onclick="getCoordinates()">Bejegyzés feltöltése</button>
                
                <div id="map" class="uploadmap"></div>
                
            </div> 
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    //Térkép
    var map = L.map('map').setView([47.4979, 19.0402], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap hozzájárulók'
    }).addTo(map);

    var marker;

    map.on('click', function(e) {
        if (marker) {
            map.removeLayer(marker);
        }
        marker = L.marker(e.latlng).addTo(map);
    });

    function getCoordinates() {
        if (marker) {
            var coordinates = marker.getLatLng();
            console.log("Kijelölt pont koordinátái:", coordinates.lat, coordinates.lng);
        }
    }
</script>

<?php
include "./common/foot.inc.php";
?>