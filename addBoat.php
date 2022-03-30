<?php
session_start();

// If we're not logged in, go to the login page
if (empty($_SESSION['isLoggedIn'])) {
    header('Location: login.php');
}

echo "Add Boat here";

echo "If adding the boat as admin, there should be dropdown list of all owers";
echo "<br>";

echo "If the owner adds one boat, the boat will be added for the owner.";
