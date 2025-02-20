<?php
include "./common/head.inc.php";
?>

<div class="d-flex">
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
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam non scelerisque ipsum, in semper velit. Quisque ac nibh sed diam scelerisque gravida ut sed lacus. 
                    Aenean eget facilisis sapien. Etiam vel diam eu nulla laoreet bibendum. Nam sollicitudin erat quam, quis condimentum nisl ullamcorper eu. Mauris malesuada posuere 
                    ante a varius. Vivamus sit amet gravida diam. Donec accumsan ex suscipit urna consequat pulvinar. Nunc fringilla risus diam, ut finibus arcu placerat consequat. 
                    Aliquam eu risus quis massa ultricies tincidunt vel a metus. Duis facilisis est nisi, at tempus diam luctus eget. Aliquam sodales efficitur leo eu tincidunt. Nulla 
                    sapien erat, placerat quis tincidunt in, gravida eget lacus. Maecenas rutrum lobortis ullamcorper. Pellentesque quis auctor nisl. Nulla tortor sapien, tincidunt eu
                     tristique ut, egestas et tellus. Nulla ullamcorper, nibh quis consectetur vulputate, eros sapien condimentum nibh, et gravida quam felis id nulla. Orci varius 
                     natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas quis lorem in massa aliquet egestas. Aenean in turpis lacus. Sed nec elementum
                      neque, quis suscipit velit. Proin ornare tellus nec augue eleifend, eget tristique ipsum volutpat. Proin vitae arcu lacus.</p>
            </div>
    </div>
    <div class="col-lg-6">
        <div class="p-5">
        <div class="justify-content-end"> 

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

                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1389118.744306069!2d18.186205676575728!3d47.15545425032719!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4741837bdf37e4c3%3A0xc4290c1e1010!2sMagyarorsz%C3%A1g!5e0!3m2!1shu!2shu!4v1740039960707!5m2!1shu!2shu" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>

<?php
include "./common/foot.inc.php";
?>