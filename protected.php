<?php

session_start();

require_once('class/User.php');

// If we're not logged in, go to the login page
if (empty($_SESSION['isLoggedIn'])) {
    header('Location: login.php');
}

// We know we're authenticated so get the user by the id stored in the session.
$user = User::find($_SESSION['userId']);

// Only admin/boss can view the owner list
if ($user->isAdmin()) {
    $owners = User::findAll();
}

require_once('includes/header.php');
?>

<div class="container">
    <div class="row mt-5">
        <div class="col">
            <h1>Nanaimo Marina</h1>
            <h3>Hello, <?php echo $user->getFirstName(); ?> [<a href="editUser.php">Edit Profile</a>] [<a href="javascript:alert('Finish the ADD boat function as Admin, edit addBoat.php')">New Boat</a>]</h3>
        </div>
        <div class="col text-end">
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <hr class="my-4">
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
                    <td>Display how many boats this ower has</td>
                    <td class="text-center"><a href="edituser.php?id=<?= $owner->getId() ?>" class="btn btn-info">Edit</a>&nbsp;<a href="javascript:alert('Finish the DELETE function for user')" class="btn btn-danger">Delete</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</div>

<?php

require_once('includes/footer.php');
