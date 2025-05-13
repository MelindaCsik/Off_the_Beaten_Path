<?php
include "./common/head.inc.php";
?>


<div class="container">
    <h1>Profil adatok</h1>

    <div class="userData">
    <div class="row g-3 align-items-center">
        <div class="col-auto">
            <label for="usernameOutput" class="col-form-label">Felhasználónév:</label>
        </div>
        <div class="col-auto">
            <input type="text" id="usernameOutput" class="form-control" value="XY" disabled readonly>
        </div>
        <div class="col-auto">
            <label for="emailOutput" class="col-form-label">Email cím:</label>
        </div>
        <div class="col-auto">
            <input type="text" id="emailOutput" class="form-control" value="xy@emil.com" disabled readonly>
        </div>
    </div>

    <div class="row g-3 align-items-center">
        <div class="col-auto">
            <label for="passwordOutput" class="col-form-label">Jelszó:</label>
        </div>
        <div class="col-auto">
            <input type="password" id="passwordOutput" class="form-control" value="jelszó" disabled readonly>
        </div>
    </div>
    </div>

    <h2>Saját bejegyzések</h2>
    <div class="line"></div>
    <div class="container">
        <div class="row posts" id="poi-container">
            <p>Betöltés...</p>
        </div>
    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    fetch(`./api/user.api.php?id=<?php echo $_SESSION['user_id']; ?>`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('usernameOutput').value = data.user.user_name;
                document.getElementById('emailOutput').value = data.user.user_email;
            } else {
                console.error("Error fetching user data:", data.error);
            }
        })
        .catch(error => console.error("Error:", error));
});

document.addEventListener("DOMContentLoaded", () => {
    fetchPOIs();

    function fetchPOIs() {
        fetch("./api/places.api.php?id=<?php echo $_SESSION['user_id']; ?>`")
        .then(response => response.json())
        .then(data => {
            console.log("Fetched Data:", data);
            displayPOIs(data);
        })
        .catch(error => console.error("Error fetching POIs:", error));
    }

    function displayPOIs(pois) {
        const container = document.getElementById("poi-container");
        container.innerHTML = "";

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
<?php
include "./common/foot.inc.php";
?>