    <?php include('server.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RKC-Volley</title>
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
                    <li>
                        <a href='../app/index.php'>Etusivu</a>
                    </li>
                    <li>
                        <a href='../app/joukkue/index.php'>Joukkue</a>
                    </li>
                    <li>
                        <a href='../app/galleria/index.php'>Galleria</a>
                    </li>
                    <li>
                        <a href='../app/yhteystiedot/index.php'>Yhteystiedot</a>
                    </li>
                    <?php if(!empty($_SESSION['user'])){
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
                        <a href="http://" target="_blank" rel="noopener noreferrer">Login</a>
                    </h1>
            </aside>

        </header>
        