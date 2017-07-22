<?php require_once('inc/init.php'); ?>

<?php require_once('inc/header.php'); ?>

<?php
    $validation  = new validation();
    $posted_data = $validation->sanitise($_POST);
    extract($posted_data);

    $playlists = new playlists($playlist_name, $playlist_email);
    $playlists->create_playlist();
?>

<div class="pt50">

    <div class="container">

        <div class="row">

            <div class="col s12">
                <h5 class="section-title main-text">Add Song to "<?php echo $playlist_name; ?>"</h5>

                <br><br>

                <h4>NEED TO SETUP THE FUNCTIONALITY TO ADD THE PLAYLIST TO THE DATABASE USING THE create_playlist METHOD IN THE playlists CLASS</h4>
            </div>

            <div class="input-field col s12">
                <input name="search_song" id="search_song" type="text" autocomplete="off">
                <label for="search_song" class="main-text-focus-important">Search Song</label>
            </div>

        </div>

        <div class="row">

            <div class="col s12">
                <h5 class="section-title main-text">Songs Added to "<?php echo $playlist_name; ?>"</h5>

                <br><br>

                <h4>NEED TO MAKE THIS DYNAMIC WHEN THE FUNCTIONALITY FOR SAVINGS SONGS IS DONE</h4>
            </div>

            <div class="col s12">

                <div class="song-container smooth-box-shadow white-bg">
                    <p class="margin0 main-text">STORMZY [@STORMZY1] - BIG FOR YOUR BOOTS</p>
                </div>

                <div class="song-container smooth-box-shadow white-bg">
                    <p class="margin0 main-text">STORMZY [@STORMZY1] - SHUT UP</p>
                </div>

                <div class="song-container smooth-box-shadow white-bg">
                    <p class="margin0 main-text">STORMZY [@STORMZY1] - KNOW ME FROM</p>
                </div>

                <div class="song-container smooth-box-shadow white-bg">
                    <p class="margin0 main-text">STORMZY [@STORMZY1] - SCARY</p>
                </div>

            </div>

        </div>

    </div><!-- .container -->

</div><!-- .pt50 -->

<?php require_once('inc/footer.php'); ?>
