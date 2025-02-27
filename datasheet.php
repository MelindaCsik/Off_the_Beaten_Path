<?php
include "./common/head.inc.php";
?>

<div class="d-flex mrg">
    <div class="col-lg-6">
        <div class="p-5">
            <h2>Cím</h2>
            <h5>Kategória</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam non scelerisque ipsum, in semper velit. Quisque ac nibh sed diam scelerisque gravida ut sed lacus. 
                    Aenean eget facilisis sapien. Etiam vel diam eu nulla laoreet bibendum. Nam sollicitudin erat quam, quis condimentum nisl ullamcorper eu. Mauris malesuada posuere 
                    ante a varius. Vivamus sit amet gravida diam. Donec accumsan ex suscipit urna consequat pulvinar. Nunc fringilla risus diam, ut finibus arcu placerat consequat. 
                    Aliquam eu risus quis massa ultricies tincidunt vel a metus. Duis facilisis est nisi, at tempus diam luctus eget. Aliquam sodales efficitur leo eu tincidunt. Nulla 
                    sapien erat, placerat quis tincidunt in, gravida eget lacus. Maecenas rutrum lobortis ullamcorper. Pellentesque quis auctor nisl. Nulla tortor sapien, tincidunt eu
                     tristique ut, egestas et tellus. Nulla ullamcorper, nibh quis consectetur vulputate, eros sapien condimentum nibh, et gravida quam felis id nulla. Orci varius 
                     natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas quis lorem in massa aliquet egestas. Aenean in turpis lacus. Sed nec elementum
                      neque, quis suscipit velit. Proin ornare tellus nec augue eleifend, eget tristique ipsum volutpat. Proin vitae arcu lacus.</p>
                      <p>

                <div class="container mt-5">
                    <div id="imageCarousel" class="carousel slide gallery" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="d-flex justify-content-center">
                                    <img src="./img/house.jpg" class="img-fluid" alt="Kép 1">
                                    <img src="./img/park.jpg" class="img-fluid" alt="Kép 2">
                                    <img src="./img/statue.jpg" class="img-fluid" alt="Kép 3">
                                </div>
                            </div>
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Előző</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Következő</span>
                        </button>
                    </div>
                </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="p-5">
        <div class="justify-content-end"> 

                <div id="map" class="mapview"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var coordinates = { lat: 47.60444864605358 , lng: 18.371659194861106 };

        var map = L.map('map').setView([coordinates.lat, coordinates.lng], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap hozzájárulók'
        }).addTo(map);

        // Marker létrehozása a koordinátáknál
        L.marker([coordinates.lat, coordinates.lng]).addTo(map)
            .bindPopup("Kijelölt pont")
            .openPopup();
    </script>
</script>

<?php
include "./common/foot.inc.php";
?>