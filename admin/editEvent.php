<?php
    require "../app/header.php";

    if (!isAdmin()) {
        header('location: ../app/login/index.php');
    }
?>

    <script type="text/javascript">
        function validate() {
            if( document.myForm.eventType.value == "" ) {
            alert( "Anna tapahtuman tyyppi!" );
            document.myForm.eventType.focus() ;
            return false;
            }
            if( document.myForm.description.value == "" ) {
                alert( "Anna tapahtuman kuvaus!" );
                document.myForm.description.focus() ;
                return false;
            }
            if( document.myForm.location.value == "" ) {
                alert( "Anna tapahtuman sijainti!" );
                document.myForm.location.focus() ;
                return false;
            }
            if( document.myForm.time.value == "" ) {
                alert( "Anna tapahtuman aika!" );
                document.myForm.time.focus() ;
                return false;
            }
            return( true );
        }
    </script>

<?php
    printEditEvent();
?>
    
<?php
    require "../app/footer.php";
?>