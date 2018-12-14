    <?php 
    include $_SERVER['DOCUMENT_ROOT'].'/project_1/app/functions.php';
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RKC-Volley</title>
    <link rel="stylesheet" href="<?php $root;?>/project_1/css/style.css">
    <link rel="shortcut icon" href="<?php $root;?>/project_1/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/v4-shims.css">
    <link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <a href='<?php $root;?>/project_1/app/index.php'>
                    <img src='<?php $root;?>/project_1/app/images/logo.png' alt='RKC logo'>
                </a>
            </div>
            

            <nav class="topnav" id="myTopnav">    
                <a href='/project_1/app/index.php'>Etusivu</a>
            
                <a href='/project_1/app/joukkue/index.php'>Joukkue</a>
            
                <a href='/project_1/app/galleria/index.php'>Galleria</a>
            
                <a href='/project_1/app/yhteystiedot/index.php'>Yhteystiedot</a>
                
                <?php 

                    // Shows the link to the page that is meant only for logged in users.
                    if(!empty($_SESSION['user'])){
                        print "
                        
                            <a href='/project_1/app/nimenhuuto/index.php'>Nimenhuuto</a>
                        ";
                    };
                    // Shows the link to the admin pages.
                    if(isAdmin()){
                        print "
                        
                            <a href='/project_1/admin/index.php'>Admin</a>
                        ";
                    };
                ?>
                
                <?php 
                    // switches between login and logout links depending if a user is logged in or out.
                    if(empty($_SESSION['user'])){
                        print "
                            <a href='/project_1/app/login/index.php'>Kirjautuminen</a>
                            ";
                    } else {
                        print "
                            <a href='/project_1/app/passwordReset/'>Vaihda salasana</a>
                            <a href=\"/project_1/app/index.php?logout='1'\">Kirjaudu ulos</a>
                            ";
                            
                    }
                ?>
                <a href="javascript:void(0);" class="icon" onclick="myFunction2()">
                    <i class="fa fa-bars"></i>
                </a>
            </nav>
            <script>
                function myFunction2() {
                    var xx = document.getElementById("myTopnav");
                    if (xx.className === "topnav") {
                        xx.className += " responsive";
                    } else {
                        xx.className = "topnav";
                    }
                }
            </script>
        </header>
        