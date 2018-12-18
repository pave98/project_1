<?php session_start() ?>
<?php

// Connection to database.
$db = mysqli_connect('localhost', 'admin', '', 'rkc');

// Declaring variables for the site.

$root 			= $_SERVER['DOCUMENT_ROOT'];
$username 	  	= "";
$email   	  	= "";
$firstname 	  	= "";
$lastname 	  	= "";
$description    = "";
$eventType		= "";
$location		= "";
$time			= "";
$news_title		= "";
$news_article	= "";
$username		= "";
$user_type 		= "";
$email 			= "";
$firstname 		= "";
$lastname 		= "";
$player_number	= "";
$player_fname	= "";
$player_lname	= "";
$height			= "";
$reach			= "";
$player_position	= "";
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
			array_push($errors, "The username already exists or the email is already in use!");
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

// calls the deleteUser() function.
if (isset($_POST['deleteUser_btn'])) {
	deleteUser();
}

// After the deleteUserButton has been pressed, delete the user in question.
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

// Echoes all errors that have been stored in the errors array.
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

// Echoes all messages that have been stored in the messages array.
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

// Checks if current session has a logged in user.
function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	}else{
		return false;
	}
}



// call the login() function if login_btn is clicked
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


// Prints all the users from users database to a table.
function printUsers() {
	global $db;
	$user_id = "";
    $query2="SELECT user_id, username, user_type, email, firstName, lastName FROM users";
	$result = mysqli_query($db, $query2);
	print "<h2>Käyttäjälista</h2>";
	print
		"
		<div class='tablediv'>
		<table class='userList'>
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
			<td>
			<form action="" method="post">
			<input type="hidden" name="user_id" value="$user_id" />
			<button class="deleteUserButton" type="submit" name="deleteUser_btn">Poista käyttäjä</button></form>
			<form action="editUser.php" method="post">
			<input type="hidden" name="user_id" value="$user_id" />
			<button class="deleteUserButton" type="submit" name="editUserPage_btn">Muokkaa käyttäjää</button></form>
			</td>
EOF;
			print "</tr>";
		}
	print "</table></div>";
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

// if a user has forgotten his/her password and is not logged in, user gives a email and a new password is send via email to the given email.
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

// prints the event editing pages content with the events details filled in the form.
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
		<form method="post" action="../app/nimenhuuto/" name="myForm" onsubmit = "return(validate());">

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
// Calls the editEvent() function.
if(isset($_POST['editEvent_btn'])) {
	editEvent();
}

// Edits an existing event with the new values given from the editEvent page.
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

// Counts days till the event. if the event has passed it gets deleted.
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

// Converts the english abbreviation to a finnish abbreviation for months. returns the month abbreviation and the day of the event.
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

//Prints News to the frontpage.
function printNews() {
	global $db;
    $query="SELECT * FROM news";
	$result = mysqli_query($db, $query);
	print "<div class='newsList'>";
		print "<h1>Ajankohtaista</h1>";
		while($row = mysqli_fetch_assoc($result)) {
			$news_id = $row['news_id'];
			$num = 0;
			print "<div class=newsItem>";
			foreach($row as $ding) {
				if($num == 1) {
					$time = strtotime($ding);
					$formatTime = date("d/m/Y", $time);
					print "<div class=news".$num.">";
					print "<p>Luotu: ".$formatTime."</p>";
					print "</div>";

				} elseif($num == 3) {
					print "<div class=news".$num.">";
					print "<p>".$ding."</p>";
					print "</div>";
				} else {
					print "<div class=news".$num.">";
					print "<p>".$ding."</p>";
					print "</div>";
				}
				$num++;
			}
			if(isAdmin()) {
					printNewsButtons($news_id);
				}
			print "</div>";
		}
	print "</div>";
}

function printNewsButtons($news_id = "") {
	print '
		<a class="removeLink" href="../admin/editNews.php?news_id='.$news_id.'"><button class="editButton">Muokkaa uutista</button></a>	
		<form action="index.php" method="post">
			<input type="hidden" name="news_id" value="'.$news_id.'" />
			<button class="deleteButton" type="submit" name="deleteNews_btn">Poista uutinen</button>
		</form> 
		
	';
}

