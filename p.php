<?php require_once('inc/init.php'); ?>

<?php require_once('inc/header.php'); ?>

<?php
    $playlists    = new playlists();
    $videos       = $playlists->get_videos($_GET['id']);
    $videos_count = count($videos);
    $edit_check   = false;

    // Sanitise the unique string
    $validation    = new validation();
    $unique_string = $validation->sanitise($_GET['id']);

    if (isset($_GET['edit']) && $_GET['edit'] == 'true') {

        // Make sure there is post data
        if (isset($_POST)) {

            // Sanitise the posted data
            $post_data  = $validation->sanitise($_POST);

            // Check all posted data is set and is not empty
            if (
                isset($post_data['unique_string']) && !empty($post_data['unique_string'])
                && isset($post_data['playlist_email']) && !empty($post_data['playlist_email'])
                && isset($post_data['playlist_password']) && !empty($post_data['playlist_password'])
            ) {

                // Abit more validation
                if (filter_var($post_data['playlist_email'], FILTER_VALIDATE_EMAIL)) {

                    // Check the playlist credentials
                    $playlists      = new playlists();
                    $edit_check     = $playlists->check_edit_credentials($unique_string, $post_data['playlist_email'], $post_data['playlist_password']);

                    if (!$edit_check) {

                        $errors->add_error('Sorry but you\'re not allowed to edit the playlist!');
                        header('Location: ' . $config->site_url . '/p/?id=' . $unique_string);
                        exit;

                    }

                } else {

                    $errors->add_error('Sorry but you\'re not allowed to edit the playlist!');
                    header('Location: ' . $config->site_url . '/p/?id=' . $unique_string);
                    exit;

                }

            } else {

                $errors->add_error('Sorry but you\'re not allowed to edit the playlist!');
                header('Location: ' . $config->site_url . '/p/?id=' . $unique_string);
                exit;

            }

        } else {

            $errors->add_error('Sorry but you\'re not allowed to edit the playlist!');
            header('Location: ' . $config->site_url . '/p/?id=' . $unique_string);
            exit;

        }

    }
?>

<script type="text/javascript">

    // Store array containing count for the number of videos in the playlist
    var videos = [];
    videos['count'] = <?php echo $videos_count; ?>;

    <?php
        $count = 0;

        // Loop through the videos in the playlist
        foreach ($videos as $video) {

            $count++;

            // Add details about the current song in the loop in an object to the videos array
            ?>
                videos[<?php echo $count; ?>] = {
                    video_id: '<?php echo $video['id']; ?>',
                    start   : <?php echo $video['start']; ?>,
                    loop    : 0,
                };
            <?php

        }
    ?>

</script>

<div id="playlist_unique_string"><?php echo $unique_string; ?></div>

<div id="modal" class="modal">

    <div class="modal-content">

        <i class="material-icons grey-text main-text-hover-important modal-close">close</i>

        <form action="<?php echo $config->site_url; ?>/p/?id=<?php echo $unique_string; ?>&amp;edit=true" method="POST">

            <input type="hidden" name="unique_string" value="<?php echo $unique_string; ?>">

            <div class="row mb0">
                <div class="input-field col s12">
                    <input id="edit_playlist_email" name="playlist_email" type="email" autocomplete="off" >
                    <label for="edit_playlist_email" class="main-text-focus-important">Playlist Email</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                    <input id="edit_playlist_password" name="playlist_password" type="text" autocomplete="off" >
                    <label for="edit_playlist_password" class="main-text-focus-important">Playlist Password</label>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <button class="btn waves-effect waves-light main-bg main-bg-hover main-bg-focus" type="submit">
                        Start Editing
                        <i class="material-icons right">edit</i>
                    </button>
                </div>
            </div>

        </form>

    </div><!-- .modal-content -->

</div><!-- .modal -->

