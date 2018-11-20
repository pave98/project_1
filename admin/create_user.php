<?php
    require "../app/header.php";

    if (!isAdmin()) {
        header('location: ../app/login/index.php');
    }
?>
    <section class="s1">
        <div class="header">
            <h2>Admin - create user</h2>
        </div>
        
        <form method="post" action="create_user.php">

        <?php echo display_error(); ?>

            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo $username; ?>">
            </div>
            <div class="input-group">
                <label>Etunimi</label>
                <input type="text" name="firstname" value="<?php echo $firstname; ?>">
            </div>
            <div class="input-group">
                <label>Sukunimi</label>
                <input type="text" name="lastname" value="<?php echo $lastname; ?>">
            </div>
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $email; ?>">
            </div>
            <div class="input-group">
                <label>User type</label>
                <select name="user_type" id="user_type" >
                    <option value=""></option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password_1">
            </div>
            <div class="input-group">
                <label>Confirm password</label>
                <input type="password" name="password_2">
            </div>
            <div class="input-group">
                <label>Kuvaus</label>
                <input type="textarea" name="description" value="<?php echo $description; ?>">
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="register_btn"> + Create user</button>
            </div>
        </form>
    </section>
<?php
    require "../app/footer.php";
?>