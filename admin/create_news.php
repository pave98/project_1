<?php
    require "../app/header.php";

    if (!isAdmin()) {
        header('location: ../app/login/index.php');
    }
?>
    <section class="s1">
        <div class="header">
            <h2>Admin - Luo Uutinen</h2>
        </div>
        <div class="formBox">
            <form method="post" action="create_news.php">

            <?php 
            echo display_error(); 
            echo display_msg();
            ?>
                <div class="input-group">
                    <label for="news_title">Uutisen otsikko</label>
                    <input type="text" name="news_title" id="news_title" value="<?php echo $news_title; ?>">
                </div>
                <div class="input-group">
                    <label for="news_article">Uutisen sisältö</label>
                    <textarea rows="4" cols="40" name="news_article" id="news_article" value="<?php echo $news_article; ?>"></textarea>
                </div>
                <div class="input-group">
                    <button type="submit" class="btn formbutton" name="createNews_btn">Luo Uutinen</button>
                </div>
            </form>
        </div>
        
    </section>
<?php
    require "../app/footer.php";
?>