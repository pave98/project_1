<?php 
session_start();

// Connection to database.
$db = mysqli_connect('localhost', 'admin', '', 'rkc');

// Declaring variables.
$username 	  	= "";
$user_type		= "";
$email   	  	= "";
$firstname 	  	= "";
$lastname 	  	= "";
$description    = "";
$eventType		= "";
$location		= "";
$time			= "";
$errors  		= array(); 

// Including the emailing function. can't get it to work inside the functions file itself.  
include "sendEmail.php";

// if the register button is pressed, call the register function that creates a user and adds it to the database.
if (isset($_POST['register_btn'])) {
	register();
}

// User registration
function register(){
	// Calling the global variables to make them usable in this function.
	global $db, $errors, $username, $email;

	// Take all variables from POST and escape them using the e() function descriped below.
	// Password is generated using the generatePassword() function.
	$username    =  e($_POST['username']);
	$email       =  e($_POST['email']);
	$firstname   =  e($_POST['firstname']);
	$password_1  =  e(generatePassword());
    $lastname    =  e($_POST['lastname']);
    $description =  e($_POST['description']);
	$user_type 	 =  e($_POST['user_type']);

	// Form validation.
	if (empty($username)) { 
		array_push($errors, "Username is required"); 
	}
	if (empty($email)) { 
		array_push($errors, "Email is required"); 
	}
	if (empty($password_1)) { 
		array_push($errors, "Password is required"); 
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

	// Register the user if there are no errors.
	if (count($errors) == 0) {

		$sqlQuery = "SELECT * FROM users WHERE (username='$username' OR email='$email')";
		$checkSQL = mysqli_query($db, $sqlQuery);

		if(mysqli_num_rows($checkSQL)) {
			array_push($errors, "The username already exists!");
		} else {

			// Sends the email to the user. Email contains their login data.
			sendEmail($email, $username, $password_1);

			//encrypting the password after sending it to the user and before storing it into the database.
			$password = md5($password_1);

			$query = "INSERT INTO users (username, email, user_type, password, firstName, lastName, description) 
					  VALUES('$username', '$email', '$user_type', '$password', '$firstname', '$lastname', '$description')";
			mysqli_query($db, $query);
			header('location: index.php');
		}
	}
}


if (isset($_POST['deleteUser_btn'])) {
	deleteUser();
}

function deleteUser() {
	global $db, $errors;

	$username = e($_POST['username']);
	if($_SESSION['user']['username'] == $username) {
		array_push($errors, "WHY ARE YOU DELETING YOURSELF!!?!?!?!");
	} else {
		$query = "DELETE FROM users WHERE username='$username'";
		if (mysqli_query($db, $query)) {
			array_push($errors, "DELETED"); 
		} else {
			echo "Error deleting record: " . mysqli_error($db);
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
				header('location: ../../admin/index.php');		  
			}else{
				$_SESSION['user'] = $logged_in_user;
				header('location: ../index.php');
			}
		}else {
			array_push($errors, "Wrong username/password combination");
		}
	}
}

// Checks if the current user is admin.
function isAdmin()
{
	if (isset($_SESSION['user'])&& $_SESSION['user']['user_type'] == 'admin' ) {
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


// Prints all the users froms users database to a list.
function printUsers() {
	global $db;
    $query2="SELECT * FROM users";
	$result = mysqli_query($db, $query2);

	print "<div class='userList'>";
		print "<h2>Käyttäjälista</h2>";
		print "<h3>";
		while($row = mysqli_fetch_array($result)){
			print "<p>".$row['username']."</p>";
		}
		print "</h3>";
	print "</div>";
}

// call resetPassword() function.
if (isset($_POST['reset_btn'])) {
	resetPassword();
}

// Resets the password of the current user.
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

// call passwordReset() function.
if (isset($_POST['resetPassword_btn'])) {
	passwordReset();
}

function passwordReset() {
	global $db, $errors;

	$email = e($_POST['email']);
	$newPassword = generatePassword();

	// make sure form is filled properly
	if (empty($email)) {
		array_push($errors, "An email address is required");
	}

	
	if (count($errors) == 0) {
		
		$query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) {
			$sqlQuery = "SELECT * FROM users WHERE email='$email'";
			$checkSQL = mysqli_query($db, $sqlQuery);
			$row = mysqli_fetch_assoc($checkSQL);
			$username = $row['username'];
			sendEmail($email, $username, $newPassword);
			$newPassword = md5($newPassword);
			$query = "UPDATE users SET password='$newPassword' WHERE (username='$username' AND email='$email')";
			$updateQuery = mysqli_query($db, $query);
			array_push($errors, "Uusi salasana lähetetty sähköpostiin.");
		} else {
			array_push($errors, "Antamaasi sähköpostia ei löydy");
		}
	}
}

// Calls the createEvent() function.
if (isset($_POST['createEvent_btn'])) {
	createEvent();
}

// Creates an event to the events database table.
function createEvent(){
	// Calling global variables to be used in this function.
	global $db, $errors;

	// receive all input values from the form and escape them with the e() function.
	$eventType    =  e($_POST['eventType']);
	$description  =  e($_POST['description']);
	$location	  =  e($_POST['location']);
    $time 		  =  e($_POST['time']);

	// form validation: ensure that the form is correctly filled
	if (empty($eventType)) { 
		array_push($errors, "Event type is required"); 
	}
	if (empty($description)) { 
		array_push($errors, "Description is required"); 
	}
	if (empty($location)) { 
		array_push($errors, "Location is required"); 
	}
    if(empty($time)) {
        array_push($errors, "Time is required"); // 
    }

	// If no errors then adds the event to the table. 
	if (count($errors) == 0) {
		$query = "INSERT INTO events (eventType, description, location, time) 
					VALUES('$eventType', '$description', '$location', '$time')";
		mysqli_query($db, $query);				
	}
}

// Prints all the events from the database to a list.
function printEvents() {
	global $db;
    $query2="SELECT * FROM events";
	$result = mysqli_query($db, $query2);
	
	print "<div class='eventList'>";
		print "<h1>Tapahtumat</h1>";
		while($row = mysqli_fetch_assoc($result)) {
			$num = 0;
			print "<div class=eventItem>";
			foreach($row as $ding) {
				
				print "<div class=event".$num.">";
				print "<p>".$ding."</p>";
				print "</div>";
				
				$num++;
			}
			print "</div>";
		}
	print "</div>";
}


// Generates a random password with a length of 8.
function generatePassword() {
	$characters = "aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ0123456789!?&";
	$generatedPassword = substr( str_shuffle($characters),0,8);
	return $generatedPassword;
}


?>

