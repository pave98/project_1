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

<?php


    printEditPlayer();
?>
    
<?php
    require "../app/footer.php";
?>