<?php
include "head.php";
?>

<div class="container mt-5">
        <h2 class="mb-4">Bejeletkezés</h2>
        <form>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="username" placeholder="Felhasználónév">
            <label for="username">Felhasználónév</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="password" placeholder="Jelszó">
            <label for="password">Jelszó</label>
        </div>
            <button type="submit" class="btn">Bejeletkezés</button>
        </form>
</div>

<?php
include "foot.php";
?>