<?php
    require "../header.php";
    // if user is not logged in, they cannot access this page
    if (!isLoggedIn()) {
        $_SESSION['msg'] = "You must log in first";
        header('location: ../login/index.php');
    }
?>
    <section>
        <h1>mOI</h1>
    </section>
<?php
    require "../footer.php";
?>