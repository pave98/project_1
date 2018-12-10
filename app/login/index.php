<?php
    include($_SERVER['DOCUMENT_ROOT'].'/project_1/app/header.php'); 
    if (isLoggedIn()) {
        header('location: ../index.php');
    }
?>
    <section class="s1">
        <div class="header">
            <h2>Login</h2>
        </div>
        <div class="formBox">
            <form method="post" action="">
                <!-- Display validation errors here -->
                <?php echo display_error(); ?>

                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" autofocus>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                </div>
                <div class="input-group">
                    <button type="submit" name="login_btn" class="btn formbutton">Login</button>
                </div>
            </form>
        </div>
        <p><a href="resetPassword.php">Unohtuiko salasana?</a></p>
    </section>
    

<?php
    include($_SERVER['DOCUMENT_ROOT'].'/project_1/app/footer.php'); 
?>