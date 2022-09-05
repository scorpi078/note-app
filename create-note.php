<!DOCTYPE html>
<html lang="en">
<?php include('php/process.php');
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
} ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a new note</title>
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
                <h1 class="py-4 bg-dark text-light rounded"><i class="large material-icons">apps</i>Create a new note</h1>

                <div class="d-flex justify-content-center">
                    <form action="php/process.php" method="POST" class="w-50">
                        <input type="hidden" name="note_id" value="<?php echo $note_id; ?>">
                        <div class="py-2">                            
                            <textarea id="input" name="text" rows="4" cols="50" value=""><?php echo $text ?></textarea>
                        </div>
                        <div class="d-flex">
                            <?php
                            if ($update == true) :
                            ?>
                                <button type="submit" class="btn btn-primary" name="update">Update</button>
                            <?php else : ?>
                                <button type="submit" class="btn btn-primary" name="create">Create</button>
                            <?php endif; ?>
                            <a href="home.php" class="back-btn btn-danger">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>