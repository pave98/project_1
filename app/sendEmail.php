<?php
    /*
    require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';	
    require 'PHPMailer/src/Exception.php';
    */

    // Sends an email to the given email address that contains the given users login username and password.
    function sendEmail($email="", $username="", $password="") {
        
        $to = $email; // note the comma

        // Subject
        $subject = 'käyttäjätunnukset';

        // Message
        $message = '
        <html>
        <head>
        <title>Tunnukset</title>
        </head>
        <body>
        <a href="www.nokkeli.fi">nokkeli.fi</a>
        <p>K&auml;ytt&auml;j&auml;tunnus: '.$username.'</p>
        <p>Salasana: '.$password.'</p>
        </body>
        </html>
        ';

        // To send HTML mail, the Content-type header must be set
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

        // Additional headers
        $headers[] = 'To: '.$email;
        $headers[] = 'From: no-reply-rkc@nokkeli.fi';

        // Mail it
        mail($to, $subject, $message, implode("\r\n", $headers));

        /*
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
        $mail->Body = "<a href='www.nokkeli.fi'>nokkeli.fi</a><p>K&auml;ytt&auml;j&auml;tunnus: ".$username."</p><p>Salasana: ".$password."</p>";
        $mail->AltBody = "This is the plain text version of the email content";

        $mail->send();

        */
    }

?>