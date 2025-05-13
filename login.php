<?php
include "./common/head.inc.php";
?>

<div class="container d-flex justify-content-center align-items-center vh-100 regLogDiv">
    <div class="p-4 rounded shadow bg-white form-container">
        <h2 class="text-center mb-4">Bejelentkezés</h2>
        <form id="loginForm">
            <div class="form-floating mb-3 input-width">
                <input type="text" class="form-control" id="username" placeholder="Felhasználónév">
                <label for="username">Felhasználónév</label>
            </div>
            <div class="form-floating mb-3 input-width">
                <input type="password" class="form-control" id="password" placeholder="Jelszó">
                <label for="password">Jelszó</label>
            </div>
            <button type="submit" class="btn w-100">Bejelentkezés</button>
            <div class="form-floating mb-3 input-width">
                <p>Még nincs fiókod?<a href="/2024/off-the-beaten-path/registration.php">Regisztrálj!<a></p>
            </div>
        </form>
    </div>
</div>

<?php
include "./common/foot.inc.php";
?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("loginForm").addEventListener("submit", function(event) {
        event.preventDefault();

        let username = document.getElementById("username").value;
        let password = document.getElementById("password").value;

        // POST request to the backend API
        fetch("./api/login.api.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ username, password }) // sending username and password
        })
        .then(response => response.json())  
        .then(data => {
            alert(data.message);
            if (data.success) {  // If login is successful
                localStorage.setItem('user_token', data.user.token); // Store token
                window.location.href = "./profile.php";  // Redirect to profile page
                console.log("Sikeres Bejelentkezés!");
            } else {
                console.log("Hiba történt: " + data.message);  // Handle error
            }
        })
        .catch(error => {
            console.error("Hiba történt:", error);  // Log network errors
        });
    });
});
</script>