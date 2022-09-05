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
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        <?php include "style.css" ?>
    </style>
</head>

<body>
    <?php
    if (isset($_SESSION['message'])) : ?>

        <div class="alert alert-<?= $_SESSION['msg_type'] ?>">
            <?php
            echo $_SESSION["message"];
            unset($_SESSION["message"]);
            ?>
        </div>
    <?php endif ?>

    <?php
    $mysqli = new mysqli('localhost', 'root', 'mypass123', 'note-app') or die(mysqli_error($mysqli));
    $result = $mysqli->query("SELECT * FROM note_data") or die($mysqli->error);
    ?>

    <nav class="navbar">
        <div class="navbar__toggle" id="mobile-menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <ul class="navbar__menu">
            <li class="navbar__item">
                <a href="/note-app/create-note.php" class="navbar__links">Create a note</a>
            </li>

            <div class="user">
                <?php if (isset($_SESSION['user'])) : ?>
                    <strong>
                        <?php echo $_SESSION['user']['username'];
                        ?>
                        <a href="home.php?logout='1'" style="color: red;">logout</a>
                    </strong>
                <?php endif ?>
                <?php
                $userId = $_SESSION['user']['id'];
                $result = $mysqli->query("SELECT * FROM note_data WHERE user_id = '$userId'") or die($mysqli->error);

                ?>
            </div>
        </ul>
    </nav>
    <main>
        <div class="backgnd">
            <div class="container text-center">
                <h1 class="py-4 bg-dark text-light rounded">My Notes</h1>
                <div class=" row justify-content-center">
                    <table class="table">
                        <?php while ($row = $result->fetch_assoc()) :
                        ?>
                            <tr>
                                <td><?php echo $row['text'] ?></td>
                                <td>
                                    <a href="create-note.php?edit=<?php echo $row['note_id'];
                                                                    ?>" class="btn btn-info "><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                        </svg></a>
                                    <a href="delete-note.php?id=<?php echo $row['note_id'];
                                                                    ?>" class="btn-delete btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                        </svg></a>
                                </td>
                            </tr>
                        <?php endwhile;
                        ?>
                    </table>

                </div>
            </div>
            <?php

            function pre_r($array)
            {
                echo '<pre>';
                print_r($array);
                echo '</pre>';
            }
            ?>
        </div>
    </main>

    <script>
        <?php include "script/script.js" ?>
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>