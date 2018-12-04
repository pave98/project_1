<?php
    include($_SERVER['DOCUMENT_ROOT'].'/project_1/app/header.php'); 
    if (isLoggedIn()) {
        header('location: ../index.php');
    }
?>
    <section class="s1">
        <form method="post" action="index.php">
            <h1>Forgot Your Password?</h1>
            <p>Type in your email to get a new password.</p>
            <!-- Display validation errors here -->
            <?php echo display_error(); ?>
            <div class="input-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-group">
                <input type="submit" name="resetPassword_btn" value="Reset Password">
            </div>
        </form>
    </section>
    

<?php
    include($_SERVER['DOCUMENT_ROOT'].'/project_1/app/footer.php'); 
?>