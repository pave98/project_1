<?php
    require "../header.php";
?>
    <section class="s1">
        <h1>RKC-Volley</h1>
            <p class="intro">RKC-Volley on 2018 keväällä perustettu lentopallojoukkue Lempäälästä. Joukkueen perustivat 
            Joukkueenjohtaja Antti Koskinen ja kapteeni Niko Hienonen koska eivät löytäneet seuraa joka sopi
            juuri heidän tarpeisiinsa. Mukaan on tullut matkan varrella lisää sotureita ja pari lähtenyt myös mutta
            joukkueen henki on silti kovempi kuin koskaan. Ota yhteyttä jos kiinnostuit toiminnasta!</p>
        <h1 class="teamheader">Edustusjoukkue 2018-2019</h1>
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