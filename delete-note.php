<!DOCTYPE html>
<html lang="en">
<?php include('php/process.php');
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
} 

$result = $mysqli->query("SELECT * FROM note_data WHERE note_id='" . $_GET['id'] . "'") or die($mysqli->error);
    $row = $result->fetch_assoc();

?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete note</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        <?php include "style.css" ?>
    </style>

</head>
<nav class="navbar">
    <div class="navbar__toggle" id="mobile-menu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>
    <ul class="navbar__menu">
        <li class="navbar__item">
            <a href="/note-app/home.php" class="navbar__links">Home</a>
        </li>

        <div class="user">
            <?php if (isset($_SESSION['user'])) : ?>
                <strong>
                    <?php echo $_SESSION['user']['username'];
                    ?>
                    <a href="home.php?logout='1'" style="color: red;">logout</a>
                </strong>
            <?php endif ?>

        </div>
    </ul>
</nav>

<body>
    <main>
        <div class="backgnd">
            <div class="container text-center">
                <h1 class="py-4 bg-dark text-light rounded"></i>Delete the note?</h1>
                <p>Are you sure you want to delete this note?</p>
                <a href="php/process.php?delete=<?php echo $row['note_id'] ?>" class="btn btn-primary">Yes, delete</a>
                <a href="home.php" class="back-btn btn-danger">Back</a>
                <div class="d-flex justify-content-center">
                  
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>