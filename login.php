<?php

// Start the session; always invoked before anything else!
session_start();

require_once('class/Auth.php');

// Check if the user is already logged in and redirect to the authenticated page if so
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']) {
    header('Location: protected.php');
}

// Error message we will use to show invalid login
$errorMessage = '';
if (
    isset($_POST['username'])
    && isset($_POST['password'])
) {

    // Authenticate the user given credentials
    if (Auth::login($_POST['username'], $_POST['password'])) {
        // Redirect to the authenticated page now that we have authenticated
        header('Location: protected.php');
    } else {
        // Set the error message to display upon failure
        $errorMessage = 'Failed to login, please try again';
    }
}

require_once('includes/header.php');

?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-4 mt-5">
            <h1>Login</h1>
            <?php if ($errorMessage) { ?>
                <div class="alert alert-danger">
                    <?php echo $errorMessage; ?>
                </div>
            <?php } ?>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-floating">
                    <input type="text" name="username" class="form-control" id="floatingInput" placeholder="Username">
                    <label for="floatingInput">Username</label>
                </div>
                <div class="form-floating">
                    <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                </div>
                <button class="w-100 btn btn-lg btn-primary mt-4" type="submit">Sign in</button>
            </form>
            Don't have account?<a href="addUser.php">Sign up for free</a>
        </div>
    </div>
</div>

<?php

require_once('includes/footer.php');
