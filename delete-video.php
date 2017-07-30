<?php
    require_once('inc/init.php');

    if (isset($_POST['delete_video']) && $_POST['delete_video'] == 'true') {

        // Sanitise posted data
        $validation = new validation();
        $post_data  = $validation->sanitise($_POST);
        extract($_POST);

        if (isset($unique_string) && !empty($unique_string) && isset($video_id) && !empty($video_id)) {

            // Get the id for the playlist
            $playlists   = new playlists();
            $playlist_id = $playlists->get_id($unique_string);

            // Check that the video exists for the playlist
            $video_exits = $db->query("SELECT COUNT(*) AS count FROM playlist_videos WHERE playlist_id = '$playlist_id' AND video_id = '$video_id'");

            if ($video_exits->fetchObject()->count != 0) {

                $playlists->delete_video($playlist_id, $video_id);

            } else {

                $errors->add_error('Sorry but the video doesn\'t exist against this playlist!');
                header('Location: ' . $config->site_url . '/p/?id=' . $unique_string . '&edit=true');
                exit;

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
