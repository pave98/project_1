    <?php include('server.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Projekti1</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="project_1\css\style.css">
    
</head>
<body>
    <div class="container">
        <header>
            <h1><a href="http://localhost/project_1/app/index.php">RKC</a></h1>
            <nav>
                <ul>
                <?php
                    if (empty($_SESSION['username'])) {
                        print "
                        <li>
                            <a href='http://localhost/project_1/app/login/'>Login</a>
                        </li>
                        ";
                    } 
                ?>
                    
                    <li>
                        <a href="javascript:void(0)">Joukkue</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">Yhteystiedot</a>
                    </li>
                </ul>
            </nav>
            <aside>
                    <h1>
                        <a href="http://" target="_blank" rel="noopener noreferrer">Login</a>
                    </h1>
            </aside>

        </header>
        