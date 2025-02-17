<?php
include "head.php";
?>

<div class="container mt-5">
        <h2 class="mb-4">Regisztráció</h2>
        <form>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="username" placeholder="Felhasználónév">
            <label for="username">Felhasználónév</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email" placeholder="Email cím">
            <label for="email">Email cím</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="password" placeholder="Jelszó">
            <label for="password">Jelszó</label>
        </div>
            <button type="submit" class="btn">Regisztráció</button>
        </form>
</div>

<?php
include "foot.php";
?>