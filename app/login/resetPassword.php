<?php
    include($_SERVER['DOCUMENT_ROOT'].'/project_1/app/header.php'); 
    if (isLoggedIn()) {
        header('location: ../index.php');
    }
?>
    <section class="s1">
        <h1>Unohtuiko salasana?</h1>
        <p>Kirjoita sähköpostisi saadaksesi uuden salasanan.</p>
        <div class="formBox">
            <form method="post" action="index.php">

            <?php 
            echo display_error(); 
            echo display_msg();
            ?>

                <div class="input-group">
                    <label for="email">Sähköposti</label>
                    <input type="email" name="email" id="email" required autofocus>
                </div>
                <div class="input-group">
                    <button type="submit" class="btn formbutton" name="resetPassword_btn">Reset</button>
                </div>
            </form>
        </div>

    </section>

<?php
    include($_SERVER['DOCUMENT_ROOT'].'/project_1/app/footer.php'); 
?>