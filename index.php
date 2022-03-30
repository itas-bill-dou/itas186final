<?php
session_start();

// If we're not logged in, go to the login page
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']) {
    header('Location: protected.php');
}

require_once('includes/header.php');
?>
<div class="container">
    <div class="row mt-5 text-center">
        <div class="col">
            <h1>Welcome to the page! Please login. WOW</h1>
            <a href="login.php">Login</a>
            <a href="addUser.php">Register</a>
        </div>
    </div>
</div>

<?php

require_once('includes/footer.php');
