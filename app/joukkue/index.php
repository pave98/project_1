<?php
    require "../header.php";
?>  
    <section class="s1">
        <div class="bodyContainer">
        <h1 class="mediumH1 nonCentered">RKC-Volley</h1>
            <p class="intro">RKC-Volley on keväällä 2018 perustettu lentopallojoukkue Lempäälästä. Joukkueen perustivat 
            Joukkueenjohtaja Antti Koskinen ja kapteeni Niko Hienonen koska eivät löytäneet seuraa joka sopi
            juuri heidän tarpeisiinsa. Mukaan on tullut matkan varrella lisää sotureita ja pari lähtenyt, mutta
            joukkueen henki ja rähinä on silti kovempi kuin koskaan. Ota yhteyttä jos kiinnostuit toiminnasta!</p>
        <h1 class="mediumH1 nonCentered">Edustusjoukkue 2018-2019</h1>
            <div class="players">
                <?php 
                    include_once "player.php"; 
                    $i = 1;
                    foreach($players as $value){
                        if(!($i % 2 === 0)){
                            print"<div class= 'player'>";
                            $value->printHead();
                            $value->printPic();
                            $value->printStats();
                            print"</div>";
                        }else{
                            print"<div class= 'player player2'>";
                            $value->printHead();
                            $value->printPic();
                            $value->printStats();
                            print"</div>";
                        }
                        $i++;
                        
                    }
                ?>
            </div>
        </div>
    </section>
<?php
    require "../footer.php";
?>