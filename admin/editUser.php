<?php
    require "../app/header.php";

    if (!isAdmin()) {
        header('location: ../app/login/index.php');
    }


?>

    <script type="text/javascript">
        function validate() {
            if( document.myForm.user_type.value == "" ) {
            alert( "Anna käyttäjän tyyppi!" );
            document.myForm.user_type.focus() ;
            return false;
            }
            if( document.myForm.username.value == "" ) {
            alert( "Anna käyttäjätunnus!" );
            document.myForm.username.focus() ;
            return false;
            }
            if( document.myForm.firstname.value == "" ) {
                alert( "Anna käyttäjän etunimi!" );
                document.myForm.firstname.focus() ;
                return false;
            }
            if( document.myForm.lastname.value == "" ) {
            alert( "Anna käyttäjän sukunimi!" );
            document.myForm.lastname.focus() ;
            return false;
            }
            if( document.myForm.email.value == "" ) {
                alert( "Anna käyttäjän sähköposti!" );
                document.myForm.email.focus() ;
                return false;
            }
            return( true );
        }
    </script>

<?php

    printEditUser();
?>
    
<?php
    require "../app/footer.php";
?>