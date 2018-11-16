<?php
    require "../header.php";
?>
    <section class="s1">
        <h1>Joukkue</h1>

        <?php 
            include_once "player.php";
            print"<div class= 'player'>";
            print'<h1> #'.$keinonen->getNumber().' '.$keinonen->getName().'</h1>';
            print "Nimi: ".$keinonen->getName()."<br>";
            print "Pituus: ".$keinonen->getHeight()."<br>";
            print "Ulottuvuus: ".$keinonen->getReach()."<br>";
            print "Pelipaikka: ".$keinonen->getPosition()."<br>";
            print"</div>";
        ?>
    </section>
    
<?php
    require "../footer.php";
?>