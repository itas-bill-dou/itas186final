<!doctype html>
<html lang="en" class="h-100">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Marina</title>
</head>

<body class="h-100">
    <?php if (!empty($_SESSION['isLoggedIn'])) { ?>
        <div class="container">
            <div class="row mt-5 align-items-center">
                <div class="col">
                    <h1>Nanaimo Marina</h1>
                </div>
                <div class="col">
                    <?= $_SESSION['userId'] > 1 ? 'Boat Owner' : 'Super Admin'; ?>
                </div>
                <div class="col text-end">
                    [<a href="editUser.php"><?= $_SESSION['username']; ?></a>]
                    [<a href="addBoat.php">New Boat</a>]
                    [<a href="logout.php">Logout</a>]
                </div>
            </div>
        </div>
    <?php } ?>