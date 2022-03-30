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
    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <h1>Nanaimo Marina</h1>
                <h3>Hello, <?php echo $loggedInUser->getFirstName(); ?> [<a href="editUser.php">Edit Profile</a>] [<a href="javascript:alert('Finish the ADD boat function as Admin, edit addBoat.php')">New Boat</a>]</h3>
            </div>
            <div class="col text-end">
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>