// prints the event editing pages content with the events details filled in the form.
function printEditNews() {
	global $db, $messages;
	$news_id = $_GET['news_id'];
	$query = "SELECT * FROM news Where news_id=$news_id";
	$result = mysqli_query($db, $query);
	$result = mysqli_fetch_assoc($result);
	$news_title = $result['news_title'];
	$news_article = $result['news_article'];

	print <<<EOF
	<section class="s1">
	<div class="header">
		<h2>Admin - Muokkaa uutista</h2>
	</div>
	<div class="formBox">
		<form method="post" action="../app/index.php"  name="myForm" onsubmit = "return(validate());">

		<?php 
            echo display_error(); 
            echo display_msg();
            ?>

			<div class="input-group">
				<label for="news_title">Uutisen otsikko</label>
				<input type="text" name="news_title" id="news_title" value="$news_title">
			</div>
			<div class="input-group">
				<label for="news_article">Uutisen sisältö</label>
				<textarea rows="4" cols="40" name="news_article" id="news_article" >$news_article</textarea>
			</div>

			<div class="input-group">
				<input type="hidden" name="news_id" value="$news_id">
				<button type="submit" class="btn formbutton" name="editNews_btn">Muokkaa uutista</button>
			</div>
		</form>
	</div>
	
</section>
EOF;
}

// Calls the editEvent() function.
if(isset($_POST['editNews_btn'])) {
	editNews();
}

// Edits an existing event with the new values given from the editEvent page.
function editNews() {
	global $db, $messages;
	$news_id = e($_POST['news_id']);
	$news_title = e($_POST['news_title']);
	$news_article = e($_POST['news_article']);

	$editQuery = "UPDATE news SET news_title='$news_title', news_article='$news_article' WHERE news_id='$news_id'";
	$result = mysqli_query($db, $editQuery);
	array_push($messages, "Uutinen muokattu");
}

// Calls the createNews() function.
if (isset($_POST['createNews_btn'])) {
	createNews();
}

// Creates an event to the news database table.
function createNews(){
	// Calling global variables to be used in this function.
	global $db, $errors, $messages;

	// receive all input values from the form and escape them with the e() function.
	$news_title   =  e($_POST['news_title']);
	$news_article =  e($_POST['news_article']);

	// form validation: ensure that the form is correctly filled
	if (empty($news_title)) { 
		array_push($errors, "News title is required"); 
	}
	if (empty($news_article)) { 
		array_push($errors, "news article is required"); 
	}


	// If no errors then adds the event to the table. 
	if (count($errors) == 0) {
		$query = "INSERT INTO news (news_title, news_article) 
					VALUES('$news_title', '$news_article')";
		mysqli_query($db, $query);				
		array_push($messages, "Uutinen luotu");
	}
}


// Calls the deleteNews() function.
if (isset($_POST['deleteNews_btn'])) {
	deleteNews();
}

