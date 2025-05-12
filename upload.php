<?php
include "./common/head.inc.php";
?>

<div class="d-flex">
    <div class="col-lg-6">
        <div class="p-5">
            <h2>Bejegyzés feltöltése</h2>
            <form id="poiForm">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="poi_name" placeholder="Felhasználónév" required>
                    <label for="poi_name">Hely/Épület/Szobor neve</label>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-control" id="landmark_id" required>
                        <option selected>Válassz egy körzetett</option>
                    </select>
                    <label for="landmark_id">Körzet</label>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-control" id="category_id" required>
                        <option selected>Válassz kategóriát</option>
                    </select>
                    <label for="category_id">Kategória</label>
                </div>
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Leírás" id="poi_description" required></textarea>
                    <label for="poi_description">Leírás</label>
                </div>
                <input type="hidden" id="latitude">
                <input type="hidden" id="longitude">
                <input type="hidden" id="user_id" value="<?php echo $_SESSION['user_id'] ?? ''; ?>">
            </form>
            <form id="uploadForm" enctype="multipart/form-data">
                <div class="mb-3 mt-3">
                    <label for="imgUpload" class="form-label">Válasszd ki a feltölteni kivánt képet:</label>
                    <input type="file" class="form-control" id="imgUpload" multiple>
                </div>
                <button type="button" class="btn" id="submitBtn">Feltöltés</button>
            </form>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="p-5">
            <div class="justify-content-end"> 
                <button class="btn uploadbtn" onclick="getCoordinates()">Koordináták mentése</button>
                <div id="map" class="uploadmap"></div>
                <div id="statusMessage" class="mt-3"></div>
            </div> 
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([47.4979, 19.0402], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap hozzájárulók'
    }).addTo(map);

    var marker;
    var selectedCoordinates = null;

    map.on('click', function(e) {
        if (marker) {
            map.removeLayer(marker);
        }
        marker = L.marker(e.latlng).addTo(map);
        selectedCoordinates = e.latlng;
        document.getElementById('latitude').value = e.latlng.lat;
        document.getElementById('longitude').value = e.latlng.lng;
    });

    function getCoordinates() {
        if (marker) {
            var coordinates = marker.getLatLng();
            console.log("Kijelölt pont koordinátái:", coordinates.lat, coordinates.lng);
            alert('Koordináták mentve! Most már feltöltheted a bejegyzést.');
        } else {
            alert('Kérjük, jelölj ki egy pontot a térképen!');
        }
    }

    function loadFormData() {
        fetch('./api/categories.api.php')
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('category_id');
                data.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.category_id;
                    option.textContent = category.category_name;
                    select.appendChild(option);
                });
            });
        
        fetch('api/landmarks.api.php')
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('landmark_id');
                data.forEach(landmark => {
                    const option = document.createElement('option');
                    option.value = landmark.landmark_id;
                    option.textContent = landmark.landmark_name;
                    select.appendChild(option);
                });
            });
    }

    document.getElementById('submitBtn').addEventListener('click', function(e) {
        e.preventDefault();
        
        if (!selectedCoordinates) {
            alert('Kérjük, jelölj ki egy pontot a térképen!');
            return;
        }

        const formData = {
            poi_name: document.getElementById('poi_name').value,
            poi_discription: document.getElementById('poi_description').value,
            latitude: selectedCoordinates.lat,
            longitude: selectedCoordinates.lng,
            landmark_id: document.getElementById('landmark_id').value,
            category_id: document.getElementById('category_id').value,
            user_id: document.getElementById('user_id').value
        };

        fetch('api/places.api.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('statusMessage').innerHTML = 
                    '<div class="alert alert-success">Bejegyzés sikeresen feltöltve!</div>';
                
                const imageFiles = document.getElementById('imgUpload').files;
                if (imageFiles.length > 0) {
                    uploadImages(imageFiles, data.poi_id);
                }
            } else {
                document.getElementById('statusMessage').innerHTML = 
                    '<div class="alert alert-danger">Hiba történt: ' + data.message + '</div>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('statusMessage').innerHTML = 
                '<div class="alert alert-danger">Hiba történt a feltöltés során.</div>';
        });
    });

    function uploadImages(files, poiId) {
        const formData = new FormData();
        for (let i = 0; i < files.length; i++) {
            formData.append('images[]', files[i]);
        }
        formData.append('poi_id', poiId);

        fetch('api/upload.api.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Images uploaded successfully');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', loadFormData);

    document.getElementById('imgUpload').addEventListener('change', function(e) {
        const fileList = document.getElementById('fileList');
        fileList.innerHTML = '';
        
        Array.from(e.target.files).forEach(file => {
            const li = document.createElement('li');
            li.className = 'list-group-item';
            li.textContent = file.name;
            fileList.appendChild(li);
        });
    });
</script>

<?php
include "./common/foot.inc.php";
?>