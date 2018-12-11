<?php
    require "../app/header.php";

    if (!isAdmin()) {
        header('location: ../app/login/index.php');
    }
?>
    <section class="s1">
        <div class="header">
            <h2>Admin - Luo Tapahtuma</h2>
        </div>
        <div class="formBox">
            <form method="post" action="create_event.php">

            <?php 
            echo display_error(); 
            echo display_msg();
            ?>
                
                <div class="input-group">
                    <label for="eventType">Tapahtuma</label>
                    <select name="eventType" id="eventType" autofocus>
                        <option value=""></option>
                        <option value="Treeni">Treeni</option>
                        <option value="Peli">Matsi</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="desc">Kuvaus</label>
                    <input type="text" name="description" id="desc" value="<?php echo $description; ?>">
                </div>
                <div class="input-group">
                    <label for="location">Sijainti</label>
                    <input type="text" name="location" id="location" value="<?php echo $location; ?>">
                </div>
                <div class="input-group">
                    <label for="time">Aika</label>
                    <input type="datetime-local" name="time" id="time" value="<?php echo $time; ?>">
                </div>
                <div class="input-group">
                    <button type="submit" class="btn formbutton" name="createEvent_btn">Luo Tapahtuma</button>
                </div>
            </form>
        </div>
        
    </section>
<?php
    require "../app/footer.php";
?>