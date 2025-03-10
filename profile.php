<?php
include "./common/head.inc.php";
?>


<div class="container">
    <h1>Profil adatok</h1>
    <div class="userData">
        <p>Felhasználónév</p>
        <p class="dataField">XY</p>

        <p>Email cím</p>
        <p class="dataField">xy@email.com</p>

        <button type="submit" class="btn w-100 gomb">Módosítás</button>
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