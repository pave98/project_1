<?php
    require "../app/header.php";

    if (!isAdmin()) {
        header('location: ../app/login/index.php');
    }

?>

    <script type="text/javascript">
        function validate() {
            if( document.myForm.news_title.value == "" ) {
            alert( "Anna uutisen otsikko!" );
            document.myForm.news_title.focus() ;
            return false;
            }
            if( document.myForm.news_article.value == "" ) {
                alert( "Anna uutisen sisältö!" );
                document.myForm.news_article.focus() ;
                return false;
            }
            return( true );
        }
    </script>

<?php

    printEditNews();
?>
    
<?php
    require "../app/footer.php";
?>