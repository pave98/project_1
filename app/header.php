    <?php include($_SERVER['DOCUMENT_ROOT'].'/project_1/app/functions.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RKC-Volley</title>
    <link rel="stylesheet" href="http://localhost/project_1\css\style.css">
    <link rel="shortcut icon" href="http://localhost/project_1/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/v4-shims.css">


</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <a href='<?php $_SERVER['DOCUMENT_ROOT']?>/project_1/app/index.php'>
                    <img src='<?php $_SERVER['DOCUMENT_ROOT']?>/project_1/app/images/logo.png' alt='RKC logo'>
                </a>
            </div>
            

            <nav>
                
                <ul>
                    <li>
                        <a href='<?php $_SERVER['DOCUMENT_ROOT']?>/project_1/app/index.php'>Etusivu</a>
                    </li>
                    
                    <li>
                        <a href='<?php $_SERVER['DOCUMENT_ROOT']?>/project_1/app/joukkue/index.php'>Joukkue</a>
                    </li>
                    <li>
                        <a href='<?php $_SERVER['DOCUMENT_ROOT']?>/project_1/app/galleria/index.php'>Galleria</a>
                    </li>
                    <li>
                        <a href='<?php $_SERVER['DOCUMENT_ROOT']?>/project_1/app/yhteystiedot/index.php'>Yhteystiedot</a>
                    </li>
                    <?php 

                        // Shows the link to the page that is meant only for logged in users.
                        if(!empty($_SESSION['user'])){
                            print "
                            <li>
                                <a href='/project_1/app/nimenhuuto/index.php'>Nimenhuuto</a>
                            </li>";
                        };
                        // Shows the link to the admin pages.
                        if(isAdmin()){
                            print "
                            <li>
                                <a href='/project_1/admin/index.php'>Admin</a>
                            </li>";
                        };
                    ?>
                    <li>
                        <?php 
                            // switches between login and logout links depending if a user is logged in or out.
                            if(empty($_SESSION['user'])){
                                print "
                                    <li>
                                        <a href='/project_1/app/login/index.php'>Login</a>
                                    </li>";
                            } else {
                                print "
                                    <a href=\"/project_1/app/index.php?logout='1'\">Logout</a>
                                    <li>
                                        <a href='/project_1/app/passwordReset/'>Reset</a>
                                    </li>
                                    ";     
                            }
                        ?>
                    </li>
                </ul>
            </nav>
        </header>
        