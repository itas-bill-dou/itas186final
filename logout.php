<?php

// Initialize the session
session_start();

require_once('class/Auth.php');

// Call the logout method from the Auth class. Remember, it's static!
Auth::logout();

// Call `header()` method and redirect back to the index page
header('Location: index.php');

// Kill the process if it tries to go past here for any reason
exit;
