<?php
include "head.inc.php";
?>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="p-4 rounded shadow bg-white form-container registrationDiv" >
        <h2 class="text-center mb-4">Regisztráció</h2>
        <form>
            <div class="form-floating mb-3 input-width">
                <input type="text" class="form-control" id="username" placeholder="Felhasználónév">
                <label for="username">Felhasználónév</label>
            </div>
            <div class="form-floating mb-3 input-width">
                <input type="email" class="form-control" id="email" placeholder="Email cím">
                <label for="email">Email cím</label>
            </div>
            <div class="form-floating mb-3 input-width">
                <input type="password" class="form-control" id="password" placeholder="Jelszó">
                <label for="password">Jelszó</label>
            </div>
            <button type="submit" class="btn w-100 gomb">Regisztráció</button>
        </form>
    </div>
</div>


<?php
include "foot.inc.php";
?>