<div class="pt50">

    <div class="container playlist-container pb50i">

        <div class="row mb0">

            <div class="col s12 pb25i">

                <h5 class="section-title main-text">Playlist: <?php echo $playlists->get_name($_GET['id']); ?></h5>

                <?php if ($playlists->has_password($unique_string)) { ?>

                    <?php if (!$edit_check) { ?>
                        <a class="btn waves-effect waves-light main-bg main-bg-hover main-bg-focus edit-playlist-btn modal-trigger" href="#modal">
                            Edit Playlist
                            <i class="material-icons right">edit</i>
                        </a>
                    <?php } else { ?>
                        <a class="btn waves-effect waves-light main-bg main-bg-hover main-bg-focus edit-playlist-btn" href="<?php echo $config->site_url; ?>/p/?id=<?php echo $unique_string; ?>">
                            Finish Editing
                            <i class="material-icons right">check</i>
                        </a>
                    <?php } ?>

                <?php } ?>

            </div>

            <?php require_once('inc/errors-block.php'); ?>

            <div class="col s12 p0i pt25i pb20i video-play-container">

                <?php if ($edit_check) { ?>
                    <div class="edit-playlist-playing-overlay center-align">
                        <div class="edit-playlist-playing-overlay-inner">
                            <h5 class="main-text white-bg p15 edit-playlist-finish-message">Please press the finish editing button at the top of the page to carry on playing the playlist</h5>
                        </div>
                    </div>
                <?php } ?>

                <div class="col m8">

                    <div id="player"></div>

                </div>

                <div class="col m4">

                    <div class="col s12 p0">
                        <h5 class="section-title main-text mt0">Playlist Options</h5>
                    </div>

                    <div class="col s12 p0 pt15i">
                        <i class="material-icons grey-text main-text-hover-important playlist-options-icon pointer-cursor" id="repeat-playlist" title="Repeat Playlist">repeat</i>
                        <i class="material-icons grey-text main-text-hover-important playlist-options-icon pointer-cursor ml25" id="loop-current" title="Loop Current Video">loop</i>
                        <i class="material-icons grey-text main-text-hover-important playlist-options-icon pointer-cursor ml25" id="replay" title="Replay PLaylist">replay</i>
                        <i class="material-icons grey-text main-text-hover-important playlist-options-icon pointer-cursor ml25" id="replay" title="Replay PLaylist">skip_next</i>
                    </div>

                </div>

            </div><!-- .p0i -->

            <?php
                $playlist_count = 1;

                foreach ($videos as $video) {

                    $video_information = $playlists->get_video_information($video['id']);

                    if ($edit_check) {
                        $container_extra_classes = 'white-bg-important';
                        $text_extra_classes      = 'main-text-very-important';
                    } else {
                        $container_extra_classes = $text_extra_classes = '';
                    }

                    ?>

                        <div class="col s12 p0i pt15i video-<?php echo $video['id']; ?>">

                            <div class="col m8">

                                <div class="song-container smooth-box-shadow white-bg mt0i <?php echo $container_extra_classes; ?>" vid-count="<?php echo $playlist_count; ?>">
                                    <p class="margin0 main-text">
                                        <img src="<?php echo $video_information['thumbnail']; ?>" alt="<?php echo $video_information['title']; ?>">
                                        <span class="main-text-important <?php echo $text_extra_classes; ?>"><?php echo $video_information['title']; ?></span>
                                    </p>
                                </div>

                            </div>

                            <div class="col m4 song-row-options">
                                <?php if ($edit_check) { ?>
                                    <i class="material-icons grey-text main-text-hover-important playlist-options-icon pointer-cursor remove-video" vid-id="<?php echo $video['id']; ?>" title="Remove Video">close</i>
                                <?php } else { ?>
                                    <i class="material-icons grey-text main-text-hover-important playlist-options-icon pointer-cursor play-video" vid-count="<?php echo $playlist_count; ?>" title="Play Video">play_arrow</i>
                                <?php } ?>
                            </div>

                        </div><!-- .pt25i -->

                    <?php

                    $playlist_count++;

                }
            ?>

        </div><!-- .row -->

    </div><!-- .container -->

</div><!-- .pt50 -->

<?php require_once('inc/footer.php'); ?>
