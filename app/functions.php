<?php 
session_start();

// connect to database
$db = mysqli_connect('localhost', 'admin', '', 'rkc');

// variable declaration
$username 	  = "";
$email   	  = "";
$firstname 	  = "";
$lastname 	  = "";
$description  = "";
$errors  	  = array(); 

// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
	register();
}

// REGISTER USER
function register(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
	$username    =  e($_POST['username']);
	$email       =  e($_POST['email']);
	$password_1  =  e($_POST['password_1']);
    $password_2  =  e($_POST['password_2']);
    $firstname   =  e($_POST['firstname']);
    $lastname    =  e($_POST['lastname']);
    $description =  e($_POST['description']);

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
    if(empty($firstname)) {
        array_push($errors, "First name is required"); // 
    }
    if(empty($lastname)) {
        array_push($errors, "Last name is required"); // 
    }
    if(empty($description)) {
        array_push($errors, "Description is required"); 
    }

	// register user if there are no errors in the form
	if (count($errors) == 0) {
		$password = md5($password_1);//encrypt the password before saving in the database

		if (isset($_POST['user_type'])) {
			$user_type = e($_POST['user_type']);
			$query = "INSERT INTO users (username, email, user_type, password, firstName, lastName, description) 
					  VALUES('$username', '$email', '$user_type', '$password', '$firstname', '$lastname', '$description')";
			mysqli_query($db, $query);
			$_SESSION['success']  = "New user successfully created!!";
			header('location: index.php');
		}else{
			$query = "INSERT INTO users (username, email, user_type, password, firstName, lastName, description) 
					  VALUES('$username', '$email', '$user_type', '$password', '$firstname', '$lastname', '$description')";
			mysqli_query($db, $query);

			// get id of the created user
			$logged_in_user_id = mysqli_insert_id($db);

			$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "You are now logged in";
			header('location: index.php');				
		}
	}
}

// return user array from their id
function getUserById($id){
	global $db;
	$query = "SELECT * FROM users WHERE id=" . $id;
	$result = mysqli_query($db, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}

// escape string
function e($val){
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}

function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
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

// log user out if logout button clicked
if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");
}

// call the login() function if register_btn is clicked
if (isset($_POST['login_btn'])) {
	login();
}

// LOGIN USER
function login(){
	global $db, $username, $errors;

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
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) { // user found
			// check if user is admin or user
			$logged_in_user = mysqli_fetch_assoc($results);
			if ($logged_in_user['user_type'] == 'admin') {

				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";
				header('location: ../../admin/index.php');		  
			}else{
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";

				header('location: index.php');
			}
		}else {
			array_push($errors, "Wrong username/password combination");
		}
	}
}

function isAdmin()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
		return true;
	}else{
		return false;
	}
}

// logout
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header('location: ../app/index.php');
}

function printUsers() {
	global $db;
    $query2="SELECT * FROM users";
	$result = mysqli_query($db, $query2);

	print "<div class='userList'>";
		print "<h2>Käyttäjälista</h2>";
		print "<h3>";
		while($row = mysqli_fetch_array($result)){
			print "<p>".$row['firstName']."</p>";
		}
		print "</h3>";
	print "</div>";
}

if (isset($_POST['reset_btn'])) {
	resetPassword();
}

function resetPassword() {
	global $db, $username, $errors;

	$oldPassword = e($_POST['oldPassword']);
	$newPassword = e($_POST['newPassword']);
	$newPassword2 = e($_POST['newPassword2']);

	// make sure form is filled properly
	if (empty($oldPassword)) {
		array_push($errors, "Old password is required");
	}
	if (empty($newPassword)) {
		array_push($errors, "New password is required");
	}
	if (empty($newPassword2)) {
		array_push($errors, "New password repeated is required");
	}
	if ($newPassword != $newPassword2) {
		array_push($errors, "The two new passwords do not match");
	}
	
	if (count($errors) == 0) {
		
		$oldPassword = md5($oldPassword);

		if($_SESSION['user']['password'] == $oldPassword) {
			$newPassword = md5($newPassword);
			$username = $_SESSION['user']['username'];
			$query = "UPDATE users SET password='$newPassword' WHERE username='$username'";
			$updateQuery = mysqli_query($db, $query);
			$_SESSION['user']['password'] = $newPassword;
		} else {
			array_push($errors, "Wrong password");
		}
	}
}

?>