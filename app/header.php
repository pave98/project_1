    <?php include($_SERVER['DOCUMENT_ROOT'].'/project_1/app/server.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RKC-Volley</title>
    <link rel="stylesheet" href="http://localhost/project_1\css\style.css">
    
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
                    <li><!--asfjo-->
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
                        if(!empty($_SESSION['username'])){
                            print "
                            <li>
                                <a href='http://localhost/project_1/app/nimenhuuto/index.php'>Nimenhuuto</a>
                            </li>";
                        };
                    ?>
                </ul>
            </nav>
            <aside>
                    <h1>
                        <?php 
                            if(empty($_SESSION['username'])){
                                print "
                                    <a href='http://localhost/project_1/app/login'>Login</a>
                                    ";
                            } else {
                                print   "
                                        <a href=\"http://localhost/project_1/app/login/index.php?logout='1'\">Logout</a>
                                        ";     
                            }
                        ?>
                        
                    </h1>
            </aside>

        </header>
        