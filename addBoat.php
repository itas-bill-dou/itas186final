<?php
session_start();

require_once('class/User.php');

// If we're not logged in, go to the login page
if (empty($_SESSION['isLoggedIn'])) {
    header('Location: login.php');
}

$loggedInUser = User::find($_SESSION['userId']);

$showOwnerList = false;
if ($loggedInUser->isAdmin()) {
    $showOwnerList = true;
    $owners = User::findAll() . filter(function ($owner) {
        return $owner->getId > 1;
    });
}

require_once('includes/header.php');
?>
<div class="container">
    <h3>New Boat</h3>
    <form method="post" enctype="multipart/form-data">
        <?php if (!$showOwnerList) : ?>
            <input type="hidden" name="user_id" value="<?= $loggedInUser->getId() ?>">
        <?php endif; ?>
        <div class="row g-3">
            <div class="col-sm-4">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Name" required>
            </div>

            <div class="col-sm-4">
                <label for="regNumber" class="form-label">Reg Number</label>
                <input type="text" class="form-control" id="regNumber" name="reg_number" placeholder="Reg Number" value="">
            </div>

            <div class=" col-sm-4">
                <label for="length" class="form-label">Length</label>
                <input type="text" class="form-control" id="length" name="length" placeholder="length">
            </div>

            <div class="col-sm-4">
                <label for="image" class="form-label">Image</label>
                <input class="form-control" type="file" id="image" name="image">
            </div>

            <div class="col-sm-4">
                <label for="image" class="form-label">Image</label>
                <input class="form-control" type="file" id="image" name="image">
            </div>

            <?php if ($showOwnerList) : ?>
                <div class="col-sm-4">
                    <label for="image" class="form-label">Select Owner</label>
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        <?php foreach ($owners as $owner) : ?>
                            <option value="<?= $owner->getId() ?>"><?= $owner->getFullName() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>

        </div>

        <hr class="my-4">

        <button class="w-100 btn btn-primary btn-lg" type="submit">Submit</button>
    </form>
</div>

<?php

require_once('includes/footer.php');
