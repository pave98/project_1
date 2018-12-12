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
        
        <?php 
            echo display_error(); 
            echo display_msg();
        ?>
        
        <div>
            <?php printUsers() ?>
        </div>
        
        

    </section>
<?php
    require "../app/footer.php";
?>