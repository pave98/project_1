<?php
    require "../app/header.php";

    if (!isAdmin()) {
        header('location: ../app/login/index.php');
    }

    printEditEvent();
?>
    
<?php
    require "../app/footer.php";
?>