<?php include "./common/head.inc.php"; ?>

<!-- Search Form -->
<form class="row g-3 search">
  <div class="col-auto">
    <input type="search" class="form-control" id="inputSearch" placeholder="Keresés...">
  </div>
  <div class="col-auto">
    <button type="submit" class="btn btn-primary mb-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-search" viewBox="0 0 16 16">
        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
        </svg>
    </button>
  </div>
</form>

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
