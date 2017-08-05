<?php
    require_once('inc/init.php');

    // Make sure that the page is not being accessed directly
    if (isset($_POST['video_posted']) && $_POST['video_posted'] == 'true') {

        // Sanitise the data posted
        $validate    = new validation();
        $data_sent = $validate->sanitise($_POST);
        extract($data_sent);

        if (isset($playlist_id) && !empty($playlist_id) && isset($video_id) && !empty($video_id) && isset($order) && !empty($order)) {

            // Add the video to the playlist
            $playlists = new playlists();
            $playlists->add_video($playlist_id, $video_id, $start, $order);

        } else {

            echo 'You can\'t access this page like that!';
            header('Location: ' . $config->site_url);
            exit;

        }

    } else {

        echo 'You can\'t access this page like that!';
        header('Location: ' . $config->site_url);
        exit;

    }
?>
