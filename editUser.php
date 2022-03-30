<?php

session_start();

require_once('class/Exception.php');
require_once('class/User.php');
require_once('class/Boat.php');

// If we're not logged in, go to the login page
if (empty($_SESSION['isLoggedIn'])) {
    header('Location: login.php');
}

$id = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
}

$errorMessage = '';
$message = '';

// We know we're authenticated so get the user by the id stored in the session.
$user = User::find($_SESSION['userId']);
if ($user->isAdmin() && $id) {
    $user = User::find($id);
    // Find this user's all boats
    $boats = Boat::findBoatsByUserId($id);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user->setUsername(filter_var($_POST['username'], FILTER_SANITIZE_STRING));
    $user->setFirstName(filter_var($_POST['first_name'], FILTER_SANITIZE_STRING));
    $user->setLastName(filter_var($_POST['last_name'], FILTER_SANITIZE_STRING));
    $user->setGender(filter_var($_POST['gender'], FILTER_SANITIZE_STRING));
    $user->setPhone(filter_var($_POST['phone'], FILTER_SANITIZE_STRING));

    if ($user->update() === null) {
        $message = "Updated";
    } else {
        $errorMessage = "Something wrong happened, failed to update";
    }
}

require_once('includes/header.php');
?>

<div class="container p-4">
    <div class="row mt-5">
        <a href="protected.php">Go back home</a>
    </div>
    <h2>Update Profile</h2>

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
                    <label for="firstName" class="form-label">First name</label>
                    <input type="text" class="form-control" id="firstName" name="first_name" value="<?= $user->getFirstName() ?>" placeholder="" value="" required="">
                </div>

                <div class="col-sm-6">
                    <label for="lastName" class="form-label">Last name</label>
                    <input type="text" class="form-control" id="lastName" name="last_name" value="<?= $user->getLastName() ?>" placeholder="" value="" required="">
                </div>

                <div class="col-sm-4">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text">@</span>
                        <input type="text" class="form-control" id="username" name="username" value="<?= $user->getUsername() ?>" placeholder="Username" required="">
                    </div>
                </div>

                <div class="col-sm-4">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?= $user->getPhone() ?>">
                </div>
                <div class="col-sm-4">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select" id="gender" name="gender">
                        <option value="M" <?= $user->getGender() === 'M' ? 'selected' : '' ?>>Male</option>
                        <option value="F" <?= $user->getGender() === 'F' ? 'selected' : '' ?>>Female</option>
                        <option value="NA" <?= $user->getGender() === 'NA' ? 'selected' : '' ?>>Unknown</option>
                    </select>
                </div>

                <input class="w-100 btn btn-primary btn-lg" type="submit" value="Submit">
            </div>
        </form>
    </div>

    <hr class="my-4">
    <?php if ($user->isAdmin()) { ?>
        <h1>Bob is the boss, not boat owner!</h1>
    <?php } else { ?>
        <h3><?= $user->getFullName() ?>'s Boats</h3>
        <a href="javascript:alert('Finish the ADD function for boat as an owner, edit addBoat.php')">New Boat</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Reg Number</th>
                    <th scope="col">Length</th>
                    <th scope="col" colspan="2" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($boats as $boat) : ?>
                    <tr>
                        <th scope="row">1</th>
                        <td><?= $boat->getName() ?></td>
                        <td><?= $boat->getRegNumber() ?></td>
                        <td>@<?= $boat->getLength() ?></td>
                        <td class="text-center"><a href="javascript:alert('Finish the edit function for boat')" class="btn btn-info">Edit</a>
                            &nbsp;
                            <a href="javascript:alert('Finish the delete function for boat')" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    <?php } ?>
</div>

<?php

require_once('includes/footer.php');
