<?php
    require_once('inc/init.php');

    // Make sure that the page is not being accessed directly
    if (isset($_GET['video_posted']) && $_GET['video_posted'] == 'true') {

        // Sanitise the data posted
        $validate    = new validation();
        $data_sent = $validate->sanitise($_GET);
        extract($data_sent);

        // Add the video to the playlist
        $playlists = new playlists();
        $playlists->add_video($playlist_id, $video_id, $start);

    } else {

        echo 'You can\'t access this page like that!';
        exit;

    }
?>
