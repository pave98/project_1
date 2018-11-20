
<?php

    session_start();

    $username = "";
    $email = "";
    $errors = array();


    // Connect to the database
    $db = mysqli_connect('localhost','root','mapatu9598','rkc');

    //if the registration button is clicked
    if(ISSET($_POST['register'])) {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
        $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
        $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
        $description = mysqli_real_escape_string($db, $_POST['description']);

        // ensure that form fields are filled properly
        if(empty($username)) {
            array_push($errors, "Username is required"); // add error to errors array
        }
        if(empty($email)) {
            array_push($errors, "Email is required"); // add error to errors array
        }
        if(empty($password_1)) {
            array_push($errors, "Password is required"); // add error to errors array
        }
        if($password_1 != $password_2) {
            array_push($errors, "The two passwords don't match");
        }
        if(empty($firstname)) {
            array_push($errors, "First name is required"); // add error to errors array
        }
        if(empty($lastname)) {
            array_push($errors, "Last name is required"); // add error to errors array
        }
        if(empty($description)) {
            array_push($errors, "Description is required"); // add error to errors array
        }
        // if there are no errors, save user to database
        if(count($errors) == 0) {
            $password = md5($password_1); // encrypt password before storing in database (security)
            $sql = "INSERT INTO users (username, password, email, firstName, lastName, description) VALUES ('$username', '$password', '$email', '$firstname', '$lastname', '$description')";
            mysqli_query($db, $sql);
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php'); // redirect to home page
        }
    }


    // log user in from login page
    if (isset($_POST['login'])) {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);

        // ensure that form fields are filled properly
        if(empty($username)) {
            array_push($errors, "Username is required"); // add error to errors array
        }
        if(empty($password)) {
            array_push($errors, "Password is required"); // add error to errors array
        }

        if(count($errors) == 0) {
            $password = md5($password); // encrypt password before comparing with that from database
            $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
            $result = mysqli_query($db, $query);
            if (mysqli_num_rows($result) == 1) {
                // log user in
                $_SESSION['username'] = $username;
                $_SESSION['success'] = "You are now logged in";
                header('location: index.php'); // redirect to home page
            }else {
                array_push($errors, "Wrong username/password combination");
            }
        }
    }

    // logout
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header('location: index.php');
    }
 
?>