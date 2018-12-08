<?php
    require "../header.php";
    require "dir.php"
?>
    <section class="s1">
    <h1>Galleria</h1>
    <?php 
    $array = createArray();
    ?>
        <div class="gallery">
            <div class="main-img">
                <img src='http://localhost/project_1/app/images/uploads/<?php echo $array[0]?>' id="current">
            </div>
            <div class="images">
                <?php 
                    foreach($array as $name){
                        echo "<img src='http://localhost/project_1/app/images/uploads/".$name."'>";
                    }
                ?>

            </div>
        </div>
        <script src="http://localhost/project_1/app/galleria/galleryjs.js"></script>
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