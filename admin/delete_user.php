<?php
    require "../app/header.php";

    if (!isAdmin()) {
        header('location: ../app/login/index.php');
    }
?>
    <section class="s1">
        <div class="header">
            <h2>Admin - delete user</h2>
        </div>
        
        <?php printUsers() ?>

        <form method="post" action="delete_user.php">

        <?php 
            echo display_error(); 
            echo display_msg();
        ?>

            <div class="formBox">
                <div class="input-group">
                    <label>Username</label>
                    <input type="text" name="username" value="<?php echo $username; ?>" autofocus>
                </div>
                <div class="input-group">
                    <button type="submit" class="btn  formbutton" name="deleteUser_btn">Delete user</button>
                </div>
            </div>
            
        </form>
    </section>
<?php
    require "../app/footer.php";
?>