function deleteNews($news_id = "") {
	global $db, $messages;

	if(isset($_POST['news_id'])) {
		$news_id = e($_POST['news_id']);
	}

	$deleteQuery = "DELETE FROM news WHERE news_id='$news_id'";
	$result = mysqli_query($db, $deleteQuery);
	array_push($messages, "Uutinen poistettu");
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
		<button class="editButton eventButton"><a href="../../admin/editEvent.php?event_id='.$event_id.'">Muokkaa tapahtumaa</a></button>	
		<form action="index.php" method="post">
			<input type="hidden" name="event_id" value="'.$event_id.'" />
			<button class="deleteButton  eventButton" type="submit" name="deleteEvent_btn">Poista tapahtuma</button>
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

if (isset($_POST['createPlayer_btn'])) {
	createPlayer();
}

function createPlayer() {
	global $db, $errors, $messages;

	$player_number		= e($_POST['player_number']);
	$player_fname		= e($_POST['player_fname']);
	$player_lname		= e($_POST['player_lname']);
	$height				= e($_POST['height']);
	$reach				= e($_POST['reach']);
	$player_position	= e($_POST['player_position']);
	// Form validation.
	if (empty($player_number)) { 
		array_push($errors, "Player number is required"); 
	}
	if (empty($player_fname)) { 
		array_push($errors, "First name is required"); 
	}
	if (empty($player_lname)) { 
		array_push($errors, "Last name is required"); 
	}
    if(empty($height)) {
        array_push($errors, "Player's height is required"); // 
    }
    if(empty($reach)) {
        array_push($errors, "Player's reach is required"); // 
    }
    if(empty($player_position)) {
        array_push($errors, "Position is required"); 
	}
	
	if(count($errors) == 0 ) {
		$sqlQuery = "SELECT * FROM players WHERE player_number='$player_number'";
		$checkSQL = mysqli_query($db, $sqlQuery);
		if(mysqli_num_rows($checkSQL)) {
			array_push($errors, "There is already a player with that number!!!");
		} else {
			$query = "INSERT INTO players (player_number, player_fname, player_lname, height, reach, player_position) 
					  VALUES('$player_number', '$player_fname', '$player_lname', '$height', '$reach', '$player_position')";
			mysqli_query($db, $query);

			uploadPlayerPhoto($player_number);
		}
	}
}


function uploadPlayerPhoto($player_number = "") {
	global $db, $errors, $messages;
	$query = "SELECT player_id FROM players WHERE player_number='$player_number' LIMIT 1";
	$result = mysqli_query($db, $query);
	$value = mysqli_fetch_assoc($result);
	$filename = $value['player_id'].".";
	
	$file = $_FILES['player_image']['name'];
	$file2 = strtolower($file) ; 
	$exts = explode(".", $file) ; 
	$n = count($exts)-1; 
	$exts = $exts[$n]; 

	$target_dir = $_SERVER['DOCUMENT_ROOT']."/project_1/app/images/players/";
	$target_file = $target_dir . $filename.$exts;
	if(file_exists($target_file)) {
		$delete = $target_file;
		unlink($delete);
	}
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	echo $_FILES["player_image"]["tmp_name"];
	$check = getimagesize($_FILES["player_image"]["tmp_name"]);
    if($check !== false) {
        array_push($messages, "File is an image - " . $check["mime"] . ".");
        $uploadOk = 1;
    } else {
		array_push($errors, "File is not an image.");
        $uploadOk = 0;
	}
	if (file_exists($target_file)) {
		array_push($errors, "Sorry, file already exists.");
		$uploadOk = 0;
	}
	if ($_FILES["player_image"]["size"] > 500000) {
		array_push($errors, "Sorry, your file is too large.");
		$uploadOk = 0;
	}
	if($imageFileType != "jpg") {
		array_push($errors, "Sorry, only JPG files are allowed.");
	$uploadOk = 0;
	}
	if ($uploadOk == 0) {
		array_push($errors, "Sorry, your file was not uploaded.");
	} else {
		if (move_uploaded_file($_FILES["player_image"]["tmp_name"], $target_file)) {
			array_push($messages, "The file ". basename( $_FILES["player_image"]["name"]). " has been uploaded.");
		} else {
			array_push($errors, "Sorry, there was an error uploading your file.");
		}
	}
}


function printEditPlayer() {
	global $db, $messages;
	$player_id = $_POST['player_id'];
	$query = "SELECT * FROM players Where player_id=$player_id";
	$result = mysqli_query($db, $query);
	$result = mysqli_fetch_assoc($result);

	$player_number = $result['player_number'];
	$player_fname = $result['player_fname'];
	$player_lname = $result['player_lname'];
	$height = $result['height'];
	$reach = $result['reach'];
	$player_position = $result['player_position'];

	print <<<EOF
	<section class="s1">
	<div class="header">
		<h2>Admin - Muokkaa Pelaajaa</h2>
	</div>
	<div class="formBox">
		<form method="post" action="" enctype ="multipart/form-data" name="myForm" onsubmit = "return(validate());">

		<?php 
            echo display_error(); 
            echo display_msg();
            ?>

			<div class="input-group">
				<label for="player_number">Pelaajan numero</label>
				<input type="text" name="player_number" id="player_number" value="$player_number" autofocus>
			</div>
			<div class="input-group">
				<label for="player_fname">Pelaajan etunimi</label>
				<input type="text" name="player_fname" id="player_fname" value="$player_fname">
			</div>
			<div class="input-group">
				<label for="player_lname">Pelaajan sukunimi</label>
				<input type="text" name="player_lname" id="player_lname" value="$player_lname">
			</div>
			<div class="input-group">
				<label for="height">Pelaajan korkeus</label>
				<input type="text" name="height" id="height" value="$height">
			</div>
			<div class="input-group">
				<label for="reach">Pelaajan Ulottuvuus</label>
				<input type="text" name="reach" id="reach" value="$reach">
			</div>
			<div class="input-group">
				<label for="player_position">Pelaajan pelipaikka</label>
				<input type="text" name="player_position" id="player_position" value="$player_position">
			</div>
			<div class="input-group">
				<label for="player_image">Pelaajan kuva</label>
				<input type="file" name="player_image" id="player_image">
			</div>
			<div class="input-group">
				<input type="hidden" name="player_id" value="$player_id">
				<button type="submit" class="btn formbutton" name="editPlayer_btn">Muokkaa pelaajaa</button>
			</div>
		</form>
	</div>
	
</section>
EOF;
}

if(isset($_POST['editPlayer_btn'])) {
	editPlayer();
}

// Edits an existing event with the new values given from the editEvent page.
function editPlayer() {
	global $db, $messages;
	$player_id = e($_POST['player_id']);
	$player_number = e($_POST['player_number']);
	$player_fname = e($_POST['player_fname']);
	$player_lname = e($_POST['player_lname']);
	$height = e($_POST['height']);
	$reach = e($_POST['reach']);
	$player_position = e($_POST['player_position']);

	$editQuery = "UPDATE players SET player_number='$player_number', player_fname='$player_fname', player_lname='$player_lname', height='$height', reach='$reach', player_position='$player_position' WHERE player_id='$player_id'";
	$result = mysqli_query($db, $editQuery);
	if(is_uploaded_file($_FILES['player_image']['tmp_name'])) {
		echo $_FILES['player_image']['tmp_name'];
		uploadPlayerPhoto($player_number);
	}
	array_push($messages, "Pelaaja muokattu");
}


function printPlayers() {
	global $db;
	$player_id = "";
    $query2="SELECT * FROM players";
	$result = mysqli_query($db, $query2);
	print "<h2>Käyttäjälista</h2>";
	print
		"
		<div class='tablediv'>
		<table class='userList'>
		<tr>
			<th>#</th>
			<th>Etunimi</th>
			<th>Sukunimi</th>
			<th>Pituus</th>
			<th>Ulottuvuus</th>
			<th>Pelipaikka</th>
		</tr>	
		";
		while($row = mysqli_fetch_row($result)){
			$player_id = $row[0];
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
			<td>
			<form action="" method="post">
			<input type="hidden" name="player_id" value="$player_id" />
			<button class="deleteUserButton" type="submit" name="deletePlayer_btn">Poista Pelaaja</button></form>
			<form action="editPlayer.php" method="post">
			<input type="hidden" name="player_id" value="$player_id" />
			<button class="deleteUserButton" type="submit" name="editPlayerPage_btn">Muokkaa pelaajaa</button></form>
			</td>
EOF;
			print "</tr>";
		}
	print "</table></div>";
}

if (isset($_POST['deletePlayer_btn'])) {
	deletePlayer();
}


function deletePlayer() {
	global $db, $errors, $messages;

	$player_id = e($_POST['player_id']);
	
	$filename = $player_id.".jpg";
	
	$target_dir = $_SERVER['DOCUMENT_ROOT']."/project_1/app/images/players/";
	$target_file = $target_dir . $filename;
	if(file_exists($target_file)) {
		$delete = $target_file;
		unlink($delete);
	}

	$query = "DELETE FROM players WHERE player_id='$player_id'";
	if (mysqli_query($db, $query)) {
		array_push($messages, "Pelaaja poistettu.");
	} else {
		echo "Error deleting record: " . mysqli_error($db);
	}

}

function printEditUser() {
	global $db, $messages;
	$user_id = $_POST['user_id'];
	$query = "SELECT * FROM users Where user_id=$user_id";
	$result = mysqli_query($db, $query);
	$result = mysqli_fetch_assoc($result);

	$username = $result['username'];
	$user_type = $result['user_type'];
	$email = $result['email'];
	$firstname = $result['firstName'];
	$lastname = $result['lastName'];

	print <<<EOF
	<section class="s1">
	<div class="header">
		<h2>Admin - Muokkaa käyttäjää</h2>
	</div>
	<div class="formBox">
		<form method="post" action="index.php" name="myForm" onsubmit = "return(validate());">

		<?php 
            echo display_error(); 
            echo display_msg();
            ?>

			<div class="input-group">
                    <label for="user_type">Käyttäjätyyppi</label>
                    <select name="user_type" id="user_type" >
                        <option value="$user_type">$user_type</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="username">Käyttäjätunnus</label>
                    <input type="text" name="username" id="username" value="$username" autofocus>
                </div>
                <div class="input-group">
                    <label for="firstname">Etunimi</label>
                    <input type="text" name="firstname" id="firstname" value="$firstname">
                </div>
                <div class="input-group">
                    <label for="lastname">Sukunimi</label>
                    <input type="text" name="lastname" id="lastname" value="$lastname">
                </div>
                <div class="input-group">
                    <label for="email">Sähköposti</label>
                    <input type="email" name="email" id="email" value="$email">
                </div>
				<div class="input-group">
					<input type="hidden" name="user_id" value="$user_id">
                    <button type="submit" class="btn formbutton" name="editUser_btn">Muokkaa käyttäjää</button>
                </div>
		</form>
	</div>
	
</section>
EOF;
}

if(isset($_POST['editUser_btn'])) {
	editUser();
}

function editUser() {
	global $db, $messages;
	$user_id = e($_POST['user_id']);
	$username = e($_POST['username']);
	$user_type = e($_POST['user_type']);
	$email = e($_POST['email']);
	$firstname = e($_POST['firstname']);
	$lastname = e($_POST['lastname']);

	$editQuery = "UPDATE users SET username='$username', user_type='$user_type', email='$email', firstName='$firstname', lastName='$lastname' WHERE user_id='$user_id'";
	$result = mysqli_query($db, $editQuery);
	array_push($messages, "Käyttäjä muokattu");
}

?>