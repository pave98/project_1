<?php
    require "../app/header.php";

    if (!isAdmin()) {
        header('location: ../app/login/index.php');
    }
?>
    <section class="s1">
        <h1 class="motto">Yhdessä Runkulla Admin</h1>
        <div>
        <?php printUsers() ?>
        </div>
        <h4><a href="create_user.php">Lisää käyttäjä</a></h1>
        <h4><a href="create_event.php">Lisää tapahtuma</a></h1>
        <h4><a href="delete_user.php">Poista käyttäjä</a></h4>
    </section>
    
<?php
    require "../app/footer.php";
?>