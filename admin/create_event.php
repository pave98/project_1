<?php
    require "../app/header.php";

    if (!isAdmin()) {
        header('location: ../app/login/index.php');
    }
?>
    <section class="s1">
        <div class="header">
            <h2>Admin - create event</h2>
        </div>
        
        <form method="post" action="create_event.php">

        <?php echo display_error(); ?>

            
            <div class="input-group">
                <label>Event</label>
                <select name="eventType" id="eventType" autofocus>
                    <option value=""></option>
                    <option value="treeni">Treeni</option>
                    <option value="peli">Matsi</option>
                </select>
            </div>
            <div class="input-group">
                <label>Description</label>
                <input type="text" name="description" value="<?php echo $description; ?>">
            </div>
            <div class="input-group">
                <label>Location</label>
                <input type="text" name="location" value="<?php echo $location; ?>">
            </div>
            <div class="input-group">
                <label>Time</label>
                <input type="datetime-local" name="time" value="<?php echo $time; ?>">
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="createEvent_btn"> Create event</button>
            </div>
        </form>
    </section>
<?php
    require "../app/footer.php";
?>