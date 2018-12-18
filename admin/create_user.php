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
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.myForm.email.value)) {
                alert( "Anna kunnollinen sähköposti!" );
                document.myForm.email.focus() ;
                return false;
            }
            if( document.myForm.description.value == "" ) {
                alert( "Anna käyttäjän kuvaus!" );
                document.myForm.description.focus() ;
                return false;
            }

            return( true );
        }
    </script>

    <section class="s1">
        <div class="header">
            <h2>Admin - Luo Käyttäjä</h2>
        </div>
        <div class="formBox">
            <form method="post" action="create_user.php" name="myForm" onsubmit = "return(validate());">

            <?php 
            echo display_error(); 
            echo display_msg();
            ?>

                <div class="input-group">
                    <label for="user_type">Käyttäjätyyppi</label>
                    <select name="user_type" id="user_type" >
                        <option value=""></option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="username">Käyttäjätunnus</label>
                    <input type="text" name="username" id="username" value="<?php echo $username; ?>" autofocus>
                </div>
                <div class="input-group">
                    <label for="firstname">Etunimi</label>
                    <input type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>">
                </div>
                <div class="input-group">
                    <label for="lastname">Sukunimi</label>
                    <input type="text" name="lastname" id="lastname" value="<?php echo $lastname; ?>">
                </div>
                <div class="input-group">
                    <label for="email">Sähköposti</label>
                    <input type="email" name="email" id="email" value="<?php echo $email; ?>">
                </div>
                
                <div class="input-group">
                    <label for="desc">Kuvaus</label>
                    <input type="text" name="description" id="desc" value="<?php echo $description; ?>">
                </div>
                <div class="input-group">
                    <button type="submit" class="btn formbutton" name="register_btn">Luo Käyttäjä</button>
                </div>
            </form>
        </div>
        
    </section>
<?php
    require "../app/footer.php";
?>