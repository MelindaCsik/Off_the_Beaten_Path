<?php
include "./common/head.inc.php";
?>

<div class="container d-flex justify-content-center align-items-center vh-100 regLogDiv">
    <div class="p-4 rounded shadow bg-white form-container" >
        <h2 class="text-center mb-4">Regisztráció</h2>
        <form id="registrationForm">
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
            <button type="button" class="btn w-100 gomb">Regisztráció</button>
        </form>
    </div>
</div>


<?php
include "./common/foot.inc.php";
?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("registrationForm").addEventListener("submit", function(event) {
        event.preventDefault();

        let username = document.getElementById("username").value;
        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;

        fetch("./api/registration.api.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ username, email, password })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                window.location.href = "./login.php";
            }
        })
        .catch(error => console.error("Hiba:", error));
    });
});
</script>