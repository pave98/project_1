<?php
    require "../header.php";
?>
    <section class="s1">
        <div class="gallery">
            <div class="main-img">
                <img src='http://localhost/project_1/app/images/uploads/img8.jpg' id="current">
            </div>
            <div class="images">
                <img src='http://localhost/project_1/app/images/uploads/img8.jpg'>
                <img src='http://localhost/project_1/app/images/uploads/img7.jpg'>
                <img src='http://localhost/project_1/app/images/uploads/img6.jpeg'>
                <img src='http://localhost/project_1/app/images/uploads/img5.jpeg'>
                <img src='http://localhost/project_1/app/images/uploads/img4.jpeg'>
                <img src='http://localhost/project_1/app/images/uploads/img3.jpeg'>
                <img src='http://localhost/project_1/app/images/uploads/img2.jpeg'>
                <img src='http://localhost/project_1/app/images/uploads/img1.jpeg'>
            </div>
        </div>
        <script src="http://localhost/project_1/app/galleria/galleryjs.js"></script>
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