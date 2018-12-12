<?php 
session_start();

// Connection to database.
$db = mysqli_connect('localhost', 'admin', '', 'rkc');

// Declaring variables.

$root 			= $_SERVER['DOCUMENT_ROOT'];
$username 	  	= "";
$email   	  	= "";
$firstname 	  	= "";
$lastname 	  	= "";
$description    = "";
$eventType		= "";
$location		= "";
$time			= "";
$errors  		= array(); 
$messages		= array();

// Including the emailing function. can't get it to work inside the functions file itself.  
include "sendEmail.php";

// if the register button is pressed, call the register function that creates a user and adds it to the database.
if (isset($_POST['register_btn'])) {
	register();
}

// User registration
function register(){
	// Calling the global variables to make them usable in this function.
	global $db, $errors, $messages, $username, $email;

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
			array_push($messages, "Käyttäjä luotu ja tiedot lähetetty sähköpostilla.");
			header('location: index.php');
		}
	}
}


if (isset($_POST['deleteUser_btn'])) {
	deleteUser();
}

function deleteUser() {
	global $db, $errors, $messages;

	$user_id = e($_POST['user_id']);
	if($_SESSION['user']['user_id'] == $user_id) {
		array_push($errors, "WHY ARE YOU DELETING YOURSELF!!?!?!?!");
	} else {
		$query = "DELETE FROM users WHERE user_id='$user_id'";
		if (mysqli_query($db, $query)) {
			array_push($messages, "Käyttäjä poistettu.");
		} else {
			echo "Error deleting record: " . mysqli_error($db);
		}
	}
}

// return user array from their id
function getUserById($id){
	global $db;
	$query = "SELECT * FROM users WHERE id=" . $user_id;
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
		foreach ($errors as $error){
			echo '<div class="error">';
			echo '<i class="fa fa-times-circle"></i>';
			echo $error .'<br>';
			echo '</div>';
		}
	}
}	

