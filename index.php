<?php include "./common/head.inc.php"; ?>


<!-- POI Container -->
<div class="container">
    <div class="row posts" id="poi-container">
        <p>Betöltés...</p>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    fetchPOIs(); // Fetch data on page load

    function fetchPOIs() {
        fetch("./api/places.api.php")
        .then(response => response.json()) // Convert response to JSON
        .then(data => {
            console.log("Fetched Data:", data);
            displayPOIs(data);
        })
        .catch(error => console.error("Error fetching POIs:", error));
    }

    function displayPOIs(pois) {
        const container = document.getElementById("poi-container");
        container.innerHTML = ""; // Clear previous content

        if (pois.success && pois.message.length > 0) {
            pois.message.forEach(poi => {
                let card = `
                    <div class="card col-lg-2 post">
                        <img src="img/park.jpg" class="card-img-top" alt="">
                        <div class="card-body">
                            <h5 class="card-title">${poi.poi_name}</h5>
                            <p class="card-text">${poi.poi_discription}</p>
                            <a href="datasheet.php?id=${poi.poi_id}" class="btn">Megnézem</a>
                        </div>
                    </div>
                `;
                container.innerHTML += card;
            });
        } else {
            container.innerHTML = "<p>Nincs elérhető POI.</p>";
        }
    }
});
</script>

<?php include "./common/foot.inc.php"; ?>
