<?php
    require "../header.php";
?>
    <section class="s1">
        <h1>Edustusjoukkue 2018-2019</h1>
    <div class="players">
        <?php 
            include_once "player.php"; 
            foreach($players as $value){
                print"<div class= 'player'>";
                $value->printHead();
                $value->printPic();
                $value->printStats();
                print"</div>";
            }
        ?>
    </div>
    </section>
    
<?php
    require "../footer.php";
?>