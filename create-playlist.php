<?php require_once('inc/init.php'); ?>

<?php require_once('inc/header.php'); ?>

<?php
    $validation  = new validation();
    $posted_data = $validation->sanitise($_POST);
    extract($posted_data);

    $playlists     = new playlists($playlist_name, $playlist_email);
    $id            = $playlists->create_playlist();
    $unique_string = $playlists->get_unique_string($id);
?>

<div id="playlist_id"><?php echo $id; ?></div>

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

            <?php require_once('inc/errors-block.php'); ?>

            <div class="col s12 p0i pt50i selected-video-preview-container">

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


                    <button class="btn waves-effect waves-light main-bg main-bg-hover main-bg-focus" type="submit" id="add_video">
                        Add to Playlist
                        <i class="material-icons right">add</i>
                    </button>
                </div>

            </div><!-- .selected-view-preview-container -->

            <div class="input-field col m9">
                <input id="set_edit_password" type="text" autocomplete="off" class="tooltipped" data-position="bottom" data-delay="0" data-tooltip="Please don't use a password you use for other websites as we don't store this password securely">
                <label for="set_edit_password" class="main-text-focus-important">Set password to allow people to edit the playlist</label>
            </div>

            <div class="col m3 right-align pt25i">
                <button class="btn waves-effect waves-light main-bg main-bg-hover main-bg-focus" type="button" id="save_password">Save Password</button>
            </div>

        </div>

        <div class="row mb0 pt50">

            <div class="col s12">
                <h5 class="section-title main-text">Songs Added to "<?php echo $playlist_name; ?>" Playlist</h5>
            </div>

            <div class="col s12 pb50i videos-added-container">

                <p class="no-videos-added">No videos have been added to the playlist yet.</p>

            </div>

        </div>

        <a href="<?php echo $config->site_url; ?>/p/?id=<?php echo $unique_string; ?>" class="btn waves-effect waves-light main-bg main-bg-hover main-bg-focus mb50 disabled" id="finish-creating-playlist-btn">
            Finish Creating Playlist
            <i class="material-icons right">keyboard_arrow_right</i>
        </a>

    </div><!-- .container -->

</div><!-- .pt50 -->

<?php require_once('inc/footer.php'); ?>
