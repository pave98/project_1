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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="jquery.datetimepicker.css"/>

    <script type="text/javascript" src="C:\wamp64\www\project_1\app\galleria\galleryjs.js"></script>


</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <a href='http://localhost/project_1/app/index.php'>
                    <img src='http://localhost/project_1/app/images/logo.png' alt='RKC logo'>
                </a>
            </div>
            

            <nav>
                
                <ul>
                    <li>
                        <a href='http://localhost/project_1/app/index.php'>Etusivu</a>
                    </li>
                    
                    <li>
                        <a href='http://localhost/project_1/app/joukkue/index.php'>Joukkue</a>
                    </li>
                    <li>
                        <a href=http://localhost/project_1/app/galleria/index.php>Galleria</a>
                    </li>
                    <li>
                        <a href=http://localhost/project_1/app/yhteystiedot/index.php>Yhteystiedot</a>
                    </li>
                    <?php 
                        if(!empty($_SESSION['user'])){
                            print "
                            <li>
                                <a href='http://localhost/project_1/app/nimenhuuto/index.php'>Nimenhuuto</a>
                            </li>";
                        };
                        if(isAdmin()){
                            print "
                            <li>
                                <a href='http://localhost/project_1/admin/index.php'>Admin</a>
                            </li>";
                        };
                    ?>
                    <li>
                        <?php 
                            if(empty($_SESSION['user'])){
                                print "
                                    <a href='http://localhost/project_1/app/login'>Login</a>
                                    ";
                            } else {
                                print   "
                                        <a href=\"http://localhost/project_1/app/index.php?logout='1'\">Logout</a>
                                        <li>
                                            <a href='http://localhost/project_1/app/passwordReset/'>Reset</a>
                                        </li>
                                        ";     
                            }
                        ?>
                    </li>
                </ul>
            </nav>
        </header>
        