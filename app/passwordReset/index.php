<?php
    require "../header.php";
    // if user is not logged in, they cannot access this page
    if (!isLoggedIn()) {
        $_SESSION['msg'] = "You must log in first";
        header('location: ../login/index.php');
    }
?>
    <form method="post" action="">

        <!-- Display validation errors here -->
        <?php echo display_error(); ?>

        <h1>Change password</h1>
        <div class="input-group">
            <input type="password" name="oldPassword" placeholder="Old Password" required>
        </div>
        <div class="input-group">
            <input type="password" name="newPassword" placeholder="New Password" required>
        </div>
        <div class="input-group">
            <input type="password" name="newPassword2" placeholder="Retype New Password" required>
        </div>
        <div class="input-group">
            <input type="submit" name="reset_btn" value="Reset Password">
        </div>
    </form>
<?php
    require "../footer.php";
?>