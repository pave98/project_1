<?php
    require "../header.php";
    // if user is not logged in, they cannot access this page
    if (!isLoggedIn()) {
        $_SESSION['msg'] = "You must log in first";
        header('location: ../login/index.php');
    }
?>

    <script type="text/javascript">
        function validate() {
            if( document.myForm.oldPassword.value == "" ) {
            alert( "Anna vanha salasanasi!" );
            document.myForm.oldPassword.focus() ;
            return false;
            }
            if( document.myForm.newPassword.value == "" ) {
                alert( "Anna uusi salasana!" );
                document.myForm.newPassword.focus() ;
                return false;
            }
            if( document.myForm.newPassword2.value == "" ) {
                alert( "toista uusi salasana!" );
                document.myForm.newPassword2.focus() ;
                return false;
            }
            return( true );
        }
    </script>

    <section class="s1">
        <div class="formBox">
            <form method="post" action="" name="myForm" onsubmit = "return(validate());">

                <!-- Display validation errors here -->

                <?php   echo display_error(); 
                        echo display_msg();
                ?>

                <h1>Vaihda salasana</h1>
                <div class="input-group">
                    <label for="oldpassword"> Vanha salasana</label>
                    <input type="password" id="oldpassword" name="oldPassword" required autofocus>
                </div>
                <div class="input-group">
                    <label for="newpassword">Uusi salasana</label>
                    <input type="password" id="newpassword" name="newPassword"  required>
                </div>
                <div class="input-group">
                    <label for="newpassword2">Kirjoita uusi salasana uudelleen</label>
                    <input type="password" id="newpassword2" name="newPassword2" required>
                </div>
                <div class="input-group">
                    <button class="btn formbutton" type="submit" name="reset_btn">Vaihda salasana</button>
                </div>
            </form>
        </div>
        
    </section>
    
<?php
    require "../footer.php";
?>