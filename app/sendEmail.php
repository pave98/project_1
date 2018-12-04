<?php

    require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';	
    require 'PHPMailer/src/Exception.php';
    

    // Sends an email to the given email address that contains the given users login username and password.
    function sendEmail($email="", $username="", $password="") {
        $mail = new PHPMailer\PHPMailer\PHPMailer;

        //Enable SMTP debugging. 
        $mail->SMTPDebug = 0;                               
        //Set PHPMailer to use SMTP.
        $mail->isSMTP();            
        //Set SMTP host name
        $mail->Host = "smtp.gmail.com";
        //Set this to true if SMTP host requires authentication to send email
        $mail->SMTPAuth = true;                          
        //Provide username and password     
        $mail->Username = "no.reply.nkc@gmail.com";                 
        $mail->Password = "Perkele#123";                           
        $mail->SMTPSecure = "ssl";                           
        //Set TCP port to connect to 
        $mail->Port = 465;                                   

        $mail->From = "name@gmail.com";
        $mail->FromName = "RKC";

        $mail->addAddress($email);

        $mail->isHTML(true);

        $mail->Subject = "RKC-sivun kirjautumistunnus";
        $mail->Body = "<p>K&auml;ytt&auml;j&auml;tunnus: ".$username."</p><p>Salasana: ".$password."</p>";
        $mail->AltBody = "This is the plain text version of the email content";

        $mail->send();
    }

?>