<?php
    require "../header.php";
    require "C:\wamp64\www\project_1\app\galleria\galleryjs.js";
?>
    <section class="s1">
        <div class="gallery">
            
        </div>
    <?php   
    if (isAdmin()) {
    ?>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            Select image to upload: <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload Image" name="submit">
        </form>
    <?php  
    }
    ?>
    </section>
<?php
    require "../footer.php";
?>