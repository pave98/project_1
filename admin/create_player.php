<?php
    require "../app/header.php";

    if (!isAdmin()) {
        header('location: ../app/login/index.php');
    }
?>

    <script type="text/javascript">
        function validate() {
            if( document.myForm.player_number.value == "" ) {
            alert( "Anna pelaajan numero!" );
            document.myForm.player_number.focus() ;
            return false;
            }
            if( document.myForm.player_fname.value == "" ) {
                alert( "Anna pelaajan etunimi!" );
                document.myForm.player_fname.focus() ;
                return false;
            }
            if( document.myForm.player_lname.value == "" ) {
                alert( "Anna pelaajan sukunimi!" );
                document.myForm.player_lname.focus() ;
                return false;
            }
            if( document.myForm.height.value == "" ) {
                alert( "Anna pelaajan pituus!" );
                document.myForm.height.focus() ;
                return false;
            }
            if( document.myForm.reach.value == "" ) {
                alert( "Anna pelaajan ulottuvuus!" );
                document.myForm.reach.focus() ;
                return false;
            }
            if( document.myForm.player_position.value == "" ) {
                alert( "Anna pelaajan pelipaikka!" );
                document.myForm.player_position.focus() ;
                return false;
            }
            if( document.myForm.player_image.value == "" ) {
                alert( "Anna pelaajan kuva!" );
                document.myForm.player_image.focus() ;
                return false;
            }
            return( true );
        }
    </script>

    <section class="s1">
        <div class="header">
            <h2>Admin - Luo Pelaaja</h2>
        </div>
        <div class="formBox">
            <form method="post" action="create_player.php" enctype ="multipart/form-data" name="myForm" onsubmit = "return(validate());">

            <?php 
            echo display_error(); 
            echo display_msg();
            ?>

                <div class="input-group">
                    <label for="player_number">Pelaajan numero</label>
                    <input type="text" name="player_number" id="player_number" value="<?php echo $player_number; ?>" autofocus>
                </div>
                <div class="input-group">
                    <label for="player_fname">Pelaajan etunimi</label>
                    <input type="text" name="player_fname" id="player_fname" value="<?php echo $player_number; ?>">
                </div>
                <div class="input-group">
                    <label for="player_lname">Pelaajan sukunimi</label>
                    <input type="text" name="player_lname" id="player_lname" value="<?php echo $player_lname; ?>">
                </div>
                <div class="input-group">
                    <label for="height">Pelaajan korkeus</label>
                    <input type="text" name="height" id="height" value="<?php echo $height; ?>">
                </div>
                <div class="input-group">
                    <label for="reach">Pelaajan Ulottuvuus</label>
                    <input type="text" name="reach" id="reach" value="<?php echo $reach; ?>">
                </div>
                <div class="input-group">
                    <label for="player_position">Pelaajan pelipaikka</label>
                    <input type="text" name="player_position" id="player_position" value="<?php echo $player_position; ?>">
                </div>
                
                <div class="input-group">
                    <label for="player_image">Pelaajan kuva</label>
                    <input type="file" name="player_image" id="player_image">
                </div>
                <div class="input-group">
                    <button type="submit" class="btn formbutton" name="createPlayer_btn">Luo Pelaaja</button>
                </div>
            </form>
        </div>
        
    </section>
<?php
    require "../app/footer.php";
?>