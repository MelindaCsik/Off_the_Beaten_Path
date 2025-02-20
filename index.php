<?php
include "./common/head.inc.php";
?>

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

<div class="container">
<div class="row posts">
    <div class="card col-lg-3 post">
        <img src="img/park.jpg" class="card-img-top " alt="">
        <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content...</p>
            <a href="#" class="btn">Go somewhere</a>
        </div>
    </div>

    <div class="card col-lg-3 post">
        <img src="img/house.jpg" class="card-img-top " alt="">
        <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content...</p>
            <a href="#" class="btn">Go somewhere</a>
        </div>
    </div>

    <div class="card col-lg-3 post">
        <img src="img/statue.jpg" class="card-img-top " alt="">
        <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content...</p>
            <a href="#" class="btn">Go somewhere</a>
        </div>
    </div>

    <div class="card col-lg-3 post">
        <img src="img/park.jpg" class="card-img-top " alt="">
        <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content...</p>
            <a href="#" class="btn">Go somewhere</a>
        </div>
    </div>

    <div class="card col-lg-3 post">
        <img src="img/park.jpg" class="card-img-top " alt="">
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