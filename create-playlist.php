<?php require_once('inc/init.php'); ?>

<?php require_once('inc/header.php'); ?>

<?php
    $validation  = new validation();
    $posted_data = $validation->sanitise($_POST);
    extract($posted_data);

    $playlists = new playlists($playlist_name, $playlist_email);
    $id = $playlists->create_playlist();
?>

<div class="pt50">

    <div class="container">

        <div class="row mb0">

            <div class="col s12">
                <h5 class="section-title main-text">Add Song to "<?php echo $playlist_name; ?>" Playlist</h5>
            </div>

            <div class="input-field col s12">
                <input id="search_song" type="text" autocomplete="off">
                <label for="search_song" class="main-text-focus-important">Search Song</label>

                <ul class="autocomplete-content create-playlist-search-results dropdown-content"></ul>
            </div>

            <div class="col s12 p0i pt50i selected-view-preview-container">

                <div class="col m8 align-center">
                    <div id="selected-video-preview"></div>
                </div>

                <div class="col m4">
                    <h5 class="section-title main-text mt0">Options</h5>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="video_start" type="number" autocomplete="off">
                            <label for="video_start" class="main-text-focus-important">Start From (Seconds)</label>
                        </div>
                    </div>


                    <button class="btn waves-effect waves-light main-bg main-bg-hover main-bg-active" type="submit" name="save_options">Add to Playlist
                        <i class="material-icons right">add</i>
                    </button>
                </div>

            </div><!-- .selected-view-preview-container -->

        </div>

        <div class="row mb0 pt50">

            <div class="col s12">
                <h5 class="section-title main-text">Songs Added to "<?php echo $playlist_name; ?>" Playlist</h5>

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
