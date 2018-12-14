<?php
    require "header.php";
?>
    <section class="s1">
        <h1 class="motto">Macht und Wille</h1>
        <?php echo display_msg();?>
        <?php printNews();?>
        <?php if(isset($_SESSION['user'])) {
            echo("<script>console.log('PHP: WTF');</script>");
        } else {
            echo("<script>console.log('PHP: WTFASDFAS');</script>");
        } ?>
    </section>
    
<?php
    require "footer.php";
?>