function display_msg() {
	global $messages;

	if (count($messages) > 0){
		
		foreach ($messages as $message){
			echo '<div class="msg">';
			echo '<i class="fa fa-check"></i>';
			echo $message .'<br>';
			echo '</div>';
		}
		
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



// call the login() function if register_btn is clicked
if (isset($_POST['login_btn'])) {
	login();
}

// LOGIN USER
function login(){
	global $db, $username, $errors, $messages;

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
				array_push($messages, "Kirjauduttu sisään.");
			}else{
				$_SESSION['user'] = $logged_in_user;
				array_push($messages, "Kirjauduttu sisään.");
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


// Prints all the users from users database to a list.
function printUsers() {
	global $db;
	$user_id = "";
    $query2="SELECT user_id, username, user_type, email, firstName, lastName FROM users";
	$result = mysqli_query($db, $query2);
	print "<h2>Käyttäjälista</h2>";
	print
		"<table class='userList'>
		<tr>
			<th>Käyttäjätunnus</th>
			<th>Käyttäjätyyppi</th>
			<th>Sähköposti</th>
			<th>Etunimi</th>
			<th>Sukunimi</th>
		</tr>	
		";
		while($row = mysqli_fetch_row($result)){
			$user_id = $row[0];
			$check = true;
			print "<tr>";
			foreach($row as $value) {
				if(!$check) {
					print "<td>".$value."</td>";
				} else {
					$check = false;
				}
				
			}
			print <<<EOF
			<td><form action="" method="post">
			<input type="hidden" name="user_id" value="$user_id" />
			<button class="deleteUserButton" type="submit" name="deleteUser_btn">Poista käyttäjä</button></form></td>
EOF;
			print "</tr>";
		}
	print "</table>";
}

// call resetPassword() function.
if (isset($_POST['reset_btn'])) {
	resetPassword();
}

// Resets the password of the current user.
function resetPassword() {
	global $db, $username, $errors, $messages;

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
			array_push($messages, "Salasana vaihdettu uuteen.");
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
	global $db, $errors, $messages;

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
	global $db, $errors, $messages;

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
		array_push($messages, "Tapahtuma luotu");
	}
}

function printEditEvent() {
	global $db, $messages;
	$event_id = $_GET['event_id'];
	$query = "SELECT * FROM events Where event_id=$event_id";
	$result = mysqli_query($db, $query);
	$result = mysqli_fetch_assoc($result);
	$eventType = $result['eventType'];
	$description = $result['description'];
	$location = $result['location'];
	$time = $result['time'];
	
	$time = strtotime($time);
	$time = date("Y-m-d\TH:i:s", $time);
	//$time->format();

	print <<<EOF
	<section class="s1">
	<div class="header">
		<h2>Admin - Muokkaa Tapahtumaa</h2>
	</div>
	<div class="formBox">
		<form method="post" action="../app/nimenhuuto/">

		<?php 
            echo display_error(); 
            echo display_msg();
            ?>

			<div class="input-group">
				<label for="eventType">Tapahtuma</label>
				<select name="eventType" id="eventType" autofocus>
					<option value="$eventType">$eventType</option>
					<option value="Treeni">Treeni</option>
					<option value="Peli">Matsi</option>
				</select>
			</div>
			<div class="input-group">
				<label for="desc">Kuvaus</label>
				<input type="text" name="description" id="desc" value="$description">
			</div>
			<div class="input-group">
				<label for="location">Sijainti</label>
				<input type="text" name="location" id="location" value="$location">
			</div>
			<div class="input-group">
				<label for="time">Aika</label>
				<input type="datetime-local" name="time" id="time" value="$time">
			</div>
			<div class="input-group">
				<input type="hidden" name="event_id" value="$event_id">
				<button type="submit" class="btn formbutton" name="editEvent_btn">Muokkaa Tapahtumaa</button>
			</div>
		</form>
	</div>
	
</section>
EOF;
}

if(isset($_POST['editEvent_btn'])) {
	editEvent();
}

function editEvent() {
	global $db, $messages;
	$event_id = e($_POST['event_id']);
	$eventType = e($_POST['eventType']);
	$description = e($_POST['description']);
	$location = e($_POST['location']);
	$time = e($_POST['time']);

	$editQuery = "UPDATE events SET eventType='$eventType', description='$description', location='$location', time='$time' WHERE event_id='$event_id'";
	$result = mysqli_query($db, $editQuery);
	array_push($messages, "Tapahtuma muokattu");
}

// Prints all the events from the database to a list.
function printEvents() {
	global $db;
    $query2="SELECT * FROM events ORDER BY time ASC";
	$result = mysqli_query($db, $query2);
	$user_id = $_SESSION['user']['user_id'];
	print "<div class='eventList'>";
		print "<h1>Tapahtumat</h1>";
		while($row = mysqli_fetch_assoc($result)) {
			$event_id = $row['event_id'];
			$daysTill = "";
			$doing = "";
			$num = 0;
			print "<div class=eventItem>";
			foreach($row as $ding) {
				if($num == 4) {
					$daysTill = countDays($ding, $event_id);
					$time = strtotime($ding);
					$formatTime = date("H:i d/m/Y", $time);
					$dayMonth = getDayMonth($time);
					$doing = $formatTime;
					print "<div class=event".$num.">";
					print "
					<div class='dayAndMonth'><p class='day'>$dayMonth[1].</p><p class='month'>$dayMonth[0]</p></div>
					";
					print "<p class='daycount'>".$daysTill."</p>";
					
					print "</div>";
				} elseif($num == 3) {
					$addr = urlencode($ding);
					print "<div class=event".$num.">";
					print "<p></p><a href='https://www.google.com/maps/search/?api=1&query=".$addr."' target='_blank'>".$ding."</a></p>";
					print "</div>";
				} else {
					print "<div class=event".$num.">";
					print "<p>".$ding."</p>";
					print "</div>";
				}
				
				
				$num++;
			}
			print "<div class='fulldate'><p class='date'>".$doing."</p></div>";

			print "<div class='attendLists'>";
			printAttendees($event_id);

			printNotComing($event_id);

			print "</div>";
			echo "<div class='buttons'>";
			
			printDecisionButtons($user_id, $event_id);
		
			if(isAdmin()) {
				printDeleteButton($event_id);
			}
			
			print "</div>";
			print "</div>";
		}
	
	print "</div>";
}

function countDays($time, $event_id) {
	$formatTime = strtotime($time);
	$date1 = new DateTime(date("d-m-Y", $formatTime));
	$date2 = new DateTime(date("d-m-Y"));

	$diff = date_diff($date2, $date1);
	$diff = $diff->format("%r%a");
	if($diff < 0 ) {
		deleteEvent($event_id);
	} elseif($diff == 0) {
		return "Tänään";
	} elseif ($diff == 1) {
		return "Huomenna";
	} else {
		return $diff." päivän päästä";
	}
}

function getDayMonth($time = "") {
	$month = date("M", $time);
	switch($month) {
		case 'Jan':
			$month = "Tammi";
			break;
		case 'Feb':
			$month = "Helmi";
			break;
		case 'Mar':
			$month = "Maalis";
			break;
		case 'Apr':
			$month = "Huhti";
			break;
		case 'May':
			$month = "Touko";	
			break;
		case 'Jun':
			$month = "Kesä";
			break;
		case 'Jul':
			$month = "Heinä";
			break;
		case 'Aug':
			$month = "Elo";
			break;
		case 'Sep':
			$month = "Syys";
			break;
		case 'Oct':
			$month = "Loka";
			break;
		case 'Nov':
			$month = "Marras";
			break;
		case 'Dec':
			$month = "Joulu";	
			break;
	}
	$day = date("d", $time);
	
	return array($month, $day);
}

function printOnlyEvents() {
	global $db;
    $query2="SELECT * FROM events";
	$result = mysqli_query($db, $query2);
	print "<div class='eventList'>";
		print "<h1>Tapahtumat</h1>";
		while($row = mysqli_fetch_assoc($result)) {
			$event_id = $row['event_id'];
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

function checkDecision($event_id="") {
	global $db;
	$user_id = $_SESSION['user']['user_id'];
	$query = "SELECT * From attending Where (event_id='$event_id' AND user_id='$user_id')";
	$result = mysqli_query($db, $query);
	if(mysqli_num_rows($result) == 1) {
		return false;
	} else {
		return true;
	}
}

function printAttendees($event_id="") {

	global $db;
	$query = "SELECT * FROM attending WHERE (event_id='$event_id' AND decision='imIn')";
	$result = mysqli_query($db, $query);
	$attendees = array();
	while($row = mysqli_fetch_assoc($result)) {
		array_push($attendees, $row['user_id']);
	}
	$count = count($attendees);
	echo "<div class='coming'><h5><i class='far fa-thumbs-up'></i> ".$count."</h5>";
	echo "<ul>";
	foreach($attendees as $result) {
		$query = "SELECT * FROM users WHERE user_id='$result'";
		$data = mysqli_query($db, $query);
		$user = mysqli_fetch_assoc($data)['firstName'];
		echo "<li class='comingUser'>".$user."</li>";
	}
	echo "</ul></div>";
}

function printNotComing($event_id="") {
	global $db;
	$query = "SELECT * FROM attending WHERE (event_id='$event_id' AND decision='imOut')";
	$result = mysqli_query($db, $query);
	$notAttending = array();
	while($row = mysqli_fetch_assoc($result)) {
		array_push($notAttending, $row['user_id']);
	}
	$count = count($notAttending);
	echo "<div class='notComing'><h5><i class='far fa-thumbs-down'></i> ".$count."</h5>";
	echo "<ul>";
	foreach($notAttending as $result) {
		$query = "SELECT * FROM users WHERE user_id='$result'";
		$data = mysqli_query($db, $query);
		$user = mysqli_fetch_assoc($data)['firstName'];
		echo "<li class='notComingUser'>".$user."</li>";
	}
	echo "</ul></div>";
}

function printDeleteButton($event_id = "") {
	print '
		<button class="editButton"><a href="../../admin/editEvent.php?event_id='.$event_id.'">Muokkaa tapahtumaa</a></button>	
		<form action="index.php" method="post">
			<input type="hidden" name="event_id" value="'.$event_id.'" />
			<button class="deleteButton" type="submit" name="deleteEvent_btn">Poista tapahtuma</button>
		</form> 
		
	';
}

function printDecisionButtons($user_id = "", $event_id = "") {
	print '
		<form action="index.php" method="post">
			<input type="hidden" name="event_id" value="'.$event_id.'" />
			<input type="hidden" name="user_id" value="'.$user_id.'" />
			<input type="hidden" name="decision" value="imIn" />
			<button class="inButton" type="submit" name="decision_btn" >
				<i class="far fa-thumbs-up"></i> IN
			</button>
		</form> 
		<form action="index.php" method="post">
			<input type="hidden" name="event_id" value="'.$event_id.'" />
			<input type="hidden" name="user_id" value="'.$user_id.'" />
			<input type="hidden" name="decision" value="imOut" />
			<button class="outButton" type="submit" name="decision_btn">
				<i class="far fa-thumbs-down"></i> OUT
			</button>
		</form> 
	';
}

if (isset($_POST['decision_btn'])) {
	makeDecision();
}

function makeDecision() {
	global $db;

	$event_id = e($_POST['event_id']);
	$user_id = e($_POST['user_id']);
	$decision = e($_POST['decision']);
	$check = "SELECT * FROM attending WHERE (event_id='$event_id' AND user_id='$user_id')";
	$checkResult = mysqli_query($db, $check);
	if(mysqli_num_rows($checkResult) == 1) {
		$query = "UPDATE attending SET decision='$decision' WHERE (event_id='$event_id' AND user_id='$user_id')";
		$endResult = mysqli_query($db, $query);
	} else {
		$query = 	"INSERT INTO attending (event_id, user_id, decision) 
					VALUES('$event_id', '$user_id', '$decision')";
		$endResult = mysqli_query($db, $query);
	}

	
}

// Calls the deleteEvent() function.
if (isset($_POST['deleteEvent_btn'])) {
	deleteEvent();
}

function deleteEvent($event_id = "") {
	global $db, $messages;

	if(isset($_POST['event_id'])) {
		$event_id = e($_POST['event_id']);
	}

	$deleteQuery = "DELETE FROM events WHERE event_id='$event_id'";
	$result = mysqli_query($db, $deleteQuery);
	$deleteQuery2 = "DELETE FROM attending WHERE event_id='$event_id'";
	$result2 = mysqli_query($db, $deleteQuery2);
	array_push($messages, "Tapahtuma poistettu");
}

// Generates a random password with a length of 8.
function generatePassword() {
	$characters = "aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ0123456789!?&";
	$generatedPassword = substr( str_shuffle($characters),0,8);
	return $generatedPassword;
}

function checkEventDate() {
	$today = now();
}
?>