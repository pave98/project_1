<?php
    require "../header.php";
    require "dir.php"
?>
<!--The gallery features a responsive image-gallery, with a "current" large image and
multiple small images. By pressing a smaller image the current image changes to that.
All the pictures are fetched from the uploads file dynamically and loaded simultaneously
which could become a problem if the amount of pictures grows too large, but the client
said that this has a very slim chance of happening.-->
    <section class="s1">
    <h1 class="mediumH1">Galleria</h1>
    <?php 
    $array = createArray();
    ?>
        <div class="gallery">
            <div class="main-img">
                <img src='/project_1/app/images/uploads/<?php echo $array[0]?>' id="current">
            </div>
            <div class="images">
                <?php 
                    foreach($array as $name){
                        echo "<img src='/project_1/app/images/uploads/".$name."'>";
                    }
                ?>

            </div>
        </div>
        <script src="/project_1/app/galleria/galleryjs.js"></script>
    <?php   
    if (isAdmin()) {
    ?>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            Select image to upload: <input name="upload[]" type="file" multiple="multiple" />
            <input type="submit" value="Upload Image" name="submit">
        </form>
    <?php  
    }
    ?>
    </section>
<?php
    require "../footer.php";
?>