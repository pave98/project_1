<?php
    require "../app/header.php";

    if (!isAdmin()) {
        header('location: ../app/login/index.php');
    }
?>
    <section class="s1">
        <div class="header">
            <h2>Admin - Luo Käyttäjä</h2>
        </div>
        <div class="formBox">
            <form method="post" action="create_user.php">

            <?php 
            echo display_error(); 
            echo display_msg();
            ?>

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
                    <label for="user_type">Käyttäjätyyppi</label>
                    <select name="user_type" id="user_type" >
                        <option value=""></option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
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