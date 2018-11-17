<?php
    require "../header.php";
?>
    <section class="s1">
        <h1>Joukkue</h1>

        <?php 
            include_once "player.php";
            foreach($players as $value){
                $value->printStats();
            }
        ?>
    </section>
    
<?php
    require "../footer.php";
?>