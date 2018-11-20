<?php
    require "../header.php";
    // if user is not logged in, they cannot access this page
    if (empty($_SESSION['username'])) {
        header('location: http://localhost/project_1/app');
    }
?>
    <section>
        <h1>mOI</h1>
    </section>
<?php
    require "../footer.php";
?>