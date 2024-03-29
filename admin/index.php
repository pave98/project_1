<?php
    require "../app/header.php";

    if (!isAdmin()) {
        header('location: ../app/login/index.php');
    }
?>
            <?php 
            echo display_msg();
            ?>
    <section class="s1">
        <h1 class="motto">Admin</h1>

        <a class="removeLink" href="create_player.php"><button class="adminButton">Lisää Pelaaja</button></a>
        <a class="removeLink" href="create_user.php"><button class="adminButton">Lisää käyttäjä</button></a>
        <a class="removeLink" href="delete_player.php"><button class="adminButton">Hallitse Pelaajia</button></a>
        <a class="removeLink" href="delete_user.php"><button class="adminButton">Hallitse käyttäjiä</button></a>
        <a class="removeLink" href="create_news.php"><button class="adminButton">Lisää Uutinen</button></a>
        <a class="removeLink" href="create_event.php"><button class="adminButton">Lisää tapahtuma</button></a>
    </section>
    
<?php
    require "../app/footer.php";
?>