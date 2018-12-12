<?php
    require "../header.php";
    // if user is not logged in, they cannot access this page
    if (!isLoggedIn()) {
        $_SESSION['msg'] = "You must log in first";
        header('location: /project_1/app/login/index.php');
    }
?>
    <section>
        <?php if (isAdmin()) {
        print   "
                <a href='../../admin/create_event.php'>Lisää tapahtuma</a>
                ";

            echo display_msg();
    }?>
        <?php printEvents() ?>
    </section>
<?php
    require "../footer.php";
?>