<?php
    require "../app/header.php";
?>
    <div class="header">
        <h2>Login</h2>
    </div>

    <form method="post" action="../app/login.php">
        <!-- Display validation errors here -->
        <?php include('../app/errors.php'); ?>
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username">
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password">
        </div>
        <div class="input-group">
            <button type="submit" name="login" class="btn">Login</button>
        </div>
    </form>

<?php
    require "../app/footer.php";
?>