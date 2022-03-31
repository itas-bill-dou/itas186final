<?php

session_start();

require_once('class/User.php');
require_once('class/Boat.php');

// If we're not logged in, go to the login page
if (empty($_SESSION['isLoggedIn'])) {
    header('Location: login.php');
}

// We know we're authenticated so get the user by the id stored in the session.
$loggedInUser = User::find($_SESSION['userId']);

// Only admin/boss can view the owner list
if ($loggedInUser->isAdmin()) {
    $owners = User::findAll();
}

require_once('includes/header.php');
?>

<div class="container">
    <hr class="my-4">
    <?php if ($loggedInUser->isAdmin()) { ?>
        <h2>Boat Owners List</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Role</th>
                    <th scope="col"># of Boats</th>
                    <th scope="col" colspan="2" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($owners as $owner) : ?>
                    <tr>
                        <td><?= $owner->getId() ?></td>
                        <td><?= $owner->getUsername() ?></td>
                        <td><?= $owner->getFullName() ?></td>
                        <td><?= $owner->isAdmin() ? 'Super Admin' : 'Boat Owner' ?></td>
                        <td><?= Boat::countBoatsByUserId($owner->getId()) ?></td>
                        <td class="text-center"><a href="edituser.php?id=<?= $owner->getId() ?>" class="btn btn-info">Edit</a>&nbsp;<a href="javascript:alert('Finish the DELETE function for user')" class="btn btn-danger">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    <?php } ?>
</div>

<?php

require_once('includes/footer.php');
