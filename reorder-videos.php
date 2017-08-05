<?php
    require_once('inc/init.php');

    if (isset($_POST['reorder']) && $_POST['reorder'] == 'true') {

        // Sanitise the data being posted
        $validation = new validation();
        $post_data  = $validation->sanitise($_POST);
        extract($post_data);

        if (isset($playlist_id) && !empty($playlist_id) && isset($songs) && !empty($songs)) {

            // Explode the string containing the song order
            $unexploded_songs = explode(',', $songs);

            // Loop through each song
            foreach ($unexploded_songs as $exploded_song) {
                $song = explode('=', $exploded_song);
                if (isset($song[1])) {

                    $video_id = str_replace('"', '', $song[0]);
                    $order    = $song[1] + 1;

                    // Save the order of the current song in the loop
                    $playlists = new playlists();
                    $playlists->save_video_order($playlist_id, $video_id, $order);

                }
            }

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
