<?php

session_start();

require_once('class/User.php');

// If we're not logged in, go to the login page
if (isset($_SESSION['isLoggedIn'])) {
    die("Logged in User can't create account. <a href=\"protected.php\">Back</a>");
}

$errorMessage = '';
$message = '';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = new User();
    $user->setUsername(filter_var($_POST['username'], FILTER_SANITIZE_STRING));
    $user->setPassword(filter_var($_POST['password'], FILTER_SANITIZE_STRING));
    $user->setFirstName(filter_var($_POST['first_name'], FILTER_SANITIZE_STRING));
    $user->setLastName(filter_var($_POST['last_name'], FILTER_SANITIZE_STRING));
    $user->setGender(filter_var($_POST['gender'], FILTER_SANITIZE_STRING));
    $user->setPhone(filter_var($_POST['phone'], FILTER_SANITIZE_STRING));

    $id = $user->create();

    if ($id) {
        $_SESSION['userId'] = $id;
        $_SESSION['isLoggedIn'] = true;
        header('Location: protected.php');
    } else {
        $errorMessage = "Something wrong happened, failed to update";
    }
}

require_once('includes/header.php');
?>

<div class="container p-4">
    <h2>Sign Up</h2>
    <div class="row mt-5">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <?php if ($errorMessage) { ?>
                <div class="alert alert-danger">
                    <?php echo $errorMessage; ?>
                </div>
            <?php } ?>
            <?php if ($message) { ?>
                <div class="alert alert-success">
                    <?php echo $message; ?>
                </div>
            <?php } ?>
            <div class="row g-3">
                <div class="col-sm-6">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text">@</span>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required="">
                    </div>
                </div>
                <div class="col-sm-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="password" required="">
                </div>
                <div class="col-sm-6">
                    <label for="firstName" class="form-label">First name</label>
                    <input type="text" class="form-control" id="firstName" name="first_name" placeholder="" value="" required="">
                </div>

                <div class="col-sm-6">
                    <label for="lastName" class="form-label">Last name</label>
                    <input type="text" class="form-control" id="lastName" name="last_name" placeholder="" value="" required="">
                </div>

                <div class="col-sm-6">
                    <label for="phone" class="form-label">Gender</label>
                    <select class="form-select" id="gender" name="gender">
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                        <option value="NA" selected>Unknown</option>
                    </select>
                </div>

                <div class="col-sm-6">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone">
                </div>


                <input class="w-100 btn btn-primary btn-lg" type="submit" value="Create">
            </div>
        </form>
    </div>
    <div class="row mt-5">
        <a href="protected.php">Go back home</a>
    </div>
</div>

<?php

require_once('includes/footer.php');
