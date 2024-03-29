<?php
    require "../app/header.php";

    if (!isAdmin()) {
        header('location: ../app/login/index.php');
    }
?>
    <script type="text/javascript">
        function validate() {
            if( document.myForm.eventType.value == "" ) {
            alert( "Anna tapahtuman tyyppi!" );
            document.myForm.eventType.focus() ;
            return false;
            }
            if( document.myForm.description.value == "" ) {
                alert( "Anna tapahtuman kuvaus!" );
                document.myForm.description.focus() ;
                return false;
            }
            if( document.myForm.location.value == "") {
                
                alert( "Anna tapahtuman sijainti" );
                document.myForm.location.focus() ;
                return false;
            }
            if( document.myForm.time.value == "" ) {
                alert( "Anna tapahtuman aika" );
                document.myForm.time.focus() ;
                return false;
            }
            return( true );
        }
    </script>

    <section class="s1">
        <div class="header">
            <h2>Admin - Luo Tapahtuma</h2>
        </div>
        <div class="formBox">
            <form name="myForm" method="post" action="create_event.php" onsubmit = "return(validate());">

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