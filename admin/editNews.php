<?php
    require "../app/header.php";

    if (!isAdmin()) {
        header('location: ../app/login/index.php');
    }

    printEditNews();
?>
    
<?php
    require "../app/footer.php";
?>