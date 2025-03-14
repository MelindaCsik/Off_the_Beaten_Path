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
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="button" class="btn">Módosítás</button>
        </div>
    </div>
    </div>

    <h2>Saját bejegyzések</h2>
    <div class="line"></div>
    <div class="row posts">
        <div class="card col-lg-3 post">
            <img src="img/park.jpg" class="card-img-top" alt="">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content...</p>
                <a href="#" class="btn">Go somewhere</a>
            </div>
        </div>
    </div>
</div>

<?php
include "./common/foot.inc.php";
?>