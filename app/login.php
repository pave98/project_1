<?php
    require "../app/header.php";
?>
    <section>
        <div class="header">
            <h2>Login</h2>
        </div>

        <form method="post" action="../app/login.php">
            <!-- Display validation errors here -->
            <?php include('../app/errors.php'); ?>
            <div class="input-group">
                <label>Username</label><br>
                <input type="text" name="username">
            </div>
            <div class="input-group">
                <label>Password</label><br>
                <input type="password" name="password"><br><br>
            </div>
            <div class="input-group">
                <button type="submit" name="login" class="btn">Login</button>
            </div>
        </form>
    </section>
    

<?php
    require "../app/footer.php";
?>