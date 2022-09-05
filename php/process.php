<?php

session_start();

$mysqli = new mysqli('localhost', 'root', 'mypass123', 'note-app') or die(mysqli_error($mysqli));

// variable declaration
$username = "";
$email    = "";
$errors   = array();
$title = '';
$text = '';
$note_id = 0;
$user_id = 0;
$update = false;

// calling the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
    register();
}

// register user
function register()
{
    // call these variables with the global keyword to make them available in function
    global $mysqli, $errors, $username, $email;

    // receive all input values from the form. Call the e() function
    // defined below to escape form values
    $username    =  e($_POST['username']);
    $email       =  e($_POST['email']);
    $password_1  =  e($_POST['password_1']);
    $password_2  =  e($_POST['password_2']);

    // form validation: ensure that the form is correctly filled
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1); //encrypt the password before saving in the database

        if (isset($_POST['user_type'])) {
            $user_type = e($_POST['user_type']);
            $query = "INSERT INTO users (username, email, user_type, password) 
					  VALUES('$username', '$email', '$user_type', '$password')";
            mysqli_query($mysqli, $query);
            $_SESSION['success']  = "New user successfully created!!";
            header('location: home.php');
        } else {
            $query = "INSERT INTO users (username, email, user_type, password) 
					  VALUES('$username', '$email', 'user', '$password')";
            mysqli_query($mysqli, $query);

            // get id of the created user
            $logged_in_user_id = mysqli_insert_id($mysqli);

            $_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
            $_SESSION['success']  = "You are now logged in";
            header('location: home.php');
        }
    }
}

// return user array from their id
function getUserById($id)
{
    global $mysqli;
    $query = "SELECT * FROM users WHERE id=" . $id;
    $result = mysqli_query($mysqli, $query);

    $user = mysqli_fetch_assoc($result);
    return $user;
}

// escape string
function e($val)
{
    global $mysqli;
    return mysqli_real_escape_string($mysqli, trim($val));
}

function display_error()
{
    global $errors;

    if (count($errors) > 0) {
        echo '<div class="error">';
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
        echo '</div>';
    }
}

function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	}else{
		return false;
	}
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: /note-app/login.php");
}

// call the login() function if register_btn is clicked
if (isset($_POST['login_btn'])) {
	login();
}

// LOGIN USER
function login(){
	global $mysqli, $username, $errors;

	// grap form values
	$username = e($_POST['username']);
	$password = e($_POST['password']);

	// make sure form is filled properly
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	// attempt login if no errors on form
	if (count($errors) == 0) {
		$password = md5($password);

		$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
		$results = mysqli_query($mysqli, $query);

		if (mysqli_num_rows($results) == 1) { // user found
			// check if user is admin or user
			$logged_in_user = mysqli_fetch_assoc($results);
			
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";

				header('location: home.php');
			}
		}else {
			array_push($errors, "Wrong username/password combination");
		}
	}

    //create a note
    if (isset($_POST['create'])) {
        
        $text = $_POST['text'];
        $user = $_SESSION['user']['id'];
    
        $mysqli->query("INSERT INTO note_data (text, user_id) VALUES ('$text', '$user')") or die($mysqli->error);
    
        $_SESSION['message'] = "Your note has been created";
        $_SESSION['msg_type'] = "success";
    
        header("location: /note-app/home.php");
    }

    //delete note
    if (isset($_GET['delete'])) {
        $note_id = $_GET['delete'];

        $mysqli -> query("DELETE FROM note_data WHERE note_id = $note_id") or die($mysqli->error);

        $_SESSION['message'] = "Your note has been deleted";
        $_SESSION['msg_type'] = "danger";
    
    
        header("location: /note-app/home.php");
    }

    //edit note
    if (isset($_GET['edit'])) {
        $note_id = $_GET['edit'];
        $update = true;

        $result = $mysqli->query("SELECT * FROM note_data WHERE note_id = $note_id") or die($mysqli->error);
    
        $row = $result->fetch_array();
        $text = $row['text'];
    }

    //update the note
    if (isset($_POST['update'])) {
        $note_id = $_POST['note_id'];
        $text = $_POST['text'];
    
        $mysqli->query("UPDATE note_data SET text='$text' WHERE note_id=$note_id") or die($mysqli->error);
    
        $_SESSION['message'] = "Your note has been updated";
        $_SESSION['msg_type'] = "warning";
    
        header("location: /note-app/home.php");
    }
